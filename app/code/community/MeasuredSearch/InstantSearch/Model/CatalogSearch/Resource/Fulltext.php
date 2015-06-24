<?php
class MeasuredSearch_InstantSearch_Model_CatalogSearch_Resource_Fulltext extends Mage_CatalogSearch_Model_Resource_Fulltext {

    const PER_PAGE = 100;

    /**
     * Overloaded method prepareResult.
     * Prepare results for query.
     * Replaces the traditional fulltext search with a Measured Search (if active).
     *
     * @param Mage_CatalogSearch_Model_Fulltext $object
     * @param string $queryText
     * @param Mage_CatalogSearch_Model_Query $query
     * @return MeasuredSearch_Model_CatalogSearch_Resource_Fulltext
     */
    public function prepareResult($object, $queryText, $query) {
        $helper = Mage::helper('measuredsearch_instantsearch');

        if(!$helper->isMeasuredSearchServiceEnabled()) {
            Mage::log('Fulltext Search: Measured Search service is disabled', null, 'measuredsearch.log');
            return parent::prepareResult($object, $queryText, $query);
        }

        Mage::log('Fulltext Search: Measured Search service is enabled', null, 'measuredsearch.log');
        $adapter = $this->_getWriteAdapter();

        try {
            $ms_base_url = $helper->getBaseUrl();
            $ms_collection = $helper->getCollection();
            $ms_key = $helper->getSecretKey();
            $ms_request_url = $ms_base_url . "collection/" . $ms_collection . "/search/?key=" . $ms_key . "&q=" . urlencode($queryText) . "&rows=" . self::PER_PAGE;
            //echo $ms_request_url;

            $ch = curl_init($ms_request_url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            $result = curl_exec($ch);
            curl_close($ch);
            Mage::log('Fulltext Search ---- '.$ms_request_url, null, 'measuredsearch.log');

            $decoded_json = json_decode($result, true);
            $results_meta = $decoded_json['meta'];
            $products_data = $decoded_json['results'];

            if ($results_meta['hits'] > 0) {
                $queryId = $query->getId();
                $columns = array('query_id', 'product_id', 'relevance');
                $searchResultTable = $this->getTable('catalogsearch/result');
                $insertRows = array();

                $count = $results_meta['hits'];
                foreach ($products_data as $p) {
                    $insertRows[] = array($queryId, $p['id'], $count);
                    $count = $count - 1;
                }

                $adapter->beginTransaction();
                $adapter->delete($searchResultTable, 'query_id = ' . $queryId);
                $adapter->insertArray($searchResultTable, $columns, $insertRows);
                $adapter->commit();
            }
            $query->setIsProcessed(1);
        } catch (Exception $e) {
            Mage::log($e, null, 'measuredsearch.log');
            return parent::prepareResult($object, $queryText, $query);
        }
        return $this;
    }
}
