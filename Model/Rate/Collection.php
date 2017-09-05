<?php

namespace Everon\EvShipping\Model\Rate;

use Everon\EvShipping\Api\Data\FilterInterface;
use Everon\EvShipping\Api\Data\RateCollectionInterface;
use Everon\EvShipping\Api\Data\RateInterface;
use Everon\EvShipping\Model\FilterCollection;
use Magento\Quote\Model\Quote\Address\RateRequest;

class Collection implements RateCollectionInterface
{
    /**
     * @var RateInterface[]
     */
    private $rates;

    /**
     * @var CollectionFactory
     */
    private $factory;

    /**
     * RuleCollection constructor.
     *
     * @param CollectionFactory $factory
     * @param RateInterface[]   $items
     */
    public function __construct(CollectionFactory $factory, array $items = [])
    {
        $this->rates   = $items;
        $this->factory = $factory;
    }

    /**
     * @return RateInterface[]
     */
    public function toArray()
    {
        return $this->rates;
    }

    /**
     * Runs the collection through the filter
     *
     * @param RateRequest     $request
     * @param FilterInterface $filter
     *
     * @return RateCollectionInterface
     */
    public function filterBy(RateRequest $request, FilterInterface $filter)
    {
        $result = [];
        foreach ($this->rates as $rate) {
            if ($filter->filter($request, $rate)) {
                $result[] = $rate;
            }
        }

        return $this->factory->create(['items' => $result]);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return (count($this->rates) === 0);
    }
}
