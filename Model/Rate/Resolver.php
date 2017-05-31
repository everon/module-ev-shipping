<?php

namespace EdmondsCommerce\Shipping\Model\Rate;

use EdmondsCommerce\Shipping\Api\Data\RateCollectionInterface;
use EdmondsCommerce\Shipping\Api\Data\RateInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;

/**
 * Class Resolver
 * @package EdmondsCommerce\Shipping\Model\Rate
 * Handles the filtering of rates and returns a collection of rates
 * Velvet Resolver
 */
class Resolver
{
    /**
     * @var Filter
     */
    private $filter;

    /**
     * Resolver constructor.
     * @param Filter $filter
     */
    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @param RateCollectionInterface $rates
     * @param RateRequest $request
     * @return RateInterface[]
     */
    public function resolve(RateCollectionInterface $rates, RateRequest $request)
    {
        //TODO: Distinct on the shipping name to remove any duplicates

        $rates = $rates->toArray();

        $result = array_filter($rates, function (RateInterface $rate) use ($request)
        {
            if (!$this->filter->filterWebsite($request->getWebsiteId(), $rate))
            {
                return false;
            }

            if (!$this->filter->filterCountry($request->getDestCountryId(), $rate))
            {
                return false;
            }

            if (!$this->filter->filterPostcode($request->getDestPostcode(), $rate))
            {
                return false;
            }

            if (!$this->filter->filterCartPrice($request->getOrderSubtotal(), $rate))
            {
                return false;
            }

            if (!$this->filter->filterWeight($request->getPackageWeight(), $rate))
            {
                return false;
            }

            if (!$this->filter->filterItemCount(count($request->getAllItems()), $rate))
            {
                return false;
            }

            return true;
        });

        return $result;
    }
}