<?php
class Avilastores_ProductUpdates_Block_Adminhtml_ProductUpdates extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_productupdates';
    $this->_blockGroup = 'productupdates';
    $this->_headerText = Mage::helper('productupdates')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('productupdates')->__('Add Item');
    parent::__construct();
  }
}