<?php

namespace EdmondsCommerce\Shipping\Model\ResourceModel\Rule;

use EdmondsCommerce\Shipping\Model\Rule as RuleModel;
use EdmondsCommerce\Shipping\Model\ResourceModel\Rule as RuleResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    public function _construct()
    {
        $this->_init(RuleModel::class, RuleResource::class);
    }
}