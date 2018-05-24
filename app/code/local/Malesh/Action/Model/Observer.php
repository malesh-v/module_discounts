<?php

class Malesh_Action_Model_Observer
{
    public function addTopMenuItem (Varien_Event_Observer $observer)
    {
        $data = array(
            'name' => 'Malesh_Action',
            'url' => Mage::getBaseUrl().'malesh_action/index/index'
        );

        $tree = $observer->getMenu()->getTree();
        $myNode = new Varien_Data_Tree_Node($data, 'id', $tree);
        $observer->getMenu()
                 ->addChild($myNode);
        return $this;
    }
}