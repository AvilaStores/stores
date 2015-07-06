<?php

class Avilastores_ProductUpdates_Model_ProductUpdates extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('productupdates/productupdates');
    }

    /**
     * Daily update catalog price rule by cron
     * Update include interval 3 days - current day - 1 days before + 1 days after
     * This method is called from cron process, cron is working in UTC time and
     * we should generate data for interval -1 day ... +1 day
     *
     * @param   Varien_Event_Observer $observer
     *
     * @return  Mage_CatalogRule_Model_Observer
     */
    public function dailyCatalogUpdate($observer)
    {
        /** @var $model Mage_CatalogRule_Model_Rule */
        $model = Mage::getSingleton('catalogrule/rule');
        $model->applyAll();

        return $this;
    }
}