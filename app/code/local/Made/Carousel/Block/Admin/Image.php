<?php
class Made_Carousel_Block_Admin_Image extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'admin_image';
        $this->_blockGroup = 'carousel';
        $this->_headerText = Mage::helper('carousel')->__('Carousel Image grid');
        $this->_addButtonLabel = Mage::helper('carousel')->__('Add New image');
        parent::__construct();
    }

}
