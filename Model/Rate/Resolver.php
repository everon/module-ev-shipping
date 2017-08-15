<?php

namespace EdmondsCommerce\Shipping\Model\Rate;

use EdmondsCommerce\Shipping\Api\Data\RateCollectionInterface;
use EdmondsCommerce\Shipping\Api\Data\RateInterface;
use EdmondsCommerce\Shipping\Model\FilterCollection;
use EdmondsCommerce\Shipping\Model\FilterCollectionFactory;
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
    private $filterCollection;

    /**
     * Resolver constructor.
     * @param Filter $filterCollection
     */
    public function __construct(FilterCollectionFactory $filterCollectionFactory)
    {
        $this->filterCollection = $filterCollectionFactory->create();
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
            foreach($this->filterCollection->getFilters() as $check)
            {
                if($check->filter($request, $rate) === false)
                {
                    return false;
                }
            }

            return true;
        });

        return $result;
    }
}