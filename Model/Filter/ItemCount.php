<?php

namespace EdmondsCommerce\Shipping\Model\Filter;

use EdmondsCommerce\Shipping\Api\Data\FilterInterface;
use EdmondsCommerce\Shipping\Api\Data\RateInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;

class ItemCount implements FilterInterface
{
    /**
     * Checks one or more values to see if they pass certain checks (total weight, item count, postcode etc)
     * @param RateRequest $request
     * @param RateInterface $rate
     * @return bool
     */
    public function filter(RateRequest $request, RateInterface $rate)
    {
        $itemCount = count($request->getAllItems());
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
}