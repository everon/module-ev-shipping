<?php

namespace EdmondsCommerce\Shipping\Model\Carrier;

use EdmondsCommerce\Shipping\Model\Storage as RuleStorage;
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
     * @var RuleStorage
     */
    private $ruleStorage;

    /**
     * Shipping constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param RuleStorage $ruleStorage
     * @param array $data
     */
    public function __construct
    (
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        RuleStorage $ruleStorage,
        array $data = []
    )
    {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
        $this->ruleStorage = $ruleStorage;
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
        $ruleCollection = $this->ruleStorage->getRuleCollection();

        //Filter by the website
        $ruleCollection = $ruleCollection->filterWebsite($request->getWebsiteId());

        //Rules that match the country code first
        $ruleCollection = $ruleCollection->filterCountry($request->getDestCountryId());

        //TODO: Handle wildcards and post code matching
        $ruleCollection = $ruleCollection->filterPostcode($request->getDestPostcode());

        //Rules that match the price boundaries
//        $ruleCollection->filterBasketTotalPrice();

        //Rules that match the weight boundaries
        $ruleCollection = $ruleCollection->filterWeight($request->getPackageWeight());

        //Sort by sort order and distinct on the shipping name to remove any duplicates
        $ruleCollection = $ruleCollection->getRulesSorted();

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