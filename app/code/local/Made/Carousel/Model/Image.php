
<?php
class Made_Carousel_Model_Image extends Mage_Core_Model_Abstract
{
    const CACHE_TAG     = 'carousel_admin_image';
    protected $_cacheTag= 'carousel_admin_image';

    protected function _construct()
    {
        $this->_init('carousel/image');
    }

}
