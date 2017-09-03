<?php

namespace Everon\EvShipping\Model;

use Everon\EvShipping\Api\Data\FilterCollectionInterface;
use Everon\EvShipping\Api\Data\FilterInterface;
use Everon\EvShipping\Api\Data\RateCollectionInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;

/**
 * Container collection for all filters
 * Class FilterCollection
 *
 * @package Magento\Shipping\Model
 */
class FilterCollection implements FilterCollectionInterface
{
    /**
     * @var FilterInterface[]
     */
    private $filters;

    /**
     * FilterCollection constructor.
     *
     * @param FilterInterface[] $filters
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return FilterInterface[]
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @param RateRequest             $request
     * @param RateCollectionInterface $rateCollection
     *
     * @return RateCollectionInterface
     */
    public function filterRates(RateRequest $request, RateCollectionInterface $rateCollection)
    {
        foreach ($this->filters as $filter) {
            //Only continue if there are still rates to check
            if (!$rateCollection->isEmpty()) {
                $rateCollection = $rateCollection->filterBy($request, $filter);
            }
        }

        return $rateCollection;
    }
}
