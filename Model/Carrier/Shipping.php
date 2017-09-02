<?php

namespace EdmondsCommerce\Shipping\Model\Carrier;

use EdmondsCommerce\Shipping\Model\Rate\Loader;
use EdmondsCommerce\Shipping\Model\Rate\Resolver;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\ResultFactory;
use Psr\Log\LoggerInterface;

class Shipping extends AbstractCarrier implements CarrierInterface
{

    private $_code = 'ecshipping';

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
     * @var MethodFactory
     */
    private $rateResultFactory;
    /**
     * @var MethodFactory
     */
    private $rateMethodFactory;

    /**
     * Shipping constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory         $rateErrorFactory
     * @param LoggerInterface      $logger
     * @param Resolver             $resolver
     * @param Loader               $loader
     * @param ResultFactory        $rateResultFactory
     * @param MethodFactory        $rateMethodFactory
     * @param array                $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        Resolver $resolver,
        Loader $loader,
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory,
        array $data = []
    ) {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);

        $this->resolver          = $resolver;
        $this->loader            = $loader;
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
    }

    /**
     * Collect and get rates
     *
     * @param RateRequest $request
     *
     * @return \Magento\Framework\DataObject|bool|null
     * @api
     */
    public function collectRates(RateRequest $request)
    {
        try {
            $rateCollection = $this->loader->getRateCollection();
        } catch (\RuntimeException $e) {
            $this->_logger->error($e->getMessage());

            return false;
        }
        $rates = $this->resolver->resolve($rateCollection, $request);

        //Convert rates to results
        $result = $this->rateResultFactory->create();

        foreach ($rates as $rate) {
            $result->append($this->rateMethodFactory->create($rate));
        }

        return $result;
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
            'ecshipping' => $this->getConfigData('name'),
        ];
    }
}
