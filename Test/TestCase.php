<?php

namespace EdmondsCommerce\Shipping\Test;
use \PHPUnit_Framework_TestCase;

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @param string $classname
     * @return \Mockery\MockInterface
     */
    protected function mock($classname)
    {
        return \Mockery::mock($classname);
    }
}