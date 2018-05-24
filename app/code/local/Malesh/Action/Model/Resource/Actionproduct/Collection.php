<?php

class Malesh_Action_Model_Resource_Actionproduct_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('mlaction/actionproduct');
    }
}