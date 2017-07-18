<?php

namespace EdmondsCommerce\Shipping\Test\Integration\Model\Rate;

use EdmondsCommerce\Shipping\Model\Rate\Resolver;
use EdmondsCommerce\Shipping\Test\Integration\IntegrationTestCase;

class ResolverTest extends IntegrationTestCase
{

    /** @var  Resolver */
    protected $resolver;

    public function setUp()
    {
        parent::setUp();

        //Create the resolver
        $this->resolver = $this->_objectManager->create(Resolver::class);
    }

    /**
     * @test
     */
    public function itWillFilterOnWebsites()
    {

    }

    /**
     * @test
     */
    public function itWillFilterOnCountries()
    {

    }

    /**
     * @test
     */
    public function itWillFilterOnPostCodes()
    {

    }

    /**
     * @test
     */
    public function itWillFilterOnCartPrice()
    {

    }

    /**
     * @test
     */
    public function itWillFilterOnItemCount()
    {

    }
}