<?php

namespace Everon\EvShipping\Test;

use Magento\TestFramework\TestCase\AbstractController;

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
