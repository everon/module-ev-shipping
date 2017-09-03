<?php

namespace Everon\EvShipping\Model\Rate;

use Everon\EvShipping\Exception\InvalidJsonShippingException;
use Everon\EvShipping\Exception\ShippingException;

/**
 * Class Reader
 *
 * @package Everon\EvShipping\Model\Rate
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
