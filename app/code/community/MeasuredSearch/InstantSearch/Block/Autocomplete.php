<?php

class MeasuredSearch_InstantSearch_Block_Autocomplete extends Mage_CatalogSearch_Block_Autocomplete {

    /*protected function _toHtml() {
        $html = '';
        $helper = Mage::helper('measuredsearch_instantsearch');

        if ($helper->isMeasuredSearchServiceEnabled()) {
            return $html;
        }

        return parent::_toHtml();
    }*/

    public function getSuggestData() {
        $helper = Mage::helper('measuredsearch_instantsearch');
        $data = array();
        if ($helper->isMeasuredSearchServiceEnabled()) {
            return $data;
        }
        return $this->_suggestData;
    }
}
