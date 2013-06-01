<?php

class Made_Carousel_Block_Admin_Image_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('carousel_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('carousel')->__('Image Information'));
    }

    protected function _beforeToHtml() {
        $this->addTab('form_section_image', array(
            'label' => Mage::helper('carousel')->__('General Information'),
            'title' => Mage::helper('carousel')->__('General Information'),
            'content' => $this->getLayout()->createBlock('carousel/admin_image_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }

}