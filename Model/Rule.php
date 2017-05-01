<?php

namespace EdmondsCommerce\Shipping\Model;

use EdmondsCommerce\Shipping\Api\Data\RuleInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use EdmondsCommerce\Shipping\Model\ResourceModel\Rule as RuleResource;

class Rule extends AbstractModel implements IdentityInterface, RuleInterface
{

    const CACHE_TAG = 'ec_shipping_rule';

    const EVENT_PREFIX = 'ec_shipping_rule';

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(RuleResource::class);
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

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
     * @return int
     */
    public function getWebsiteId()
    {
        return $this->getData('website_id');
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->getData('country');
    }

    /**
     * @return string
     */
    public function getPostCode()
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