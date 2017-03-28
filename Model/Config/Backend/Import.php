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
        \EdmondsCommerce\Shipping\Model\Upload\Importer $importer,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        parent::__construct($context, $registry, $config, $cacheTypeList, $uploaderFactory, $requestData, $filesystem, $resource, $resourceCollection, $data);
    }

    public function beforeSave()
    {
        //Validate the file before continuing
//        $this->addValidateCallback();

        /**
         * throw new \Magento\Framework\Exception\LocalizedException(
        __('The file you\'re uploading exceeds the server size limit of %1 kilobytes.', $this->_maxFileSize)
        );
         */

        return parent::beforeSave();
    }

    public function afterSave()
    {
//        $config = $this->get
        $csv = $this->getValue();
        $uploadDir = $this->_getUploadDir();
        return parent::afterSave();
    }
}