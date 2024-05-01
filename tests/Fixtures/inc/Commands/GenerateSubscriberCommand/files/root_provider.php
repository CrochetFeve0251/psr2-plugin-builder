<?php

namespace PSR2Plugin;

use PSR2Plugin\Dependencies\LaunchpadCore\Container\AbstractServiceProvider;

/**
 * Service provider.
 */
class ServiceProvider extends AbstractServiceProvider
{

    /**
     * Return IDs from common subscribers.
     *
     * @return string[]
     */
    public function get_common_subscribers(): array {
        return [
            \PSR2Plugin\MySubscriber::class,
        ];
    }

    /**
     * Registers items with the container
     *
     * @return void
     */
    public function define()
    {
        $this->register_service(\PSR2Plugin\MySubscriber::class);
    }
}
