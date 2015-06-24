<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Pages {
    
    protected $_options;
    const PAGES_PRODUCT  = 'product';
    const PAGES_CATEGORY = 'category';
	const PAGES_CMS      = 'cms';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::PAGES_PRODUCT,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Product Pages')
			);
			$this->_options[] = array(
					'value'=>self::PAGES_CATEGORY,
					'label'=>Mage::helper('apptrian_socialintegrator')->__('Category Pages')
			);
			$this->_options[] = array(
			   'value'=>self::PAGES_CMS,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('CMS Pages')
			);
		}
		return $this->_options;
	}
}