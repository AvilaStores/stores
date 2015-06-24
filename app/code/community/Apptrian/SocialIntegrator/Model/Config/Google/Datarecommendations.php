<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Google_Datarecommendations {
    
    protected $_options;
    const DATA_RECOMMENDATIONS_TRUE  = 'true';
    const DATA_RECOMMENDATIONS_FALSE = 'false';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::DATA_RECOMMENDATIONS_TRUE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('True')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_RECOMMENDATIONS_FALSE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('False')
			);
		}
		return $this->_options;
	}
}