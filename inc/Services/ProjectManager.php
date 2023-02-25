<?php

namespace RocketLauncherBuilder\Services;

use League\Flysystem\Filesystem;
use RocketLauncherBuilder\Entities\Configurations;

class ProjectManager
{
    CONST COMPOSER_FILE = 'composer.json';

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

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
        $scripts['run-tests'][] = "@$group_key";
        $scripts[$group_key] = "\"vendor/bin/phpunit\" --testsuite integration --colors=always --configuration tests/Integration/phpunit.xml.dist --group $group";
        $scripts['test-integration'] .= ",$group";

        $json['scripts'] = $scripts;

        $content = json_encode($json);
        $this->filesystem->update(self::COMPOSER_FILE, $content);

        return true;
    }

    protected function create_id(string $class ) {
        $class = trim( $class, '\\' );
        $class = str_replace( '\\', '.', $class );
        return 'test-integration-' . strtolower( preg_replace( ['/([a-z])\d([A-Z])/', '/[^_]([A-Z][a-z])]/'], '$1_$2', $class ) );
    }
}
