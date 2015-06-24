<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Pinterest_Datapinshape {
    
    protected $_options;
    const DATA_PIN_SHAPE_ROUND     = 'round';
    const DATA_PIN_SHAPE_RECTANGLE = 'rectangle';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::DATA_PIN_SHAPE_ROUND,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Circular')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_PIN_SHAPE_RECTANGLE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Rectangular')
			);
		}
		return $this->_options;
	}
}