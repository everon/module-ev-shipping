<?php

namespace EdmondsCommerce\Shipping\Model\Rate;

use EdmondsCommerce\Shipping\Api\Data\RateInterface;

/**
 * Class Filter
 * @package EdmondsCommerce\Shipping\Model\Rate
 * Handles filtering of various rules
 */
class Filter
{
    /**
     * @param $websiteId
     * @param RateInterface $rate
     * @return bool
     */
    public function filterWebsite($websiteId, RateInterface $rate)
    {
        $websites = $rate->getWebsiteIds();

        return (in_array($websiteId, $websites));
    }

    /**
     * @param string $postcode
     * @param RateInterface $rate
     * @return bool
     */
    public function filterPostcode($postcode, RateInterface $rate)
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

    /**
     * @param $countryCode
     * @param RateInterface $rate
     * @return bool
     */
    public function filterCountry($countryCode, RateInterface $rate)
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

    /**
     * @param $weight
     * @param RateInterface $rate
     * @return bool
     */
    public function filterWeight($weight, RateInterface $rate)
    {
        if ($weight > $rate->getWeightFrom())
        {
            $rate->getWeightTo();
            if ($weight < $rate->getWeightTo())
            {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $itemCount
     * @param $rate
     * @return bool
     */
    public function filterItemCount($itemCount, RateInterface $rate)
    {
        if ($itemCount >= $rate->getItemsFrom() && $itemCount <= $rate->getItemsTo())
        {
            return true;
        }

        return false;
    }

    /**
     * @param float $price
     * @param RateInterface $rate
     * @return bool
     */
    public function filterCartPrice($price, RateInterface $rate)
    {
        if($price >= $rate->getCartPriceFrom() && $price <= $rate->getCartPriceTo())
        {
            return true;
        }

        return false;
    }
}