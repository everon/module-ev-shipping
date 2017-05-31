<?php

namespace EdmondsCommerce\Shipping\Model\Carrier;

use EdmondsCommerce\Shipping\Model\Rate\Loader;
use EdmondsCommerce\Shipping\Model\Rate\Resolver;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Psr\Log\LoggerInterface;

class Shipping extends AbstractCarrier implements CarrierInterface
{

    protected $_code = 'ecshipping';

    /**
     * @var Loader
     */
    private $ruleStorage;
    /**
     * @var Resolver
     */
    private $resolver;
    /**
     * @var Loader
     */
    private $loader;

    /**
     * Shipping constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param Resolver $resolver
     * @param Loader $loader
     * @param array $data
     */
    public function __construct
    (
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        Resolver $resolver,
        Loader $loader,
        array $data = []
    )
    {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);

        $this->resolver = $resolver;
        $this->loader = $loader;
    }

    /**
     * Collect and get rates
     *
     * @param RateRequest $request
     * @return \Magento\Framework\DataObject|bool|null
     * @api
     */
    public function collectRates(RateRequest $request)
    {
        $rateCollection = $this->loader->getRateCollection();
        $rates = $this->resolver->resolve($rateCollection, $request);

        //Distinct on the shipping name to remove any duplicates
        return $ruleCollection->toArray();
    }

    /**
     * Get allowed shipping methods
     *
     * @return array
     * @api
     */
    public function getAllowedMethods()
    {
        return [
            'ecshipping' => $this->getConfigData('name')
        ];
    }
}