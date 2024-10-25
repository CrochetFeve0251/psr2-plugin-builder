<?php

namespace LaunchpadCLI\Services;

use League\Flysystem\Filesystem;
use LaunchpadCLI\Entities\Configurations;
use LaunchpadCLI\Templating\Renderer;

class SetUpGenerator
{
    use CreateIDTrait, DetectClassTrait, DetectClassTrait;

    /**
     * Interacts with the filesystem.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Renderer that handles layout of template files.
     *
     * @var Renderer
     */
    protected $renderer;

    /**
     * Configuration from the project.
     *
     * @var Configurations
     */
    protected $configurations;

    /**
     * Instantiate the class.
     *
     * @param Filesystem $filesystem Interacts with the filesystem.
     * @param Renderer $renderer Renderer that handles layout of template files.
     * @param Configurations $configurations Configuration from the project.
     */
    public function __construct(Filesystem $filesystem, Renderer $renderer, Configurations $configurations)
    {
        $this->filesystem = $filesystem;
        $this->renderer = $renderer;
        $this->configurations = $configurations;
    }

    /**
     * Generate set_up method.
     *
     * @param string $path Path from the class we generate set_up function for.
     * @param string $fullclass Fullname from the class.
     *
     * @return array
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \LaunchpadCLI\Templating\FileNotFoundException
     */
    public function generate_set_up(string $path, string $fullclass) {

        $usages = [];

        if(! $this->filesystem->has($path)) {
            return [
                'setup' => '',
                'usages' => $usages
            ];
        }

        $content = $this->filesystem->read($path);

        $name = str_replace('.php', '', basename($path) );

        $has_main_class = $this->detect_class($name, $content);
        $has_abstract_class = $this->detect_abstract_class($name, $content);

        $has_main_trait = $this->detect_trait($name, $content);

        $key_main_class = $this->create_id($name);
        if(! $has_main_class && ! $has_main_trait) {
            return [
                'setup' => '',
                'usages' => $usages
            ];
        }

        $parameters = $this->fetch_parameters($content);

        $properties = '';
        $properties_initialisation = '';
        $init_params = '';

        $usages[]= trim(str_replace('/', '\\', $fullclass) ,'\\');

        foreach ($parameters as $key => $type) {
            $key_without_dollar = str_replace('$', '', $key);
            $init_params .= "\$this->$key_without_dollar, ";
            if($type) {
                $usages []= $this->find_fullname( $type, $content );

                $properties .= $this->renderer->apply_template('/test/_partials/parameter.php.tpl', [
                   'type' => $type,
                   'has_type' => true,
                   'name' => $key
                ]);

                $properties_initialisation .= $this->renderer->apply_template('/test/_partials/parameter_init.php.tpl', [
                    'type' => $type,
                    'has_type' => true,
                    'name' => $key_without_dollar
                ]);
                continue;
            }
            $properties .= $this->renderer->apply_template('/test/_partials/parameter.php.tpl', [
                'has_type' => false,
                'name' => $key
            ]);
            $properties_initialisation .= $this->renderer->apply_template('/test/_partials/parameter_init.php.tpl', [
                'has_type' => false,
                'name' => $key_without_dollar
            ]);

        }

        $setup = $this->renderer->apply_template('/test/_partials/setup.php.tpl', [
            'main_class_name' => $key_main_class,
            'main_class_type' => $name,
            'properties' => $properties,
            'is_trait' => $has_main_trait,
            'is_abstract' => $has_abstract_class,
            'properties_initialisation' => $properties_initialisation,
            'init_params' => trim($init_params, ', '),
        ]);

        $usages = array_unique($usages);
        $usages = array_filter($usages);

        $usages = array_filter($usages, function ($usage) {
            return ! $this->is_base_type($usage);
        });

        $usages = array_map(function ($usage) use ($path) {
            return $this->find_fullname_class($path, $usage);
        }, $usages);

        if(count($usages) > 1 || $has_abstract_class || $has_main_trait) {
            array_unshift($usages, 'Mockery');
        }

        return [
            'setup' => $setup,
            'usages' => $usages
        ];
    }

