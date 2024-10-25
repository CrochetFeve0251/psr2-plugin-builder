<?php

namespace LaunchpadCLI\Tests\Unit\inc\Templating\Renderer;

use League\Flysystem\Filesystem;
use Mockery;
use LaunchpadCLI\Templating\FileNotFoundException;
use LaunchpadCLI\Templating\Renderer;
use LaunchpadCLI\Tests\Unit\TestCase;

/**
 * @covers \LaunchpadCLI\Templating\Renderer::apply_template
 *
 */
class Test_applyTemplate extends TestCase {

    protected $renderer;

    protected $filesystem;

    protected $template_folder = 'template_folder';

    protected function set_up()
    {
        parent::set_up();
        $this->filesystem = Mockery::mock(Filesystem::class);
        $this->renderer = new Renderer($this->filesystem, $this->template_folder);
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldReturnExpected( $config, $expected )
    {
        $this->filesystem->expects()->has($expected['template_path'])->andReturn($config['template_exists']);
        $this->configureTemplateExists($config, $expected);

        $results = $this->renderer->apply_template($config['template'], $config['variables']);

        if($config['template_exists']) {
            $this->assertSame($expected['content'], $results);
        }
    }

    protected function configureTemplateExists($config, $expected) {
        if(!$config['template_exists']) {
            $this->expectException(FileNotFoundException::class);
            return;
        }
        $this->filesystem->expects()->read($expected['template_path'])->andReturn($config['content']);
    }
}
