<?php

namespace EdmondsCommerce\Shipping\Model;

class RateCollection
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