<?php
class ES_Newsletterpopup_Block_Button extends Mage_Core_Block_Template
{
    public function getButtonIsActive()
    {
        return Mage::getStoreConfig('newsletterpopup/button/isactive');
    }

    public function getButtonUsage()
    {
        return Mage::getStoreConfig('newsletterpopup/button/usage');
    }

    public function getButtonText()
    {
        return Mage::getStoreConfig('newsletterpopup/button/text');
    }

    public function getButtonPosition()
    {
        return Mage::getStoreConfig('newsletterpopup/button/position');
    }

    public function getCookieName()
    {
        return Mage::getStoreConfig('newsletterpopup/popup/cookiename');
    }

    public function getButtonPositionTop()
    {
        $top = Mage::getStoreConfig('newsletterpopup/button/top');
        if (!is_numeric($top) || (Mage::getStoreConfig('newsletterpopup/button/position') == 'leftbottom' || Mage::getStoreConfig('newsletterpopup/button/position') == 'rightbottom'))
            return '';
        return $top;
    }
}