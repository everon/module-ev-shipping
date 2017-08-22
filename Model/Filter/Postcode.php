<?php

namespace EdmondsCommerce\Shipping\Model\Filter;

use EdmondsCommerce\Shipping\Api\Data\FilterInterface;
use EdmondsCommerce\Shipping\Api\Data\RateInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;

class Postcode implements FilterInterface
{


    /**
     * Checks one or more values to see if they pass certain checks (total weight, item count, postcode etc)
     * @param RateRequest $request
     * @param RateInterface $rate
     * @return bool
     */
    public function filter(RateRequest $request, RateInterface $rate)
    {
        $destinationPostcode = $request->getDestPostcode();
        $postcodes = $rate->getPostCodes();
        if ($postcodes === null)
        {
            //No condition set
            return true;
        }

        foreach ($rate->getPostCodes() as $checkPostCode)
        {
            //Wildcard match
            if ($checkPostCode === '*')
            {
                return true;
            }

            //UK district match - BD, LS etc
            $result = stristr($destinationPostcode, $checkPostCode);
            if ($result !== false)
            {
                return true;
            }
        }

        return false;
    }
}