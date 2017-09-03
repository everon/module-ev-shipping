<?php

namespace Everon\EvShipping\Model\Rate;

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
        $rates = $rates->toArray();
        $collection = $this->filterCollectionFactory->create();
        $result = array_filter($rates, function (RateInterface $rate) use ($request, $collection) {
            foreach ($collection->getFilters() as $check) {
                if ($check->filter($request, $rate) === false) {
                    return false;
                }
            }

            return true;
        });

        return $result;
    }
}
