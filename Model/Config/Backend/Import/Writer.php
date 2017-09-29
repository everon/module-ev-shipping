<?php

namespace Everon\EvShipping\Model\Config\Backend\Import;

use Everon\EvShipping\Exception\RateImportException;
use Everon\EvShipping\Exception\ShippingException;
use Everon\EvShipping\Model\Rate\Validator;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\File\Read;
use Magento\Framework\Filesystem\File\ReadInterfaceFactory;
use Magento\Framework\Filesystem\File\WriteInterfaceFactory;

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
     * @var ReadInterface
     */
    private $readerFactory;

    /**
     * @var WriteInterface
     */
    private $writerFactory;

    /**
     * Writer constructor.
     *
     * @param Validator             $validator
     * @param DirectoryList         $directoryList
     * @param ReadInterfaceFactory  $readerFactory
     * @param WriteInterfaceFactory $writerFactory
     */
    public function __construct(
        Validator $validator,
        DirectoryList $directoryList,
        ReadInterfaceFactory $readerFactory,
        WriteInterfaceFactory $writerFactory
    ) {
        $this->validator     = $validator;
        $this->directoryList = $directoryList;
        $this->readerFactory = $readerFactory;
        $this->writerFactory = $writerFactory;
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
        try {
            //Try and open the file
            /** @var Read $fileReader */
            $fileReader = $this->readerFactory->create(['path' => $filePath]);
        } catch (FileSystemException $e) {
            //Could not find the file
            throw new RateImportException('Could not find the uploader rates file at: ' . $filePath);
        }

        $data = $fileReader->readAll();
        $fileReader->close();

        //Try and decode the file
        $json = json_decode($data, true);
        if ($json === null) {
            throw new RateImportException('Invalid Json in uploaded rate file');
        }

        //Attempt validation
        $this->validator->validateJson($json);

        //Passed all checks, write the file
        $targetPath = $this->directoryList->getPath('var') . '/shipping-config.json';

        try {
            $writer = $this->writerFactory->create(['path' => $targetPath, 'mode' => 'w']);
            $writer->write($data);
        } catch (FileSystemException $e) {
            $error = implode('<br />', error_get_last());
            throw new RateImportException($error);
        }

        return $targetPath;
    }
}
