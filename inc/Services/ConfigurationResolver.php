<?php

namespace LaunchpadCLI\Services;

use League\Flysystem\Filesystem;
use LaunchpadCLI\Entities\Configurations;

class ConfigurationResolver
{
    /**
     * Interacts with the filesystem.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Base directory from the project.
     *
     * @var string
     */
    protected $project_dir;

    /**
     * Instantiate the class.
     *
     * @param Filesystem $filesystem Interacts with the filesystem.
     * @param string $project_dir Base directory from the project.
     */
    public function __construct(Filesystem $filesystem, string $project_dir)
    {
        $this->filesystem = $filesystem;
        $this->project_dir = $project_dir;
    }

    /**
     * Get configurations from the project.
     *
     * @return Configurations
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function get_configuration() {
        $composer_json = json_decode($this->filesystem->read( 'composer.json'), true);
        $namespaces = array_keys($composer_json["autoload"]["psr-4"]);

        $test_namespaces = array_keys($composer_json["autoload-dev"]["psr-4"]);

        $namespace = array_shift( $namespaces );
        $test_namespace = array_shift( $test_namespaces );
        $base_dir = $composer_json["autoload"]["psr-4"][$namespace];
        $test_dir = $composer_json["autoload-dev"]["psr-4"][$test_namespace];

        return new Configurations($namespace, $base_dir, $test_dir?: '');
    }
}
