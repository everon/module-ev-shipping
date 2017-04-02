<?php

namespace EdmondsCommerce\Shipping\Model\Import\File;

class CSV
{

    private $data;

    /**
     * CSV constructor.
     * @param $data string File data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Validates the file formatting only, not the contents
     */
    public function validate()
    {

    }

    /**
     *
     */
    public function getRules()
    {

    }
}