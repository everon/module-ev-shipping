<?php

namespace EdmondsCommerce\Shipping\Api\Data;

interface RateCollectionInterface
{
    public function filterWebsite();

    public function filterCountry();
}