<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Facebook_Datacolorscheme {
    
    protected $_options;
	const DATA_COLOR_SCHEME_LIGHT = 'light';
    const DATA_COLOR_SCHEME_DARK  = 'dark';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::DATA_COLOR_SCHEME_LIGHT,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Light')
			);
			$this->_options[] = array(
			   'value'=>self::DATA_COLOR_SCHEME_DARK,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Dark')
			);
		}
		return $this->_options;
	}
}