<?php

namespace LaunchpadCLI\Events;

class Filter extends Hook
{
    public function set_parameters(array $parameters) {
        $this->parameters = $parameters;
    }
}