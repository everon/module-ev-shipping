<?php

namespace Everon\EvShipping\Model;

class FilterCollectionFactory
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager = null;
    /**
     * @var FilterReader
     */
    private $reader;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param FilterReader                              $reader
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, FilterReader $reader)
    {
        $this->objectManager = $objectManager;
        $this->reader         = $reader;
    }

    public function create()
    {
        //Get the configured filters
        $filters = [];
        foreach ($this->reader->getFilters() as $filter) {
            $filters[$filter['name']] = $this->objectManager->create($filter['class']);
        }

        //Create the class
        $collection = new FilterCollection($filters);

        //Done
        return $collection;
    }
}
