<?php
namespace AHT\CustomerPayment\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $attributes = [
            'customer_payment' => [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'default' =>'simple',
                'comment' => 'Customer Payment'
            ],
        ];

        foreach ($attributes as $key => $value) {
            $installer->getConnection()->addColumn(
                $installer->getTable('customer_group'),
                $key,
                $value
            );
        }

        $installer->endSetup();

    }
}
