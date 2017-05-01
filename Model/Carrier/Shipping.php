<?php

namespace EdmondsCommerce\Shipping\Model\Carrier;

use EdmondsCommerce\Shipping\Model\Rule;
use EdmondsCommerce\Shipping\Model\RuleFactory;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;

class Shipping extends AbstractCarrier implements CarrierInterface
{

    protected $_code = 'ecshipping';
    /**
     * @var RuleFactory
     */
    private $ruleFactory;

    /**
     * Shipping constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param RuleFactory $ruleFactory
     * @param array $data
     */
    public function __construct
    (
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        RuleFactory $ruleFactory,
        array $data = []
    )
    {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
        $this->ruleFactory = $ruleFactory;
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
        /** @var Rule $rule */
        $rule = $this->ruleFactory->create();
        $ruleCollection = $rule->getCollection();

        //Filter by the website
        $ruleCollection->addFieldToFilter('website_id', ['eq' => $request->getWebsiteId()]);

        //Rules that match the country code first
        $ruleCollection->addFieldToFilter('country', ['eq' => $request->getDestCountryId()]);

        //Rules that match the postal code
        //TODO: Handle wildcards and post code matching

        //Rules that match the price boundaries
        //TODO: Handle wildcards and infinity keyword (INF)

        //Rules that match the weight boundaries
        //TODO: Handle wildcards and infinity keyword (INF)

        //Sort by sort order
        $ruleCollection->setOrder('sort_order', $ruleCollection::SORT_ORDER_ASC);

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