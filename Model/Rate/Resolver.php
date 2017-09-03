<?php

namespace Everon\EvShipping\Model\Rate;

use Everon\EvShipping\Api\Data\FilterInterface;
use Everon\EvShipping\Api\Data\RateCollectionInterface;
use Everon\EvShipping\Api\Data\RateInterface;
use Everon\EvShipping\Model\FilterCollection;
use Everon\EvShipping\Model\FilterCollectionFactory;
use Magento\Quote\Model\Quote\Address\RateRequest;

/**
 * Class Resolver
 *
 * @package Everon\EvShipping\Model\Rate
 * Handles the filtering of rates and returns a collection of rates
 * Velvet Resolver
 */
class Resolver
{
    /**
     * @var FilterCollection
     */
    private $filterCollectionFactory;

    /**
     * Resolver constructor.
     *
     * @param FilterCollectionFactory $filterCollectionFactory
     */
    public function __construct(FilterCollectionFactory $filterCollectionFactory)
    {
        $this->filterCollectionFactory = $filterCollectionFactory;
    }

    /**
     * @param RateCollectionInterface $rates
     * @param RateRequest             $request
     *
     * @return RateInterface[]
     */
    public function resolve(RateCollectionInterface $rates, RateRequest $request)
    {
        /** @var FilterInterface $filter */
        $filter = null;

        //Get the available filters
        $collection = $this->filterCollectionFactory->create();

        //Filter the rates collection
        $rates = $collection->filterRates($request, $rates);

        return $rates->toArray();
    }
}
