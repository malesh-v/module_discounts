<?php

class Malesh_Action_Model_Action extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('mlaction/action');
    }


}