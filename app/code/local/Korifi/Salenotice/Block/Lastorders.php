<?php
/**
 * Developed by Korifi Company.
 * Author: Linh <linh@korifi.vn>
 * Date: 1/7/14  Time: 11:05 AM
 * For more Magento Extensions, please check out http://hotextension.com
 */
 class Korifi_Salenotice_Block_Lastorders extends Mage_Core_Block_Template{

     function _toHtml(){
         return $this->getScript();
     }
     function getLastOrdersCollection(){
         $collection = Mage::getModel('sales/order')->getCollection();
         $collection->getSelect()->join(array('order_address'=>'sales_flat_order_address'),'order_address.parent_id = main_table.entity_id',array('order_address.city','order_address.region','order_address.country_id'));
         $collection->addAttributeToFilter('main_table.store_id',Mage::app()->getStore()->getId());
         $collection->addAttributeToFilter('order_address.address_type','shipping');
         $collection->setOrder('main_table.created_at','desc');
         $collection->setPageSize(Mage::helper('salenotice')->getLimitLastOrder());

         return $collection;
     }

     function getOrderItemCollection($_orderId){
         $collection = Mage::getModel('sales/order_item')->getCollection();
         $collection->addAttributeToFilter('store_id',Mage::app()->getStore()->getId());
         $collection->addAttributeToFilter('order_id',$_orderId);
         return $collection;

     }

     function getSoldItems(){
         $_helper = $this->helper('catalog/output');
         $data = array();
        if(Mage::helper('salenotice')->getDataUsing()){
             // using actual orders
            $collection = $this->getLastOrdersCollection();
            $data = array();
            foreach($collection as $c){ //print"<pre>"; print_r($c->getData()); exit;
                $_items =  $this->getOrderItemCollection($c->getId());
                foreach($_items as $_item){
                    $_product = Mage::getModel('catalog/product')->load($_item->getProductId());
                    $_img = '<img width="50" height="50" src="'.Mage::helper('catalog/image')->init($_product, 'image')->resize(50).'" alt="" title="" />';
                    $shipping_address = $c->getCity();
                    if($c->getRegion()){
                        $shipping_address.=','.$c->getRegion();
                    }
                    if($c->getCountryId()){
                        $shipping_address.=', '.Mage::app()->getLocale()->getCountryTranslation($c->getCountryId());
                    }

                    $output = '<div class="salenotice"><div class="notice-img">'.$_helper->productAttribute($_product, $_img, 'image').'</div><div class="notice-text">'.Mage::helper("salenotice")->__("Someone in %s bought",$shipping_address);                    
                    $output.='<a class="notice-product-link" href="'.$_product->getProductUrl().'">'.$_product->getName().'</a><div class="time-ago">'.Mage::helper('salenotice')->getTimeAgo($c->getCreatedAt()).'</div></div></div>';
                    array_push($data,$output);
                }
            }

        }else{
            // using dummy data
            $collection = Mage::getModel('salenotice/solditem')->getCollection();
            $collection->addStoreFilter(array('store_id'=>Mage::app()->getStore()->getId()));
            $i=0; foreach($collection as $key => $_item){
                //print"<pre>"; print_r($_item->getData()); exit;
                $_product = Mage::getModel('catalog/product')->load($_item->getProductId());
                $_img = '<img width="50" height="50" src="'.Mage::helper('catalog/image')->init($_product, 'image')->resize(50).'" alt="" title="" />';
                $output = '<div class="salenotice"><div class="notice-img">'.$_helper->productAttribute($_product, $_img, 'image').'</div><div class="notice-text">'.Mage::helper("salenotice")->__("Someone in %s bought",$_item->getShippingAddress());
                $output.='<a class="notice-product-link" href="'.$_product->getProductUrl().'">'.$_product->getName().'</a><div class="time-ago">'.$_item->getOrderTime().' ago</div></div></div>';
                $data[$i] = $output;
                $i++;
            }
        }
        return $data;
     }


     function getScript(){
		$data = $this->getSoldItems();
		if(count($data)==0){
			return;
		}
         $output='<script>';
         $output.='function soldItemNotification(){';
         $output.='var data = Array();';
         
         for($i=0; $i < count($data); $i++){
             $output.= "data[".($i+1)."] = '".Mage::helper('core')->jsQuoteEscape($data[$i])."';";
         }
         $output.='var no=Math.floor((Math.random()*'.count($data).')+1);';
         $output.='jQuery.notify({inline: true,html: data[no],close: \'<a href="javascript:void(0)"><span>x</span></a>\'}, '.Mage::helper('salenotice')->getTimeDisplay().');';
         $output.='setTimeout("soldItemNotification()",'.Mage::helper('salenotice')->getTimeDelay().' )};';
         $output.='jQuery(document).ready(function () {setTimeout("soldItemNotification()",'.Mage::helper('salenotice')->getFirstTime().');});';
         $output.='</script>';
         return $output;
     }
 }