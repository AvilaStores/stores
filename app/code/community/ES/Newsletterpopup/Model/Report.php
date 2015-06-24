<?php

class ES_Newsletterpopup_Model_Report
{
    public function geCouponReportChartData()
    {
        $helper = Mage::helper('newsletterpopup/adminhtml');
        $timeLabel = $this->getTimeLabels();

        $series1 = $this->groupResult($this->getCoupons(), $timeLabel);
        $series2 = $this->groupResult($this->getUsedCoupons(), $timeLabel);

        $chartXSeries = $this->formatTimeLabels($timeLabel);


        $resultSize = count($chartXSeries);
        if ($resultSize == 1) {
            $chartXSeries = array('', $chartXSeries[0], '');
            $series1 = array(0, $series1[0], 0);
            $series2 = array(0, $series2[0], 0);
        } elseif ($resultSize == 0) {
            return array(
                'error' => Mage::helper('newsletterpopup')->__('No records found.')
            );
        }

        return array(
            array(
                'chartOptions' => $helper->getChartOptions(),
                'chartData' => array(
                    'labels' => $chartXSeries,
                    'datasets' => array(
                        array(
                            'data' => $series2,
                            'label' => Mage::helper('newsletterpopup')->__('Used coupons'),
                            'fillColor' => "rgba(247,70,74,0.2)",
                            'strokeColor' => "rgba(247,70,74,1)",
                            'pointColor' => "rgba(247,70,74,1)",
                            'pointStrokeColor' => "#fff",
                            'pointHighlightFill' => "#fff",
                            'pointHighlightStroke' => "rgba(247,70,74,1)",
                        ),
                        array(
                            'data' => $series1,
                            'label' => Mage::helper('newsletterpopup')->__('Generated coupons'),
                            'fillColor' => "rgba(220,220,220,0.2)",
                            'strokeColor' => "rgba(220,220,220,1)",
                            'pointColor' => "rgba(220,220,220,1)",
                            'pointStrokeColor' => "#fff",
                            'pointHighlightFill' => "#fff",
                            'pointHighlightStroke' => "rgba(220,220,220,1)",
                        )
        ))));
    }

    public function getSubscriptionReportChartData()
    {
        $timeLabel = $this->getTimeLabels();
        $data = $this->groupResult($this->getSubscribers(), $timeLabel);
        $chartXSeries = $this->formatTimeLabels($timeLabel);
        $helper = Mage::helper('newsletterpopup/adminhtml');

        $resultSize = count($chartXSeries);
        if ($resultSize == 1) {
            $chartXSeries = array('', $chartXSeries[0], '');
            $data = array(0, $data[0], 0);
        } elseif ($resultSize == 0) {
            return array(
                'error' => Mage::helper('newsletterpopup')->__('No records found.')
            );
        }

        return array(
            array(
                'chartOptions' => $helper->getChartOptions(),
                'chartData' => array(
                    'labels' => $chartXSeries,
                    'datasets' => array(
                        array(
                            'data' => $data,
                            'label' => Mage::helper('newsletterpopup')->__('Subscriptions'),
                            'fillColor' => "rgba(220,220,220,0.2)",
                            'strokeColor' => "rgba(220,220,220,1)",
                            'pointColor' => "rgba(220,220,220,1)",
                            'pointStrokeColor' => "#fff",
                            'pointHighlightFill' => "#fff",
                            'pointHighlightStroke' => "rgba(220,220,220,1)",
                        )
        ))));
    }

    public function groupResult(Mage_Core_Model_Resource_Db_Collection_Abstract $collection, $timeLabels)
    {
        $results = array();
        if (!isset($timeLabels[0])) {
            return $results;
        }

        //detect date format
        if (date('Y-m-d', strtotime($timeLabels[0])) == $timeLabels[0]) {
            $dateFormat = 'Y-m-d';
        } elseif (date('Y-m', strtotime($timeLabels[0])) == $timeLabels[0]) {
            $dateFormat = 'Y-m';
        } else {
            $dateFormat = 'Y';
        }

        $results = array_combine($timeLabels, array_fill(0, count($timeLabels) , 0));
        foreach ($collection as $row) {
            $results[date($dateFormat, strtotime($row->getDate()))]++;
        }

        $results = array_values($results);
        return $results;
    }

