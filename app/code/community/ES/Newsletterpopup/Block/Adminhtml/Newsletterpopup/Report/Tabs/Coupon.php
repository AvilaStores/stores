<?php

class ES_Newsletterpopup_Block_Adminhtml_Newsletterpopup_Report_Tabs_Coupon
    extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('newsletterpopup/report/tabs/coupon.phtml');
    }

    public function getChartAjaxUrl()
    {
        return Mage::helper('adminhtml')->getUrl('adminhtml/newsletterpopup_report/couponChartAjax', array(
            'isAjax'=> 'true'
        ));
    }

    public function getStoreId()
    {
        $storeId = Mage::app()->getRequest()->getParam('store');
        return is_numeric($storeId)?$storeId:0;
    }
}
