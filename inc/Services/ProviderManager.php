<?php

namespace LaunchpadCLI\Services;

use League\Flysystem\Filesystem;
use LaunchpadCLI\App;
use LaunchpadCLI\Commands\GenerateServiceProvider;
use LaunchpadCLI\ObjectValues\SubscriberType;
use LaunchpadCLI\Templating\Renderer;

class ProviderManager
{
    /**
     * @var App
     */
    protected $app;

    /**
     * Interacts with the filesystem.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Class generator.
     *
     * @var ClassGenerator
     */
    protected $class_generator;

    /**
     * Renderer that handles layout of template files.
     *
     * @var Renderer
     */
    protected $renderer;

    /**
     * @var ProjectManager
     */
    protected $project_manager;

    /**
     * @var string[]
     */
    protected $functions_mapping = [];

    /**
     * Instantiate the class.
     *
     * @param App $app CLI.
     * @param Filesystem $filesystem Interacts with the filesystem.
     * @param ClassGenerator $class_generator Class generator.
     * @param Renderer $renderer Renderer that handles layout of template files.
     */
    public function __construct(App $app, Filesystem $filesystem, ClassGenerator $class_generator, Renderer $renderer, ProjectManager $project_manager)
    {
        $this->app = $app;
        $this->filesystem = $filesystem;
        $this->class_generator = $class_generator;
        $this->renderer = $renderer;
        $this->project_manager = $project_manager;
    }

    /**
     * Generate a service provider if it doesn't exist.
     *
     * @param string $namespace Namespace to create the service provider in.
     *
     * @return void
     */
    public function maybe_generate_service_provider(string $namespace, string $type = '' ) {
        $service_provider_path = $this->class_generator->get_dirname( $namespace ) . '/ServiceProvider.php';
        $service_provider_name = $this->class_generator->get_dirname( $namespace ) . '/ServiceProvider';

        if( ! $this->class_generator->exists( $service_provider_path ) ) {

            $params = [
                false,
                $service_provider_name
            ];

            if($type) {
                $params[] = '-t';
                $params[] = $type;
            }

            $this->app->launchCommand(GenerateServiceProvider::class, $params);
        }
    }

    /**
     * Register a new class to the service provider.
     *
     * @param string $path Path to the service provider.
     * @param string $class Class to add to the service provider.
     *
     * @return void
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function add_class(string $path, string $class) {
        if( $this->project_manager->is_resolver_present() ) {
            return;
        }
        $provider_path = $this->class_generator->generate_path( $path. '/ServiceProvider' );
        $provider_content = $this->filesystem->read( $provider_path );
        $provider_content = $this->remove_anonymous_functions($provider_content);
        $full_name = $this->class_generator->get_fullname( $class );
        $id = $this->class_generator->get_fullname( $full_name ) . '::class';

        preg_match( '/\n(?<indents> *)public function define\(\)\s*{ *\n(?<content>[^}]*)}/',
            $provider_content,
            $content );

        if(! key_exists('indents', $content)) {
            return;
        }

        $indents = $content['indents'];

        if(! key_exists('content', $content)) {
            return;
        }

        if(! trim($content['content'], " \n")) {
            $content['content'] = '';
        } else {
            $content['content'] = rtrim($content['content'], " \n") . "\n";
        }

        $content = $content['content'] . "$indents    \$this->register_service(" . $id . ");\n";
        $provider_content = preg_replace( '/public function define\(\)[^}]*{ *\n(?<content>[^}]*)}/', "public function define()\n$indents{\n$content$indents}", $provider_content );
        $provider_content = $this->reset_anonymous_functions($provider_content);

        $this->filesystem->update( $provider_path, $provider_content );
    }

    /**
     * Register a subscriber to the service provider.
     *
     * @param string $id ID from the subscriber.
     * @param string $path Path from the service provider.
     * @param SubscriberType $type Type from the subscriber.
     *
     * @return void
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function register_subscriber(string $id, string $path, SubscriberType $type) {
        $provider_path = $this->class_generator->generate_path($path. '/ServiceProvider');
        $provider_content = $this->filesystem->read( $provider_path );

        if ( $type->getValue() === SubscriberType::FRONT ) {
            $provider_content = $this->add_to_subscriber_method($id, 'get_front_subscribers', $provider_content);
        }
        if ( $type->getValue() === SubscriberType::ADMIN ) {
            $provider_content = $this->add_to_subscriber_method($id, 'get_admin_subscribers', $provider_content);
        }
        if ( $type->getValue() === SubscriberType::COMMON ) {
            $provider_content = $this->add_to_subscriber_method($id, 'get_common_subscribers', $provider_content);
        }

        $this->filesystem->update($provider_path, $provider_content);
    }

    /**
     * Add the subscriber to the method.
     *
     * @param string $id ID from the subscriber.
     * @param string $method Method to register the subscriber to.
     * @param string $content Content from the service provider.
     *
     * @return string
     * @throws \LaunchpadCLI\Templating\FileNotFoundException
     */
    protected function add_to_subscriber_method(string $id, string $method, string $content): string {
        if ( ! preg_match('/\n(?<indents> *)public function ' . $method . '\(\)[^{]*{(?<content>[^}]*)}/', $content, $results ) ) {
            return $this->add_method_autoresolve($content, $method, $id);
        }
        $indents = $results['indents'];
        $results = $results['content'] . " " . $id . ",\n";
        return preg_replace('/public function ' . $method . '\(\)[^}]*{(?<content>[^}]*)}/', "public function $method()\n$indents{\n$results$indents}", $content);
    }

