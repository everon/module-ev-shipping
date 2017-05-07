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
        foreach($rate->getPostCodes() as $checkPostCode)
        {
            //Wildcard match
            if($checkPostCode === '*')
            {
                return true;
            }

            //UK district match - BD
            $result = stristr(trim($postcode), $checkPostCode);
            if($result !== false)
            {
                return true;
            }


        }

        //UK sub district - BD17
        //Wildcard - *
//        if($postcode ==)

        return false;
    }
}