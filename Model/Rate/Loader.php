<?php

namespace Everon\EvShipping\Model\Rate;

use Everon\EvShipping\Exception\ValidationException;
use Everon\EvShipping\Model\Rate\CollectionFactory;
use Everon\EvShipping\Model\RateFactory;
use Psr\Log\LoggerInterface;

/**
 * Class Storage
 *
 * @package Everon\EvShipping\Model\Rate
 * Handles the retrieval of rules from a file
 */
class Loader
{

    /**
     * @var Everon\EvShipping\Model\RateFactory
     */
    private $rateFactory;

    /**
     * @var Everon\EvShipping\Model\Rate\CollectionFactory
     */
    private $rateCollectionFactory;

    /**
     * @var Locator
     */
    private $locator;

    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Loader constructor.
     *
     * @param RateFactory   $rateFactory
     * @param CollectionFactory $rateCollectionFactory
     * @param Locator                                         $locator
     * @param Reader                                          $reader
     * @param Validator                                       $validator
     * @param LoggerInterface                                 $logger
     */
    public function __construct(
        RateFactory $rateFactory,
        CollectionFactory $rateCollectionFactory,
        Locator $locator,
        Reader $reader,
        Validator $validator,
        LoggerInterface $logger
    ) {
        $this->locator               = $locator;
        $this->reader                = $reader;
        $this->rateFactory           = $rateFactory;
        $this->rateCollectionFactory = $rateCollectionFactory;
        $this->validator             = $validator;
        $this->logger                = $logger;
    }

    /**
     * @param string $filePath
     *
     * @return Collection
     */
    public function getRateCollection($filePath = null)
    {
        //Default to the configured rate path (from config or the hard coded value)
        if ($filePath === null) {
            $filePath = $this->locator->getRatePath();
        }

        //Read the JSON to array
        $data = $this->reader->read($filePath);

        //Validate
        try {
            $this->validator->validateJson($data);
        } catch (ValidationException $e) {
            $this->logger->error('Could not parse json file');

            //Return an empty collection to prevent this from stopping the checkout
            return $this->rateCollectionFactory->create(['items' => []]);
        }

        /** @var array $rawRates */
        $rawRates = $data['rates'];

        //Generate the rates
        $rates = [];
        foreach ($rawRates as $rule) {
            $this->validator->validateRate($rule);
            $temp = $this->rateFactory->create($rule);
            $temp->setData($rule);
            $rates[] = $temp;
        }

        return $this->rateCollectionFactory->create(['items' => $rates]);
    }
}
