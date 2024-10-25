<?php

namespace LaunchpadCLI\Tests\Integration\inc\Commands\GenerateTestsCommand;

use LaunchpadCLI\Tests\Integration\TestCase;

class Test_Execute extends TestCase
{
    /**
     * @dataProvider configTestData
     */
    public function testShouldDoAsExpected($config, $expected) {
        foreach ($config['methods'] as $path => $test) {
            $this->assertSame($test['exists'], $this->filesystem->exists($path));
            if($test['exists']) {
                $this->assertSame($test['content'], $this->filesystem->get_contents($path));
            }
        }
        if(key_exists('my_class_path', $config)) {
            $this->filesystem->put_contents($config['my_class_path'], $config['my_class_content']);
        }
        $this->launch_app("test {$config['class']}{$config['parameters']}");
        foreach ($expected['methods'] as $path => $test) {
            $this->assertSame($test['exists'], $this->filesystem->exists($path), "$path should exist");
            if($test['exists']) {
                $this->assertSame($test['content'], $this->filesystem->get_contents($path), "$path should have right content");
            }
        }
    }
}
