<?php
/**
 * Developed by Korifi Company.
 * Author: Linh <linh@korifi.vn>
 * Date: 1/8/14  Time: 9:26 AM
 * For more Magento Extensions, please check out http://hotextension.com
 */
class Korifi_Salenotice_Block_Adminhtml_Solditem_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{

    public function __construct()
    {
        parent::__construct();
        $this->setId('solditem_tab');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('salenotice')->__('General'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('salenotice')->__('Sold Item'),
            'title'     => Mage::helper('salenotice')->__('Sold Item'),
            'content'   => $this->getLayout()->createBlock('salenotice/adminhtml_solditem_edit_tabs_form')->toHtml(),
            'active'	=> true,
        ));


        return parent::_beforeToHtml();
    }
}