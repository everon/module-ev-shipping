<?php

namespace Everon\EvShipping\Model;

use Everon\EvShipping\Model\Rate\Validator;

class RateFactory
{

    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager = null;
    /**
     * @var Validator
     */
    private $validator;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param Validator                                 $validator
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, Validator $validator)
    {
        $this->objectManager = $objectManager;
        $this->validator      = $validator;
    }

    public function create(array $data)
    {
        /** @var Rate $rate */
        $rate = $this->objectManager->create(Rate::class);

        $this->validator->validateRate($data);

        $rate->setData($data);

        return $rate;
    }
}
