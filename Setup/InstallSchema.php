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
        )->addColumn('id', Table::TYPE_INTEGER, null, [
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary'  => 'true'
        ], 'Rate ID')

            ->addColumn('name', Table::TYPE_TEXT, null, [], 'Rate Name')
            ->addColumn('website_id', Table::TYPE_INTEGER, null, [], 'Website Scope ID')
            ->addColumn('postcode', Table::TYPE_TEXT, null, [], 'Postcode')
            ->addColumn('price', Table::TYPE_FLOAT, null, [], 'Rate Base Price');

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}