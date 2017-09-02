<?php

namespace EdmondsCommerce\Shipping\Model\Carrier;

use EdmondsCommerce\Shipping\Api\Data\RateInterface;
use Magento\Quote\Model\Quote\Address\RateResult\Method;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory as ParentFactory;

/**
 * Class ResultFactory
 *
 * @package EdmondsCommerce\Shipping\Model\Carrier
 * Convenience class for converting rates to results
 */
class MethodFactory
{

    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;
    /**
     * @var ParentFactory
     */
    private $factory;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Factory constructor
     *
     * @param ParentFactory                                      $factory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(ParentFactory $factory, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->factory     = $factory;
        $this->scopeConfig = $scopeConfig;
    }


    /**
     * @param RateInterface $rate
     *
     * @return Method
     */
    public function create(RateInterface $rate)
    {
        /** @var Method $result */
        $result = $this->factory->create();

        $result->setCarrier('ecshipping');
        $result->setCarrierTitle($rate->getName());
        $result->setMethod('ecshipping');
        $result->setMethodTitle($rate->getName());
        $result->setCost($rate->getShippingPrice());
        $result->setPrice($rate->getShippingPrice());

        return $result;
        /**
         * [
         * 'price' => $rate->getShippingPrice(),
         * 'cost' => $rate->getShippingPrice(),
         * 'carrier' => $rate->getName(),
         * 'carrier_title' => $rate->getName(),
         * 'method' => $rate->getName(),
         * 'method_title' => $rate->getName()
         * ]
         */
    }
}
