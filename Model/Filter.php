<?php

namespace EdmondsCommerce\Shipping\Model;

/**
 * Class Filter
 * @package EdmondsCommerce\Shipping\Model
 * Handles filtering of various rules
 */
class Filter
{
    /**
     * @param string $postcode
     * @param Rate $rate
     * @return bool
     */
    public function filterPostcode($postcode, Rate $rate)
    {
        foreach ($rate->getPostCodes() as $checkPostCode)
        {
            //Wildcard match
            if ($checkPostCode === '*')
            {
                return true;
            }

            //UK district match - BD, LS etc
            $result = stristr($postcode, $checkPostCode);
            if ($result !== false)
            {
                return true;
            }
        }

        return false;
    }

    public function filterCountry($countryCode, Rate $rate)
    {
        foreach ($rate->getCountries() as $checkCountry)
        {
            if ($checkCountry == '*')
            {
                return true;
            }

            $result = ($checkCountry == $countryCode);
            if ($result === true)
            {
                return true;
            }
        }

        return false;
    }
}