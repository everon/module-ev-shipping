<?php

namespace EdmondsCommerce\Shipping\Test\Unit\Model\Filter;

use EdmondsCommerce\Shipping\Model\Filter\CartPrice;
use Mockery\MockInterface;

abstract class AbstractRangeFilterTest extends AbstractFilterTest
{

    /** @var  CartPrice */
    protected $class;

    public function setUp()
    {
        parent::setUp();

        $this->class = new CartPrice();
    }

    /**
     * @param $count int Scalar value to set
     *
     * @return MockInterface
     */
    abstract protected function getRangedRequestMock($count);


    /**
     * @param null $from
     * @param null $to
     *
     * @return MockInterface
     */
    abstract protected function getRangedRateMock($from = null, $to = null);

    /**
     * @test
     */
    public function itShouldSkipWhenNoRestrictionsArePlaced()
    {
        $request = $this->getRangedRequestMock(5);
        $rate    = $this->getRangedRateMock();

        $this->assertTrue($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itShouldAllowGreaterMinimum()
    {
        $request = $this->getRangedRequestMock(5);
        $rate    = $this->getRangedRateMock(3);

        $this->assertTrue($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itShouldPreventLessThanMinimum()
    {
        $request = $this->getRangedRequestMock(5);
        $rate    = $this->getRangedRateMock(8);

        $this->assertFalse($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itShouldFilterGreaterThanMaximum()
    {
        $request = $this->getRangedRequestMock(10);
        $rate    = $this->getRangedRateMock(null, 5);

        $this->assertFalse($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itShouldAllowLessThanMaximum()
    {
        $request = $this->getRangedRequestMock(5);
        $rate    = $this->getRangedRateMock(null, 10);

        $this->assertTrue($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itShouldFilterOnRange()
    {
        $request = $this->getRangedRequestMock(15);
        $rate    = $this->getRangedRateMock(3, 10);

        $this->assertFalse($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itShouldAllowInRange()
    {
        $request = $this->getRangedRequestMock(5);
        $rate    = $this->getRangedRateMock(3, 10);

        $this->assertTrue($this->class->filter($request, $rate));
    }
}
