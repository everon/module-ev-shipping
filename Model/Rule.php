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
        // TODO: Implement getId() method.
    }

    /**
     * @return string
     */
    public function getName()
    {
        // TODO: Implement getName() method.
    }

    /**
     * @return int
     */
    public function getWebsiteId()
    {
        // TODO: Implement getStoreId() method.
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        // TODO: Implement getCountry() method.
    }

    /**
     * @return string
     */
    public function getPostCode()
    {
        // TODO: Implement getPostCode() method.
    }

    /**
     * @return float
     */
    public function getWeightFrom()
    {
        // TODO: Implement getWeightFrom() method.
    }

    /**
     * @return float
     */
    public function getWeightTo()
    {
        // TODO: Implement getWeightTo() method.
    }

    /**
     * @return float
     */
    public function getPriceFrom()
    {
        // TODO: Implement getPriceFrom() method.
    }

    /**
     * @return float
     */
    public function getPriceTo()
    {
        // TODO: Implement getPriceTo() method.
    }

    /**
     * @return float
     */
    public function getShippingPrice()
    {
        // TODO: Implement getShippingPrice() method.
    }

    /**
     * @return int
     */
    public function getSortOrder()
    {
        // TODO: Implement getSortOrder() method.
    }


}