<?php

class Made_Carousel_Block_Admin_Image_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{


    protected function _prepareLayout() {
        parent::_prepareLayout();
       
    }
    
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/save', array('image_id' => $this->getRequest()->getParam('image_id'))),
                                      'method' => 'post',
                                      'enctype' => 'multipart/form-data'
                                   )
      );

      $form->setUseContainer(true);
      $this->setForm($form);
      return parent::_prepareForm();
  }
}