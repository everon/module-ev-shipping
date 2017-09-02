<?php

namespace EdmondsCommerce\Shipping\Model\Rate;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class Storage
 *
 * @package EdmondsCommerce\Shipping\Model\Rate
 * Handles the retrieval of rules from a file
 */
class Locator
{

    /**
     * @var DirectoryList
     */
    private $directory_list;

    /**
     * @var ScopeConfigInterface
     */
    private $config;

    /**
     * Loader constructor.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     * @param DirectoryList                                      $directory_list
     */
    public function __construct(
        ScopeConfigInterface $config,
        DirectoryList $directory_list
    ) {
        $this->directory_list = $directory_list;
        $this->config         = $config;
    }

    /**
     * @return string
     */
    public function getRatePath()
    {
        //Attempt to get the file from config first
        $filePath = $this->config->getValue('ecshipping/file');
        if (empty($filePath)) {
            return $this->directory_list->getPath('var') . '/shipping-config.json';
        }

        //Check for configuration of the file
        $rootPath = $this->directory_list->getRoot();

        return $rootPath . DIRECTORY_SEPARATOR . $filePath;
    }
}
