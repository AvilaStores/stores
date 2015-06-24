<?php

class MeasuredSearch_InstantSearch_Model_Observer extends Varien_Event_Observer {

    public function __construct() {
    }

    public function catalog_product_save_after($observer) {
        Mage::log("Product after_save event triggered", null, 'measuredsearch.log');
        $helper = Mage::helper('measuredsearch_instantsearch');
        $event = $observer->getEvent();
        $product = $event->getProduct();
        $collection = $helper->getCollection();
        $product_id = $product->getId();
        if ($product->hasDataChanges()) {
            Mage::log("Product ".$product_id." changed", null, 'measuredsearch.log');
            try {
                $helper->deleteProduct($product_id);
                $productDetails = $helper->getProductDetails($product);
                if ($helper->isVisibleInSearch($product) && !$helper->isDisabled($product)) {
                    $helper->uploadProductData($productDetails);
                }
            } catch (Exception $e) {
                Mage::log($e->getTraceAsString(), null, 'measuredsearch.log');
            }
        } else {
            Mage::log("Product ".$product_id." not changed", null, 'measuredsearch.log');
        }
        return $this;
    }

    public function processProductAfterDeleteEvent($observer) {
        $event = $observer->getEvent();
        $product = $event->getProduct();
        $product_id = $product->getId();
        $helper = Mage::helper('measuredsearch_instantsearch');
        Mage::log('Deleting ' . $product_id, null, 'measuredsearch.log');
        $helper->deleteProduct($product_id);
        return $this;
    }
	//checkout_cart_add_product_complete
	public function afterAddToCart($observer) 
	{	
		$active = Mage::helper('measuredsearch_instantsearch')->isMeasuredSearchServiceEnabled();
		if(!$active)
		{
			return ;
		}
		$event = $observer->getEvent();
		$product = $event->getProduct();
		$request = $event->getRequest();
		$response = $event->getResponse();
		if(!$product instanceof Mage_Catalog_Model_Product)
		{
			return;
		}
		
		if (!$product->getId()) {
            return;
        }
		
        $product = Mage::getModel('catalog/product')->load($product->getId());
 
        
 
        $categories = $product->getCategoryIds();
		$categoryArray=array();
		foreach($categories as $categoryId)
		{
			$categoryArray[]=Mage::getModel('catalog/category')->load($categoryId)->getName();
		}
		$categoryName=implode('|',$categoryArray);
        Mage::getModel('core/session')->setProductToShoppingCart(
            new Varien_Object(array(
                'id' => $product->getId(),
				'sku'=>$product->getSku(),
                'qty' => $request->getParam('qty', 1),
                'name' => $product->getName(),
                'price' => $product->getFinalPrice(),
                'category_name' => $categoryName,
            ))
        );
    }
	
	
	
	
}
