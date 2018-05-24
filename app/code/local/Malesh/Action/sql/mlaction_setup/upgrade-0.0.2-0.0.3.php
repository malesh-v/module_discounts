<?php
/** @var Mage_Core_Model_Resource_Setup $installer */

$installer = $this;
$tableAction = $installer->getTable('mlaction/table_action_product');


$installer->getConnection()->dropTable($tableAction);
$table = $installer->getConnection()
    ->newTable($tableAction)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ))
    ->addColumn('action_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ))
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'primary'   => true
    ))
    ->addForeignKey(
        $installer->getFkName(
            'mlaction/table_action_product',
            'product_id',
            'catalog/product',
            'entity_id'),
        'product_id', $installer->getTable('catalog/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName(
            'mlaction/table_action_product',
            'action_id',
            'mlaction/table_action',
            'id'),
        'action_id', $installer->getTable('mlaction/table_action'), 'id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);
$installer->getConnection()->createTable($table);

$installer->endSetup();