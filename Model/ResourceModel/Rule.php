<?php

namespace EdmondsCommerce\Shipping\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Rule extends AbstractDb
{

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ecshipping_rates', 'id');
    }
}