<?php

namespace EdmondsCommerce\Shipping\Test\Unit\Model\Rate;

use EdmondsCommerce\Shipping\Exception\ValidationShippingException;
use EdmondsCommerce\Shipping\Model\Rate\Collection;
use EdmondsCommerce\Shipping\Model\Rate\CollectionFactory;
use EdmondsCommerce\Shipping\Model\Rate\Loader;
use EdmondsCommerce\Shipping\Model\Rate\Locator;
use EdmondsCommerce\Shipping\Model\Rate\Reader;
use EdmondsCommerce\Shipping\Model\Rate\Validator;
use EdmondsCommerce\Shipping\Model\RateFactory;
use EdmondsCommerce\Shipping\Test\Integration\IntegrationTestCase;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Mockery\MockInterface;

class LoaderTest extends IntegrationTestCase
{

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

    /**
     * @var  MockInterface
     */
    private $validator;


    public function setUp()
    {
        parent::setUp();

        $this->rateFactory       = $this->mock(RateFactory::class);
        $this->collectionFactory = $this->mock(CollectionFactory::class);
        $this->locator           = $this->mock(Locator::class);
        $this->validator         = $this->mock(Validator::class);
        $this->reader            = $this->mock(Reader::class);

        $this->class = new Loader($this->locator, $this->reader, $this->validator, $this->rateFactory,
            $this->collectionFactory);
    }

    /**
     * @test
     */
    public function itWillGetAPathIfNotGivenOne()
    {
        $this->locator->shouldReceive('getRatePath')->once()->withNoArgs()
                      ->andReturn('test.json');

        $fileResponse = [
            'rates' => [],
        ];
        $this->reader->shouldReceive('read')->once()->with('test.json')->andReturn($fileResponse);

        $this->validator->shouldReceive('validateJson')->once()->withAnyArgs();

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
        $this->locator->shouldNotReceive('getRatePath');

        $fileResponse = [
            'rates' => [],
        ];
        $this->reader->shouldReceive('read')->once()->with('file.json')->andReturn($fileResponse);
        $this->validator->shouldReceive('validateJson')->once()->withAnyArgs();

        $rateResponse = [];
        $this->rateFactory->shouldReceive('create')->zeroOrMoreTimes()->with($fileResponse)
                          ->andReturn($rateResponse);

        $this->collectionFactory->shouldReceive('create')->once()->with(['items' => $rateResponse])
                                ->andReturn($this->mock(Collection::class));

        $result = $this->class->getRateCollection('file.json');

        $this->assertInstanceOf(Collection::class, $result);
    }

    /**
     * @test
     */
    public function itWillReturnAnEmptyCollectionIfItFails()
    {
        $this->locator->shouldNotReceive('getRatePath');

        $fileResponse = [
            'rates' => [],
        ];
        $this->reader->shouldReceive('read')->once()->with('file.json')->andReturn($fileResponse);

        $this->validator->shouldReceive('validateJson')->once()->withAnyArgs()->andThrow(ValidationShippingException::class);

        $this->collectionFactory->shouldReceive('create')->once()->with(['items' => []])
                                ->andReturn($this->mock(Collection::class));

        $result = $this->class->getRateCollection('file.json');

        $this->assertInstanceOf(Collection::class, $result);
    }
}
