<?php

class Avilastores_ProductUpdates_Block_Adminhtml_ProductUpdates_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('productupdates_form', array('legend'=>Mage::helper('productupdates')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('productupdates')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('productupdates')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('productupdates')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('productupdates')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('productupdates')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('productupdates')->__('Content'),
          'title'     => Mage::helper('productupdates')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getProductUpdatesData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getProductUpdatesData());
          Mage::getSingleton('adminhtml/session')->setProductUpdatesData(null);
      } elseif ( Mage::registry('productupdates_data') ) {
          $form->setValues(Mage::registry('productupdates_data')->getData());
      }
      return parent::_prepareForm();
  }
}