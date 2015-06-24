<?php

class MeasuredSearch_InstantSearch_Adminhtml_InstantsearchController extends Mage_Adminhtml_Controller_Action {

    public function catalogAction() {
        $result = '{"success": false, "message": "Unknown error"}';
        try {
            $helper = Mage::helper('measuredsearch_instantsearch');
            $count = Mage::getModel('catalog/product')->getCollection()
                ->clear()
                ->addAttributeToSelect('sku')
                ->addAttributeToFilter('visibility', $helper->getVisibilityScope())
                ->addAttributeToFilter('status', array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED))
                ->count();
            $pages = ceil($count/$helper->getBatchSize());
            $result = '{"success": true, "count":'.$count.', "pages":'.$pages.' }';
        } catch(Exception $e) {
            Mage::log($e, null, 'measuredsearch.log');
            $result = '{"success": false, "message": "Error fetching product details in catalog."}';
        }
        Mage::app()->getResponse()->setBody($result);
    }

    public function syncAction() {
        $result = 'Sync initiated...';
        try {
            $page = intval($this->getRequest()->getParam('page'));
            $helper = Mage::helper('measuredsearch_instantsearch');
            Mage::log("******* Page " . $page, null, 'measuredsearch.log');
            $collection = Mage::getModel('catalog/product')
                ->getCollection()
                ->clear()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('visibility', $helper->getVisibilityScope())
                ->addAttributeToFilter('status', array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED))
                ->setPageSize($helper->getBatchSize())
                ->setCurPage($page)
                ->load();
            $product_collection = array();
            foreach ($collection as $product) {
                $product_json = $helper->getProductDetails($product);
                if (!is_null($product_json)) {
                    array_push($product_collection, $product_json);
                }
            }

            if ($helper->uploadProductData($product_collection)) {
                $result = 'Sync initiated...';
            } else {
                $result = 'Sync error';
            }
        } catch(Exception $e) {
            Mage::log($e, null, 'measuredsearch.log');
            $result = 'Sync error';
        }
        Mage::app()->getResponse()->setBody($result);
    }

    public function statusAction() {
        $result = '0';
        try {
            $helper = Mage::helper('measuredsearch_instantsearch');
            $collection = $helper->getCollection();
            $result = $helper->getCollectionDetails($collection);
            if (is_null($result)) {
                $result = 'ERROR';
            } else {
                $result = $result->{'count'};
            }
        } catch(Exception $e) {
            Mage::log($e->getTraceAsString(), null, 'measuredsearch.log');
            $result = 'ERROR';
        }
        Mage::app()->getResponse()->setBody($result);
    }
}
