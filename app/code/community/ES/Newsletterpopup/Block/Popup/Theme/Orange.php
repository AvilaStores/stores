<?php
class ES_Newsletterpopup_Block_Popup_Theme_Orange extends Mage_Core_Block_Template
{


    public function __construct()
    {
        $this->setTemplate('newsletterpopup/popup/theme/orange.phtml');
    }

    public function getFirstTitle()
    {
        return Mage::getStoreConfig('newsletterpopup/theme_orange/firsttitle');
    }

    public function getSecondTitle()
    {
        return Mage::getStoreConfig('newsletterpopup/theme_orange/secondtitle');
    }

    public function getText()
    {
        return Mage::getStoreConfig('newsletterpopup/theme_orange/message');
    }

    public function getFooterTitle()
    {
        return Mage::getStoreConfig('newsletterpopup/theme_orange/footer_title');
    }

    public function getColor1()
    {
        return '#' . str_replace('#', '', Mage::getStoreConfig('newsletterpopup/theme_orange/color1'));
    }

    public function getIcon()
    {
        return Mage::getStoreConfig('newsletterpopup/theme_orange/icon');
    }

    public function getCurrencySymbol()
    {
        return Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
    }

    public function getAdditionalFields()
    {
        return $this->getParentBlock()->getAdditionalFields();
    }

    public function getSocial()
    {
        return $this->getParentBlock()->getSocial();
    }
}