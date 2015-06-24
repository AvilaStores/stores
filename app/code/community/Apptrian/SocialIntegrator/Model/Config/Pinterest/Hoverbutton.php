<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Pinterest_Hoverbutton {
    
    protected $_options;
    const HOVER_BUTTON_OFF           = 'off';
    const HOVER_BUTTON_PRODUCT_PAGES = 'product_pages';
	const HOVER_BUTTON_GLOBAL        = 'global';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::HOVER_BUTTON_OFF,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Do Not Show')
			);
            $this->_options[] = array(
			   'value'=>self::HOVER_BUTTON_PRODUCT_PAGES,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Only On Product Pages')
			);
            $this->_options[] = array(
			   'value'=>self::HOVER_BUTTON_GLOBAL,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Global')
			);
		}
		return $this->_options;
	}
}