<?php

namespace EdmondsCommerce\Shipping\Model\Config\Backend\Import;

use EdmondsCommerce\Shipping\Exception\ShippingException;
use EdmondsCommerce\Shipping\Exception\RateImportShippingException;
use EdmondsCommerce\Shipping\Model\Rate\Validator;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Model\AbstractModel;

class Writer
{
    /**
     * @var Validator
     */
    private $validator;
    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * Writer constructor.
     *
     * @param Validator     $validator
     * @param DirectoryList $directoryList
     */
    public function __construct(Validator $validator, DirectoryList $directoryList)
    {
        $this->validator     = $validator;
        $this->directoryList = $directoryList;
    }

    /**
     * Validate the rates file and write it to the correct place on disk
     * WARNING: Overwrites existing rate file
     *
     * @param $filePath
     *
     * @return string The file path of the imported rate file
     * @throws ShippingException
     */
    public function handleImport($filePath)
    {
        //Check file exists
        if (!file_exists($filePath)) {
            throw new RateImportShippingException('Could not find the uploader rates file at: ' . $filePath);
        }

        //Try and read the file
        $data = @file_get_contents($filePath);
        if ($data === false) {
            throw new RateImportShippingException('Could not read the file at ' . $filePath);
        }

        //Try and decode the file
        $json = json_decode($data, true);
        if ($json === null) {
            throw new RateImportShippingException('Invalid Json in uploaded rate file');
        }

        //Attempt validation
        $this->validator->validateJson($json);

        //Passed all checks, write the file
        $targetPath = $this->directoryList->getPath('var') . '/shipping-config.json';

        file_put_contents($targetPath, $data);

        return $targetPath;
    }
}
