<?php
/** @var Mage_Core_Model_Resource_Setup $installer */

$installer = $this;
$tableAction = $installer->getTable('mlaction/table_action');

$installer->getConnection()->dropTable($tableAction);
$table = $installer->getConnection()
    ->newTable($tableAction)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ))
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, array(
        'nullable'  => false,
    ))
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, '50', array(
        'nullable'  => false,
    ))
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, '255', array(
        'nullable'  => true,
    ))
    ->addColumn('short_description', Varien_Db_Ddl_Table::TYPE_TEXT, '255', array(
        'nullable'  => false,
    ))
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_TEXT, '255', array(
        'nullable'  => true,
    ))
    ->addColumn('create_datetime', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable'  => false,
    ))
    ->addColumn('start_datetime', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable'  => true,
    ))
    ->addColumn('end_datetime', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable'  => true,
    ));
$installer->getConnection()->createTable($table);

$installer->endSetup();