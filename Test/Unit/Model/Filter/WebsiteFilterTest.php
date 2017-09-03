<?php

namespace Everon\EvShipping\Test\Unit\Model\Filter;

use Everon\EvShipping\Model\Filter\Website;
use Mockery\MockInterface;

class WebsiteFilterTest extends AbstractFilterTest
{
    /** @var  Website */
    protected $class;

    public function setUp()
    {
        parent::setUp();

        $this->class = new Website();
    }

    /**
     * @param string $website
     *
     * @return MockInterface
     */
    protected function getWebsiteRequestMock($website)
    {
        return $this->getRateRequestMock()->shouldReceive('getWebsiteId')->andReturn($website)->getMock();
    }

    /**
     * @param string[] $websites
     *
     * @return MockInterface
     */
    protected function getWebsiteRateMock(array $websites)
    {
        return $this->getRateMock()->shouldReceive('getWebsiteIds')->andReturn($websites)->getMock();
    }

    /**
     * @test
     */
    public function itWillFilterOutAWebsite()
    {
        $request = $this->getWebsiteRequestMock('1');
        $rate    = $this->getWebsiteRateMock(['2', '3']);

        $this->assertFalse($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itWillFindAWebsite()
    {
        $request = $this->getWebsiteRequestMock('2');
        $rate    = $this->getWebsiteRateMock(['1', '2']);

        $this->assertTrue($this->class->filter($request, $rate));
    }
}
