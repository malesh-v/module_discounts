<?php

class Malesh_Action_Adminhtml_ActionController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout()
             ->_setActiveMenu('mlaction');

        $this->_addContent($this->getLayout()
            ->createBlock('mlaction/adminhtml_action'));
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $model = Mage::getModel('mlaction/action');

        if ($data = Mage::getSingleton('adminhtml/session')->getFormData()) {
            $model->setData($data)->setId($id);
        } else {
            $model->load($id);
        }
        Mage::register('current_action', $model);

        $this->loadLayout()->_setActiveMenu('mlaction');

        $this->_addLeft($this->getLayout()->createBlock('mlaction/adminhtml_action_edit_tabs'));
        $this->_addContent($this->getLayout()->createBlock('mlaction/adminhtml_action_edit'));
        $this->renderLayout();
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                try {
                    $uploader = new Varien_File_Uploader('image');
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);
                    $newDir = "action";

                    $newdirPath = Mage::getBaseDir('media') . '\\' . $newDir;

                    if (!file_exists($newdirPath)) {
                        mkdir($newdirPath, 0777);
                    }

                    $path = Mage::getBaseDir('media') . '\\' . $newDir . '\\';
                    $uploader->save($path, $_FILES['image']['name']);

                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }
                $data['image'] = 'action'.$uploader->getUploadedFileName();
            }else{
                if (is_array($data['image'])){
                    if($data['image']['delete']){
                        Mage::helper('mlaction')->deleteImg($data['image']['value']);
                        $data['image'] = '';
                    }
                    else unset($data['image']);
                }
            }

            try {
                $model = Mage::getModel('mlaction/action');

                $data['start_datetime'] = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s',$data['start_datetime'] );
                $data['end_datetime'] = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s', $data['end_datetime']);
                $data['create_datetime'] = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s');

                $model->setData($data)->setId($this->getRequest()->getParam('id'));
                if(!$model->getCreated()){
                    $model->setCreated(now());
                }


                $model->save();

                //---change products
                $idAction = $model->getId();
                $productsAction = Mage::getModel('mlaction/actionproduct')
                    ->getActionProductsCollection($idAction)
                    ->getColumnValues('product_id');

                if ($selectedProducts = $this->getRequest()->getParam('selected_products', null)) {
                    $selectedProducts = Mage::helper('adminhtml/js')->decodeGridSerializedInput($selectedProducts);
                }
                else {
                    $selectedProducts = array();
                }

                $setAction = array_diff($selectedProducts, $productsAction);
                $unsetAction = array_diff($productsAction, $selectedProducts);

                $model = Mage::getModel('mlaction/actionproduct');
                foreach ($setAction as $id) {
                    $model->setData(array(
                        'action_id' => (int) $idAction,
                        'product_id' => $id))
                        ->save();
                }

                foreach($unsetAction as $id){
                    $model->load($id,'product_id')
                        ->delete();
                }
                //save and continue
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect(
                        '*/*/edit',
                        array(
                            'id' => $idAction,
                        )
                    );
                    return;
                }

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Action was saved successfully'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array(
                    'id' => $this->getRequest()->getParam('id')
                ));
            }
            return;
        }
}

    public function massDeleteAction()
    {
        $action = $this->getRequest()->getParam('action', null);

        if (is_array($action) && sizeof($action) > 0) {
            try {
                foreach ($action as $id) {
                    $model =  Mage::getModel('mlaction/action')->load($id);
                    Mage::helper('mlaction')->deleteImg($model->getImage());
                    $model->delete();

                }
                $this->_getSession()->addSuccess($this->__('Total of %d action have been deleted', sizeof($action)));
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        } else {
            $this->_getSession()->addError($this->__('Please select action'));
        }
        $this->_redirect('*/*');
    }


    public function productsAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $model = Mage::getModel('mlaction/action')->load($id);
        $request = Mage::app()->getRequest();

        Mage::register('current_action', $model);

        if ($request->isAjax()) {

            $this->loadLayout();
            $layout = $this->getLayout();

            $root = $layout->createBlock('core/text_list', 'root', array('output' => 'toHtml'));

            $grid = $layout->createBlock('mlaction/adminhtml_action_edit_tabs_products');
            $root->append($grid);

            if (!$request->getParam('grid_only')) {
                $serializer = $layout->createBlock('adminhtml/widget_grid_serializer');
                $serializer->initSerializerBlock($grid, 'getSelectedProducts', 'selected_products', 'selected_products');
                $root->append($serializer);
            }

            $this->renderLayout();
        }
    }

}