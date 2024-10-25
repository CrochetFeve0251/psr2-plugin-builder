<?php

namespace LaunchpadCLI\Tests\Unit\inc\Services\SetUpGenerator;

use League\Flysystem\Filesystem;
use Mockery;
use LaunchpadCLI\Services\SetUpGenerator;
use LaunchpadCLI\Templating\Renderer;
use LaunchpadCLI\Tests\Unit\TestCase;

/**
 * @covers \LaunchpadCLI\Services\SetUpGenerator::generate_set_up
 *
 */
class Test_generateSetUp extends TestCase {

    protected $filesystem;
    protected $renderer;
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->filesystem = Mockery::mock(Filesystem::class);
        $this->renderer = Mockery::mock(Renderer::class);
        $this->service = new SetUpGenerator($this->filesystem, $this->renderer);
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldReturnExpected( $config, $expected )
    {
        $this->filesystem->expects()->has($expected['path'])->andReturn($config['file_exists']);
        $this->configureDetectClass($config, $expected);
        $this->assertSame($expected['set_up'], $this->service->generate_set_up($config['path'], $config['fullclassname']));
    }

    protected function configureDetectClass( $config, $expected ) {
        if(! $config['file_exists']) {
            return;
        }
        $this->filesystem->expects()->read($expected['path'])->andReturn($config['content']);

        $this->renderer->expects()->apply_template('/test/_partials/parameter.php.tpl', $expected['parameter_params'])
            ->andReturn($config['parameter']);
        $this->renderer->expects()->apply_template('/test/_partials/parameter_init.php.tpl', $expected['parameter_init_params'])
            ->andReturn($config['parameter_init']);
        $this->renderer->expects()->apply_template('/test/_partials/setup.php.tpl', $expected['setup_params'])
            ->andReturn($config['setup']);
    }
}
