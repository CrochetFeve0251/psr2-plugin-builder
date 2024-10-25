<?php

namespace LaunchpadCLI\ServiceProviders;

use League\Event\EventDispatcher;

interface EventDispatcherAwareInterface
{
    /**
     * Set the event dispatcher.
     *
     * @param EventDispatcher $event_dispatcher Event dispatcher.
     * @return mixed
     */
    public function set_event_dispatcher(EventDispatcher $event_dispatcher);
}