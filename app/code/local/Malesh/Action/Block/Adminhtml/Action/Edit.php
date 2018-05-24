<?php

class Malesh_Action_Block_Adminhtml_Action_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    protected function _construct()
    {
        $this->_blockGroup = 'mlaction';
        $this->_controller = 'adminhtml_action';
        $this->_addButton('save_and_continue', array(
            'label' => Mage::helper('mlaction')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save'
        ), -100);
        $this->_formScripts[] = "
             function saveAndContinueEdit(){
                editForm.submit($('edit_form').action + 'back/edit/');
             }
             ";
    }

    public function getHeaderText()
    {
        $helper = Mage::helper('mlaction');
        $model = Mage::registry('current_action');

        if ($model->getId()) {
            Mage::getModel('core/session')->setData('actionid',$model->getId());
            return $helper->__("Edit Action item ", $this->escapeHtml($model->getTitle()));
        } else {
            return $helper->__("Add Action item");
        }
    }
}