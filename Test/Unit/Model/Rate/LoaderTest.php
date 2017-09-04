<?php

namespace Everon\EvShipping\Test\Unit\Model\Rate;

use Everon\EvShipping\Exception\ValidationException;
use Everon\EvShipping\Model\Rate\Collection;
use Everon\EvShipping\Model\Rate\CollectionFactory;
use Everon\EvShipping\Model\Rate\Loader;
use Everon\EvShipping\Model\Rate\Locator;
use Everon\EvShipping\Model\Rate\Reader;
use Everon\EvShipping\Model\Rate\Validator;
use Everon\EvShipping\Model\RateFactory;
use Everon\EvShipping\Test\Integration\IntegrationTestCase;
use Mockery\MockInterface;
use Psr\Log\LoggerInterface;

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

    /**
     * @var  MockInterface
     */
    private $logger;

    public function setUp()
    {
        parent::setUp();

        $this->rateFactory       = $this->mock(RateFactory::class);
        $this->collectionFactory = $this->mock(CollectionFactory::class);
        $this->locator           = $this->mock(Locator::class);
        $this->validator         = $this->mock(Validator::class);
        $this->reader            = $this->mock(Reader::class);
        $this->logger            = $this->mock(LoggerInterface::class);

        $this->class = new Loader(
            $this->rateFactory,
            $this->collectionFactory,
            $this->locator,
            $this->reader,
            $this->validator,
            $this->logger
        );
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

        $this->validator->shouldReceive('validateJson')->once()->withAnyArgs()->andThrow(ValidationException::class);
        $this->logger->shouldReceive('error')->once()->withAnyArgs();

        $this->collectionFactory->shouldReceive('create')->once()->with(['items' => []])
                                ->andReturn($this->mock(Collection::class));

        $result = $this->class->getRateCollection('file.json');

        $this->assertInstanceOf(Collection::class, $result);
    }
}
