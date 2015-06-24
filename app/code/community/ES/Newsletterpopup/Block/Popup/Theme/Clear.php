<?php
class ES_Newsletterpopup_Block_Popup_Theme_Clear extends Mage_Core_Block_Template
{

    public function __construct()
    {
        $this->setTemplate('newsletterpopup/popup/theme/clear.phtml');
    }

    public function getFirstTitle()
    {
        return Mage::getStoreConfig('newsletterpopup/theme_clear/firsttitle');
    }

    public function getSecondTitle()
    {
        return Mage::getStoreConfig('newsletterpopup/theme_clear/secondtitle');
    }

    public function getColor1()
    {
        return '#' . str_replace('#', '', Mage::getStoreConfig('newsletterpopup/theme_clear/color1'));
    }

    public function getAdditionalFields()
    {
        return $this->getParentBlock()->getAdditionalFields();
    }

    public function getSocialLink($name)
    {
        return Mage::getStoreConfig('newsletterpopup/theme_orange/social_link_'.$name);
    }

    public function getSocial()
    {
        return $this->getParentBlock()->getSocial();
    }

    public function getFooterTitle()
    {
        return Mage::getStoreConfig('newsletterpopup/theme_orange/footer_title');
    }
}