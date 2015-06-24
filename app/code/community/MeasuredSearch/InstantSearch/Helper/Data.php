<?php

class MeasuredSearch_InstantSearch_Helper_Data extends Mage_Core_Helper_Abstract {

    public function getProductDetails($product) {
        try {
            $productDetails = array();
            $productDetails['id'] = $product->getId();
            $productDetails['title'] = $product->getName();
            $productDetails['description'] = $product->getDescription();
            $productDetails['link'] = $product->getProductUrl();
            $productDetails['qty'] = floatval(Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty());

            $skuArray = array();
            $skuArray['type'] = 'LITERAL';
            $skuArray['value'] = $product->getSku();
            $productDetails['sku'] = $skuArray;

            $categories = array();
            $cats = $product->getCategoryIds();
            foreach ($cats as $category_id) {
                $cat = Mage::getModel('catalog/category')->load($category_id);
                array_push($categories, $cat->getName());
            }

            $categoriesArray = array();
            $categoriesArray['type'] = 'LITERAL_ARRAY';
            $categoriesArray['value'] = $categories;
            $productDetails['categories'] = $categoriesArray;

            /*
            if ($color = $product->getAttributeText('color')) {
                $colorArray = array();
                $colorArray['type'] = 'LITERAL';
                $colorArray['value'] = $color;
                $productDetails['color'] = $colorArray;
            }

            if ($manufacturer = $product->getAttributeText('manufacturer')) {
                $manufacturerArray = array();
                $manufacturerArray['type'] = 'LITERAL';
                $manufacturerArray['value'] = $manufacturer;
                $productDetails['manufacturer'] = $manufacturerArray;
            }
            */

            try {
                $imageUrlArray = array();
                $imageUrlArray['type'] = 'IMAGE';
                $imageUrlArray['value'] = $product->getImageUrl();
                $productDetails['image_url'] = $imageUrlArray;
            } catch (Exception $e) {
                $productDetails['image_url'] = '';
            }

            /* Uncomment so that it works on localhost
            try {
                $productDetails['image_url'] = $product->getImageUrl();
            } catch (Exception $e) {
                $productDetails['image_url'] = '';
            }*/

            try {
                $productDetails['price'] = floatval($product->getPrice());
            } catch (Exception $e) {
            }

            return $productDetails;
        } catch (Exception $e) {
            Mage::log($e, null, 'measuredsearch.log');
            Mage::log("----------------", null, 'measuredsearch.log');
        }
        return NULL;
    }

    public function isVisibleInSearch($product) {
        if ($product->getVisibility() == 3 || $product->getVisibility() == 4) {
            return true;
        }
        return false;
    }

    public function isDisabled($product) {
        if($product->getStatus() == 2) {
            return true;
        }

        // !$product->getStatus() or $product->getStatus() is 1
        return false;
    }

    public function uploadProductData($data) {
        try {
            $url = $this->buildDocumentUrl($this->getCollection()) . '?key=' . $this->getSecretKey();
            Mage::log('POST '.$url, null, 'measuredsearch.log');
            $client = new Zend_Http_Client($url);
            $client->setRawData(json_encode($data))->setEncType('application/json');
            Mage::log(json_encode($data), null, 'measuredsearch.log');
            $response = $client->request('POST');
            Mage::log($response, null, 'measuredsearch.log');
            Mage::log("----------------", null, 'measuredsearch.log');
            if ($response->isError()) {
                return false;
            }
            return true;
        } catch (Exception $e) {
            Mage::log($e, null, 'measuredsearch.log');
            Mage::log("----------------", null, 'measuredsearch.log');
            return false;
        }
        return true;
    }

    public function deleteProduct($product_id) {
        try {
            $url = $this->buildDocumentUrl($this->getCollection()) . $product_id . '/?key=' . $this->getSecretKey();
            Mage::log('DELETE '.$url, null, 'measuredsearch.log');
            $client = new Zend_Http_Client($url);
            $client->setEncType('application/json');
            $response = $client->request('DELETE');
            Mage::log($response, null, 'measuredsearch.log');
            Mage::log("----------------", null, 'measuredsearch.log');
            return $response;
        } catch (Exception $e) {
            Mage::log($e, null, 'measuredsearch.log');
            Mage::log("----------------", null, 'measuredsearch.log');
        }
        return NULL;
    }

    public function getCollectionDetails($collection_slug) {
        try {
            $url = $this->buildCollectionUrl($collection_slug) . '?key=' . $this->getSecretKey();
            Mage::log('GET '.$url, null, 'measuredsearch.log');
            $client = new Zend_Http_Client($url);
            $client->setEncType('application/json');
            $response = $client->request('GET');
            Mage::log($response, null, 'measuredsearch.log');
            Mage::log("----------------", null, 'measuredsearch.log');
            if ($response->isError()) {
                return NULL;
            }
            return json_decode($response->getBody());
        } catch (Exception $e) {
            Mage::log($e, null, 'measuredsearch.log');
        }
        return NULL;
    }

    public function buildDocumentUrl($collection_slug) {
        return $this->getBaseUrl() . 'collection/' . $collection_slug . '/document/';
    }

    public function buildBaseCollectionUrl() {
        return $this->getBaseUrl() . 'collection/';
    }

    public function buildCollectionUrl($collection_slug) {
        return $this->getBaseUrl() . 'collection/' . $collection_slug . '/';
    }

    public function getBaseUrl() {
        return 'https://api.measuredsearch.com/api/v1/';
    }

    public function getCollection() {
        return Mage::getStoreConfig('instantsearch_section/configuration_group/collection_field');
    }

    public function getSecretKey() {
        return Mage::getStoreConfig('instantsearch_section/configuration_group/secret_key_field');
    }

    public function getDeveloperKey() {
        return Mage::getStoreConfig('instantsearch_section/configuration_group/developer_key_field');
    }

    public function isMeasuredSearchServiceEnabled() {
        return (bool) Mage::getStoreConfig('instantsearch_section/configuration_group/measuredsearch_service_field');
    }

    public function getBatchSize() {
        return 500;
    }

    public function getVisibilityScope() {
        return array(Mage_Catalog_Model_Product_Visibility :: VISIBILITY_IN_SEARCH,
            Mage_Catalog_Model_Product_Visibility :: VISIBILITY_BOTH);
    }
}
