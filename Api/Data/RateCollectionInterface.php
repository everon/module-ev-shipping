<?php

namespace Everon\EvShipping\Api\Data;

use Everon\EvShipping\Model\FilterCollection;
use Magento\Quote\Model\Quote\Address\RateRequest;

/**
 * Immutable collection for rates
 * Interface RateCollectionInterface
 *
 * @package Everon\EvShipping\Api\Data
 */
interface RateCollectionInterface
{
    /**
     * @return RateInterface[]
     */
    public function toArray();

    /**
     * Passes the rates through a filter
     * @param RateRequest     $rateRequest
     * @param FilterInterface $filter
     *
     * @return RateCollectionInterface
     */
    public function filterBy(RateRequest $rateRequest, FilterInterface $filter);

    /**
     * If the collection is empty or not
     * @return bool
     */
    public function isEmpty();
}
