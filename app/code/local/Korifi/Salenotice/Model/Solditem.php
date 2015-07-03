<?php
/**
 * Developed by Korifi Company.
 * Author: Linh <linh@korifi.vn>
 * Date: 1/8/14  Time: 8:55 AM
 * For more Magento Extensions, please check out http://hotextension.com
 */
class Korifi_Salenotice_Model_Solditem extends Mage_Core_Model_Abstract{
    public function _construct(){
        parent::_construct();
        $this->_init('salenotice/solditem');
    }

}