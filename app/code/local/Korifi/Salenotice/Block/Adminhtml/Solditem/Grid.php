<?php
/**
 * Developed by Korifi Company.
 * Author: Linh <linh@korifi.vn>
 * Date: 1/8/14  Time: 9:21 AM
 * For more Magento Extensions, please check out http://hotextension.com
 */
class Korifi_Salenotice_Block_Adminhtml_Solditem_Grid extends Mage_Adminhtml_Block_Widget_Grid{

    public function __construct(){
        parent::__construct();
        $this->setId('solditemGrid');
        $this->setDefaultSort('item_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
    }

    protected function _prepareCollection(){
        $collection = Mage::getModel('salenotice/solditem')->getCollection();
       // print"<pre>"; print_r($collection->getSelect()->__toString());
        if($this->_getStore()->getId()){
            $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
            $collection->addStoreFilter($this->_getStore());
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store_id', 0);
        return Mage::app()->getStore($storeId);
    }

    protected function _prepareColumns(){
        $this->addColumn('item_id', array(
            'header'    => Mage::helper('salenotice')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'item_id',
            'filter'    => false,
            'sortable'  => false,
        ));
        $this->addColumn('product_name', array(
            'header'    => Mage::helper('salenotice')->__('Name'),
            'align'     =>'left',
            'index'     => 'product_id',
            'renderer'    =>'Korifi_Salenotice_Block_Adminhtml_Solditem_Renderer_Productname',
            'sortable'  => false
        ));

        $this->addColumn('shipping_address', array(
            'header'    => Mage::helper('salenotice')->__('Shipping Address'),
            'align'     =>'left',
            'index'     => 'shipping_address',
            'sortable'  => false
        ));

        $this->addColumn('order_time', array(
            'header'    => Mage::helper('salenotice')->__('Time ago'),
            'align'     =>'left',
            'index'     => 'order_time',
            'sortable'  => false,
            'filter'    => false,
        ));


        $this->addColumn('created_at', array(
            'header'    => Mage::helper('salenotice')->__('Created'),
            'align'     =>'left',
            'index'     => 'created_at',
            'type'    => 'datetime',
            'sortable'  => false,
            'filter'    => false
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id',
                array (
                    'header' => Mage::helper('salenotice')->__('Store view'),
                    'index' => 'store_id',
                    'type' => 'store',
                    'store_all' => true,
                    'store_view' => true,
                    'sortable' => false,
                    'filter_condition_callback' => array (
                        $this,
                        '_filterStoreCondition' ) ));
        }



        $this->addColumn('action',
            array(
                'header'    => Mage::helper('salenotice')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('salenotice')->__('Edit'),
                        'url'     => array(
                            'base'=>'*/*/edit',
                            'params'=>array('store'=>$this->getRequest()->getParam('store'))
                        ),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
            ));


        return parent::_prepareColumns();
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('soliditemIds');
        $this->getMassactionBlock()->setFormFieldName('soliditemIds');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('salenotice')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('salenotice')->__('Are you sure?'),
        ));

        return $this;
    }

    /**
     * Helper function to do after load modifications
     *
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addStoreFilter($value);
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}

