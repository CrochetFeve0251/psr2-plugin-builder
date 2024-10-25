<?php

namespace LaunchpadCLI\ServiceProviders;

use LaunchpadCLI\App;
use LaunchpadCLI\Entities\Configurations;
use LaunchpadCLI\Templating\Renderer;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

abstract class AbstractServiceProvider implements ServiceProviderInterface, EventDispatcherAwareInterface
{
    use EventDispatcherAwareTrait;
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
    protected $configs;

    /**
     * base directory from the cli.
     *
     * @var string
     */
    protected $app_dir;


    /**
     * Instantiate the class.
     *
     * @param Configurations $configs configuration from the project.
     * @param Filesystem $filesystem Interacts with the filesystem.
     * @param string $app_dir base directory from the cli.
     */
    public function __construct(Configurations $configs, Filesystem $filesystem, string $app_dir)
    {
        $this->configs = $configs;
        $this->filesystem = $filesystem;
        $this->app_dir = $app_dir;
    }

}