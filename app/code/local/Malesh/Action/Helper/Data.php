<?php

class Malesh_Action_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function convertFromGMT($dateTime)
    {
        return $dateTime = Mage::getModel('core/date')->Date('Y-m-d H:i:s', $dateTime);
    }


    public function getIssetImage($fileNamePath, $width, $height = '')
    {
        if ($fileNamePath) {

            if(!$height){
                $height = $width;
            }
            $folderURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS;
            $imageURL = $folderURL . $fileNamePath;

            $basePath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . $fileNamePath;

            $fileName = explode('/', $fileNamePath);
            $fileName = array_pop($fileName);

            $newPath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . "/action/imgresiz/" . $fileName;
            if ($width != '') {
                if (file_exists($basePath) && is_file($basePath) && !file_exists($newPath)) {
                    $imageObj = new Varien_Image($basePath);
                    $imageObj->constrainOnly(TRUE);
                    $imageObj->keepAspectRatio(FALSE);
                    $imageObj->keepFrame(FALSE);
                    $imageObj->resize($width, $height);
                    $imageObj->save($newPath);
                }
                $imgresizURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . "action/imgresiz/" . $fileName;
            } else {
                $imgresizURL = $imageURL;
            }
            return $imgresizURL;
        } else {
           return $this->noImage($width, $height = '');
        }

    }

    public function noImage($width = '', $height = ''){

        $path = 'catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/images/catalog/product/placeholder/image.jpg';
        $pathImage =  Mage::getBaseDir('base') . '/media/' . $path;
        $pathImage = str_replace('\\','/', $pathImage);

        if(file_exists($pathImage)){
            $defImg = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $path;
            if ($width){
                $defImg .= '" width="';
                $defImg .=  $width;
            }
            if($height){
                $defImg .= '" height=';
                $defImg .= $height;
            }
        }
        else return '';

        return $defImg;
    }

    public function deleteImg($imgPath)
    {
        $filePath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . '/' . $imgPath;
        $filePath = str_replace('\\','/', $filePath);
        unlink($filePath);
    }


}