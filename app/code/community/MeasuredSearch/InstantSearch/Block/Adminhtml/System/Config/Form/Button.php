<?php

class MeasuredSearch_InstantSearch_Block_Adminhtml_System_Config_Form_Button extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _construct() {
        parent::_construct();
        $this->setTemplate('measuredsearch/system/config/button.phtml');
    }

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {
        return $this->_toHtml();
    }

    public function getAjaxSyncNowUrl() {
        return Mage::helper('adminhtml')->getUrl('adminhtml/instantsearch/sync');
    }

    public function getIndexedDocCountUrl() {
        return Mage::helper('adminhtml')->getUrl('adminhtml/instantsearch/status');
    }

    public function getCatalogInfo() {
        return Mage::helper('adminhtml')->getUrl('adminhtml/instantsearch/catalog');
    }

    public function getButtonHtml() {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'id'        => 'syncnow_button',
                'label'     => $this->helper('adminhtml')->__('Sync Now'),
                'onclick'   => 'javascript:syncnow(); return false;'
        ));

        return $button->toHtml();
    }
}
