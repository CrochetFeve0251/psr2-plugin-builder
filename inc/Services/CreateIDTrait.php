<?php

namespace LaunchpadCLI\Services;

trait CreateIDTrait
{
    /**
     * Create an ID from the class.
     *
     * @param string $class Class to create the ID from.
     *
     * @return string
     */
    public function create_id(string $class ) {
        $class = trim( $class, '\\' );
        $class = str_replace( '\\', '.', $class );
        return strtolower( preg_replace( ['/([a-z])\d([A-Z])/', '/[^_]([A-Z][a-z])]/'], '$1_$2', $class ) );
    }
}
