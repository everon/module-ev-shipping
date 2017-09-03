<?php

namespace Everon\EvShipping\Model\Rate;

use Everon\EvShipping\Exception\ValidationShippingException;
use Everon\EvShipping\Model\RateFactory;

/**
 * Class Storage
 *
 * @package Everon\EvShipping\Model\Rate
 * Handles the retrieval of rules from a file
 */
class Loader
{

    /**
     * @var \Everon\EvShipping\Model\RateFactory
     */
    private $rateFactory;

    /**
     * @var \Everon\EvShipping\Model\Rate\CollectionFactory
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
     * Loader constructor.
     *
     * @param Locator                                                $locator
     * @param Reader                                                 $reader
     * @param Validator                                              $validator
     * @param RateFactory                                            $rateFactory
     * @param \Everon\EvShipping\Model\Rate\CollectionFactory $rateCollectionFactory
     */
    public function __construct(
        Locator $locator,
        Reader $reader,
        Validator $validator,
        RateFactory $rateFactory,
        CollectionFactory $rateCollectionFactory
    ) {
        $this->locator               = $locator;
        $this->reader                = $reader;
        $this->rateFactory           = $rateFactory;
        $this->rateCollectionFactory = $rateCollectionFactory;
        $this->validator             = $validator;
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
        } catch (ValidationShippingException $e) {
            //TODO: Log the error
            //Return an empty collection to prevent this from stopping the checkout
            return $this->rateCollectionFactory->create(['items' => []]);
        }

        /** @var array $rawRates */
        $rawRates = $data['rates'];

        //Generate the rates
        $rates = [];
        foreach ($rawRates as $rule) {
            $rates[] = $this->rateFactory->create($rule);
        }

        return $this->rateCollectionFactory->create(['items' => $rates]);
    }
}
