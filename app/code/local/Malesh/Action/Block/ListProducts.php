<?php
class Malesh_Action_Block_ListProducts extends Mage_Core_Block_Template
{

    public function getId(){
        return $this->getRequest()->getParam('id');
    }

    public function getProdInAction(){

        $productsAction = Mage::getModel('mlaction/actionproduct')
            ->getActionProductsCollection($this->getId())
            ->getColumnValues('product_id');
        return $productsAction;
    }

    public function getProductsCollection($productsAction){

        $products = Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->addFieldToFilter('entity_id', array('in' => $productsAction))
            ->load();
        return $products;
    }

    public function getActionModel()
    {
        $getActionModel = Mage::getModel('mlaction/action')->load($this->getId());
        return $getActionModel;
    }


}