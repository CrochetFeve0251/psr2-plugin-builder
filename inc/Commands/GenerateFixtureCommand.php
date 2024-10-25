<?php

namespace LaunchpadCLI\Commands;

use Ahc\Cli\IO\Interactor;
use League\Flysystem\Filesystem;
use LaunchpadCLI\Entities\Configurations;
use LaunchpadCLI\Services\ClassGenerator;

/**
 * @property string|null $name Name from the fixture to generate.
 */
class GenerateFixtureCommand extends Command
{
    /**
     * Class generator.
     *
     * @var ClassGenerator
     */
    protected $class_generator;

    /**
     * Interacts with the filesystem.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Configuration from the project.
     *
     * @var Configurations
     */
    protected $configurations;

    /**
     * Instantiate the class.
     *
     * @param ClassGenerator $class_generator Class generator.
     * @param Filesystem $filesystem Interacts with the filesystem.
     * @param Configurations $configurations Configuration from the project.
     */
    public function __construct(ClassGenerator $class_generator, Filesystem $filesystem, Configurations $configurations)
    {
        parent::__construct('fixture', 'Generate fixture class');

        $this->class_generator = $class_generator;
        $this->filesystem = $filesystem;
        $this->configurations = $configurations;

        $this
            ->argument('[name]', 'Full name from the fixture')
            // Usage examples:
            ->usage(
            // append details or explanation of given example with ` ## ` so they will be uniformly aligned when shown
                '<bold>  $0 fixture</end> <comment>MyClass </end> ## Create the fixture<eol/>'
            );
    }

    /**
     * Interacts with the user to get missing values.
     *
     * @param Interactor $io Interface to interact with the user.
     * @return void
     */
    public function interact(Interactor $io)
    {
        // Collect missing opts/args
        if (!$this->name) {
            $this->set('name', $io->prompt('Enter name from the fixture'));
        }
    }

    /**
     * Execute the command.
     *
     * @param string|null $name Name from the fixture to generate.
     * @return void
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function execute($name)
    {
        $io = $this->app()->io();
        $test_namespace = str_replace('\\', '/', $this->configurations->getBaseNamespace() ) . 'Tests/';
        $fixture_path = $test_namespace . 'Fixtures/classes/' . $name;
        $relative_path = '/classes/' . $name . '.php';
        $path = $this->class_generator->generate('fixture.php.tpl', $fixture_path, [], true);

        if( ! $path ) {
            $io->write("The class already exists", true);
            return;
        }

        $bootstrap = $this->configurations->getTestDir() . '/Unit/bootstrap.php';

        $bootstrap_content = $this->filesystem->read( $bootstrap );
        preg_match('/\$fixtures = \[(?<content>[^]]*)];/', $bootstrap_content, $content);
        $content = $content['content'] . "    '" . $relative_path . "',\n";
        $bootstrap_content = preg_replace('/\$fixtures = \[(?<content>[^\]])*];/', "\$fixtures = [$content    ];", $bootstrap_content);

        $this->filesystem->update( $bootstrap, $bootstrap_content );
    }
}
