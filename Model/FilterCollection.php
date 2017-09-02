<?php

namespace EdmondsCommerce\Shipping\Model;

use EdmondsCommerce\Shipping\Api\Data\FilterInterface;

/**
 * Container collection for all filters
 * Class FilterCollection
 *
 * @package Magento\Shipping\Model
 */
class FilterCollection
{
    /**
     * @var FilterInterface[]
     */
    private $filters;

    /**
     * FilterCollection constructor.
     *
     * @param FilterInterface[] $filters
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return FilterInterface[]
     */
    public function getFilters()
    {
        return $this->filters;
    }
}
