<?php

namespace LaunchpadCLI;

use LaunchpadCLI\ServiceProviders\EventDispatcherAwareInterface;
use LaunchpadCLI\ServiceProviders\HasSubscribersInterface;
use League\Event\EventDispatcher;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use LaunchpadCLI\ServiceProviders\BaseServiceProvider;
use LaunchpadCLI\ServiceProviders\ServiceProviderInterface;
use LaunchpadCLI\Services\ConfigurationResolver;

class AppBuilder
{
    /**
     * Is the test mode active.
     *
     * @var bool
     */
    protected static $is_test_mode = false;

    /**
     *  Initiate the CLI.
     *
     * @param string $project_dir Base directory from the project.
     * @param string[] $service_providers Service providers to add to the CLI.
     */
    public static function init(string $project_dir, array $service_providers = [])
    {
        $app = new App('Launchpad', "1.0.4", self::$is_test_mode ? function() {} : null);
        $app->logo("
  _                      _                  _ 
 | |   __ _ _  _ _ _  __| |_  _ __  __ _ __| |
 | |__/ _` | || | ' \/ _| ' \| '_ \/ _` / _` |
 |____\__,_|\_,_|_||_\__|_||_| .__/\__,_\__,_|
                             |_|              ");



        $service_providers = array_merge($service_providers, [
            BaseServiceProvider::class,
        ]);

        $adapter = new Local($project_dir, self::$is_test_mode ? 0 : LOCK_EX);

        // The FilesystemOperator
        $filesystem = new Filesystem($adapter);

        $event_dispatcher = new EventDispatcher();

        $configs = (new ConfigurationResolver($filesystem, $project_dir))->get_configuration();
        foreach ($service_providers as $service_provider) {
            $instance = new $service_provider($configs, $filesystem, __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
            if(! $instance instanceof ServiceProviderInterface){
                continue;
            }

            if( $instance instanceof EventDispatcherAwareInterface) {
               $instance->set_event_dispatcher($event_dispatcher);
            }

            if( $instance instanceof HasSubscribersInterface) {
                foreach ($instance->get_subscribers() as $subscriber) {
                    $event_dispatcher->subscribeListenersFrom($subscriber);
                }
            }

            $app = $instance->attach_commands($app);
        }
        $app->handle($_SERVER['argv']);
    }

    /**
     * Enable test mode.
     *
     * @return void
     */
    public static function enable_test_mode() {
        self::$is_test_mode = true;
    }
}
