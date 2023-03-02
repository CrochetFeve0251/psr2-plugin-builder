<?php

namespace RocketLauncherBuilder\Tests\Integration\inc\Commands\GenerateTestsCommand;

use RocketLauncherBuilder\Tests\Integration\TestCase;

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
        $this->launch_app("test {$config['class']}{$config['parameters']}");
        foreach ($expected['methods'] as $path => $test) {
            $this->assertSame($test['exists'], $this->filesystem->exists($path), "$path should exist");
            if($test['exists']) {
                $this->assertSame($test['content'], $this->filesystem->get_contents($path), "$path should have right content");
            }
        }
    }
}
