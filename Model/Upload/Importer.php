<?php

namespace EdmondsCommerce\Shipping\Model\Upload;

class Importer
{
    /**
     * @var Validator
     */
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function import()
    {

    }
}