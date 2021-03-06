<?php

namespace Everon\EvShipping\Model\Filter;

use Everon\EvShipping\Api\Data\FilterInterface;
use Everon\EvShipping\Api\Data\RateInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;

class Website implements FilterInterface
{

    /**
     * Checks one or more values to see if they pass certain checks (total weight, item count, postcode etc)
     *
     * @param RateRequest   $request
     * @param RateInterface $rate
     *
     * @return bool
     */
    public function filter(RateRequest $request, RateInterface $rate)
    {
        $websiteId = $request->getWebsiteId();
        $websites  = $rate->getWebsiteIds();
        if ($websites === null) {
            //no condition set
            return true;
        }

        return (in_array($websiteId, $websites));
    }
}
