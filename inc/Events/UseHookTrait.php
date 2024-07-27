<?php

namespace LaunchpadCLI\Events;

use LaunchpadCLI\ServiceProviders\EventDispatcherAwareTrait;
use League\Event\EventDispatcher;

trait UseHookTrait
{

    use EventDispatcherAwareTrait;

    protected function apply_filter(string $name, array $parameters = []): array {
        $filter = new Filter($name, $parameters);
        $filter = $this->event_dispatcher->dispatch($filter);
        return $filter->get_parameters();
    }

    protected function do_action(string $name, array $parameters): void  {
        $action = new Action($name, $parameters);
        $this->event_dispatcher->dispatch($action);
    }
}