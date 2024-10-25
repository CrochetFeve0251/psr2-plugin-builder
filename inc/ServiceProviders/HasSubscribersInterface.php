<?php

namespace LaunchpadCLI\ServiceProviders;

use League\Event\ListenerSubscriber;

interface HasSubscribersInterface
{
    /**
     * @return ListenerSubscriber[]
     */
    public function get_subscribers(): array;
}