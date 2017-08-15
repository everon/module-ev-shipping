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
        if($websites === null)
        {
            //no condition set
            return true;
        }
        return (in_array($websiteId, $websites));
    }

    /**
     * @param string $postcode
     * @param RateInterface $rate
     * @return bool
     */
    public function filterPostcode($postcode, RateInterface $rate)
    {
        $postcodes = $rate->getPostCodes();
        if($postcodes === null)
        {
            //No condition set
            return true;
        }

        foreach ($rate->getPostCodes() as $checkPostCode) {
            //Wildcard match
            if ($checkPostCode === '*') {
                return true;
            }

            //UK district match - BD, LS etc
            $result = stristr($postcode, $checkPostCode);
            if ($result !== false) {
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
        $countries = $rate->getCountries();

        //If no country array is set then skip the check
        if($countries === null)
        {
            return true;
        }

        foreach ($countries as $checkCountry) {
            if ($checkCountry === '*') {
                return true;
            }

            $result = ($checkCountry === $countryCode);
            if ($result === true) {
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
        $weightFrom = $rate->getWeightFrom();
        $weightTo = $rate->getWeightTo();

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

    /**
     * @param $itemCount
     * @param $rate
     * @return bool
     */
    public function filterItemCount($itemCount, RateInterface $rate)
    {
        $itemsFrom = $rate->getItemsFrom();
        $itemsTo = $rate->getItemsTo();

        if($itemsFrom === null && $itemsTo === null)
        {
            //no condition set
            return true;
        }

        if ($itemCount >= $itemsFrom && $itemCount <= $itemsTo) {
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
        $priceFrom = $rate->getCartPriceFrom();
        $priceTo = $rate->getCartPriceTo();
        if($priceFrom == null && $priceTo == null)
        {
            //No condition
            return true;
        }

        if ($price >= $priceFrom && $price <= $priceTo) {
            return true;
        }

        return false;
    }
}