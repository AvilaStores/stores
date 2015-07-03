<?php
/**
 * Developed by Korifi Company.
 * Author: Linh <linh@korifi.vn>
 * Date: 1/7/14  Time: 9:35 AM
 * For more Magento Extensions, please check out http://hotextension.com
 */
class Korifi_Salenotice_Helper_Data extends Mage_Core_Helper_Data{

    function getTimeAgo($dattime){
        //$current_time = Mage::getModel('core/date')->timestamp(time());
        $current_time = time();
        $time =strtotime($dattime);
        $different_time = round(($current_time-$time)/60);
        $output_min='';
        $output_hour='';
        $output_day='';
        $output_sec='';
        $hour = round($different_time/60);
        $hour_mod = ($different_time % 60);
        $min = ($different_time % 60);
        $min_mod = $different_time % 60;
        $day = round($different_time/(60*24));
        $day_mod = $different_time % (60*24);
        $second = $current_time-$time;
        if($day > 1){
            $output_day= $day.' '.Mage::helper('salenotice')->__('days').' ';
        }
        if($day == 1){
            $output_day=Mage::helper('salenotice')->__('a day').' ';
        }
        if($day < 1){
            if($hour > 1){
                $output_hour= $hour.' '.Mage::helper('salenotice')->__('hours').' ';
            }
            if($hour == 1){
                $output_hour= Mage::helper('salenotice')->__('an hour').' ';
                if($hour_mod > 1){
                    $output_min=$hour_mod.' '.Mage::helper('salenotice')->__('minutes').' ';
                }
            }
            if($hour == 0){
                if($min > 10){
                    $output_min = $min.' '.Mage::helper('salenotice')->__('minutes').' ';
                }
                if($min > 1 && $min < 10){
                    $output_min = Mage::helper('salenotice')->__('a few minutes').' ';
                }
                if($min==1){
                    $output_min = Mage::helper('salenotice')->__('a minute').' ';
                }
                if($min==0){
                    $output_sec = ' '.Mage::helper('salenotice')->__('a few seconds').' ';
                }

            }
        }

        $output=$output_day.$output_hour.$output_min.$output_sec.Mage::helper('salenotice')->__('ago');

        return $output;
    }

    function getFirstTime(){
        if(Mage::getStoreConfig('salenotice/settings/first_load')){
            return Mage::getStoreConfig('salenotice/settings/first_load');
        }else{
            return 5000;
        }
    }

    function getTimeDelay(){
        if(Mage::getStoreConfig('salenotice/settings/time_delay')){
            return Mage::getStoreConfig('salenotice/settings/time_delay');
        }else{
            return 15000;
        }
    }
    function getTimeDisplay(){
        if(Mage::getStoreConfig('salenotice/settings/time_display')){
            return Mage::getStoreConfig('salenotice/settings/time_display');
        }else{
            return 5000;
        }
    }

    function getLimitLastOrder(){
        if(Mage::getStoreConfig('salenotice/settings/limit_last_order')){
            return Mage::getStoreConfig('salenotice/settings/limit_last_order');
        }else{
            return 5;
        }
    }

    function getDataUsing(){
        if(Mage::getStoreConfig('salenotice/settings/data_using')){
            return Mage::getStoreConfig('salenotice/settings/data_using');
        }else{
            return 0;
        }
    }
}