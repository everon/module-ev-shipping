<?php

namespace EdmondsCommerce\Shipping\Model\Filter;

use EdmondsCommerce\Shipping\Api\Data\FilterInterface;
use EdmondsCommerce\Shipping\Api\Data\RateInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;

class Weight implements FilterInterface
{

    /**
     * Checks one or more values to see if they pass certain checks (total weight, item count, postcode etc)
     * @param RateRequest $request
     * @param RateInterface $rate
     * @return bool
     */
    public function filter(RateRequest $request, RateInterface $rate)
    {
        $weightFrom = $rate->getWeightFrom();
        $weightTo = $rate->getWeightTo();

        $weight = $request->getPackageWeight();

        if($weightFrom === null && $weightTo === null)
        {
            //no condition
            return true;
        }

        if($weight >= $weightFrom && $weight <= $weightTo)
        {
            return true;
        }

        return false;
    }
}