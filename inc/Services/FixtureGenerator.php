<?php

namespace LaunchpadCLI\Services;

use League\Flysystem\Filesystem;
use LaunchpadCLI\Templating\Renderer;

class FixtureGenerator
{
    use DetectReturnTrait, DetectParametersTrait;

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
     * Instantiate the class.
     *
     * @param Filesystem $filesystem Interacts with the filesystem.
     * @param Renderer $renderer Renderer that handles layout of template files.
     */
    public function __construct(Filesystem $filesystem, Renderer $renderer)
    {
        $this->filesystem = $filesystem;
        $this->renderer = $renderer;
    }


    /**
     * Generate scenarios for the test.
     *
     * @param string $path Path from the test file.
     * @param string $method Method to test.
     * @param bool $has_return_value Should the test have a return value.
     * @param array $scenarios Scenarios to add to fixtures.
     *
     * @return string
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \LaunchpadCLI\Templating\FileNotFoundException
     */
    public function generate_scenarios(string $path, string $method, bool $has_return_value, array $scenarios) {
        if(! $this->filesystem->has($path)) {
            return '';
        }

        $content = $this->filesystem->read($path);

        $has_method = $this->has_method($method, $content);

        if( ! $has_method ) {
            return '';
        }

        $parameters = $this->get_parameters($method, $content);

        $parameter_template = '';

        foreach ($parameters as $key => $type) {
            $key_without_dollar = str_replace('$', '', $key);
            $parameter_template .= $this->renderer->apply_template('/test/_partials/parameterscenario.php.tpl', [
                'type' => $type,
                'has_type' => ! is_null($type),
                'key' => $key_without_dollar
            ]);
        }

        $output = '';

        foreach ($scenarios as $scenario) {
            $output .= $this->renderer->apply_template('/test/_partials/fixturesscenario.php.tpl', [
                'scenario' => $scenario,
                'values' => $parameter_template,
                'has_expected' => $has_return_value,
            ]);
        }

        return $output;
    }

    /**
     * Check if the content has the method.
     *
     * @param string $method Method to search.
     * @param string $content Content to search in.
     *
     * @return bool
     */
    protected function has_method(string $method, string $content) {
        return (bool) preg_match("/public[ \n]+function[ \n]+$method/", $content );
    }

    /**
     * Check if the method returns something.
     *
     * @param string $path Path from the file to search in.
     * @param string $method Content to search in.
     *
     * @return bool
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function method_has_return(string $path, string $method) {
        if(! $this->filesystem->has($path)) {
            return false;
        }
        $content = $this->filesystem->read($path);

        $has_method = $this->has_method($method, $content);

        if( ! $has_method ) {
            return false;
        }

        return $this->has_return($method, $content);
    }
}
