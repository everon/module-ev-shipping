<?php

namespace Everon\EvShipping\Test\Unit\Model\Filter;

use Everon\EvShipping\Model\Filter\Postcode;

class PostcodeFilterTest extends AbstractFilterTest
{
    /** @var Postcode */
    protected $class;

    public function setUp()
    {
        parent::setUp();

        $this->class = new Postcode();
    }

    /**
     * @param $requestedPostCode
     *
     * @return \Mockery\MockInterface
     */
    protected function getPostCodeRequestMock($requestedPostCode)
    {
        return $this->getRateRequestMock()->shouldReceive('getDestPostcode')
                    ->andReturn($requestedPostCode)->getMock();
    }

    /**
     * @param array $patterns
     *
     * @return \Mockery\MockInterface
     */
    protected function getPostCodeRateMock(array $patterns)
    {
        return $this->getRateMock()->shouldReceive('getPostCodes')
                    ->andReturn($patterns)->getMock();
    }

    /**
     * @test
     */
    public function itCanFilterOutWhenNoPostCodesMatch()
    {
        $request = $this->getPostCodeRequestMock('BD17 7DB');
        $rate    = $this->getPostCodeRateMock(['LS', 'NW1']);

        $this->assertFalse($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itCanPassOnPartialMatches()
    {
        $request = $this->getPostCodeRequestMock('BD17 7DB');
        $rate    = $this->getPostCodeRateMock(['BD', 'LS1']);

        $this->assertTrue($this->class->filter($request, $rate));
    }

    public function itCanPassOnFullMatches()
    {
        $request = $this->getPostCodeRequestMock('BD17 7DB');
        $rate    = $this->getPostCodeRateMock(['LS%', 'NW2', 'BD17 7DB']);

        $this->assertTrue($this->class->filter($request, $rate));
    }
}
