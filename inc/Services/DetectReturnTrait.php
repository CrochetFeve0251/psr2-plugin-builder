<?php

namespace LaunchpadCLI\Services;

trait DetectReturnTrait
{
    /**
     * Check if the method returns something.
     *
     * @param string $method Method to search.
     * @param string $content Content to search in.
     *
     * @return bool
     */
    protected function has_return(string $method, string $content) {

        if(preg_match("/\/\*\*(?<docblock>[^\/]+)\/[ \n]+public[ \n]+function[ \n]+{$method}/", $content, $results) && preg_match('/@return (void|null)/', $results['docblock'])) {
            return false;
        }

        if(! preg_match("/function\s+{$method}\([^\)]*\)(?<return>[ \n]*:[ \n]*\w+)?\s*(?<content>\{((?:[^{}]+|\{(?3)\})*)\})/", $content, $results ) ) {
            return false;
        }

        $content = $results['content'];

        if(key_exists('return', $results) && $results['return'] && strpos($results['return'], 'void') === false) {
            return true;
        }

        return preg_match('/return\s+([^;]+);/', $content);
    }
}
