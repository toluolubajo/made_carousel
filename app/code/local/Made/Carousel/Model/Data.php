<?php
Class Made_Carousel_Model_Data {
    protected function getImageModel() {
        return Mage::getModel('carousel/image');
    }
    protected function getImageCollection() {
        $storeId = Mage::app()->getStore()->getId();
        $collection = $this->getImageModel()->getCollection();
        $collection->addFilter('is_active', 1);
        $collection->addStoreFilter($storeId);
        $collection->addOrder('position', 'ASC');
        return $collection;
    }
    public function getImage() {
        return $this->getImageCollection();
    }
    public function getImageSource(){
        
    }
}
?>