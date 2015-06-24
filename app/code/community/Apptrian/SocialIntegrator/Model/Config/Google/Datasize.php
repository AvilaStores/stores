<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Google_Datasize {
    
    protected $_options;
    const DATA_SIZE_SMALL    = 'small';
    const DATA_SIZE_MEDIUM   = 'medium';
	const DATA_SIZE_STANDARD = 'standard';
    const DATA_SIZE_TALL     = 'tall';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::DATA_SIZE_SMALL,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Small')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_SIZE_MEDIUM,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Medium')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_SIZE_STANDARD,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Standard')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_SIZE_TALL,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Tall')
			);
		}
		return $this->_options;
	}
}