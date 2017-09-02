<?php

namespace EdmondsCommerce\Shipping\Model;

use EdmondsCommerce\Shipping\Model\Rate\Validator;

class RateFactory
{

    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;
    /**
     * @var Validator
     */
    private $validator;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, Validator $validator)
    {
        $this->_objectManager = $objectManager;
        $this->validator      = $validator;
    }

    public function create(array $data)
    {
        /** @var Rate $rate */
        $rate = $this->_objectManager->create(Rate::class);

        $this->validator->validateRate($data);

        $rate->setData($data);

        return $rate;
    }
}
