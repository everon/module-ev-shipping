<?php

namespace EdmondsCommerce\Shipping\Model\Filter;

use EdmondsCommerce\Shipping\Api\Data\FilterInterface;
use EdmondsCommerce\Shipping\Api\Data\RateInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;

class CartPrice extends AbstractRangeFilter implements FilterInterface
{

    /**
     * Get the value that is being checked
     *
     * @param RateRequest $request
     *
     * @return float
     */
    public function getValue(RateRequest $request)
    {
        return $request->getData('package_value');
    }

    /**
     * Upper boundary to check against
     *
     * @param RateInterface $rate
     *
     * @return float
     */
    public function getUpperBoundary(RateInterface $rate)
    {
        return $this->parseRangeValue($rate->getCartPriceTo());
    }

    /**
     * Lower boundary to check against
     *
     * @param RateInterface $rate
     *
     * @return float
     */
    public function getLowerBoundary(RateInterface $rate)
    {
        return $this->parseRangeValue($rate->getCartPriceFrom());
    }
}
