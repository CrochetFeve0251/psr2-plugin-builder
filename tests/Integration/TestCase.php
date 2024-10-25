<?php

namespace LaunchpadCLI\Tests\Integration;

use ReflectionObject;
use LaunchpadCLI\AppBuilder;
use WPMedia\PHPUnit\Unit\TestCase as UnitTestCase;
use WPMedia\PHPUnit\Unit\VirtualFilesystemTestCase;
use WPMedia\PHPUnit\VirtualFilesystemTestTrait;

abstract class TestCase extends VirtualFilesystemTestCase
{

    protected $config;

    protected function setUp(): void {
        parent::setUp();

        if ( empty( $this->config ) ) {
            $this->loadTestDataConfig();
        }

        $this->init();

    }

    public function configTestData() {
        if ( empty( $this->config ) ) {
            $this->loadTestDataConfig();
        }

        return isset( $this->config['test_data'] )
            ? $this->config['test_data']
            : $this->config;
    }

    protected function launch_app(string $command) {
        $argv = array_merge(['index.php'], explode(' ', $command));

        $_SERVER['argv'] = $argv;
        AppBuilder::enable_test_mode();
        AppBuilder::init($this->rootVirtualUrl);
        unset($_SERVER['argv']);
    }

    protected function loadTestDataConfig() {
        $obj      = new ReflectionObject( $this );
        $filename = $obj->getFileName();

        $this->config = $this->getTestData( dirname( $filename ), basename( $filename, '.php' ) );
    }
}
