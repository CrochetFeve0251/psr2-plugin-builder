<?php

namespace LaunchpadCLI\Services;

use League\Flysystem\Filesystem;
use LaunchpadCLI\Entities\Configurations;
use LaunchpadCLI\Templating\Renderer;

class ClassGenerator
{
    use CreateIDTrait;

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
     * Get the basename from a class.
     *
     * @param string $name Class fullname.
     *
     * @return string
     */
    public function get_basename(string $name ): string {
        return basename( $name );
    }

    /**
     * Get dirname from a class.
     *
     * @param string $name Class fullname.
     *
     * @return string
     */
    public function get_dirname( string $name): string {
        return implode('/', array_slice(explode('/', $name), 0, -1));
    }

    /**
     * Get fullname from a class.
     *
     * @param string $name Class fullname.
     *
     * @return string
     */
    public function get_fullname( string $name ): string {

        $base = $this->configurations->getBaseNamespace();

        $base = rtrim($base, '\\');

        $name = '\\' . str_replace('/', '\\', $name);

        if(strpos($name, $base) !== false) {
            return $name;
        }

        return $base . $name;
    }

    /**
     * Check if a class exists.
     *
     * @param string $name Name from the class.
     *
     * @return bool
     */
    public function exists( string $name ): bool {
        return $this->filesystem->has($this->generate_path( $name ) );
    }

    /**
     * Generate path from a class name.
     *
     * @param string $name Class name.
     * @param bool $is_test Is the class a test class.
     *
     * @return string
     */
    public function generate_path( string $name, bool $is_test = false ): string {
        $base_namespace = $is_test ? $this->configurations->getBaseNamespace() . 'Tests\\': $this->configurations->getBaseNamespace();

        $base_namespace = str_replace('\\', '/', $base_namespace);

        $code_dir = $is_test ? $this->configurations->getTestDir() : $this->configurations->getCodeDir();

        return str_replace(
                [$base_namespace, "/"],
                [$code_dir, DIRECTORY_SEPARATOR],
                $name
            ) . '.php';
    }

    /**
     * Generate a class.
     *
     * @param string $template Template to use for the class.
     * @param string $class_name Name from the class to generate.
     * @param array $variables Variables to pass to the template.
     * @param bool $is_test Is the class a test class.
     *
     * @return false|string
     * @throws \League\Flysystem\FileExistsException
     * @throws \LaunchpadCLI\Templating\FileNotFoundException
     */
    public function generate(string $template, string $class_name, array $variables = [], bool $is_test = false) {
        $basename = $this->get_basename( $class_name );
        $namespace = implode('\\', array_slice(explode('/', $class_name), 0, -1));

        $base_namespace = $is_test ? $this->configurations->getBaseNamespace() . 'Tests\\': $this->configurations->getBaseNamespace();

        $base_namespace = str_replace('\\', '/', $base_namespace);

        $code_dir = $is_test ? $this->configurations->getTestDir() : $this->configurations->getCodeDir();

        $path = str_replace(
                [$base_namespace, "/"],
                [$code_dir, DIRECTORY_SEPARATOR],
                $class_name
            ) . '.php';

        if( $this->filesystem->has($path)) {
            return false;
        }

        $variables_renderer = array_merge([
            'namespace' => $namespace,
            'base_namespace' => $this->configurations->getBaseNamespace(),
            'class_name' => $basename
        ],
        $variables);

        $content = $this->renderer->apply_template($template, $variables_renderer);

        $this->filesystem->write($path, $content);

        return $path;
    }

    /**
     * Convert String from snake case to camel case.
     * @param string $string string to convert.
     *
     * @return string
     */
    public function snake_to_camel_case(string $string) {
        $result = str_replace('_', '', ucwords($string, '_'));
        return lcfirst($result);
    }

    /**
     * Add the default to the name if it is missing.
     *
     * @param string $name Name from the class.
     * @return string
     */
    public function maybe_add_default(string $name)
    {
        $base_namespace = trim($this->configurations->getBaseNamespace(), '\\');
        if(strpos($name, $base_namespace) !== false) {
            return $name;
        }

        return $base_namespace . DIRECTORY_SEPARATOR . $name;
    }
}
