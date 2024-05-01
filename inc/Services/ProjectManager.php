<?php

namespace LaunchpadCLI\Services;

use League\Flysystem\Filesystem;
use LaunchpadCLI\Entities\Configurations;

class ProjectManager
{
    CONST COMPOSER_FILE = 'composer.json';

    /**
     * Interacts with the filesystem.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Instantiate the class.
     *
     * @param Filesystem $filesystem Interacts with the filesystem.
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Add an external run for a group.
     *
     * @param string $group Group to create the external run.
     *
     * @return bool
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function add_external_test_group(string $group) {

        if( ! $this->filesystem->has(self::COMPOSER_FILE)) {
            return false;
        }

        $content = $this->filesystem->read(self::COMPOSER_FILE);
        $json = json_decode($content,true);

        if(! $json || ! key_exists('scripts', $json) || ! key_exists('test-integration', $json['scripts']) || ! key_exists('run-tests', $json['scripts']) ) {
            return false;
        }

        $scripts = $json['scripts'];

        $group_key = $this->create_id($group);
        if (! in_array("@$group_key", $scripts['run-tests'])) {
            $scripts['run-tests'][] = "@$group_key";
        }
        $scripts[$group_key] = "\"vendor/bin/phpunit\" --testsuite integration --colors=always --configuration tests/Integration/phpunit.xml.dist --group $group";
        if(preg_match("/,$group,|$/", $scripts['test-integration'])) {
            $scripts['test-integration'] .= ",$group";
        }

        $json['scripts'] = $scripts;

        $content = json_encode($json, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) . "\n";
        $this->filesystem->update(self::COMPOSER_FILE, $content);

        return true;
    }

    public function is_resolver_present() {
        if( ! $this->filesystem->has(self::COMPOSER_FILE)) {
            return false;
        }

        $content = $this->filesystem->read(self::COMPOSER_FILE);
        $json = json_decode($content,true);

        if (! $json ) {
            return false;
        }

        return $this->is_detected($json, 'wp-launchpad/autoresolver');
    }

    protected function is_detected(array $json , string $library)
    {

        if( ! key_exists('extra', $json)) {
            return false;
        }


        foreach (['strauss', 'mozart'] as $config) {
            if (key_exists($config, $json['extra']) &&
                key_exists('packages', $json['extra'][$config]) &&
                in_array($library, $json['extra'][$config]['packages'])
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Create an ID from the class.
     *
     * @param string $class Class to create the ID from.
     *
     * @return string
     */
    protected function create_id(string $class ) {
        $class = trim( $class, '\\' );
        $class = str_replace( '\\', '.', $class );
        return 'test-integration-' . strtolower( preg_replace( ['/([a-z])\d([A-Z])/', '/[^_]([A-Z][a-z])]/'], '$1_$2', $class ) );
    }

}
