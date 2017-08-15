<?php

namespace EdmondsCommerce\Shipping\Model\Filter;

use EdmondsCommerce\Shipping\Api\Data\FilterInterface;
use EdmondsCommerce\Shipping\Api\Data\RateInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;

class CartPrice implements FilterInterface
{


    /**
     * Checks one or more values to see if they pass certain checks (total weight, item count, postcode etc)
     * @param RateRequest $request
     * @param RateInterface $rate
     * @return bool
     */
    public function filter(RateRequest $request, RateInterface $rate)
    {
        $price = $request->getOrderSubtotal();

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