<?php

namespace Everon\EvShipping\Model\Filter;

use Everon\EvShipping\Api\Data\FilterInterface;
use Everon\EvShipping\Api\Data\RateInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;

/**
 * Class AbstractRangeFilter
 *
 * @package Everon\EvShipping\Model\Filter
 * Handles range based filters (i.e. weight range, price range)
 */
abstract class AbstractRangeFilter implements FilterInterface
{
    /**
     * Get the value that is being checked
     *
     * @param RateRequest $request
     *
     * @return float
     */
    abstract public function getValue(RateRequest $request);

    /**
     * Upper boundary to check against
     *
     * @param RateInterface $rate
     *
     * @return float
     */
    abstract public function getUpperBoundary(RateInterface $rate);

    /**
     * Casts to float but honours null values
     *
     * @param $value
     *
     * @return float
     */
    public function parseRangeValue($value)
    {
        return ($value !== null && is_numeric($value)) ? floatval($value) : null;
    }

    /**
     * Lower boundary to check against
     *
     * @param RateInterface $rate
     *
     * @return float
     */
    abstract public function getLowerBoundary(RateInterface $rate);

    public function filter(RateRequest $request, RateInterface $rate)
    {
        $value = $this->getValue($request);
        $lower = $this->getLowerBoundary($rate);
        $upper = $this->getUpperBoundary($rate);

        //No condition set
        if ($lower == null && $upper == null) {
            return true;
        }

        //Only lower boundary
        if ($lower !== null && $upper == null && $value >= $lower) {
            return true;
        }

        //Only upper boundary
        if ($upper !== null && $lower == null && $value <= $upper) {
            return true;
        }

        //Upper and lower boundary
        if ($value >= $lower && $value <= $upper) {
            return true;
        }

        return false;
    }
}
