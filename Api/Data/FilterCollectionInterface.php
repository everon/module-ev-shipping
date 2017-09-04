<?php

namespace Everon\EvShipping\Api\Data;

use Magento\Quote\Model\Quote\Address\RateRequest;

interface FilterCollectionInterface
{
    /**
     * @param RateRequest             $request
     * @param RateCollectionInterface $rateCollection
     *
     * @return FilterCollectionInterface
     */
    public function filterRates(RateRequest $request, RateCollectionInterface $rateCollection);
}
