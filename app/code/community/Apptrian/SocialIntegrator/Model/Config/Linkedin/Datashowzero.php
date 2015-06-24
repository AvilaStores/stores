<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Linkedin_Datashowzero {
    
    protected $_options;
    const DATA_SHOWZERO_TRUE  = 'true';
    const DATA_SHOWZERO_FALSE = 'false';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::DATA_SHOWZERO_TRUE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('True')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_SHOWZERO_FALSE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('False')
			);
		}
		return $this->_options;
	}
}