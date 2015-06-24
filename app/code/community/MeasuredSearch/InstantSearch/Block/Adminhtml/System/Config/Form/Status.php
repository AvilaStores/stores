<?php

class MeasuredSearch_InstantSearch_Block_Adminhtml_System_Config_Form_Status extends Mage_Adminhtml_Block_System_Config_Form_Field {

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {
        $helper = Mage::helper('measuredsearch_instantsearch');
        $collection = $helper->getCollection();
        $count = 0;
        $result = $helper->getCollectionDetails($collection);
        if (is_null($result)) {
            $count = 'ERROR';
        } else {
            $count = $result->{'count'};
        }
        return '<span id="indexedDocsCount">' . $count . '</span>';
    }

    public function getIndexedDocCountUrl() {
        return Mage::helper('adminhtml')->getUrl('adminhtml/instantsearch/status');
    }
}
