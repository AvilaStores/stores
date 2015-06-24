<?php

class ES_Newsletterpopup_Helper_Adminhtml
    extends Mage_Core_Helper_Abstract
{
    public function getDateFrom($localFormat = false)
    {
        $from = Mage::app()->getRequest()->getParam('dateFrom');
        if (!empty($from)) {
            $from = $this->_convertDate($from);
            Mage::getSingleton('admin/session')->setEsReportDateFrom($from);
        } else {
            $from = Mage::getSingleton('admin/session')->getEsReportDateFrom();
        }
        if (!empty($from) && $localFormat) {
            $format = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
            $tmpFrom = new Zend_Date($from);
            $from = $tmpFrom->toString($format);
        }
        return $from;
    }

    public function getDateTo($localFormat = false)
    {
        $to = Mage::app()->getRequest()->getParam('dateTo');
        if (!empty($to)) {
            $to = $this->_convertDate($to);
            Mage::getSingleton('admin/session')->setEsReportDateTo($to);
        } else {
            $to = Mage::getSingleton('admin/session')->getEsReportDateTo();
        }

        if (!empty($to) && $localFormat) {
            $format = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
            $tmpTo = new Zend_Date($to);
            $to = $tmpTo->toString($format);
        }
        return $to;
    }

    protected function _convertDate($date)
    {
        $format = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
        $dateObject = new Zend_Date(
            $date,
            $format
        );
        return date('Y-m-d', $dateObject->getTimestamp());
    }

    public function getStoreId()
    {
        if (Mage::app()->getRequest()->getParam('storeId')) {
            $storeId = Mage::app()->getRequest()->getParam('storeId');
        } else {
            $storeId = Mage::app()->getStore()->getId();
        }
        return $storeId;
    }

    public function getChartOptions()
    {
        $options =  array(
            'showScale' => true,
            'bezierCurve' => false,
            'pointLabelDelimiter' => "\n",
            'legendTemplate' => "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
        );
        return $options;
    }
}