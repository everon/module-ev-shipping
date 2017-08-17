<?php

namespace EdmondsCommerce\Shipping\Test\Unit\Model\Filter;

use EdmondsCommerce\Shipping\Model\Filter\Weight;
use Mockery\MockInterface;

class WeightTest extends AbstractFilterTest
{
    /** @var  Weight */
    protected $class;

    /** @var  MockInterface */
    private $requestMock;

    public function setUp()
    {
        parent::setUp();

        $this->class = new Weight();
    }

    protected function getWeightRequestMock($weight)
    {
        return $this->getRateRequestMock()->shouldReceive('getPackageWeight')->andReturn($weight)->getMock();
    }

    protected function getWeightRateMock($from = null, $to = null)
    {
        return $this->getRateMock()->shouldReceive([
            'getWeightFrom' => $from,
            'getWeightTo' => $to
        ])->getMock();
    }

    /**
     * @test
     */
    public function itShouldSkipWhenNoRestrictionsArePlaced()
    {
        $request = $this->getWeightRequestMock(5);
        $rate = $this->getWeightRateMock();

        $this->assertTrue($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itShouldAllowGreaterMinimum()
    {
        $request = $this->getWeightRequestMock(5);
        $rate = $this->getWeightRateMock(3);

        $this->assertTrue($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itShouldPreventLessThanMinimum()
    {
        $request = $this->getWeightRequestMock(5);
        $rate = $this->getWeightRateMock();

        $this->assertFalse($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itShouldFilterGreaterThanMaximum()
    {
        $request = $this->getWeightRequestMock(10);
        $rate = $this->getWeightRateMock(null, 5);

        $this->assertFalse($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itShouldAllowLessThanMaximum()
    {
        $request = $this->getWeightRequestMock(5);
        $rate = $this->getWeightRateMock(null, 10);

        $this->assertTrue($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itShouldFilterOnWeightRange()
    {
        $request = $this->getWeightRequestMock(15);
        $rate = $this->getWeightRateMock(3, 10);

        $this->assertFalse($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itShouldAllInRange()
    {
        $request = $this->getWeightRequestMock(5);
        $rate = $this->getWeightRateMock(3, 10);

        $this->assertFalse($this->class->filter($request, $rate));
    }
}