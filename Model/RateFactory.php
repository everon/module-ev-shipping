<?php

namespace EdmondsCommerce\Shipping\Model;

class RateFactory {

	/**
	 * Object Manager instance
	 *
	 * @var \Magento\Framework\ObjectManagerInterface
	 */
	protected $_objectManager = null;

	/**
	 * Factory constructor
	 *
	 * @param \Magento\Framework\ObjectManagerInterface $objectManager
	 */
	public function __construct( \Magento\Framework\ObjectManagerInterface $objectManager ) {
		$this->_objectManager = $objectManager;
	}

	public function create( array $data ) {
		/** @var Rate $rate */
		$rate = $this->_objectManager->create( Rate::class );

		//Required parameters
		$args = [ 'name', 'price'];

		$missing = [];
		foreach($args as $arg)
		{
			if(!isset($data[$arg]))
			{
				$missing[] = $arg;
			}
		}
		if(!empty($missing))
		{
			throw new \Exception('Missing required arguments for rate: '.implode(',', $missing));
		}

		$rate->setData($data);

		return $rate;
	}
}