    public function getSubscribers()
    {
        $helper = Mage::helper('newsletterpopup/adminhtml');
        $collection = Mage::getModel('newsletter/subscriber')->getCollection()
            ->addFieldToFilter('subscriber_status', Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED);
        if ($from = $helper->getDateFrom()) {
            $from = date('Y-m-d 00:00:00', strtotime($from));
            $collection->addFieldToFilter('created_at', array('gteq' => $from));
        }
        if ($to =  $helper->getDateTo()) {
            $to = date('Y-m-d 23:59:59', strtotime($to));
            $collection->addFieldToFilter('created_at', array('lteq' => $to));
        }
        $storeId = $helper->getStoreId();
        if ($storeId > 0) {
            $collection->addFieldToFilter('store_id', $storeId);
        }

        $collection->getSelect()
            ->columns(array('date' => 'created_at'));
        return $collection;
    }

    public function getCoupons()
    {
        $helper = Mage::helper('newsletterpopup/adminhtml');
        $ruleId = Mage::getStoreConfig('newsletterpopup/coupon/roleid', $helper->getStoreId());
        if (!$ruleId) {
            return null;
        }

        $collection =  Mage::getModel('salesrule/coupon')->getCollection()
            ->addFieldToFilter('rule_id', $ruleId);

        if ($from = $helper->getDateFrom()) {
            $from = date('Y-m-d 00:00:00', strtotime($from));
            $collection->addFieldToFilter('created_at', array('gteq' => $from));
        }
        if ($to =  $helper->getDateTo()) {
            $to = date('Y-m-d 23:59:59', strtotime($to));
            $collection->addFieldToFilter('created_at', array('lteq' => $to));
        }

        $collection->getSelect()
            ->columns(array('date' => 'created_at'));

        return $collection;
    }

    public function getUsedCoupons()
    {
        $collection = $coupons = $this->getCoupons();
        return $collection->addFieldToFilter('times_used', array('gteq' => 1));
    }

    public function getTimeLabels()
    {
        $labelScale = $this->getLabelScale();
        $labels = array();
        $helper = Mage::helper('newsletterpopup/adminhtml');
        $from = $helper->getDateFrom();
        $to = $helper->getDateTo();

        switch ($labelScale) {
            case 'day':
                $begin = new DateTime($from);
                $end = new DateTime($to);
                $end = $end->modify('+1 day');
                $interval = new DateInterval('P1D');
                break;
            case 'month':
                $begin = new DateTime(date('Y-m-1', strtotime($from)));
                $end = new DateTime(date('Y-m-'.cal_days_in_month(CAL_GREGORIAN,date('m', strtotime($to)),date('Y', strtotime($to))), strtotime($to)));
                $interval = new DateInterval('P1M');
                break;
            case 'year':
                $begin = new DateTime(date('Y-1-1', strtotime($from)));
                $end = new DateTime(date('Y-12-31', strtotime($to)));
                $interval = new DateInterval('P1Y');
                break;
        }

        $dateRange = new DatePeriod($begin, $interval ,$end);
        foreach($dateRange as $date){
            switch ($labelScale) {
                case 'day':
                    $labels[] = $date->format("Y-m-d");
                    break;
                case 'month':
                    $labels[] = $date->format("Y-m");
                    break;
                case 'year':
                    $labels[] = $date->format("Y");
                    break;
            }

        }

        return $labels;
    }

    public function getLabelScale()
    {
        $helper = Mage::helper('newsletterpopup/adminhtml');
        $from = new DateTime($helper->getDateFrom());
        $to = new DateTime($helper->getDateTo());
        $interval = $from->diff($to);

        if ($interval->y > 0) {
            $interval = 'year';
        } elseif ($interval->m > 0 && $interval->d >= 31) {
            $interval = 'month';
        } else {
            $interval = 'day';
        }
        return $interval;
    }

    public function formatTimeLabels($data)
    {
        if ($data) {
            $labelScale = $this->getLabelScale();
            foreach ($data as $key => $value) {
                switch ($labelScale) {
                    case 'day':
                        $data[$key] = date('d', strtotime($value)). "\n" . Mage::helper('core')->__(date('M', strtotime($value)));
                        break;
                    case 'month':
                        $data[$key] = Mage::helper('core')->__(date('F', strtotime($value)))."\n".date('Y', strtotime($value));
                        break;
                }
            }
        }
        return $data;
    }
}