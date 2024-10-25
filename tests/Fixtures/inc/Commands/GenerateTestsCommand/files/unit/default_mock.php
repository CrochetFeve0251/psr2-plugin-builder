<?php

namespace PSR2Plugin\Tests\Unit\inc\Test\MyClass;

use Mockery;
use PSR2Plugin\Test\MyClass;
use Brain\Monkey\Name\Exception\InvalidName;


use PSR2Plugin\Tests\Unit\TestCase;

/**
 * @covers \PSR2Plugin\Test\MyClass::my_method
 */
class Test_myMethod extends TestCase {

    /**
     * @var string
     */
    protected $test;

    /**
     * @var InvalidName
     */
    protected $r;

    protected $e_t;

    /**
     * @var MyClass
     */
    protected $myclass;

    public function set_up() {
        parent::set_up();
        $this->test = '';
        $this->r = Mockery::mock(InvalidName::class);
        $this->e_t = null;

        $this->myclass = Mockery::mock(MyClass::class, [$this->test, $this->r, $this->e_t])->makePartial();
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldReturnAsExpected( $config, $expected )
    {
        $this->assertSame($expected, $this->myclass->my_method($config['test']));

    }
}
