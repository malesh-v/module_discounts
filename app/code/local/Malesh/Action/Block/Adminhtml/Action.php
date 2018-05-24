<?php
class Malesh_Action_Block_Adminhtml_Action extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    protected function _construct()
    {
        parent::_construct();

        $helper = Mage::helper('mlaction');
        $this->_blockGroup = 'mlaction';
        $this->_controller = 'adminhtml_action';

        $this->_headerText = $helper->__('Action Management');
        $this->_addButtonLabel = $helper->__('Add new action');
    }
}