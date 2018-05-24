
<?php

class Malesh_Action_Model_Resource_Action_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('mlaction/action');
    }
}