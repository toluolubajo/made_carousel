<?php

class Made_Carousel_Helper_Data extends Mage_Core_Helper_Abstract {

    public function numberArray($max, $text) {

        $items = array();
        for ($index = 1; $index <= $max; $index++) {
            $items[$index] = $text . ' ' . $index;
        }
        return $items;
    }

    public function getImageUrl($image_file) {
        $url = false;
        $url = Mage::getBaseUrl('media') . $image_file;
        return $url;
    }

    public function getFileExists($image_file) {
        $file_exists = false;
        $file_exists = file_exists('media'. $image_file);
        return $file_exists;
    }

}
