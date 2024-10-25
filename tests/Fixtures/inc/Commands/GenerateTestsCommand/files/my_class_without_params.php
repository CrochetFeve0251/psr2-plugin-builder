<?php
namespace PSR2Plugin\Test;

class MyClass {
    protected $test;

    /**
     * @param $test
     */
    public function __construct(string $test)
    {
        $this->test = $test;
    }

    public function my_method(string $test): string {
        return "AZ";
    }

    protected function my_protected_method() {

    }

    public function my_second_method(array $param = []) {

    }
}
