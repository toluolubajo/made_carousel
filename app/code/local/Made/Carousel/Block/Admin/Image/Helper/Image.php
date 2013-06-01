<?php

class Made_Carousel_Block_Admin_Image_Helper_Image extends Varien_Data_Form_Element_Image {
    
    protected function _getUrl(){
        $url=false;
        if($this->getValue()){
            $url=Mage::getBaseUrl('media').$this->getValue();
        }
        return $url;
    }
}
