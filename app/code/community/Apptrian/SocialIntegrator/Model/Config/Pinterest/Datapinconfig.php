<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Pinterest_Datapinconfig {
    
    protected $_options;
    const DATA_PIN_CONFIG_ABOVE  = 'above';
    const DATA_PIN_CONFIG_BESIDE = 'beside';
	const DATA_PIN_CONFIG_NONE   = 'none';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::DATA_PIN_CONFIG_ABOVE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Above')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_PIN_CONFIG_BESIDE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Beside')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_PIN_CONFIG_NONE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('None')
			);
		}
		return $this->_options;
	}
}