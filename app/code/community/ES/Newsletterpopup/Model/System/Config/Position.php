<?php

class ES_Newsletterpopup_Model_System_Config_Position
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'leftcenter', 'label'=>Mage::helper('adminhtml')->__('Left Center')),
            array('value' => 'rightcenter', 'label'=>Mage::helper('adminhtml')->__('Right Center')),
            array('value' => 'leftbottom', 'label'=>Mage::helper('adminhtml')->__('Left Bottom')),
            array('value' => 'rightbottom', 'label'=>Mage::helper('adminhtml')->__('Right Bottom')),
        );
    }
}