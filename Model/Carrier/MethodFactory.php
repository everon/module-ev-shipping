<?php

namespace Everon\EvShipping\Model\Carrier;

use Everon\EvShipping\Api\Data\RateInterface;
use Magento\Quote\Model\Quote\Address\RateResult\Method;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory as ParentFactory;

/**
 * Class ResultFactory
 *
 * @package Everon\EvShipping\Model\Carrier
 * Convenience class for converting rates to results
 */
class MethodFactory
{
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
    }
}
