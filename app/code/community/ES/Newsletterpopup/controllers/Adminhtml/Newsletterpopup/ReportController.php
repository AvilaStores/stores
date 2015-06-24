<?php


class ES_Newsletterpopup_Adminhtml_Newsletterpopup_ReportController
    extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Newsletter Popup Pro'))->_title($this->__('Report'));
        $this->loadLayout();
        $this->_setActiveMenu('newsletter/newsletter_popup_report');
        $this->renderLayout();
    }

    public function subscriptionChartAjaxAction()
    {
        $chartData = Mage::getModel('newsletterpopup/report')->getSubscriptionReportChartData();
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($chartData));
    }

    public function couponChartAjaxAction()
    {
        $chartData = Mage::getModel('newsletterpopup/report')->geCouponReportChartData();
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($chartData));
    }

}
