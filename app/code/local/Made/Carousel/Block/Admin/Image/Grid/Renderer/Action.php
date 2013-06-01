<?php

class Made_Carousel_Block_Admin_Image_Grid_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
	    public function render(Varien_Object $row)
	    {
	
	        $actions[] = array(
	        	'url' => $this->getUrl('*/*/edit', array('image_id' => $row->getId())),
	        	'caption' => Mage::helper('carousel')->__('Edit')
	         );
		     
	         $actions[] = array(
	        	'url' => $this->getUrl('*/*/delete', array('image_id' => $row->getId())),
	        	'caption' => Mage::helper('carousel')->__('Delete'),
	        	'confirm' => Mage::helper('carousel')->__('Are you sure you want to delete this image ?')
	         );
	
	        $this->getColumn()->setActions($actions);
	
	        return parent::render($row);
	    }
}
