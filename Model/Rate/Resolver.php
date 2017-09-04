<?php

namespace Everon\EvShipping\Model\Rate;

use Everon\EvShipping\Api\Data\FilterCollectionInterface;
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
    private $filterCollection;

    /**
     * Resolver constructor.
     *
     * @param FilterCollectionInterface $filterCollection
     */
    public function __construct(FilterCollectionInterface $filterCollection)
    {
        $this->filterCollection = $filterCollection;
    }

    /**
     * @param RateCollectionInterface $rates
     * @param RateRequest             $request
     *
     * @return RateInterface[]
     */
    public function resolve(RateCollectionInterface $rates, RateRequest $request)
    {
        //Filter the rates collection
        $rates = $this->filterCollection->filterRates($request, $rates);

        return $rates->toArray();
    }
}
