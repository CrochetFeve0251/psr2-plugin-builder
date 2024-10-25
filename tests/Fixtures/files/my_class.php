<?php
namespace PSR2Plugin\Test;

use Brain\Monkey\Name\Exception\InvalidName;

class MyClass {
    protected $test;

    protected $r;

    protected $e_t;

    /**
     * @param $test
     * @param $r
     * @param $e_t
     */
    public function __construct(string $test, InvalidName $r, $e_t)
    {
        $this->test = $test;
        $this->r = $r;
        $this->e_t = $e_t;
    }

    public function my_method(string $test): string {
        return "AZ";
    }

    protected function my_protected_method() {

    }

    public function my_second_method(array $param = []) {

    }
}