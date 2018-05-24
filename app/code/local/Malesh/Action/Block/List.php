<?php
class Malesh_Action_Block_List extends Mage_Core_Block_Template
{

    public function _construct()
    {
        parent::_construct();
        $collection = Mage::getModel('mlaction/action')
            ->getCollection()
            ->addFieldToFilter('status', 2)
            ->addFieldToFilter('is_active', true)
            ->setOrder('start_datetime', "DESC");
        $this->setCollection($collection);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        $pager->setAvailableLimit(array(2=>2,5=>5,10=>10,20=>20,'all'=>'all'));
        $pager->setCollection($this->getCollection());
        $this->setChild('pager', $pager);
        $this->getCollection()->load();
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getAllActions($idProduct)
    {
        $actionIdsArray = (array) Mage::getModel('mlaction/actionproduct')
            ->getCollection()
            ->addFieldToFilter('product_id', $idProduct)
            ->getColumnValues('action_id');

        $getActions = $this->getActionsCollection($actionIdsArray);

        return $getActions;
    }

    public function getActionsCollection($actionIdsArray){
        $actions = Mage::getModel('mlaction/action')
            ->getCollection()
            ->addFieldToFilter('id', $actionIdsArray);

        return $actions;
    }
}