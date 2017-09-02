<?php

namespace EdmondsCommerce\Shipping\Model;

use EdmondsCommerce\Shipping\Api\Data\FilterInterface;
use Magento\Framework\Xml\Parser;

class FilterReader
{
    const MODULE_NAME = 'EdmondsCommerce_Shipping';

    /**
     * @var \Magento\Framework\Module\Dir\Reader
     */
    private $reader;
    /**
     * @var Parser
     */
    private $parser;

    /**
     * FilterReader constructor.
     *
     * @param \Magento\Framework\Module\Dir\Reader $reader
     * @param Parser                               $parser
     */
    public function __construct(\Magento\Framework\Module\Dir\Reader $reader, Parser $parser)
    {
        $this->reader = $reader;
        $this->parser = $parser;
    }

    /**
     * @return FilterInterface[]
     */
    public function getFilters()
    {
        //Read the config
        $path = $this->reader->getModuleDir('etc', self::MODULE_NAME) . DIRECTORY_SEPARATOR . 'filters.xml';
        $args = $this->parser->load($path)->xmlToArray();

        return array_map(function($arg) {
            return ['name' => $arg['_attribute']['name'], 'class' => $arg['_value']];

        }, $args['config']['filters']['item']);

    }
}
