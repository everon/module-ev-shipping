<?php

namespace Everon\EvShipping\Model;

use Everon\EvShipping\Api\Data\RateInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Rate
 *
 * @package Everon\EvShipping\Model\Rate
 * Standard object that contains information about a shipping rate
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
        return ($this->getData('countries') === null ? null : $this->getData('countries'));
    }

    /**
     * @return string[]
     */
    public function getPostCodes()
    {
        return $this->getData('postcodes');
    }

    /**
     * @return float
     */
    public function getWeightFrom()
    {
        $weight = $this->getData('weight');

        return (isset($weight['from']) ? $weight['from'] : null);
    }

    /**
     * @return float
     */
    public function getWeightTo()
    {
        $weight = $this->getData('weight');

        return (isset($weight['to']) ? $weight['to'] : null);
    }

    /**
     * @return float
     */
    public function getCartPriceFrom()
    {
        $cartPrice = $this->getData('cart_price');

        return (isset($cartPrice['from']) ? $cartPrice['from'] : null);
    }

    /**
     * @return float
     */
    public function getCartPriceTo()
    {
        $cartPrice = $this->getData('cart_price');

        return (isset($cartPrice['to']) ? $cartPrice['to'] : null);
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
        $items = $this->getData('items');

        return (isset($items['from']) ? $items['from'] : null);
    }

    /**
     * @return int
     */
    public function getItemsTo()
    {
        $items = $this->getData('items');

        return (isset($items['to']) ? $items['to'] : null);
    }
}
