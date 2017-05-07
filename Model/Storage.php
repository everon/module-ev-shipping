<?php

namespace EdmondsCommerce\Shipping\Model;

use EdmondsCommerce\Shipping\Model\RuleCollectionFactory;
use EdmondsCommerce\Shipping\Model\RuleFactory;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class Storage
 * @package EdmondsCommerce\Shipping\Model
 * Handles the retrieval of rules from a file (database)
 */
class Storage
{
    /**
     * @var DirectoryList
     */
    private $directory_list;
    /**
     * @var \EdmondsCommerce\Shipping\Model\RuleFactory
     */
    private $ruleFactory;
    /**
     * @var \EdmondsCommerce\Shipping\Model\RuleCollectionFactory
     */
    private $ruleCollectionFactory;

    /**
     * Storage constructor.
     * @param DirectoryList $directory_list
     * @param \EdmondsCommerce\Shipping\Model\RuleFactory $ruleFactory
     * @param \EdmondsCommerce\Shipping\Model\RuleCollectionFactory $ruleCollectionFactory
     */
    public function __construct(DirectoryList $directory_list, RuleFactory $ruleFactory, RuleCollectionFactory $ruleCollectionFactory)
    {
        $this->directory_list = $directory_list;
        $this->ruleFactory = $ruleFactory;
        $this->ruleCollectionFactory = $ruleCollectionFactory;
    }

    public function getRulePath()
    {
        return $this->directory_list->getPath('var') . '/shipping.json';
    }

    /**
     * @return RateCollection
     */
    public function getRuleCollection()
    {
        //Assume that the file is located at a specific path
        $file = file_get_contents($this->getRulePath());
        $data = json_decode($file);

        //Generate the rules
        $rules = [];
        foreach($data['rules'] as $rule)
        {
            $rules[] = $this->ruleFactory->create($rule);
        }

        $collection = $this->ruleCollectionFactory->create($rules);

        return $collection;
    }
}