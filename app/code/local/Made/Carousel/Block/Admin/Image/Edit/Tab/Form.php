<?php

class Made_Carousel_Block_Admin_Image_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {


    protected function _prepareForm() {
        $model = Mage::registry('carousel_image');
        $form = new Varien_Data_Form(array('id' => 'edit_form_image', 'action' => $this->getData('action'), 'method' => 'post'));
        $form->setHtmlIdPrefix('image_');
        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('carousel')->__('General Information'), 'class' => 'fieldset-wide'));
        if ($model->getCategoryId()) {
            $fieldset->addField('image_id', 'hidden', array(
                'name' => 'image_id',
            ));
        }

        $fieldset->addField('title', 'text', array(
            'name' => 'title',
            'label' => Mage::helper('carousel')->__('Title'),
            'title' => Mage::helper('carousel')->__('Title'),
            'required' => true,
        ));

        $fieldset->addField('image_src', 'image', array(
            'name' => 'image_src',
            'label' => Mage::helper('carousel')->__('Image Source'),
            'title' => Mage::helper('carousel')->__('Image Source'),
            'required' => true,
        ));

       $fieldset->addField('image_alt_text', 'text', array(
            'name' => 'image_alt_text',
            'label' => Mage::helper('carousel')->__('Image Alt Text'),
            'title' => Mage::helper('carousel')->__('Image Alt Text'),
            'required' => false,
        ));

        $fieldset->addField('position', 'select', array(
            'name' => 'position',
            'label' => Mage::helper('carousel')->__('Position'),
            'title' => Mage::helper('carousel')->__('Position'),
            'required' => false,
            'options' => Mage::helper('carousel')->numberArray(10,Mage::helper('carousel')->__('')),
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'multiselect', array(
                'name' => 'stores[]',
                'label' => Mage::helper('carousel')->__('Store View'),
                'title' => Mage::helper('carousel')->__('Store View'),
                'required' => true,
                'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            'style' => 'height:150px',
            ));
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name' => 'stores[]',
                'value' => Mage::app()->getStore(true)->getId()
            ));
            $model->setStoreId(Mage::app()->getStore(true)->getId());
        }
        
        $fieldset->addField('is_active', 'select', array(
            'label' => Mage::helper('carousel')->__('Status'),
            'title' => Mage::helper('carousel')->__('Status'),
            'name' => 'is_active',
            'required' => true,
            'options' => array(
                '1' => Mage::helper('carousel')->__('Enabled'),
                '0' => Mage::helper('carousel')->__('Disabled'),
            ),
        ));
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
