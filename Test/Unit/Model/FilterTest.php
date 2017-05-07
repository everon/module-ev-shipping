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
    public function itCanMatchPostcodesForUk()
    {
        $rate = $this->mock(Rate::class);

        $rate->shouldReceive(['getPostCodes' => ['BD', 'LS', 'AD3']]);
        $postcodes = [
            'LS1 1AA'  => true,
            'BD17 7DB' => true,
            'NW1 1AA'  => false,
            'SW2 1AA'  => false,
            'AD3 3BD'  => true,
        ];

        foreach ($postcodes as $pc => $expect)
        {
            $result = $this->class->filterPostcode($pc, $rate);
            $this->assertSame($expect, $result);
        }
    }
}