<?php

namespace EdmondsCommerce\Shipping\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $table = $setup->getConnection()->newTable(
            $setup->getTable('ecshipping_rates')
        )->addColumn('id', Table::TYPE_INTEGER, null,
            [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary'  => 'true'
            ], 'Rate ID')
            ->addColumn('name', Table::TYPE_TEXT, null, [], 'Rate Name')
            ->addColumn('website_id', Table::TYPE_INTEGER, null, [], 'Website Scope ID')
            ->addColumn('country', Table::TYPE_TEXT, 32, [], 'Country code')
            ->addColumn('postcode', Table::TYPE_TEXT, null, [], 'Postcode')
            ->addColumn('weight_from', Table::TYPE_FLOAT, null, [], 'Weight lower boundary')
            ->addColumn('weight_to', Table::TYPE_FLOAT, null, [], 'Weight upper boundary')
            ->addColumn('price_from', Table::TYPE_FLOAT, null, [], 'Price lower boundary')
            ->addColumn('price_to', Table::TYPE_FLOAT, null, [], 'Price upper boundary')
            ->addColumn('price', Table::TYPE_FLOAT, null, [], 'Rate Base Price')
            ->addColumn('sort_order', Table::TYPE_INTEGER, null, [], 'Rule sort order');

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}