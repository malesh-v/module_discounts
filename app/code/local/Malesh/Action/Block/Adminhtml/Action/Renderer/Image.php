<?php
class Malesh_Action_Block_Adminhtml_Action_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        if($row->_data[image]){
            $val = Mage::getBaseUrl().'media/'.$row->_data[image];
            $val = str_replace('/index.php','',$val);
        }
        else{
            $val = Mage::helper('mlaction')->noImage();
        }
        $out = '<img src="'. $val .'"' . ' width="50px" />';
        return $out;
    }
}