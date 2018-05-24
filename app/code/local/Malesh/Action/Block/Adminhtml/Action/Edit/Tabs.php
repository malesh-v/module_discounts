<?php
class Malesh_Action_Block_Adminhtml_Action_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        $helper = Mage::helper('mlaction');

        parent::__construct();
        $this->setId('action_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($helper->__('Action Information'));

    }

    protected function _prepareLayout()
    {
        $helper = Mage::helper('mlaction');

        $this->addTab('general_section', array(
            'label' => $helper->__('Action Information'),
            'title' => $helper->__('Action Information'),
            'content' => $this->getLayout()->createBlock('mlaction/adminhtml_action_edit_tabs_general')->toHtml(),
        ));

        $this->addTab('products_section', array(
            'class' => 'ajax',
            'label' => $helper->__('Products'),
            'title' => $helper->__('Products'),
            'url' => $this->getUrl('*/*/products', array('_current' => true)),
        ));

        return parent::_prepareLayout();
    }

}
