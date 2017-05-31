<?php

namespace EdmondsCommerce\Shipping\Model\Rate;

class Collection
{
    /** @var Rate[] */
    protected $items;

    /**
     * RuleCollection constructor.
     * @param Rate[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function toArray()
    {
        return $this->items;
    }
}