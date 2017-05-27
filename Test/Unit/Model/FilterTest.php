<?php

namespace EdmondsCommerce\Shipping\Test\Unit\Model;

use EdmondsCommerce\Shipping\Model\Filter;
use EdmondsCommerce\Shipping\Model\Rate;
use EdmondsCommerce\Shipping\Test\Unit\UnitTestCase;

class FilterTest extends UnitTestCase
{
    /** @var  Filter */
    protected $class;

    public function setUp()
    {
        parent::setUp();

        $this->class = new Filter();
    }

    /**
     * @test
     */
    public function itCanFilterWebsites()
    {
        $rate = $this->mock(Rate::class);
        $rate->shouldReceive('getWebsiteIds')->andReturn([
            1,
            3
        ]);

        $websites = [
            1 => true,
            2 => false,
            3 => true,
        ];

        foreach ($websites as $website => $expect)
        {
            $result = $this->class->filterWebsite($website, $rate);
            $this->assertSame($expect, $result);
        }
    }

    /**
     * @test
     */
    public function itCanMatchPostcodesForUk()
    {
        $rate = $this->mock(Rate::class);

        $rate->shouldReceive(['getPostCodes' => ['BD', 'LS', 'AD3', 'PO36']]);
        $postcodes = [
            'LS1 1AA'  => true,
            'BD17 7DB' => true,
            'NW1 1AA'  => false,
            'SW2 1AA'  => false,
            'AD3 3BD'  => true,
            'PO36 1AD' => true
        ];

        foreach ($postcodes as $pc => $expect)
        {
            $result = $this->class->filterPostcode($pc, $rate);
            $this->assertSame($expect, $result);
        }
    }

    /**
     * @test
     */
    public function itCanMatchCountryCode()
    {
        $rate = $this->mock(Rate::class);

        $rate->shouldReceive(['getCountries' => ['GBR', 'FRA', 'GER', 'FIN']]);
        $countryCodes = [
            'GBR' => true,
            'FRA' => true,
            'GER' => true,
            'FIN' => true,
            'ALG' => false,
        ];

        foreach ($countryCodes as $countryCode => $expect)
        {
            $result = $this->class->filterCountry($countryCode, $rate);
            $this->assertSame($expect, $result);
        }
    }

    /**
     * @test
     */
    public function itCanCheckWeightBoundaries()
    {
        $rate = $this->mock(Rate::class);

        $rate->shouldReceive(['getWeightFrom' => 0, 'getWeightTo' => 9]);
        $weights = [
            1  => true,
            5  => true,
            10 => false,
            3  => true
        ];

        foreach ($weights as $weight => $expect)
        {
            $result = $this->class->filterWeight($weight, $rate);
            $this->assertSame($expect, $result);
        }
    }
}