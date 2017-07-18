<?php

namespace EdmondsCommerce\Shipping\Test;
use Magento\TestFramework\TestCase\AbstractController;
use \PHPUnit_Framework_TestCase;

abstract class TestCase extends AbstractController
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