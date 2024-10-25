<?php

namespace LaunchpadCLI\Services;

use League\Flysystem\Filesystem;
use LaunchpadCLI\Entities\Configurations;
use LaunchpadCLI\Templating\Renderer;

class ContentGenerator
{
    use DetectReturnTrait, DetectParametersTrait, CreateIDTrait;

    /**
     * Interacts with the filesystem.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Renderer that handles layout of template files.
     *
     * @var Renderer
     */
    protected $renderer;

    /**
     * Instantiate the class.
     *
     * @param Filesystem $filesystem Interacts with the filesystem.
     * @param Renderer $renderer Renderer that handles layout of template files.
     */
    public function __construct(Filesystem $filesystem, Renderer $renderer)
    {
        $this->filesystem = $filesystem;
        $this->renderer = $renderer;
    }

    /**
     * Generate content for an integration test.
     *
     * @param string $path Path to the class to test.
     * @param string $method Method to test.
     * @param bool $has_return Does the class return a value.
     *
     * @return string
     */
    public function generate_integration(string $path, string $method, bool $has_return) {
        return $this->generate($path, $method, $has_return, '/test/_partials/contentintegration.php.tpl');
    }

    /**
     * Generate content for a test.
     *
     * @param string $path Path to the class to test.
     * @param string $method Method to test.
     * @param bool $has_return Does the class return a value.
     * @param string $template Template from the test.
     * @param bool $has_event Does the test should have an event.
     *
     * @return string
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \LaunchpadCLI\Templating\FileNotFoundException
     */
    protected function generate(string $path, string $method, bool $has_return, string $template, bool $has_event = true) {
        if(! $this->filesystem->has($path)) {
            return '';
        }

        $class_name = str_replace('.php', '', basename($path));
        $class_name = $this->create_id($class_name);

        $content = $this->filesystem->read($path);

        $parameters = $this->get_parameters($method, $content);
        $events = $this->get_events($method, $content);
        $is_action = ! $this->has_return($method, $content);

        if( count($events) === 0 && $has_event) {
            return '';
        }

        $event = array_pop($events);

        $init = '';

        foreach ($parameters as $key => $type) {
            $key_without_dollar = str_replace('$', '', $key);

            $init .= "\$config['$key_without_dollar'], ";
        }

        $init = trim($init, ', ');

        if( strlen( $init ) > 0 && $has_event ) {
            $init = ', ' . $init;
        }

        return $this->renderer->apply_template(
            $template,
            [
                'class' => $class_name,
                'parameters' => $init,
                'event'      => $event,
                'method' => $method,
                'has_return' => $has_return,
                'is_action' => $is_action,
            ]
        );
    }

    /**
     * Generate content for an unit test.
     *
     * @param string $path Path to the class to test.
     * @param string $method Method to test.
     * @param bool $has_return Does the class return a value.
     *
     * @return string
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \LaunchpadCLI\Templating\FileNotFoundException
     */
    public function generate_unit(string $path, string $method, bool $has_return) {
        return $this->generate($path, $method, $has_return, '/test/_partials/contentunit.php.tpl', false);
    }

    /**
     * Get events a method is registered to.
     *
     * @param string $method Method registered.
     * @param string $content Content to search in.
     *
     * @return array
     */
    protected function get_events(string $method, string $content) {
        if(! preg_match('/public[ \n]+static[ \n]+function[ \n]+get_subscribed_events[ \n]*\(([^\)])*\)([ \n]*:[ \n]*\w+)?[ \n]*(?<content>\{((?:[^{}]+|\{(?3)\})*)\})/', $content, $results)) {
            return [];
        }

        $content = $results['content'];

        if(! preg_match_all('/return\s+(?<value>[^;]+);/', $content, $results)) {
            return [];
        }

        $values = $results['value'];

        $events = [];

        foreach ($values as $value) {

            if( ! preg_match_all("/[\"'](?<event>[^'\"]*)[\"'][ \n]*=>[^=]*[\"']{$method}[\"']/", $value, $results)) {
                continue;
            }

            $events = array_merge($events, $results['event']);
        }

        return array_unique($events);
    }
}
