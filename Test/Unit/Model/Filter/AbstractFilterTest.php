<?php

namespace Everon\EvShipping\Test\Unit\Model\Filter;

use Everon\EvShipping\Model\Rate;
use Everon\EvShipping\Test\Unit\UnitTestCase;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Mockery\MockInterface;

abstract class AbstractFilterTest extends UnitTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @return MockInterface
     */
    protected function getRateRequestMock()
    {
        return $this->mock(RateRequest::class);
    }

    /**
     * @return MockInterface
     */
    public function getRateMock()
    {
        return $this->mock(Rate::class);
    }
}
