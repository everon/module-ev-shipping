<?php

namespace EdmondsCommerce\Shipping\Test\Unit\Model\Rate;

use EdmondsCommerce\Shipping\Model\Rate\Collection;
use EdmondsCommerce\Shipping\Model\Rate\CollectionFactory;
use EdmondsCommerce\Shipping\Model\Rate\Loader;
use EdmondsCommerce\Shipping\Model\Rate\Locator;
use EdmondsCommerce\Shipping\Model\Rate\Reader;
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
	 * @var  MockInterface
	 */
	private $rateFactory;

	/**
	 * @var  MockInterface
	 */
	private $collectionFactory;

	/**
	 * @var  MockInterface
	 */
	private $locator;

	/**
	 * @var  MockInterface
	 */
	private $reader;


	public function setUp() {
		parent::setUp();

		$this->rateFactory       = $this->mock( RateFactory::class );
		$this->collectionFactory = $this->mock( CollectionFactory::class );
		$this->locator           = $this->mock( Locator::class );
		$this->reader            = $this->mock( Reader::class );

		$this->class = new Loader( $this->locator, $this->reader, $this->rateFactory, $this->collectionFactory );
	}

	/**
	 * @test
	 */
	public function itWillGetAPathIfNotGivenOne() {
		$this->locator->shouldReceive( 'getRatePath' )->once()->withNoArgs()
			->andReturn('test.json');

		$fileResponse = [
			'rates' => []
		];
		$this->reader->shouldReceive('read')->once()->with('test.json')->andReturn($fileResponse);

		$rateResponse = [];
		$this->rateFactory->shouldReceive('create')->zeroOrMoreTimes()->with($fileResponse)
			->andReturn($rateResponse);

		$this->collectionFactory->shouldReceive('create')->once()->with(['items' => $rateResponse])
			->andReturn($this->mock(Collection::class));

		$result = $this->class->getRateCollection();

		$this->assertInstanceOf(Collection::class, $result);
	}

	/**
	 * @test
	 */
	public function itWillAcceptAPathInsteadOfUsingConfig()
	{
		$this->locator->shouldNotReceive( 'getRatePath' );

		$fileResponse = [
			'rates' => []
		];
		$this->reader->shouldReceive('read')->once()->with('file.json')->andReturn($fileResponse);

		$rateResponse = [];
		$this->rateFactory->shouldReceive('create')->zeroOrMoreTimes()->with($fileResponse)
		                  ->andReturn($rateResponse);

		$this->collectionFactory->shouldReceive('create')->once()->with(['items' => $rateResponse])
		                        ->andReturn($this->mock(Collection::class));

		$result = $this->class->getRateCollection('file.json');

		$this->assertInstanceOf(Collection::class, $result);
	}


}