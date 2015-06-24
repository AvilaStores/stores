<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Observer
{
	
	public function addCustomHandles(Varien_Event_Observer $observer)
	{
		
		if (Mage::getStoreConfig('apptrian_socialintegrator/general/enabled')) {
		
			// Initialize customHandles array
			$customHandles = array();
			
			$pageType = Mage::helper('apptrian_socialintegrator')->getPageType();
			
			if ($pageType !== null) {
			
				// Get buttons handle if enabled
				if (Mage::getStoreConfig('apptrian_socialintegrator/' . $pageType . '_buttons/enabled')) {
					
					$parent   = Mage::getStoreConfig('apptrian_socialintegrator/' . $pageType . '_buttons/parent');
					$position = Mage::getStoreConfig('apptrian_socialintegrator/' . $pageType . '_buttons/position');
				
					$customHandles[] = 'apptrian_socialintegrator_buttons_' . $parent . '_' . $position;
					
				}
			
			}
			
			// Get primary social icons handle if enabled
			if (Mage::getStoreConfig('apptrian_socialintegrator/primary_icons/enabled')) {
					
				$parent   = Mage::getStoreConfig('apptrian_socialintegrator/primary_icons/parent');
				$position = Mage::getStoreConfig('apptrian_socialintegrator/primary_icons/position');
					
				$customHandles[] = 'apptrian_socialintegrator_primary_icons_' . $parent . '_' . $position;
			
			}
			
			// Get secondary social icons handle if enabled
			if (Mage::getStoreConfig('apptrian_socialintegrator/secondary_icons/enabled')) {
			
				$parent   = Mage::getStoreConfig('apptrian_socialintegrator/secondary_icons/parent');
				$position = Mage::getStoreConfig('apptrian_socialintegrator/secondary_icons/position');
			
				$customHandles[] = 'apptrian_socialintegrator_secondary_icons_' . $parent . '_' . $position;
			
			}
			
			if (count($customHandles) > 0) {
				
				$layout = $observer->getEvent()->getLayout();
				
				foreach ($customHandles as $customHandle) {
					
					$layout->getUpdate()->addHandle($customHandle);
					
				}
				
			}
		
		
		}
		
		return $this;
		
	}
    
	public function addHeadTagPrefix(Varien_Event_Observer $observer)
	{
		
		$name = $observer->getBlock()->getNameInLayout();
		
		if ($name == 'root') {
			
			if (Mage::getStoreConfig('apptrian_socialintegrator/general/enabled')) {
			
				$prefix = Mage::helper('apptrian_socialintegrator')->getHeadTagPrefixAttibute();
				
				if ($prefix) {
					
					// Get html
					$html = $observer->getTransport()->getHtml();
					
					// Set needle and replace string
					$needle  = '<head';
					$replace = '<head ' . $prefix;
						
					$pos = strpos($html, $needle);
					if ($pos !== false) {
						$newHtml = substr_replace($html, $replace, $pos, strlen($needle));
					}
						
					$observer->getTransport()->setHtml($newHtml);
					
				}
			
			}
	
		}
		
		return $this;
		
	}
	
}