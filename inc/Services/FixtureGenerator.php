<?php

namespace RocketLauncherBuilder\Services;

use League\Flysystem\Filesystem;
use RocketLauncherBuilder\Templating\Renderer;

class FixtureGenerator
{
    use DetectReturnTrait;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var Renderer
     */
    protected $renderer;

    /**
     * @param Filesystem $filesystem
     * @param Renderer $renderer
     */
    public function __construct(Filesystem $filesystem, Renderer $renderer)
    {
        $this->filesystem = $filesystem;
        $this->renderer = $renderer;
    }


    public function generate_scenarios(string $path, string $method) {
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
                'has_type' => is_null($type),
                'name' => $key_without_dollar
            ]);
        }

        $has_return_value = $this->has_return($method, $content);

        return $this->renderer->apply_template('/test/_partials/fixturesscenario.php.tpl', [
            'scenario' => '',
            'parameters' => $parameter_template,
            'has_expected' => $has_return_value,
        ]);

    }

    protected function has_method(string $method, string $content) {
        return ( ! preg_match("/public[ \n]+function[ \n]+$method/", $content ) );
    }

    protected function get_parameters(string $method, string $content) {
        if ( ! preg_match("/public[ \n]+function[ \n]+{$method}[ \n]*\((?<parameters>[^\)])*\)/", $content, $results ) ) {
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
