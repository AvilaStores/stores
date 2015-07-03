<?php
/**
 * Developed by Korifi Company.
 * Author: Linh <linh@korifi.vn>
 * Date: 1/8/14  Time: 8:57 AM
 * For more Magento Extensions, please check out http://hotextension.com
 */
class Korifi_Salenotice_Model_Mysql4_Solditem extends  Mage_Core_Model_Mysql4_Abstract{

    protected function _construct() {
        $this->_init('salenotice/solditem','item_id');
    }

    protected  function _beforeSave(Mage_Core_Model_Abstract $object){
        if (!$object->getId()) {
            $object->setCreatedAt(date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time())));

        }

        return parent::_beforeSave($object);
    }

    protected function _afterSave(Mage_Core_Model_Abstract $object){
        $condition = $this->_getWriteAdapter()->quoteInto('item_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('solditem_store'), $condition);

        if (!$object->getData('stores')){
            $storeArray = array();
            $storeArray['item_id'] = $object->getId();
            $storeArray['store_id'] = '0';
            $this->_getWriteAdapter()->insert($this->getTable('solditem_store'), $storeArray);
        }else{
            foreach ((array)$object->getData('stores') as $store) {
                $storeArray = array();
                $storeArray['item_id'] = $object->getId();
                $storeArray['store_id'] = $store;
                $this->_getWriteAdapter()->insert($this->getTable('solditem_store'), $storeArray);
            }
        }

        return parent::_afterSave($object);
    }

    protected function _afterDelete(Mage_Core_Model_Abstract $object){
        $condition = $this->_getWriteAdapter()->quoteInto('item_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('solditem_store'), $condition);
        return parent::_afterDelete($object);

    }

    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        $select = $this->_getReadAdapter()->select()->from(
            $this->getTable('solditem_store')
        )->where('item_id = ?', $object->getId());

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $storesArray = array ();
            foreach ($data as $row) {
                $storesArray[] = $row['store_id'];
            }
            $object->setData('store_id', $storesArray);
        }
        return parent::_afterLoad($object);

    }
}