<?php

class Avilastores_ProductUpdates_Model_Mysql4_ProductUpdates extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the productupdates_id refers to the key field in your database table.
        $this->_init('productupdates/productupdates', 'productupdates_id');
    }
}