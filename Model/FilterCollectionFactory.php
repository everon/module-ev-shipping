<?php

namespace EdmondsCommerce\Shipping\Model;

class FilterCollectionFactory
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;
    /**
     * @var FilterReader
     */
    private $reader;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param FilterReader $reader
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, FilterReader $reader)
    {
        $this->_objectManager = $objectManager;
        $this->reader = $reader;
    }


    public function create(array $data = [])
    {
        //Get the configured filters
        $filters = [];
        foreach ($this->reader->getFilters() as $filter)
        {
            $filters[$filter['name']] = $this->_objectManager->create($filter['class']);
        }

        //Create the class
        $collection = new FilterCollection($filters);

        //Done
        return $collection;
    }
}