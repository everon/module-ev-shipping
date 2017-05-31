<?php

namespace EdmondsCommerce\Shipping\Model\Rate;

use EdmondsCommerce\Shipping\Model\Rate\CollectionFactory;
use EdmondsCommerce\Shipping\Model\RateFactory;
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
     * Loader constructor.
     * @param DirectoryList $directory_list
     * @param RateFactory $ruleFactory
     * @param \EdmondsCommerce\Shipping\Model\Rate\CollectionFactory $rateCollectionFactory
     */
    public function __construct(
        DirectoryList $directory_list,
        RateFactory $ruleFactory,
        CollectionFactory $rateCollectionFactory
    )
    {
        $this->directory_list = $directory_list;
        $this->rateFactory = $ruleFactory;
        $this->rateCollectionFactory = $rateCollectionFactory;
    }

    /**
     * @return string
     */
    public function getRatePath() //TODO: Make rule path injectable
    {
        return $this->directory_list->getPath('var') . '/shipping.json';
    }

    /**
     * @return \EdmondsCommerce\Shipping\Model\Rate\Collection
     */
    public function getRateCollection()
    {
        //Assume that the file is located at a specific path
        $file = file_get_contents($this->getRatePath());
        /** @var array $data */
        $data = json_decode($file, true);

        /** @var array $rawRates */
        $rawRates = $data['rates'];

        //Generate the rates
        $rates = [];
        foreach ($rawRates as $rule)
        {
            $rates[] = $this->rateFactory->create($rule);
        }
        
        return $this->rateCollectionFactory->create($rates);
    }
}