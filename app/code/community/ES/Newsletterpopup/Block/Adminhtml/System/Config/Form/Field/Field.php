<?php

class ES_Newsletterpopup_Block_Adminhtml_System_Config_Form_Field_Field extends Mage_Core_Block_Html_Select
{
    private $_fields;

    protected function _getFields($fieldId = null)
    {

        if (is_null($this->_fields)) {
            $this->_fields = array();
            $helper = Mage::helper('newsletterpopup');
            $this->_fields['input'] = $helper->__('Short Text');
            $this->_fields['select'] = $helper->__('Drop Down');
        }

        if (!is_null($fieldId)) {
            return isset($this->_fields[$fieldId]) ? $this->_fields[$fieldId] : null;
        }

        return $this->_fields;
    }

    public function setInputName($value)
    {
        return $this->setName($value);
    }

    public function _toHtml()
    {
        if (!$this->getOptions()) {
            foreach ($this->_getFields() as $fieldId => $groupLabel) {
                $this->addOption($fieldId, addslashes($groupLabel));
            }
        }
        return parent::_toHtml();
    }
}
