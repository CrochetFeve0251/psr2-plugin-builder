<?php

namespace LaunchpadCLI\Entities;

class Configurations
{
    /**
     * Base namespace from the project.
     *
     * @var string
     */
    protected $base_namespace;

    /**
     * Base directory from the code of the project.
     *
     * @var string
     */
    protected $code_dir;

    /**
     * Base directory from the tests of the project.
     *
     * @var string
     */
    protected $test_dir;

    /**
     * Instantiate the class.
     *
     * @param string $base_namespace Base namespace from the project.
     * @param string $code_dir Base directory from the code of the project.
     * @param string $test_dir Base directory from the tests of the project.
     */
    public function __construct(string $base_namespace, string $code_dir, string $test_dir)
    {
        $this->base_namespace = $base_namespace;
        $this->code_dir = $code_dir;
        $this->test_dir = $test_dir;
    }

    /**
     * Get the base namespace from the project.
     *
     * @return string
     */
    public function getBaseNamespace(): string
    {
        return $this->base_namespace;
    }

    /**
     * Get the base directory from the code of the project.
     *
     * @return string
     */
    public function getCodeDir(): string
    {
        return $this->code_dir;
    }

    /**
     * Get the base directory from the tests of the project.
     *
     * @return string
     */
    public function getTestDir(): string
    {
        return $this->test_dir;
    }
}
