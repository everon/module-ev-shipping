<?php

namespace EdmondsCommerce\Shipping\Model;

use EdmondsCommerce\Shipping\Api\Data\RateInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Rule
 * @package EdmondsCommerce\Shipping\Model
 */
class Rate extends AbstractModel implements RateInterface
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->getData('id');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getData('name');
    }

    /**
     * @return int[]
     */
    public function getWebsiteIds()
    {
        return $this->getData('websites');
    }

    /**
     * @return string[]
     */
    public function getCountries()
    {
        return $this->getData('country');
    }

    /**
     * @return string[]
     */
    public function getPostCodes()
    {
        return $this->getData('postcode');
    }

    /**
     * @return float
     */
    public function getWeightFrom()
    {
        return $this->getData('weight_from');
    }

    /**
     * @return float
     */
    public function getWeightTo()
    {
        return $this->getData('weight_to');
    }

    /**
     * @return float
     */
    public function getPriceFrom()
    {
        return $this->getData('price_from');
    }

    /**
     * @return float
     */
    public function getPriceTo()
    {
        return $this->getData('price_to');
    }

    /**
     * @return float
     */
    public function getShippingPrice()
    {
        return $this->getData('price');
    }

    /**
     * @return int
     */
    public function getSortOrder()
    {
        return $this->getData('sort_order');
    }
}