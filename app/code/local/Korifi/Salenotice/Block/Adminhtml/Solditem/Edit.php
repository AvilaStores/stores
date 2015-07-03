<?php
/**
 * Developed by Korifi Company.
 * Author: Linh <linh@korifi.vn>
 * Date: 1/8/14  Time: 9:21 AM
 * For more Magento Extensions, please check out http://hotextension.com
 */
class Korifi_Salenotice_Block_Adminhtml_Solditem_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{

    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'item_id';
        $this->_blockGroup = 'salenotice';
        $this->_controller = 'adminhtml_solditem';
        $this->_updateButton('save', 'label', Mage::helper('salenotice')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('salenotice')->__('Delete'));
        //$this->_removeButton('save');
        //$this->_removeButton('delete');


        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('salenotice')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
                function saveAndContinueEdit(){
                        editForm.submit($('edit_form').action+'back/edit/');
                }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('item_data') && Mage::registry('item_data')->getId() ) {
            return Mage::helper('salenotice')->__("Edit Item ID '%s'", $this->htmlEscape(Mage::registry('item_data')->getItemId()));
        } else {
            return Mage::helper('salenotice')->__('New Item');
        }
    }
}