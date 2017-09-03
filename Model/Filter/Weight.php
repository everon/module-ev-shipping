<?php

namespace Everon\EvShipping\Model\Filter;

use Everon\EvShipping\Api\Data\FilterInterface;
use Everon\EvShipping\Api\Data\RateInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;

class Weight extends AbstractRangeFilter implements FilterInterface
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
        return $request->getPackageWeight();
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
        return $this->parseRangeValue($rate->getWeightTo());
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
        return $this->parseRangeValue($rate->getWeightFrom());
    }
}
