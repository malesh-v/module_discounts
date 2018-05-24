<?php

class Malesh_Action_Block_Adminhtml_Action_Edit_Tabs_General extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('actionGrid');
        $this->setSaveParametersInSession(false);
        $this->setUseAjax(false);
    }

    protected function _prepareForm()
    {
        $helper = Mage::helper('mlaction');
        $model = Mage::registry('current_action');

        $form = new Varien_Data_Form(array(
            'id' => 'editaction_form',
            'action' => $this->getUrl('*/*/save', array(
                'id' => $this->getRequest()->getParam('id')
            )),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $this->setForm($form);

        $fieldset = $form->addFieldset('action_form', array('legend' => $helper->__('Action Information')));

        $fieldset->addField('is_active', 'select', array(
            'label' => $helper->__('is_active'),
            'required' => true,
            'options'    => array(
                '1' => Mage::helper('mlaction')->__('Active'),
                '0' => Mage::helper('mlaction')->__('Inactive'),
            ),
            'name' => 'is_active',
        ));

        $fieldset->addField('image', 'image', array(
            'label'     => Mage::helper('mlaction')->__('Image'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'image'
        ));

        $fieldset->addField('name', 'text', array(
            'label' => $helper->__('name action'),
            'required' => true,
            'name' => 'name',
        ));

        $fieldset->addField('description', 'textarea', array(
            'label' => $helper->__('description'),
            'required' => false,
            'name' => 'description',
        ));

        $fieldset->addField('short_description', 'text', array(
            'label' => $helper->__('short_description'),
            'required' => true,
            'name' => 'short_description',
        ));

        $fieldset->addField('status', 'select', array(
            'label' => $helper->__('status'),
            'name' => 'status',
            'readonly' => true,
            'disabled' => true,
            'options' => array(
                '1' => $helper->__('The Action has not yet begun'),
                '2' => $helper->__('Action is active'),
                '3' => $helper->__('Action closed')
            ),
        ));

        $fieldset->addField('start_datetime', 'datetime', array(
            'name'      => 'start_datetime',
            'label'     => $helper->__('Start datetime '),
            'title'     => $helper->__('Start datetime '),
            'format' => 'yyyy-M-d H:mm',
            'time' => true,
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'required'  => true,

        ));

        $fieldset->addField('end_datetime', 'datetime', array(
            'name'      => 'end_datetime',
            'label'     => $helper->__('End datetime'),
            'title'     => $helper->__('End datetime'),
            'format' => 'yyyy-M-d H:mm',
            'time' => true,
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'required'  => false,
        ));

        //convert from GMT
        $model->setData('start_datetime',
            Mage::getModel('core/date')->Date('Y-m-d H:i:s', $model->getData('start_datetime')));
        if($model->getData('end_datetime')){
            $model->setData('end_datetime',
                Mage::getModel('core/date')->Date('Y-m-d H:i:s',$model->getData('end_datetime')));
        }

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();

    }

}