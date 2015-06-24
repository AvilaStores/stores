<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Facebook_Datashowfaces {
    
    protected $_options;
    const DATA_SHOW_FACES_FALSE = 'false';
	const DATA_SHOW_FACES_TRUE  = 'true';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::DATA_SHOW_FACES_FALSE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('False')
			);
			$this->_options[] = array(
			   'value'=>self::DATA_SHOW_FACES_TRUE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('True')
			);
		}
		return $this->_options;
	}
}