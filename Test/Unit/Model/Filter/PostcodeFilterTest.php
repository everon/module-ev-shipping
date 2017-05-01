<?php

namespace EdmondsCommerce\Shipping\Test\Unit\Model\Filter;

use EdmondsCommerce\Shipping\Test\Unit\UnitTestCase;
use Magento\Shipping\Model\Filters\PostcodeFilter;

class PostcodeFilterTest extends UnitTestCase
{
    /** @var PostcodeFilter */
    protected $class;

    public function setUp()
    {
        $this->class = new PostcodeFilter();
    }

    /**
     * @test
     */
    public function itCanMatchAgainstAFullSinglePostcode()
    {
        $rules = [];
        $inputs = [];
    }




}