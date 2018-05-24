<?php

class Malesh_Action_Block_Adminhtml_Action_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('mlaction/action')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('action');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => $this->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
        ));
        return $this;
    }

    public function getRowUrl($model)
    {
        return $this->getUrl('*/*/edit', array(
            'id' => $model->getId(),
        ));
    }

    protected function _prepareColumns()
    {

        $helper = Mage::helper('mlaction');

        $this->addColumn('id', array(
            'header' => $helper->__('Action ID'),
            'index' => 'id'
        ));

        $this->addColumn('name', array(
            'header' => $helper->__('Name'),
            'index' => 'name',
            'type' => 'text',
        ));

        $this->addColumn('status', array(
            'header' => $helper->__('Status'),
            'index' => 'status',
            'type' => 'options',
            'readonly' => true,
            'disabled' => true,
            'options' => array(
                '1' => $helper->__('The Action has not yet begun'),
                '2' => $helper->__('Action is active'),
                '3' => $helper->__('Action closed')
            ),
        ));

        $this->addColumn('is_active', array(
            'header'  => $helper->__('IS ACTIVE'),
            'index'   => 'is_active',
            'type'  => 'options',
            'options'    => array(
                '0' => $helper->__('No'),
                '1' => $helper->__('Yes'),
            ),
        ));

        $this->addColumn('short_description', array(
            'header' => $helper->__('Short Description'),
            'index' => 'short_description',
            'type' => 'text',
        ));

        $this->addColumn('image', array(
            'header' => $helper->__('Image'),
            'index' => 'image',
            'renderer' => 'Malesh_Action_Block_Adminhtml_Action_Renderer_Image'
        ));

        $this->addColumn('create_datetime', array(
            'header' => $helper->__('Created'),
            'index' => 'create_datetime',
            'type' => 'datetime',
            'value' => Mage::getModel('core/date')->Date('Y-m-d H:i:s','create_datetime')
        ));

        $this->addColumn('start_datetime', array(
            'header' => $helper->__('Start datetime'),
            'index' => 'start_datetime',
            'type' => 'datetime',
            'value' => Mage::getModel('core/date')->Date('Y-m-d H:i:s','start_datetime')
        ));

        $this->addColumn('end_datetime', array(
            'header' => $helper->__('End datetime'),
            'index' => 'end_datetime',
            'type' => 'datetime',
            'value' => Mage::getModel('core/date')->Date('Y-m-d H:i:s','end_datetime')
        ));

        return parent::_prepareColumns();
    }

}