<?php

namespace EdmondsCommerce\Shipping\Model\Import;

class Importer
{

    /**
     * @var ImportResolver
     */
    private $importResolver;

    public function __construct(ImportResolver $importResolver)
    {
        $this->importResolver = $importResolver;
    }

    public function import($data, $type, $website)
    {
        //Which importer to use
        $importer = $this->importResolver->create($type, $data, $website);

        //Attempt validation of data
        if(!$importer->validate())
        {
            throw new \Exception('Invalid data in file');
        }

        //Remove old records from the database for current store

        //Insert new records to database
    }


}