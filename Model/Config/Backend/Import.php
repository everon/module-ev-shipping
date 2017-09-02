<?php

namespace EdmondsCommerce\Shipping\Model\Config\Backend;

use EdmondsCommerce\Shipping\Model\Config\Backend\Import\Writer;
use Magento\Config\Model\Config\Backend\File;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;

class Import extends File
{
    /**
     * @var Writer
     */
    private $writer;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        UploaderFactory $uploaderFactory,
        File\RequestData\RequestDataInterface $requestData,
        Filesystem $filesystem,
        Writer $writer,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $config,
            $cacheTypeList,
            $uploaderFactory,
            $requestData,
            $filesystem,
            $resource,
            $resourceCollection,
            $data
        );
        $this->writer = $writer;
    }

    /**
     * @return Import
     */
    public function beforeSave()
    {
        //Attempt import
        /** @var array $file */
        $file     = $this->getValue();
        $filePath = $file['tmp_name'];

        $resultPath = $this->writer->handleImport($filePath);
        $this->setValue($resultPath);

        return $this;
    }

    /**
     * Getter for allowed extensions of uploaded files
     *
     * @return array
     */
    public function _getAllowedExtensions()
    {
        return ['json'];
    }
}
