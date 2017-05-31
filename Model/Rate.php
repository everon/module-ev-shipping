<?php

namespace EdmondsCommerce\Shipping\Model;

use EdmondsCommerce\Shipping\Api\Data\RateInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Rule
 * @package EdmondsCommerce\Shipping\Model\Rate
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
    public function getCartPriceFrom()
    {
        return $this->getData('cart_price_from');
    }

    /**
     * @return float
     */
    public function getCartPriceTo()
    {
        return $this->getData('cart_price_to');
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

    /**
     * @return int
     */
    public function getItemsFrom()
    {
        return $this->getData('items_from');
    }

    /**
     * @return int
     */
    public function getItemsTo()
    {
        return $this->getData('items_to');
    }
}