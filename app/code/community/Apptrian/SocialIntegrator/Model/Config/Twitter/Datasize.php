<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Twitter_Datasize {
    
    protected $_options;
    const DATA_SIZE_MEDIUM = 'medium';
    const DATA_SIZE_LARGE  = 'large';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::DATA_SIZE_MEDIUM,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Medium')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_SIZE_LARGE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Large')
			);
		}
		return $this->_options;
	}
}