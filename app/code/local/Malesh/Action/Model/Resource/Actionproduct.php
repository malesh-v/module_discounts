<?php

class Malesh_Action_Model_Resource_Actionproduct extends Mage_Core_Model_Mysql4_Abstract
{

    public function _construct()
    {
        $this->_init('mlaction/table_action_product', 'id');
    }
}