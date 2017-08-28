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
class Loader {


	/**
	 * @var \EdmondsCommerce\Shipping\Model\RateFactory
	 */
	private $rateFactory;

	/**
	 * @var \EdmondsCommerce\Shipping\Model\Rate\CollectionFactory
	 */
	private $rateCollectionFactory;
	/**
	 * @var Locator
	 */
	private $locator;


	/**
	 * Loader constructor.
	 *
	 * @param Locator $locator
	 * @param RateFactory $rateFactory
	 * @param \EdmondsCommerce\Shipping\Model\Rate\CollectionFactory $rateCollectionFactory
	 */
	public function __construct(
		Locator $locator,
		RateFactory $rateFactory,
		CollectionFactory $rateCollectionFactory
	) {
		$this->rateFactory           = $rateFactory;
		$this->rateCollectionFactory = $rateCollectionFactory;
		$this->locator = $locator;
	}

	/**
	 * @param string $filePath
	 *
	 * @return Collection
	 */
	public function getRateCollection( $filePath = null ) {
		//Default to the configured rate path (from config or the hard coded value)
		if ( $filePath === null ) {
			$filePath = $this->locator->getRatePath();
		}

		$file = @file_get_contents( $filePath );

		if ( $file === false ) {
			//TODO: Replace with more specific exception
			throw new \RuntimeException( 'Could not load shipping rates file: ' . $filePath );
		}

		/** @var array $data */
		$data = json_decode( $file, true );

		/** @var array $rawRates */
		$rawRates = $data['rates'];

		//Generate the rates
		$rates = [];
		foreach ( $rawRates as $rule ) {
			$rates[] = $this->rateFactory->create( $rule );
		}

		return $this->rateCollectionFactory->create( [ 'items' => $rates ] );
	}
}