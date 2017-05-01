<?php

namespace Magento\Shipping\Model\Filters;

use EdmondsCommerce\Shipping\Api\FilterInterface;

/**
 * Class PostcodeFilter
 * @package Magento\Shipping\Model\Filters
 * Handles filtering of postcodes
 * Types of rule include full post codes, partial post codes (BD1, LS1, NW1 M1), wildcard (*),
 */
class PostcodeFilter implements FilterInterface
{
    /**
     * Takes a value and filters it, returns true if the filter matches, false otherwise
     * @param string $input
     * @return boolean
     */
    public function filter($input)
    {
        return true;
    }
}