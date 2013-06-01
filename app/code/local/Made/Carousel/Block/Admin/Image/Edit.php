<?php

class Made_Carousel_Block_Admin_Image_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
    	$this->_objectId = 'image_id';
        $this->_controller = 'admin_image';
        $this->_blockGroup = 'carousel';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('carousel')->__('Save Image'));
        $this->_updateButton('delete', 'label', Mage::helper('carousel')->__('Delete Image'));
        
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
        
    }

    public function getHeaderText()
    {
        if (Mage::registry('carousel_image')->getId()) {
            return Mage::helper('carousel')->__("Edit Image '%s'", $this->htmlEscape(Mage::registry('carousel_image')->getTitle()));
        }
        else {
            return Mage::helper('carousel')->__('New Image');
        }
    }

}
