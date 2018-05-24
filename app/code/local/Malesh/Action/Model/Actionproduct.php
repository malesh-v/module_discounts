<?php

class Malesh_Action_Model_Actionproduct extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('mlaction/actionproduct');
    }

    public function getActionProductsCollection($idAction)
    {
        $collection = Mage::getModel('mlaction/actionproduct')->getCollection();
        $collection->addFieldToFilter('action_id', $idAction);
        return $collection;
    }
}