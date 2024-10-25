<?php

$content = <<<CONTENT
<?php

namespace LaunchpadCLI\Services;

use League\Flysystem\Filesystem;
use LaunchpadCLI\Entities\Configurations;
use LaunchpadCLI\Templating\Renderer;

class ClassGenerator
{
    /**
     * @var Filesystem
     */
    protected \$filesystem;
    
    /**
     * @param Filesystem \$filesystem
     * @param Renderer \$renderer
     * @param Configurations \$configurations
     */
    public function __construct(Filesystem \$filesystem)
    {
        \$this->filesystem = \$filesystem;
    }

    public function get_basename(string \$name ): string {
        return basename( \$name );
    }
}
CONTENT;

$setup = <<<SETUP
    protected \$value;
    protected \$class_generator;

    public function set_up() {
        parent::set_up();
        \$this->value = Mockery::mock(Value::class);
        \$this->class_generator = new ClassGenerator(\$this->value);
    }
SETUP;


return [
    'classDoesNotExistShouldReturnEmpty' => [
        'config' => [
            'path' => '/inc/ClassGenerator.php',
            'file_exists' => false,
            'content' => $content,
            'parameter' => 'protected $value;',
            'parameter_init' => '$this->value = Mockery::mock($this->value);',
            'setup' => '',
            'fullclassname' => '/LaunchpadCLI/Services/ClassGenerator'
        ],
        'expected' => [
            'path' => '/inc/ClassGenerator.php',
            'set_up' => [
                'setup' => '',
                'usages' => [],
            ],
            'parameter_params' => [],
            'parameter_init_params' => [],
            'setup_params' => [],
        ],
    ],
    'classExistShouldReturnSetUp' => [
        'config' => [
            'path' => '/inc/ClassGenerator.php',
            'file_exists' => true,
            'content' => $content,
            'parameter' => 'protected $value;',
            'parameter_init' => '$this->value = Mockery::mock(Filesystem::class);',
            'setup' => $setup,
            'fullclassname' => '/LaunchpadCLI/Services/ClassGenerator'
        ],
        'expected' => [
            'path' => '/inc/ClassGenerator.php',
            'set_up' => [
                'setup' => $setup,
                'usages' => [
                    'LaunchpadCLI\Services\ClassGenerator',
                    'Mockery',
                    'League\Flysystem\Filesystem',
                ],
            ],
            'parameter_params' => [
                'type' => 'Filesystem',
                'has_type' => true,
                'name' => '$filesystem'
            ],
            'parameter_init_params' => [
                'type' => 'Filesystem',
                'has_type' => true,
                'name' => 'filesystem'
            ],
            'setup_params' => [
                'main_class_name' => 'classgenerator',
                'main_class_type' => 'ClassGenerator',
                'properties' => 'protected $value;',
                'properties_initialisation' => '$this->value = Mockery::mock(Filesystem::class);',
                'init_params' => '$this->filesystem',
            ],
        ],
    ]
];