<?php

class Avilastores_ProductUpdates_Block_Adminhtml_ProductUpdates_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'productupdates';
        $this->_controller = 'adminhtml_productupdates';
        
        $this->_updateButton('save', 'label', Mage::helper('productupdates')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('productupdates')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('productupdates_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'productupdates_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'productupdates_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('productupdates_data') && Mage::registry('productupdates_data')->getId() ) {
            return Mage::helper('productupdates')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('productupdates_data')->getTitle()));
        } else {
            return Mage::helper('productupdates')->__('Add Item');
        }
    }
}