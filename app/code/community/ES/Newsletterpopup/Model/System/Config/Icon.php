<?php

class ES_Newsletterpopup_Model_System_Config_Icon
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'letter', 'label'=>Mage::helper('adminhtml')->__('Letter')),
            array('value' => 'giftcard',   'label'=>Mage::helper('adminhtml')->__('Gift Card')),

        );
    }
}