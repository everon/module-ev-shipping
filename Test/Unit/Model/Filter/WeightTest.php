<?php

namespace Everon\EvShipping\Test\Unit\Model\Filter;

use Everon\EvShipping\Model\Filter\Weight;
use Mockery\MockInterface;

class WeightTest extends AbstractRangeFilterTest
{
    /** @var  Weight */
    protected $class;

    public function setUp()
    {
        parent::setUp();

        $this->class = new Weight();
    }

    /**
     * @param $weight int Scalar value to set
     *
     * @return MockInterface
     */
    protected function getRangedRequestMock($weight)
    {
        return $this->getRateRequestMock()->shouldReceive('getPackageWeight')->andReturn($weight)->getMock();
    }

    /**
     * @param null $from
     * @param null $to
     *
     * @return MockInterface
     */
    protected function getRangedRateMock($from = null, $to = null)
    {
        return $this->getRateMock()->shouldReceive([
            'getWeightFrom' => $from,
            'getWeightTo'   => $to,
        ])->getMock();
    }
}
