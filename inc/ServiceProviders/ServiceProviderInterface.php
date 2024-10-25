<?php

namespace LaunchpadCLI\ServiceProviders;

use LaunchpadCLI\App;

interface ServiceProviderInterface
{
    /**
     * Attach commands from the service provider to the cli.
     *
     * @param App $app cli.
     *
     * @return App
     */
    public function attach_commands(App $app): App;
}
