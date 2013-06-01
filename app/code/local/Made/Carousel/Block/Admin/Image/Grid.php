<?php

class Made_Carousel_Block_Admin_Image_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('CarouselGrid');
        $this->setDefaultSort('position');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('carousel/image')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {

        $baseUrl = $this->getUrl();
        $this->addColumn('image_id', array(
            'header' => Mage::helper('carousel')->__('ID'),
            'align' => 'left',
            'width' => '30px',
            'index' => 'image_id',
        ));
        $this->addColumn('image_alt_text', array(
            'header' => Mage::helper('carousel')->__('Alt'),
            'align' => 'left',
            'index' => 'image_alt_text',
        ));
        $this->addColumn('column', array(
            'header' => Mage::helper('carousel')->__('Title'),
            'align' => 'left',
            'index' => 'title',
            'width' => '30px',
        ));
        $this->addColumn('position', array(
            'header' => Mage::helper('carousel')->__('Position'),
            'align' => 'left',
            'index' => 'position',
            'width' => '30px',
        ));
        $this->addColumn('image_src', array(
            'header' => Mage::helper('carousel')->__('Image Source'),
            'align' => 'left',
            'index' => 'image_src',
            'width' => '30px',
        ));
         $this->addColumn('image_src', array(
            'header' => Mage::helper('carousel')->__('Thumbnail'),
            'type' => 'image',
            'index' => 'image_src',
            'width' => '30px',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'        => Mage::helper('carousel')->__('Store View'),
                'index'         => 'store_id',
                'type'          => 'store',
                'store_all'     => true,
                'store_view'    => true,
                'sortable'      => false,
                'filter_condition_callback'
                                => array($this, '_filterStoreCondition'),
            ));
        }
        $this->addColumn('is_active', array(
            'header' => Mage::helper('carousel')->__('Status'),
            'index' => 'is_active',
            'type' => 'options',
            'options' => array(
                0 => Mage::helper('carousel')->__('Disabled'),
                1 => Mage::helper('carousel')->__('Enabled'),
            ),
        ));
        $this->addColumn('action',
                array(
                    'header' => Mage::helper('carousel')->__('Action'),
                    'index' => 'image_id',
                    'sortable' => false,
                    'filter' => false,
                    'no_link' => true,
                    'width' => '100px',
                    'renderer' => 'carousel/admin_image_grid_renderer_action'
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('carousel')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('carousel')->__('XML'));
        return parent::_prepareColumns();
    }

    protected function _afterLoadCollection() {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    protected function _filterStoreCondition($collection, $column) {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $this->getCollection()->addStoreFilter($value);
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('image_id');
        $this->getMassactionBlock()->setFormFieldName('massaction');
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('carousel')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('carousel')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('carousel')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('carousel')->__('Status'),
                    'values' => array(
                        0 => Mage::helper('carousel')->__('Disabled'),
                        1 => Mage::helper('carousel')->__('Enabled'),
                    ),
                )
            )
        ));
        return $this;
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('image_id' => $row->getId()));
    }

}
