<?php

namespace LaunchpadCLI\Services;

trait DetectClassTrait
{
    /**
     * Detect if a class is present in the content.
     *
     * @param string $name Name from the class.
     * @param string $content Content to check in.
     *
     * @return bool
     */
    protected function detect_class(string $name, string $content) {
        return (bool) preg_match("/class[\n ]+$name/", $content);
    }

    /**
     * Detect if an abstract class is present in the content.
     *
     * @param string $name Name from the class.
     * @param string $content Content to check in.
     *
     * @return bool
     */
    protected function detect_abstract_class(string $name, string $content) {
        return (bool) preg_match("/abstract\s+class[\n ]+$name/", $content);
    }

    /**
     * Detect if a trait is present in the content.
     *
     * @param string $name Name from the trait.
     * @param string $content Content to check in.
     *
     * @return bool
     */
    protected function detect_trait(string $name, string $content) {
        return (bool) preg_match("/trait[\n ]+$name/", $content);
    }
}
