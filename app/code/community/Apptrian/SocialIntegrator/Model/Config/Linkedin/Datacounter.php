<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Linkedin_Datacounter {
    
    protected $_options;
    const DATA_COUNTER_DISABLED = 'disabled';
    const DATA_COUNTER_RIGHT    = 'right';
	const DATA_COUNTER_TOP      = 'top';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::DATA_COUNTER_DISABLED,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Disabled')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_COUNTER_RIGHT,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Right')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_COUNTER_TOP,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Top')
			);
		}
		return $this->_options;
	}
}