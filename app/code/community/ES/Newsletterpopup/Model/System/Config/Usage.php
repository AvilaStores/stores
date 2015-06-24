<?php

class ES_Newsletterpopup_Model_System_Config_Usage
{
    public function toOptionArray()
    {
        return array(
            array('value' => '0', 'label'=>Mage::helper('adminhtml')->__('Only Button')),
            array('value' => '1', 'label'=>Mage::helper('adminhtml')->__('Auto Call and Button')),
        );
    }
}