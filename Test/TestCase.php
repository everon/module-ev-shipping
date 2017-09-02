<?php

namespace EdmondsCommerce\Shipping\Test;

use Magento\TestFramework\TestCase\AbstractController;
use \PHPUnit_Framework_TestCase;

abstract class TestCase extends AbstractController
{
    public function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    /**
     * @param string $classname
     *
     * @return \Mockery\MockInterface
     */
    protected function mock($classname)
    {
        return \Mockery::mock($classname);
    }
}
