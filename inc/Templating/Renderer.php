<?php

namespace LaunchpadCLI\Templating;

use League\Flysystem\Filesystem;

class Renderer
{
    /**
     * @var string Folder where templates are.
     */
    public $templates_folder;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Instantiate the class.
     *
     * @param Filesystem $filesystem Interacts with the filesystem.
     * @param string $templates_folder Folder where templates are.
     */
    public function __construct(Filesystem $filesystem, string $templates_folder)
    {
        $this->filesystem = $filesystem;
        $this->templates_folder = $templates_folder;
    }

    /**
     * Apply variables to the template.
     *
     * @param string $template_name Path to the template.
     * @param array<string,mixed> $variables Variables to apply to the template.
     *
     * @return string
     *
     * @throws FileNotFoundException
     */
    public function apply_template(string $template_name, array $variables = []): string
    {
        $template = $this->get_template($template_name);

        $template = $this->apply_ifs($template, $variables);

        foreach ($variables as $variable_name => $variable_value) {
            $template = str_replace("{{ $variable_name }}", $variable_value, $template);
        }

        return $template;
    }

    /**
     * Apply if from the template.
     *
     * @param string $content Content from the template.
     * @param array $variables Variables to apply to the template.
     * @return string
     */
    protected function apply_ifs(string $content, array $variables = []): string {
        if ( ! preg_match_all('/ *\{%[ \n]+if[ \n]+(?<condition>[^:]+):[ \n]+%\}\n?(?<content_if>[\s\S]*?)( *\n?\{%[ \n]+else[ \n]+%\}\n?(?<content_else>[\s\S]*?))? *\n?\{%[ \n]+endif[ \n]+%\}\n?/m', $content, $results)) {
            return $content;
        }
        $ifs_mapping = [];

        foreach ($results[0] as $match) {
            $id = uniqid('rendering_if_');
            $ifs_mapping[$id] = $match;
        }

        $conditions = $results['condition'];
        $contents_if = $results['content_if'];
        $contents_else = $results['content_else'];

        foreach ($ifs_mapping as $id => $value) {
            $content = str_replace($value, $id, $content);
        }
        $index = -1;
        foreach ($ifs_mapping as $id => $value) {
            $index ++;
            $condition = $conditions[$index];
            foreach ($variables as $variable_name => $variable_value) {
                if($variable_value === false) {
                    $variable_value = 'false';
                }
                $condition = str_replace("{{ $variable_name }}", $variable_value, $condition);
            }

            $is_true = (bool) eval('return ' . $condition . ';');
            if($is_true) {
                $content = str_replace($id, $contents_if[$index], $content);
                continue;
            }

            $content = str_replace($id, $contents_else[$index], $content);
        }

        return $content;
    }

    /**
     * Get the content from the template from its path.
     *
     * @param string $template Path from the template.
     *
     * @return string
     *
     * @throws FileNotFoundException
     */
    public function get_template(string $template): string
    {
        $template_file = $this->templates_folder . $template;
        if (!$this->filesystem->has($template_file)) {
            throw new FileNotFoundException("Template file not found.");
        }

        return $this->filesystem->read($template_file);
    }
}
