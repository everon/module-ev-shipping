<?php

namespace Everon\EvShipping\Model\Rate;

use Everon\EvShipping\Api\Data\RateCollectionInterface;
use Everon\EvShipping\Api\Data\RateInterface;

class Collection implements RateCollectionInterface
{
    /** @var RateInterface[] */
    protected $items;

    /**
     * RuleCollection constructor.
     *
     * @param RateInterface[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return RateInterface[]
     */
    public function toArray()
    {
        return $this->items;
    }
}
