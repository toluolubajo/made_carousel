<?php

class Made_Carousel_Block_Widget_Grid_Column extends Mage_Adminhtml_Block_Widget_Grid_Column
{
 

    protected function _getRendererByType()
    {
        switch (strtolower($this->getType())) {
            case 'image':
                $rendererClass = 'carousel/widget_grid_column_renderer_image';
                break;
            default:
                $rendererClass = parent::_getRendererByType();
                break;
        }
        return $rendererClass;
    }

    protected function _getFilterByType()
    {
        switch (strtolower($this->getType())) {
            case 'image':
                $filterClass = 'carousel/widget_grid_column_filter_image';
                break;
            default:
                $filterClass = parent::_getFilterByType();
                break;
        }
        return $filterClass;
    }

}