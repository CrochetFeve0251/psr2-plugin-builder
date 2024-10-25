<?php

namespace LaunchpadCLI\ObjectValues;

class SubscriberType
{
    const COMMON = 'COMMON';
    const FRONT = 'FRONT';

    const ADMIN = 'ADMIN';

    const VALUES = [self::ADMIN, self::FRONT, self::COMMON];

    /**
     * Value validated by the object value.
     *
     * @var string
     */
    protected $value;

    /**
     * Instantiate the class.
     *
     * @param string $value value validated by the object value.
     */
    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    /**
     * Get the value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Validate the value.
     *
     * @param string $value Value to validate.
     *
     * @return void
     * @throws InvalidValue
     */
    protected function validate(string $value) {
        if(! in_array($value, self::VALUES, true)) {
            throw new InvalidValue();
        }
    }

}
