<?php

namespace EdmondsCommerce\Shipping\Model\Config\Backend;

use \Magento\Config\Model\Config\Backend\File;

class Import extends File
{

    public function _construct()
    {
        parent::_construct();
    }

    /**
     * @return $this
     */
    public function beforeSave()
    {
        //Attempt import
//        $a = 1;
//
//        $file = $this->getValue();
//        $fileData = file_get_contents($file['tmp_name']);
//        $website = $this->getScopeId();


        return parent::beforeSave();
    }

    /**
     * Getter for allowed extensions of uploaded files
     *
     * @return array
     */
    protected function _getAllowedExtensions()
    {
        return ['csv'];
    }
}