    /**
     * Fetch parameters from the constructor from the class.
     *
     * @param string $content content from the class.
     *
     * @return array<string,string|null>
     */
    protected function fetch_parameters(string $content): array {
        if(! preg_match('/public[\n ]+function[\n ]+__construct\([\n ]*(?<parameters>[^\)]*)[\n ]*\)/',
            $content,
            $results) || ! key_exists('parameters', $results)) {
            return [];
        }
        $parameters = $results['parameters'];
        if(! preg_match_all('/(?<type>\w+)?[ \n]+(?<name>\$\w+)/m', $parameters, $results) ||
            !key_exists('name', $results)) {
            return [];
        }
        $types = $results['type'];
        $names = $results['name'];

        $ouput = array_combine($names, $types);
        if(! $ouput) {
            return [];
        }
        return $ouput;
    }

    /**
     * Find the fullname from a class in the content.
     *
     * @param string $name Name from the class.
     * @param string $content Content to search in.
     *
     * @return string
     */
    protected function find_fullname(string $name, string $content) {
        if(! preg_match("/use[ \n]+(?<class>[^;]*$name);/", $content, $results) ) {
            return $name;
        }
        return $results['class'];
    }

    /**
     * Add a setup method to the class.
     *
     * @param string $setup Setup method to add.
     * @param string $content Content from the class.
     *
     * @return string
     */
    public function add_setup_to_class(string $setup, string $content) {
        if(! preg_match('/(?<class>class[ \n]+\w+[ \n]+extends[ \n]+TestCase[ \n]+{)/', $content, $results)) {
            return $content;
        }
        $class = $results['class'] . "\n" . $setup;
        $class = rtrim($class, " \n");
        return str_replace($results['class'], $class, $content);
    }

    /**
     * Add import from classes used.
     *
     * @param string[] $usages classes used.
     * @param string $content content from the file.
     *
     * @return string
     */
    public function add_usage_to_class(array $usages, string $content) {
        $uses = array_reduce($usages, function ($result, $usage) {
            return $result . "use $usage;\n";
        },"\n");

        if(! preg_match('/(?<namespace>namespace[^;]+;)/', $content, $results)) {
            return $content;
        }
        $namespace = $results['namespace'];
        $replace = $namespace . "\n$uses";
        return str_replace($namespace, $replace, $content);
    }

    /**
     * Find the fullname from the class.
     *
     * @param string $path Path from the usage.
     * @param string $class Short name from the class.
     *
     * @return string
     */
    protected function find_fullname_class(string $path, string $class) {

        $base_namespace = $this->configurations->getBaseNamespace();

        $base_namespace_regex_safe = preg_quote($base_namespace);
        if( preg_match("/^$base_namespace_regex_safe/", $class) ) {
            return $class;
        }

        $relative_path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        $potential_path = dirname($path) . DIRECTORY_SEPARATOR . $relative_path . '.php';

        if( ! $this->filesystem->has($potential_path)) {
            return $class;
        }
        $content = $this->filesystem->read($potential_path);
        if(! $this->detect_class($class, $content)) {
            return $class;
        }

        $base_code_folder = preg_quote($this->configurations->getCodeDir());
        $potential_path = preg_replace("#^$base_code_folder#", $base_namespace, $potential_path);
        $potential_path = str_replace('.php', '', $potential_path);
        return str_replace(DIRECTORY_SEPARATOR, '\\', $potential_path);
    }

    /**
     * Detect if the type is a base one.
     *
     * @param string $type Type to check.
     *
     * @return bool
     */
    protected function is_base_type(string $type) {
        return in_array($type, ['string', 'int', 'float', 'bool', 'array', 'boolean', 'integer', 'object']);
    }
}
