<?php

namespace LaunchpadCLI\ServiceProviders;

use League\Event\EventDispatcher;

trait EventDispatcherAwareTrait
{
    /**
     * Event dispatcher.
     *
     * @var EventDispatcher
     */
    protected $event_dispatcher;

    /**
     * Set the event dispatcher.
     * @param EventDispatcher $event_dispatcher Event dispatcher.
     */
    public function set_event_dispatcher(EventDispatcher $event_dispatcher): void
    {
        $this->event_dispatcher = $event_dispatcher;
    }
}