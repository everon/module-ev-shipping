<?php

namespace EdmondsCommerce\Shipping\Model\Import;

use EdmondsCommerce\Shipping\Api\ImporterInterface;
use EdmondsCommerce\Shipping\Model\Import\File\CSV;
use Magento\Framework\ObjectManager\ObjectManager;

/**
 * Class ImportResolver
 * @package EdmondsCommerce\Shipping\Model\Import
 * Resolves the type of importer to use depending on the file type and builds it
 */
class ImportResolver
{
    /** @var array */
    private $importers;

    /** @var ObjectManager */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->importers = [
            'text/csv' => CSV::class
        ];
    }

    public function resolve($type)
    {
        if(isset($this->importers[$type]))
        {
            return $this->importers[$type];
        }

        throw new \Exception('Could not find importer for file type: '. $type);
    }

    /**
     * @param $type
     * @param $data
     * @return ImporterInterface
     */
    public function create($type, $data, $website)
    {
        $class = $this->resolve($type);

        return $this->objectManager->create($class, ['data' => $data, 'website' => $website]);
    }
}