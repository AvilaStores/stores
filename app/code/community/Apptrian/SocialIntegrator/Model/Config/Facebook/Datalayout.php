<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Facebook_Datalayout {
    
    protected $_options;
    const DATA_LAYOUT_STANDARD     = 'standard';
    const DATA_LAYOUT_BOX_COUNT    = 'box_count';
	const DATA_LAYOUT_BUTTON_COUNT = 'button_count';
    const DATA_LAYOUT_BUTTON       = 'button';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::DATA_LAYOUT_STANDARD,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Standard')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_LAYOUT_BOX_COUNT,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Box Count')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_LAYOUT_BUTTON_COUNT,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Button Count')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_LAYOUT_BUTTON,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Button')
			);
		}
		return $this->_options;
	}
}