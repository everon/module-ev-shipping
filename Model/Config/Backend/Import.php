<?php

namespace EdmondsCommerce\Shipping\Model\Config\Backend;

use \Magento\Config\Model\Config\Backend\File;
use Magento\Framework\Filesystem;

class Import extends File
{

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Magento\Config\Model\Config\Backend\File\RequestData\RequestDataInterface $requestData,
        Filesystem $filesystem,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        parent::__construct($context, $registry, $config, $cacheTypeList, $uploaderFactory, $requestData, $filesystem, $resource, $resourceCollection, $data);
    }

    public function beforeSave()
    {
        //Attempt import
        $a = 1;

        $file = $this->getValue();
        $fileData = file_get_contents($file['tmp_name']);
        $website = $this->getScopeId();


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