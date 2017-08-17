<?php

namespace EdmondsCommerce\Shipping\Test\Unit\Model\Filter;

use EdmondsCommerce\Shipping\Model\Filter\ItemCount;
use Mockery\MockInterface;

class ItemCountTest extends AbstractFilterTest
{
    /** @var  ItemCount */
    protected $class;

    /** @var  MockInterface */
    private $requestMock;

    public function setUp()
    {
        parent::setUp();

        $this->class = new ItemCount();
    }

    protected function getItemCountRequestMock($count)
    {
        $result = [];
        for ($i = 0; $i < $count; $i++)
        {
            $result[] = null;
        }

        return $this->getRateRequestMock()->shouldReceive('getAllItems')->andReturn($result)->getMock();
    }

    protected function getItemCountRateMock($from = null, $to = null)
    {
        return $this->getRateMock()->shouldReceive([
            'getItemsFrom' => $from,
            'getItemsTo' => $to
        ])->getMock();
    }

    /**
     * @test
     */
    public function itShouldSkipWhenNoRestrictionsArePlaced()
    {
        $request = $this->getItemCountRequestMock(5);
        $rate = $this->getItemCountRateMock();

        $this->assertTrue($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itShouldAllowGreaterMinimum()
    {
        $request = $this->getItemCountRequestMock(5);
        $rate = $this->getItemCountRateMock(3);

        $this->assertTrue($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itShouldPreventLessThanMinimum()
    {
        $request = $this->getItemCountRequestMock(5);
        $rate = $this->getItemCountRateMock();

        $this->assertFalse($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itShouldFilterGreaterThanMaximum()
    {
        $request = $this->getItemCountRequestMock(10);
        $rate = $this->getItemCountRateMock(null, 5);

        $this->assertFalse($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itShouldAllowLessThanMaximum()
    {
        $request = $this->getItemCountRequestMock(5);
        $rate = $this->getItemCountRateMock(null, 10);

        $this->assertTrue($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itShouldFilterOnWeightRange()
    {
        $request = $this->getItemCountRequestMock(15);
        $rate = $this->getItemCountRateMock(3, 10);

        $this->assertFalse($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itShouldAllInRange()
    {
        $request = $this->getItemCountRequestMock(5);
        $rate = $this->getItemCountRateMock(3, 10);

        $this->assertFalse($this->class->filter($request, $rate));
    }
}