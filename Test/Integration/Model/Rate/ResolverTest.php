<?php

namespace Everon\EvShipping\Test\Integration\Model\Rate;

use Everon\EvShipping\Model\Rate\Loader;
use Everon\EvShipping\Model\Rate\Resolver;
use Everon\EvShipping\Test\Integration\IntegrationTestCase;
use Magento\Quote\Model\Quote\Address\RateRequestFactory;

class ResolverTest extends IntegrationTestCase
{

    /** @var  Resolver */
    protected $resolver;

    /** @var  Loader */
    protected $loader;

    public function setUp()
    {
        parent::setUp();

        /** @var Resolver resolver */
        $this->resolver = $this->_objectManager->create(Resolver::class);

        /** @var Loader $loader */
        $this->loader = $this->_objectManager->create(Loader::class);
    }

    protected function getRateCollection($fileName)
    {
        $file = $this->getFileDir() . '/' . $fileName;
        if (realpath($file) === false) {
            throw new \Exception('Could not find rate file');
        }

        return $this->loader->getRateCollection($file);
    }

    /**
     * @test
     */
    public function itWillFilterOnWebsites()
    {
        $rateCollection = $this->getRateCollection('websites.json');
        $request        = $this->makeRateRequest([]);

        $rates = $this->resolver->resolve($rateCollection, $request);

        $this->assertCount(1, $rates);
        $rate = array_shift($rates);
        $this->assertEquals('Website Courier', $rate->getName());
    }

    /**
     * @test
     */
    public function itWillFilterOnCountries()
    {
        $rateCollection = $this->getRateCollection('countries.json');
        $request        = $this->makeRateRequest(['dest_country_id' => 'GB']);

        $rates = $this->resolver->resolve($rateCollection, $request);

        $this->assertCount(1, $rates);
        $rate = array_shift($rates);
        $this->assertEquals('Country Courier', $rate->getName());
    }

    /**
     * @test
     */
    public function itWillFilterOnPostCodes()
    {
        $rateCollection = $this->getRateCollection('postcodes.json');
        $request        = $this->makeRateRequest(['dest_postcode' => 'BD1 1AA']);

        $rates = $this->resolver->resolve($rateCollection, $request);

        $this->assertCount(1, $rates);
        $rate = array_shift($rates);
        $this->assertEquals('Postcode Courier', $rate->getName());
    }

    /**
     * @test
     */
    public function itWillFilterOnCartPrice()
    {
        $rateCollection = $this->getRateCollection('cartprice.json');
        $request        = $this->makeRateRequest(['package_value' => 25]);

        $rates = $this->resolver->resolve($rateCollection, $request);

        $this->assertCount(1, $rates);
        $rate = array_shift($rates);
        $this->assertEquals('Cart Price Courier', $rate->getName());
    }

    /**
     * @test
     */
    public function itWillFilterOnItemCount()
    {
        $rateCollection = $this->getRateCollection('itemcount.json');
        $request        = $this->makeRateRequest([
            'all_items' => [
                null,
                null,
            ],
        ]);

        $rates = $this->resolver->resolve($rateCollection, $request);

        $this->assertCount(1, $rates);
        $rate = array_shift($rates);
        $this->assertEquals('Item Count Courier', $rate->getName());
    }

    /**
     * @test
     */
    public function itWillFilterOnTotalWeight()
    {
        $rateCollection = $this->getRateCollection('weight.json');
        $request        = $this->makeRateRequest(['package_weight' => 2]);

        $rates = $this->resolver->resolve($rateCollection, $request);

        $this->assertCount(1, $rates);
        $rate = array_shift($rates);
        $this->assertEquals('Weight Courier', $rate->getName());
    }

    /**
     * @param array $args
     *
     * @return \Magento\Quote\Model\Quote\Address\RateRequest
     */
    protected function makeRateRequest(array $args)
    {
        /** @var RateRequestFactory $factory */
        $factory = $this->_objectManager->create(RateRequestFactory::class);

        $defaults = $this->getRateDefaults();
        $args     = array_merge($defaults, $args);

        return $factory->create()->setData($args);
    }

    protected function getRateDefaults()
    {
        return [
            'all_items'                   => [],
            'dest_country_id'             => 'TW',
            'dest_region_id'              => null,
            'dest_region_code'            => '',
            'dest_street'                 => null,
            'dest_city'                   => null,
            'dest_postcode'               => '123',
            'package_value'               => 84,
            'package_value_with_discount' => 84,
            'package_weight'              => 2,
            'package_qty'                 => 2,
            'package_physical_value'      => 84,
            'free_method_weight'          => 0,
            'store_id'                    => 1,
            'website_id'                  => 1,
            'free_shipping'               => true,
            'base_currency'               => \Magento\Directory\Model\Currency::class,
            'package_currency'            => \Magento\Directory\Model\Currency::class,
            'limit_carrier'               => null,
            'base_subtotal_incl_tax'      => '84.0000',
            'country_id'                  => 'US',
            'region_id'                   => '12',
            'city'                        => null,
            'postcode'                    => 90034,
        ];
    }
}
