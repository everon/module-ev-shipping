<?php

namespace EdmondsCommerce\Shipping\Model\Rate;

use EdmondsCommerce\Shipping\Exception\ValidationException;

/**
 * Class Validator
 * @package EdmondsCommerce\Shipping\Model\Rate
 * Validates the shipping rate file for obvious things
 */
class Validator {

	/**
	 * Takes raw json and handles the validation of the rates if they exist
	 *
	 * @param array $data
	 *
	 * @return bool
	 * @throws ValidationException
	 */
	public function validateJson( array $data ) {
		if ( ! isset( $data['rates'] ) ) {
			throw new ValidationException( 'Rates is missing "rates" container' );
		}

		return $this->validateRateCollection( $data['rates'] );
	}

	/**
	 * Validate an array of rates
	 *
	 * @param array $rates
	 *
	 * @return bool
	 * @throws ValidationException
	 */
	public function validateRateCollection( array $rates ) {
		//Check for required values
		foreach ( $rates as $rate ) {
			$this->validateRate( $rate );
		}

		return true;
	}

	/**
	 * Validate a single rate
	 *
	 * @param array $data
	 *
	 * @return bool
	 * @throws ValidationException
	 */
	public function validateRate( array $data ) {
		//Check for required values
		$required = [ 'id', 'name', 'price' ];

		$missing = [];
		foreach ( $required as $value ) {
			if ( ! isset( $data[ $value ] ) ) {
				$missing[] = $value;
			}
		}

		if ( $missing ) {
			throw new ValidationException( 'Missing required rate fields: ' . implode( ', ', $missing ) );
		}

		return true;
	}
}