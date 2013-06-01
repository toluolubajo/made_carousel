<?php

class Made_Carousel_Block_Home extends Mage_Core_Block_Template {

    public function __construct() {
        parent::__construct();
       
            $this->setTemplate('made/carousel.phtml');
    }

}
