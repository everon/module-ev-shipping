<?php

namespace EdmondsCommerce\Shipping\Model\Rate;

use EdmondsCommerce\Shipping\Model\Rate\CollectionFactory;
use EdmondsCommerce\Shipping\Model\RateFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class Storage
 * @package EdmondsCommerce\Shipping\Model\Rate
 * Handles the retrieval of rules from a file
 */
class Loader
{
    /**
     * @var DirectoryList
     */
    private $directory_list;

    /**
     * @var \EdmondsCommerce\Shipping\Model\RateFactory
     */
    private $rateFactory;

    /**
     * @var \EdmondsCommerce\Shipping\Model\Rate\CollectionFactory
     */
    private $rateCollectionFactory;
    /**
     * @var ScopeConfigInterface
     */
    private $config;

    /**
     * Loader constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     * @param DirectoryList $directory_list
     * @param RateFactory $ruleFactory
     * @param \EdmondsCommerce\Shipping\Model\Rate\CollectionFactory $rateCollectionFactory
     */
    public function __construct(
        ScopeConfigInterface $config,
        DirectoryList $directory_list,
        RateFactory $ruleFactory,
        CollectionFactory $rateCollectionFactory
    )
    {
        $this->directory_list = $directory_list;
        $this->rateFactory = $ruleFactory;
        $this->rateCollectionFactory = $rateCollectionFactory;
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getRatePath()
    {
        //Check for configuration of the file
        $rootPath = $this->directory_list->getRoot();

        $filePath = $this->config->getValue('ecshipping/file');

        if (empty($filePath)) {
            return $this->directory_list->getPath('var') . '/shipping.json';
        }

        return $rootPath.$filePath;
    }

    /**
     * @param string $filePath
     * @return Collection
     */
    public function getRateCollection($filePath = null)
    {
        //Default to the configured rate path (from config or the hard coded value)
        if($filePath === null) {
            $filePath = $this->getRatePath();
        }

        $file = @file_get_contents($filePath);

        if ($file === false) {
            //TODO: Replace with more specific exception
            throw new \RuntimeException('Could not load shipping rates file: '.$filePath);
        }

        /** @var array $data */
        $data = json_decode($file, true);

        /** @var array $rawRates */
        $rawRates = $data['rates'];

        //Generate the rates
        $rates = [];
        foreach ($rawRates as $rule) {
            $rates[] = $this->rateFactory->create($rule);
        }

        return $this->rateCollectionFactory->create(['items' => $rates]);
    }
}