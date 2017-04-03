<?php

namespace EdmondsCommerce\Shipping\Model\Config\Backend;

use EdmondsCommerce\Shipping\Model\Import\Importer;
use \Magento\Config\Model\Config\Backend\File;
use Magento\Framework\Filesystem;

class Import extends File
{
    /**
     * @var Importer
     */
    private $ruleImporter;

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
        Importer $ruleImporter,
        array $data = []
    )
    {
        parent::__construct($context, $registry, $config, $cacheTypeList, $uploaderFactory, $requestData, $filesystem, $resource, $resourceCollection, $data);
        $this->ruleImporter = $ruleImporter;
    }

    public function beforeSave()
    {
        //Attempt import
        $a = 1;

        return parent::beforeSave();
    }
}