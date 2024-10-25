<?php

namespace LaunchpadCLI;

use Ahc\Cli\Application;
use Ahc\Cli\Helper\Shell;

class App extends Application
{
    /**
     * Launch a command from PHP code.
     *
     * @param string $command_class class from the command to launch.
     * @param array $params params from the command.
     *
     * @return void
     */
    public function launchCommand(string $command_class, array $params = []) {
        $command_instance = array_reduce($this->commands, function ($result, $command) use ($command_class) {
            if( $result ) {
                return $result;
            }

            if( $command instanceof $command_class) {
                return $command;
            }

            return $result;
        }, null);

        if(! $command_instance) {
            return;
        }

        $command_instance->parse($params);

        $this->doAction($command_instance);
    }

    /**
     * Launch a shell command.
     *
     * @param string $command command to launch.
     * @param string|null $directory directory to exec
     * @param array $env
     * @param float $timeout
     * @return Shell
     */
    public function launchShell(string $command, string $directory = null, array $env = [], float $timeout = 10.5) {
        $shell = new Shell($command);
        return $shell->setOptions($directory, $env, $timeout)->execute();
    }
}
