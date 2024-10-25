<?php

namespace LaunchpadCLI\Services;

use League\Flysystem\Filesystem;
use LaunchpadCLI\Entities\Configurations;
use LaunchpadCLI\Templating\Renderer;

class BootstrapManager
{
    const BOOTSTRAP_FILE = '/Integration/bootstrap.php';

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
    protected $configuration;

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
     * @param Configurations $configuration Configuration from the project.
     * @param Renderer $renderer Renderer that handles layout of template files.
     */
    public function __construct(Filesystem $filesystem, Configurations $configuration, Renderer $renderer)
    {
        $this->filesystem = $filesystem;
        $this->configuration = $configuration;
        $this->renderer = $renderer;
    }

    /**
     * Add external group to the bootstrap.
     *
     * @param string $group Group to add.
     *
     * @return bool
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \LaunchpadCLI\Templating\FileNotFoundException
     */
    public function add_external_group(string $group) {

        $bootstrap_path = $this->configuration->getTestDir() . self::BOOTSTRAP_FILE;

        if( ! $this->filesystem->has($bootstrap_path) ) {
            return false;
        }

        $content = $this->filesystem->read($bootstrap_path);

        if(! preg_match('/(?<prefix>tests_add_filter\(\s*\'muplugins_loaded\',\s*function\(\) {\s*\n)/', $content, $results)) {
            return false;
        }

        $prefix = $results['prefix'];

        if( preg_match("/BootstrapManager::isGroup\(\s*[\"']{$group}[\"']\s*\)/", $content)) {
            return false;
        }

        $replacement = $prefix . $this->renderer->apply_template('test/_partials/bootstrapintegrationgroup.php.tpl', [
                'group' => $group
            ]);

        $content = str_replace($prefix, $replacement, $content);

        $content = $this->maybe_add_usage($content);

        $this->filesystem->update($bootstrap_path, $content);

        return true;
    }

    /**
     * Add usage to the bootstrap file if missing.
     *
     * @param string $content Content from the bootstrap file.
     *
     * @return string
     */
    protected function maybe_add_usage(string $content) {
        if( preg_match('/use[ \n]+WPMedia\\\PHPUnit\\\BootstrapManager;/', $content)) {
            return $content;
        }

        if(! preg_match('/(?<namespace>namespace[^;]+;)/', $content, $results)) {
            return $content;
        }

        $namespace = $results['namespace'];

        $replacement = $namespace . "\nuse WPMedia\PHPUnit\BootstrapManager;";

        return str_replace($namespace, $replacement, $content);
    }
}
