<?php

namespace Everon\EvShipping\Api\Data;

use Magento\Quote\Model\Quote\Address\RateRequest;

interface FilterInterface
{
    /**
     * Checks one or more values to see if they pass certain checks (total weight, item count, postcode etc)
     *
     * @param RateRequest   $request
     * @param RateInterface $rate
     *
     * @return bool
     */
    public function filter(RateRequest $request, RateInterface $rate);
}
