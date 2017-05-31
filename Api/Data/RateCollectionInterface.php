<?php

namespace EdmondsCommerce\Shipping\Api\Data;

interface RateCollectionInterface
{
    /**
     * @return RateInterface[]
     */
    public function toArray();
}