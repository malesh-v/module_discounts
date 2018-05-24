<?php

class Malesh_Action_Block_Adminhtml_Action_Edit_Tabs_Products extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setDefaultFilter(array('ajax_grid_in_action' => 1));
        $this->setId('actionproductsGrid');
        $this->setSaveParametersInSession(false);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH);

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('mlaction');

        $this->addColumn('ajax_grid_in_action', array(
            'align' => 'center',
            'header_css_class' => 'a-center',
            'index' => 'entity_id',
            'type' => 'checkbox',
            'values' => $this->getSelectedProducts(),
        ));

        $this->addColumn('ajax_grid_product_id', array(
            'header' => $helper->__('products ID'),
            'index' => 'entity_id',
            'width' => '100px',
        ));

        $this->addColumn('ajax_grid_name',
            array(
                'header'=> Mage::helper('catalog')->__('Name'),
                'index' => 'name',
            ));

        $this->addColumn('ajax_grid_product_type',
            array(
                'header'=> Mage::helper('catalog')->__('Type'),
                'width' => '60px',
                'index' => 'type_id',
                'type'  => 'options',
                'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
            ));

        $this->addColumn('ajax_grid_product_status',
            array(
                'header'=> Mage::helper('catalog')->__('Status'),
                'width' => '70px',
                'index' => 'status',
                'type'  => 'options',
                'options' => Mage::getSingleton('catalog/product_status')->getOptionArray(),
            ));

        $this->addColumn('ajax_grid_product_visibility',
            array(
                'header'=> Mage::helper('catalog')->__('Visibility'),
                'width' => '70px',
                'index' => 'visibility',
                'type'  => 'options',
                'options' => Mage::getModel('catalog/product_visibility')->getOptionArray(),
            ));

        $this->addColumn('ajax_grid_product_sku',
            array(
                'header'=> Mage::helper('catalog')->__('SKU'),
                'width' => '80px',
                'index' => 'sku',
            ));

        return parent::_prepareColumns();
    }

    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'ajax_grid_in_action') {
            $collection = $this->getCollection();
            $selectedProducts = $this->getSelectedProducts();
            if ($column->getFilter()->getValue()) {
                $collection->addFieldToFilter('entity_id', array('in' => $selectedProducts));
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/products', array('_current' => true, 'grid_only' => 1));
    }

    public function getSelectedProducts()
    {
        if (!isset($this->_data['selected_products'])) {
            $productsInAction = Mage::app()->getRequest()->getParam('selected_products', null);
            //if products is blank or products is no array
            if(is_null($productsInAction) || !is_array($productsInAction)){
                $actionId = (int) $this->getRequest()
                    ->getParam('id');
                $productsInAction = (array) Mage::getModel('mlaction/actionproduct')
                    ->getActionProductsCollection($actionId)
                    ->getColumnValues('product_id')
                ;
            }
            $this->_data['selected_products'] = $productsInAction;
        }
        return $this->_data['selected_products'];
    }

}
