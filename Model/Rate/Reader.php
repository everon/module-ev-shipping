<?php

namespace EdmondsCommerce\Shipping\Model\Rate;

use EdmondsCommerce\Shipping\Exception\InvalidJsonShippingException;
use EdmondsCommerce\Shipping\Exception\ShippingException;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Reader
 *
 * @package EdmondsCommerce\Shipping\Model\Rate
 * Simple wrapper to read and parse rate classes
 */
class Reader
{
    /**
     * @param $path
     *
     * @return array
     * @throws \Exception
     */
    public function read($path)
    {
        if (!file_exists($path)) {
            throw new ShippingException('Could not read rate file at ' . $path);
        }

        //Read the file
        $data = file_get_contents($path);

        //Decode the file
        $data = json_decode($data, true);

        if ($data === null) {
            throw new InvalidJsonShippingException('Invalid JSON in rate file at ' . $path);
        }

        return $data;
    }
}
