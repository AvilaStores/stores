<?php

class Avilastores_ProductUpdates_Block_Adminhtml_ProductUpdates_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('productupdates_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('productupdates')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('productupdates')->__('Item Information'),
          'title'     => Mage::helper('productupdates')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('productupdates/adminhtml_productupdates_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}