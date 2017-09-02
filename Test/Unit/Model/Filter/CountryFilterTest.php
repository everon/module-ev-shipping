<?php

namespace EdmondsCommerce\Shipping\Test\Unit\Model\Filter;

use EdmondsCommerce\Shipping\Model\Filter\Country;
use Mockery\MockInterface;

class CountryFilterTest extends AbstractFilterTest
{
    /** @var  Country */
    protected $class;

    public function setUp()
    {
        parent::setUp();

        $this->class = new Country();
    }

    /**
     * @param string $country
     *
     * @return MockInterface
     */
    protected function getCountryRequestMock($country)
    {
        return $this->getRateRequestMock()->shouldReceive('getDestCountryId')->andReturn($country)->getMock();
    }

    /**
     * @param string[] $countries
     *
     * @return \Mockery\ExpectationInterface
     */
    protected function getCountryRateMock(array $countries)
    {
        return $this->getRateMock()->shouldReceive('getCountries')->andReturn($countries)->getMock();
    }

    /**
     * @test
     */
    public function itWillFilterOutACountry()
    {
        $request = $this->getCountryRequestMock('GBP');
        $rate    = $this->getCountryRateMock(['FRA', 'GER']);

        $this->assertFalse($this->class->filter($request, $rate));
    }

    /**
     * @test
     */
    public function itWillFindACountry()
    {
        $request = $this->getCountryRequestMock('GBP');
        $rate    = $this->getCountryRateMock(['FRA', 'GBP']);

        $this->assertTrue($this->class->filter($request, $rate));
    }

}
