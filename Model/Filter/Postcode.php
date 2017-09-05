<?php

namespace Everon\EvShipping\Model\Filter;

use Everon\EvShipping\Api\Data\FilterInterface;
use Everon\EvShipping\Api\Data\RateInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;

class Postcode implements FilterInterface
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
        $destinationPostcode = $request->getDestPostcode();
        $postcodes           = $rate->getPostCodes();
        if ($postcodes === null) {
            //No condition set
            return true;
        }

        foreach ($rate->getPostCodes() as $checkPostCode) {
            //UK district match - BD, LS etc
            $result = stristr($destinationPostcode, $checkPostCode);
            if ($result !== false) {
                return true;
            }
        }

        return false;
    }
}
