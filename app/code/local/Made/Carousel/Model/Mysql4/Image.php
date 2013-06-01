<?php

class Made_Carousel_Model_Mysql4_Image extends Mage_Core_Model_Mysql4_Abstract {

    protected function _construct() {
        $this->_init('carousel/image', 'image_id');
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object) {
        return $this;
    }

    protected function _afterSave(Mage_Core_Model_Abstract $object) {
        $condition = $this->_getWriteAdapter()->quoteInto('image_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('carousel/image_store'), $condition);
        if (!$object->getData('stores')) {
            $object->setData('stores', $object->getData('store_id'));
        }
        if (in_array(0, $object->getData('stores'))) {
            $object->setData('stores', array(0));
        }
        foreach ((array) $object->getData('stores') as $store) {
            $storeArray = array();
            $storeArray['image_id'] = $object->getId();
            $storeArray['store_id'] = $store;
            $this->_getWriteAdapter()->insert($this->getTable('carousel/image_store'), $storeArray);
        }
        return parent::_afterSave($object);
    }
    protected function _afterLoad(Mage_Core_Model_Abstract $object) {
        $select = $this->_getReadAdapter()->select()
                        ->from($this->getTable('carousel/image_store'))
                        ->where('image_id = ?', $object->getId());

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $storesArray = array();
            foreach ($data as $row) {
                $storesArray[] = $row['store_id'];
            }
            $object->setData('store_id', $storesArray);
        }
        return parent::_afterLoad($object);
    }

    protected function _beforeDelete(Mage_Core_Model_Abstract $object) {
        $adapter = $this->_getReadAdapter();
        $adapter->delete($this->getTable('carousel/image_store'), 'image_id=' . $object->getId());
    }

}