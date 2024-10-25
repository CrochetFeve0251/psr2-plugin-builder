<?php

namespace LaunchpadCLI\Commands;

use Ahc\Cli\IO\Interactor;
use League\Flysystem\Filesystem;
use LaunchpadCLI\Entities\Configurations;
use LaunchpadCLI\Services\ClassGenerator;
use LaunchpadCLI\Services\ProjectManager;

/**
 * @property string|null $name Name from the service provider.
 */
class GenerateServiceProvider extends Command
{
    CONST PROVIDER_CONFIGS = 'configs/providers.php';

    /**
     * Class generator.
     *
     * @var ClassGenerator
     */
    protected $class_generator;

    /**
     * Interacts with the filesystem.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Configuration from the project.
     *
     * @var Configurations
     */
    protected $configurations;

    /**
     * @var ProjectManager
     */
    protected $project_manager;

    /**
     * Instantiate the class.
     *
     * @param ClassGenerator $class_generator Class generator.
     * @param Filesystem $filesystem Interacts with the filesystem.
     * @param Configurations $configurations Configuration from the project.
     */
    public function __construct(ClassGenerator $class_generator, Filesystem $filesystem, Configurations $configurations, ProjectManager $project_manager)
    {
        parent::__construct('provider', 'Generate service provider class');

        $this->filesystem = $filesystem;
        $this->configurations = $configurations;
        $this->class_generator = $class_generator;
        $this->project_manager = $project_manager;

        $this
            ->argument('[name]', 'Full name from the service provider')

            // Usage examples:
            ->usage(
            // append details or explanation of given example with ` ## ` so they will be uniformly aligned when shown
                '<bold>  $0 provider</end> <comment>MyClass</end> ## Creates the service provider<eol/>'
            );

        if($this->project_manager->is_resolver_present()) {
            $this->option('-t --type', 'Type from the provider');
        }
    }

    /**
     * Interacts with the user to get missing values.
     *
     * @param Interactor $io Interface to interact with the user.
     * @return void
     */
    public function interact(Interactor $io)
    {
        // Collect missing opts/args
        if (!$this->name) {
            $this->set('name', $io->prompt('Enter name from the service provider'));
        }
    }

    /**
     * Execute the command.
     * @param string|null $name Name from the service provider.
     * @return void
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function execute($name, $type)
    {
        $io = $this->app()->io();

        $is_resolver = $type === 'autoresolver' || $type === 'a';

        $path = $this->class_generator->generate( $is_resolver ? 'serviceprovider/autoresolver.php.tpl' : 'serviceprovider/vanilla.php.tpl', $name );

        if( ! $path ) {
            $io->write("The class already exists", true);
            return;
        }

        $io->write("The service provider is created at this path: $path", true);

        $this->add_provider_to_plugin($name);

        $this->add_provider_to_configs($name);
    }

    protected function add_provider_to_plugin(string $class) {
        $plugin_path = $this->configurations->getCodeDir() . 'Plugin.php';

        if(! $this->filesystem->has($plugin_path)) {
            return;
        }

        $plugin_content = $this->filesystem->read($plugin_path);

        preg_match('/\$providers = \[(?<content>[^]]*)];/', $plugin_content, $content);
        $content = $content['content'] . "    " . $this->class_generator->get_fullname($class) . "::class,\n";
        $plugin_content = preg_replace('/\$providers = \[(?<content>[^\]])*];/', "\$providers = [$content        ];", $plugin_content);

        if(! $plugin_content) {
            return;
        }

        $this->filesystem->update($plugin_path, $plugin_content);
    }

    protected function add_provider_to_configs(string $class) {
        if(! $this->filesystem->has(self::PROVIDER_CONFIGS)) {
            return;
        }
        $content = $this->filesystem->read(self::PROVIDER_CONFIGS);

        if(! preg_match('/(?<array>return\s\[(?:[^[\]]+|(?R))*\]\s*;\s*$)/', $content, $results)) {
            return;
        }

        $new_content = "    {$this->class_generator->get_fullname($class)}::class,\n";
        $new_content .= "];\n";

        $content = preg_replace('/\n\h*]\s*;\s*$/', $new_content, $content);

        $this->filesystem->update(self::PROVIDER_CONFIGS, $content);
    }
}
