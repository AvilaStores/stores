<?php

class ES_Newsletterpopup_Block_Adminhtml_Newsletterpopup_Report_Tabs_Container
    extends Mage_Adminhtml_Block_Template
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    protected $_tabLabel = '';

    protected $_tabTitle = '';

    public function __construct()
    {
        $this->setTemplate('newsletterpopup/report/tabs/container.phtml');
    }

    public function setTabLabel($tabLabel)
    {
        $this->_tabLabel = $tabLabel;
    }

    public function setTabTitle($tabTitle)
    {
        $this->_tabTitle = $tabTitle;
    }

    public function getTabLabel()
    {
        return Mage::helper('newsletterpopup')->__($this->_tabLabel);
    }

    public function getTabTitle()
    {
        return Mage::helper('newsletterpopup')->__($this->_tabTitle);
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

}
