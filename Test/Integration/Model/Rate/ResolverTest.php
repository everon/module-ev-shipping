<?php

namespace EdmondsCommerce\Shipping\Test\Integration\Model\Rate;

use EdmondsCommerce\Shipping\Api\Data\RateCollectionInterface;
use EdmondsCommerce\Shipping\Model\Rate\Loader;
use EdmondsCommerce\Shipping\Model\Rate\Resolver;
use EdmondsCommerce\Shipping\Test\Integration\IntegrationTestCase;
use Magento\Quote\Model\Quote\Address\RateRequestFactory;

class ResolverTest extends IntegrationTestCase {

	/** @var  Resolver */
	protected $resolver;

	/** @var  Loader */
	protected $loader;

	public function setUp() {
		parent::setUp();

		/** @var Resolver resolver */
		$this->resolver = $this->_objectManager->create( Resolver::class );

		/** @var Loader $loader */
		$this->loader = $this->_objectManager->create( Loader::class );
	}

	protected function getRateCollection( $fileName ) {
		$file = $this->getFileDir() . '/' . $fileName;
		if ( realpath( $file ) === false ) {
			throw new \Exception( 'Could not find rate file' );
		}

		return $this->loader->getRateCollection( $file );
	}

	/**
	 * @test
	 */
	public function itWillFilterOnWebsites() {
		$rateCollection = $this->getRateFile( 'websites.json' );
		$request        = $this->makeRateRequest( [] );

		$rates = $this->resolver->resolve( $rateCollection, $request );

		$this->assertCount(1, $rates);
		$rate = $rates[0];
		$this->assertEquals($rate->getName(), 'Website Courier');
	}

	/**
	 * @test
	 */
	public function itWillFilterOnCountries() {

	}

	/**
	 * @test
	 */
	public function itWillFilterOnPostCodes() {

	}

	/**
	 * @test
	 */
	public function itWillFilterOnCartPrice() {

	}

	/**
	 * @test
	 */
	public function itWillFilterOnItemCount() {

	}

	/**
	 * @param array $args
	 *
	 * @return \Magento\Quote\Model\Quote\Address\RateRequest
	 */
	protected function makeRateRequest( array $args ) {
		/** @var RateRequestFactory $factory */
		$factory = $this->_objectManager->create( RateRequestFactory::class );

		$defaults = $this->getRateDefaults();
		$args     = array_merge( $args, $defaults );

		return $factory->create()->setData( $args );
	}

	protected function getRateDefaults() {
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