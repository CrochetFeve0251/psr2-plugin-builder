<?php

namespace LaunchpadCLI\Events;

class Hook implements \League\Event\HasEventName
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @param string $name
     */
    public function __construct(string $name, array $parameters)
    {
        $this->name = $name;
        $this->parameters = $parameters;
    }


    public function eventName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function get_name(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function get_parameters(): array
    {
        return $this->parameters;
    }

}