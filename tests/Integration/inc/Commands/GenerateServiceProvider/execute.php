<?php

namespace LaunchpadCLI\Tests\Integration\inc\Commands\GenerateServiceProvider;

use LaunchpadCLI\Tests\Integration\TestCase;

class Test_Execute extends TestCase
{
    /**
     * @dataProvider configTestData
     */
    public function testShouldDoAsExpected($config, $expected) {
        if(key_exists('custom_composer', $config)) {
            $this->filesystem->put_contents('composer.json', $config['custom_composer']);
        }
        self::assertFalse($this->filesystem->exists($expected['path']));
        $this->launch_app("provider {$config['class']}{$config['parameters']}");
        self::assertTrue($this->filesystem->exists($expected['path']));
        self::assertSame($expected['content'], $this->filesystem->get_contents($expected['path']));
        self::assertSame($expected['plugin_content'], $this->filesystem->get_contents($config['plugin_path']));
    }
}
