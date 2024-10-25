<?php

namespace LaunchpadCLI\Commands;

use Ahc\Cli\IO\Interactor;
use League\Flysystem\Filesystem;
use LaunchpadCLI\ObjectValues\SubscriberType;
use LaunchpadCLI\Services\ClassGenerator;
use LaunchpadCLI\Services\ProjectManager;
use LaunchpadCLI\Services\ProviderManager;
use LaunchpadCLI\Templating\Renderer;

/**
 * @property string|null $name Name from the subscriber to generate.
 */
class GenerateSubscriberCommand extends Command
{
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
     * Handle operations with service providers.
     *
     * @var ProviderManager
     */
    protected $service_provider_manager;

    /**
     * @var ProjectManager
     */
    protected $project_manager;

    /**
     * Instantiate the class.
     *
     * @param ClassGenerator $class_generator Class generator.
     * @param Filesystem $filesystem Interacts with the filesystem.
     * @param ProviderManager $service_provider_manager Handle operations with service providers.
     */
    public function __construct(ClassGenerator $class_generator, Filesystem $filesystem, ProviderManager $service_provider_manager, ProjectManager $project_manager)
    {
        parent::__construct('subscriber', 'Generate subscriber class');

        $this->class_generator = $class_generator;
        $this->filesystem = $filesystem;
        $this->service_provider_manager = $service_provider_manager;
        $this->project_manager = $project_manager;

        $this
            ->argument('[name]', 'Full name from the subscriber')
            ->option('-t --type', 'Type of subscriber')
            // Usage examples:
            ->usage(
            // append details or explanation of given example with ` ## ` so they will be uniformly aligned when shown
                '<bold>  $0 subscriber</end> <comment>MyClass</end> ## Creates a common subscriber<eol/>' .
                // $0 will be interpolated to actual command name
                '<bold>  $0 subscriber</end> <comment>MyClass --type common</end> ## Creates a common subscriber<eol/>' .
                '<bold>  $0 subscriber</end> <comment>MyClass --type admin</end> ## Creates a admin subscriber<eol/>' .
                '<bold>  $0 subscriber</end> <comment>MyClass --type front</end> ## Creates a front subscriber<eol/>'
            );

        if($this->project_manager->is_resolver_present()) {
            $this->option('-p --provider', 'Type from the provider');
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
            $this->set('name', $io->prompt('Enter name from the subscriber'));
        }
    }

    /**
     * Execute the command.
     *
     * @param string|null $name
     * @param string|null $type
     * @return void
     */
    public function execute($name, $type, $provider)
    {
        $io = $this->app()->io();

        $name = $this->class_generator->maybe_add_default($name);

        $path = $this->class_generator->generate('subscriber.php.tpl', $name);

        if( ! $path ) {
            $io->write("The class already exists", true);
            return;
        }

        if(! $provider) {
            $provider = '';
        }

        $io->write("The subscriber is created at this path: $path", true);

        $service_provider_name = $this->class_generator->get_dirname( $name );
        $id_subscriber = $this->class_generator->get_fullname($name) . '::class';

        $this->service_provider_manager->maybe_generate_service_provider($name, $provider);

        $this->service_provider_manager->add_class($service_provider_name, $name);

        if( ! $type || $type === 'c' || $type === 'common') {
            $this->service_provider_manager->register_subscriber($id_subscriber, $service_provider_name, new SubscriberType(SubscriberType::COMMON));
        }

        if($type === 'a' || $type === 'admin') {
            $this->service_provider_manager->register_subscriber($id_subscriber, $service_provider_name, new SubscriberType(SubscriberType::ADMIN));
        }

        if($type === 'f' || $type === 'front') {
            $this->service_provider_manager->register_subscriber($id_subscriber, $service_provider_name, new SubscriberType(SubscriberType::FRONT));
        }

    }

}
