<?php

class ES_Newsletterpopup_Block_Adminhtml_Newsletterpopup_Report
    extends Mage_Adminhtml_Block_Template
{
    protected $_periods = array(
        'today', 'yesterday', 'last-week', 'last-month', 'last-7-days' ,'last-30-days'
    );

    public function __construct()
    {
        $this->setTemplate('newsletterpopup/report/report.phtml');
    }

    public function getPeriod($periodName)
    {
        switch($periodName) {
            case 'today':
                $from = date('Y-m-d');
                $to = date('Y-m-d');
                break;
            case 'yesterday':
                $from = date('Y-m-d', strtotime('-1day'));
                $to = date('Y-m-d', strtotime('-1day'));
                break;
            case 'last-week':
                $from = date('Y-m-d', strtotime('monday last week'));
                $to = date('Y-m-d', strtotime('sunday last week'));
                break;
            case 'last-month':
                $from = date('Y-m-d', strtotime('first day of previous month'));
                $to = date('Y-m-d', strtotime('last day of previous month'));
                break;
            case 'last-7-days':
                $from = date('Y-m-d', strtotime('-7days'));
                $to = date('Y-m-d', strtotime('-1day'));
                break;
            case 'last-30-days':
                $from = date('Y-m-d', strtotime('-30day'));
                $to = date('Y-m-d', strtotime('-1day'));
                break;
        }

        return $from. '|' . $to;
    }

    public function getPeriods()
    {
        return $this->_periods;
    }

    public function getCurrentPeriod()
    {
        $helper = Mage::helper('newsletterpopup/adminhtml');
        $from = $helper->getDateFrom();
        $to = $helper->getDateTo();
        if (!$from || !$to) {
            return $this->getPeriod('last-30-days');
        } else {
            return $from . '|' . $to ;
        }
    }



}
