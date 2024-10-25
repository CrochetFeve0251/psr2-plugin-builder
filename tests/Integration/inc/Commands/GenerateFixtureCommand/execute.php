<?php

namespace LaunchpadCLI\Tests\Integration\inc\Commands\GenerateFixtureCommand;

use LaunchpadCLI\Tests\Integration\TestCase;

class Test_Execute extends TestCase
{
    /**
     * @dataProvider configTestData
     */
    public function testShouldDoAsExpected($config, $expected) {
        self::assertFalse($this->filesystem->exists($expected['path']));
        $this->launch_app("fixture {$config['class']}");
        self::assertTrue($this->filesystem->exists($expected['path']));
        self::assertSame($expected['content'], $this->filesystem->get_contents($expected['path']));
        self::assertSame($expected['boostrap_content'], $this->filesystem->get_contents($config['bootstrap_path']));
    }
}
