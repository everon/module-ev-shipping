<?php

namespace EdmondsCommerce\Shipping\Model\Rate;

use EdmondsCommerce\Shipping\Api\Data\RateCollectionInterface;
use EdmondsCommerce\Shipping\Api\Data\RateInterface;
use EdmondsCommerce\Shipping\Model\FilterCollection;
use EdmondsCommerce\Shipping\Model\FilterCollectionFactory;
use Magento\Quote\Model\Quote\Address\RateRequest;

/**
 * Class Resolver
 *
 * @package EdmondsCommerce\Shipping\Model\Rate
 * Handles the filtering of rates and returns a collection of rates
 * Velvet Resolver
 */
class Resolver
{
    /**
     * @var FilterCollection
     */
    private $filterCollectionFactory;

    /**
     * Resolver constructor.
     *
     * @param FilterCollectionFactory $filterCollectionFactory
     */
    public function __construct(FilterCollectionFactory $filterCollectionFactory)
    {
        $this->filterCollectionFactory = $filterCollectionFactory;
    }

    /**
     * @param RateCollectionInterface $rates
     * @param RateRequest             $request
     *
     * @return RateInterface[]
     */
    public function resolve(RateCollectionInterface $rates, RateRequest $request)
    {
        $rates = $rates->toArray();
        $collection = $this->filterCollectionFactory->create();
        $result = array_filter($rates, function (RateInterface $rate) use ($request, $collection) {
            foreach ($collection->getFilters() as $check) {
                if ($check->filter($request, $rate) === false) {
                    return false;
                }
            }

            return true;
        });

        return $result;
    }
}
