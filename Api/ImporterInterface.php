<?php

namespace EdmondsCommerce\Shipping\Api;

interface ImporterInterface
{
    /**
     * Get the shipping rules for this file
     * @return array
     */
    public function getRules();

    /**
     * Validate the file
     * @return boolean
     * @throws \Exception
     */
    public function validate();
}