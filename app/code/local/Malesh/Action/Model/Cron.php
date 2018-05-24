<?php
class Malesh_Action_Model_Cron {

    public function review_status_action(){
        $model = Mage::getModel('mlaction/action')->getCollection();

        foreach ($model as $action) {
            $current_data = strtotime(Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s'))  ;
            $startDataTime = strtotime($action->getStart_datetime()) ;
            $endDataTime = strtotime($action->getEnd_datetime())  ;

            //1 - час дії ще ненаступив, 2 - акція діє, 3 - акція закрита.
            if ($endDataTime) {
                if ($startDataTime < $current_data && $current_data < $endDataTime) {
                    $action->setData(array(
                        'status' => 2,
                        'id' => $action->getId()
                    ))->save();
                }
                if ($current_data > $endDataTime) {
                    $action->setData(array(
                        'status' => 3,
                        'id' => $action->getId()
                    ))->save();
                }
            } else {
                if ($current_data > $startDataTime) {
                    $action->setData(array(
                        'status' => 2,
                        'id' => $action->getId()
                    ))->save();
                }
            }
            if ($current_data < $startDataTime) {
                $action->setData(array(
                    'status' => 1,
                    'id' => $action->getId()
                ))->save();
            }
        }

    }
}