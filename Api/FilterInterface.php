<?php

namespace EdmondsCommerce\Shipping\Api;

/**
 * Interface FilterInterface
 * @package EdmondsCommerce\Shipping\Api
 */
interface FilterInterface
{
    /**
     * Takes a value and filters it, returns true if the filter matches, false otherwise
     * @param string $input
     * @return boolean
     */
    public function filter($input);
}