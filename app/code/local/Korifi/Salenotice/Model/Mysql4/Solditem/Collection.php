<?php
/**
 * Developed by Korifi Company.
 * Author: Linh <linh@korifi.vn>
 * Date: 1/8/14  Time: 8:59 AM
 * For more Magento Extensions, please check out http://hotextension.com
 */

class Korifi_Salenotice_Model_Mysql4_Solditem_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    protected function _construct() {
        $this->_init('salenotice/solditem');
    }


    public function addStoreFilter($store){
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }

        $this->getSelect()->join(
            array('store_table' => $this->getTable('salenotice/solditem_store')),
            'main_table.item_id = store_table.item_id',
            array ()
        )->where('store_table.store_id in (?)', array (
                0,
                $store
            ));

        return $this;
    }

}