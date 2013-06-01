<?php

class Made_Carousel_Model_Mysql4_Image_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    protected function _construct() {
        $this->_init('carousel/image');
    }

    public function toOptionArray() {
        return $this->_toOptionArray('image_id', 'title');
    }
    
    public function addStoreFilter($store, $withAdmin = true) {
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }

        $this->getSelect()->join(
                        array('image_store' => $this->getTable('carousel/image_store')),
                        'main_table.image_id = image_store.image_id',
                        array()
                )
                ->where('image_store.store_id in (?)', ($withAdmin ? array(0, $store) : $store));

        return $this;
    }

}