    protected function add_method_autoresolve(string $content, string $method, string $id) {
        if(! preg_match('/class(?<content>\s*[^{]*{\h*\n)/', $content, $results)) {
            return $content;
        }
        $new_content = $this->renderer->apply_template('serviceprovider/_partials/' . $method . '.php.tpl', [
            'ids' => "$id,"
        ]);
        $results = 'class' . $results['content'] . $new_content;
        return preg_replace('/class(?<content>\s*[^{]*{\h*\n)/', $results, $content);
    }

    /**
     * Instantiate a class inside the service provider.
     *
     * @param string $path Path from the service provider.
     * @param string $class Class to add to the service provider.
     *
     * @return void
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function instantiate(string $path, string $class) {
        $provider_path = $this->class_generator->generate_path( $path. '/ServiceProvider' );
        $provider_content = $this->filesystem->read( $provider_path );
        $full_name = $this->class_generator->get_fullname( $class );
        $id = $full_name . '::class';

        if(! $this->is_autoresolver($provider_content)) {
            $provider_content = $this->instantiate_vanilla($provider_content, $id);
            $this->filesystem->update( $provider_path, $provider_content );
            return;
        }
        $provider_content = $this->instantiate_autoresolver($provider_content, $id);
        $this->filesystem->update( $provider_path, $provider_content );
    }

    protected function instantiate_vanilla(string $provider_content, string $id) {
        $provider_content = $this->remove_anonymous_functions($provider_content);


        preg_match( '/\n(?<indents> *)public function define\(\)[^}]*\s*{(?<content>[^}]*)}/', $provider_content, $content );

        $indents = $content['indents'];
        $content = $content['content'] . "$indents\$this->register_service(" . $id . ", function () {\n$indents        \$this->getContainer()->get($id);\n$indents    });\n";

        $provider_content = preg_replace( '/public function define\(\)[^}]*{(?<content>[^}]*)}/', "public function define()\n$indents{"."$content$indents}", $provider_content );

        return $this->reset_anonymous_functions($provider_content);
    }

    protected function instantiate_autoresolver(string $provider_content, string $id) {
        $method = 'get_class_to_instantiate';
        if ( ! preg_match('/\n(?<indents> *)public function ' . $method . '\(\)[^{]*{(?<content>[^}]*)}/', $provider_content, $results ) ) {
            return $this->add_method_autoresolve($provider_content, $method, $id);
        }
        $indents = $results['indents'];
        $results = $results['content'] . " " . $id . ",\n";
        return preg_replace('/public function ' . $method . '\(\)[^}]*{(?<content>[^}]*)}/', "public function $method()\n$indents{\n$results$indents}", $provider_content);

    }

    protected function remove_anonymous_functions(string $content) {
        if(! preg_match_all('/(?<function>function\s*\([^)]*\)\s*\{[^}]*})/', $content, $results)) {
            return $content;
        }
        foreach ($results['function'] as $function) {
            $id = '#function_' . uniqid() . '#';
            $this->functions_mapping[$id] = $function;
            $content = str_replace($function, $id, $content);
        }

        return $content;
    }

    protected function reset_anonymous_functions(string $content) {
        foreach ($this->functions_mapping as $id => $function) {
            $content = str_replace($id, $function, $content);
        }

        return $content;
    }

    public function is_autoresolver(string $content) {
        return (bool) preg_match('/Dependencies\\\\RocketLauncherAutoresolver\\\\ServiceProvider/', $content);
    }
}
