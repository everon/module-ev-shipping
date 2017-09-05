<?php

namespace Everon\EvShipping\Model\Filter;

use Everon\EvShipping\Api\Data\FilterInterface;
use Everon\EvShipping\Api\Data\RateInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;

class Country implements FilterInterface
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
        $destCountry = $request->getDestCountryId();
        $countries   = $rate->getCountries();

        //If no country array is set then skip the check
        if ($countries === null) {
            return true;
        }

        foreach ($countries as $checkCountry) {
            $result = ($checkCountry === $destCountry);
            if ($result === true) {
                return true;
            }
        }

        return false;
    }
}
