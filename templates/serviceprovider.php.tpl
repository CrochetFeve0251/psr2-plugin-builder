<?php

namespace {{ namespace }};

use {{ base_namespace }}\Dependencies\LaunchpadCore\Container\AbstractServiceProvider;

/**
 * Service provider.
 */
class {{ class_name }} extends AbstractServiceProvider
{

    /**
     * The provided array is a way to let the container
     * know that a service is provided by this service
     * provider. Every service that is registered via
     * this service provider must have an alias added
     * to this array or it will be ignored.
     *
     * @var array
     */
    protected $provides = [

    ];

    /**
     * Registers items with the container
     *
     * @return void
     */
    public function register()
    {

    }
}
