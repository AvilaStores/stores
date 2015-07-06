<?php

class Avilastores_ProductUpdates_Model_Mysql4_ProductUpdates_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('productupdates/productupdates');
    }
}