<?php

namespace PSR2Plugin\Tests\Unit\inc\Test\MyClass;

use PSR2Plugin\Test\MyClass;


use PSR2Plugin\Tests\Unit\TestCase;

/**
 * @covers \PSR2Plugin\Test\MyClass::my_second_method
 */
class Test_mySecondMethod extends TestCase {

    /**
     * @var string
     */
    protected $test;

    /**
     * @var MyClass
     */
    protected $myclass;

    public function set_up() {
        parent::set_up();
        $this->test = '';

        $this->myclass = new MyClass($this->test);
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldDoAsExpected( $config )
    {
        $this->myclass->my_second_method($config['param']);

    }
}
