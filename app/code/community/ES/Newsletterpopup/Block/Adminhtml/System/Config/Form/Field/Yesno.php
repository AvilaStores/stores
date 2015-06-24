<?php

class ES_Newsletterpopup_Block_Adminhtml_System_Config_Form_Field_Yesno extends Mage_Core_Block_Html_Select
{
    private $_values;

    protected function _getValues($fieldId = null)
    {
        if (is_null($this->_values)) {
            $this->_values = array();
            $helper = Mage::helper('newsletterpopup');
            $this->_values['1'] = $helper->__('Yes');
            $this->_values['0'] = $helper->__('No');
        }

        if (!is_null($fieldId)) {
            return isset($this->_values[$fieldId]) ? $this->_values[$fieldId] : null;
        }

        return $this->_values;
    }

    public function setInputName($value)
    {
        return $this->setName($value);
    }

    public function _toHtml()
    {
        if (!$this->getOptions()) {
            foreach ($this->_getValues() as $fieldId => $groupLabel) {
                $this->addOption($fieldId, addslashes($groupLabel));
            }
        }
        return parent::_toHtml();
    }
}
