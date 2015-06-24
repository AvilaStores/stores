<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Pinterest_Datapincolor {
    
    protected $_options;
    const DATA_PIN_COLOR_GRAY  = 'gray';
    const DATA_PIN_COLOR_RED   = 'red';
	const DATA_PIN_COLOR_WHITE = 'white';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::DATA_PIN_COLOR_GRAY,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Gray')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_PIN_COLOR_RED,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Red')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_PIN_COLOR_WHITE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('White')
			);
		}
		return $this->_options;
	}
}