<?php

namespace EdmondsCommerce\Shipping\Api\Data;

interface RuleCollectionInterface
{
    public function filterWebsite();

    public function filterCountry();
}