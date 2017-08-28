<?php

namespace EdmondsCommerce\Shipping\Model\Rate;

/**
 * Class Reader
 * @package EdmondsCommerce\Shipping\Model\Rate
 * Simple wrapper to read and parse rate classes
 */
class Reader {
	/**
	 * @param $path
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function read( $path ) {
		if ( ! file_exists( $path ) ) {
			throw new \Exception( 'Could not read rate file at ' . $path );
		}

		//Read the file
		$data = file_get_contents( $path );

		//Decode the file
		$data = json_decode( $data, true );

		if ( $data === null ) {
			throw new \Exception( 'Invalid JSON in rate file at ' . $path );
		}

		return $data;
	}
}