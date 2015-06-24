<?php
class ES_Newsletterpopup_Block_Popup_Theme_Label extends Mage_Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('newsletterpopup/popup/theme/label.phtml');
    }

    public function getFirstTitle()
    {
        return Mage::getStoreConfig('newsletterpopup/theme_label/firsttitle');
    }

    public function getSecondTitle()
    {
        return Mage::getStoreConfig('newsletterpopup/theme_label/secondtitle');
    }

    public function getText()
    {
        return Mage::getStoreConfig('newsletterpopup/theme_label/message');
    }
}