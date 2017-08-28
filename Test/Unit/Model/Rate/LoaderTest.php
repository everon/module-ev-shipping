<?php

namespace EdmondsCommerce\Shipping\Test\Unit\Model\Rate;

use EdmondsCommerce\Shipping\Model\Rate\CollectionFactory;
use EdmondsCommerce\Shipping\Model\Rate\Loader;
use EdmondsCommerce\Shipping\Model\RateFactory;
use EdmondsCommerce\Shipping\Test\Integration\IntegrationTestCase;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Mockery\MockInterface;

class LoaderTest extends IntegrationTestCase {
	/**
	 * @var Loader
	 */
	private $class;

	/**
	 * @var MockInterface
	 */
	private $config;

	/**
	 * @var MockInterface
	 */
	private $directory;

	/**
	 * @var MockInterface
	 */
	private $rateFactory;

	/**
	 * @var MockInterface
	 */
	private $collectionFactory;

	public function setUp() {
		parent::setUp();

		$this->config            = $this->mock( ScopeConfigInterface::class );
		$this->directory         = $this->mock( DirectoryList::class );
		$this->rateFactory       = $this->mock( RateFactory::class );
		$this->collectionFactory = $this->mock( CollectionFactory::class );

		$this->class = new Loader( $this->config, $this->directory, $this->rateFactory, $this->collectionFactory );
	}

	/**
	 * @test
	 */
	public function itWillUseConfigPathFirst()
	{
		$this->config->shouldReceive('getValue')->once()->with('ecshipping/file')
		             ->andReturn('var/rates.json');
		$this->directory->shouldReceive('getRoot')->once()->withNoArgs()
			->andReturn('/var/www/vhosts/magento');

		$result = $this->class->getRatePath();

		$this->assertEquals('/var/www/vhosts/magento/var/rates.json', $result);

	}

	/**
	 * @test
	 */
	public function itWillUseADefaultPathAfterConfig() {
		$this->config->shouldReceive('getValue')->once()->with('ecshipping/file')
			->andReturn('');
		$this->directory->shouldReceive('getPath')->once()->with('var')->andReturn('testpath');

		$result = $this->class->getRatePath();

		$this->assertEquals('testpath/shipping-config.json', $result);
	}



}