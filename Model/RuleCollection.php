<?php

namespace EdmondsCommerce\Shipping\Model;

class RuleCollection
{
    /** @var Rule */
    protected $items;

    /**
     * RuleCollection constructor.
     * @param Rule[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function filterWebsite($websiteCode)
    {

    }
}