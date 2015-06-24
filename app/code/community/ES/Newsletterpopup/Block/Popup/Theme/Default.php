<?php
class ES_Newsletterpopup_Block_Popup_Theme_Default extends Mage_Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('newsletterpopup/popup/theme/default.phtml');
    }

    public function getFirstTitle()
    {
        return Mage::getStoreConfig('newsletterpopup/theme_default/firsttitle');
    }

    public function getSecondTitle()
    {
        return Mage::getStoreConfig('newsletterpopup/theme_default/secondtitle');
    }

    public function getText()
    {
        return Mage::getStoreConfig('newsletterpopup/theme_default/message');
    }
}