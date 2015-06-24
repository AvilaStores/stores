<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Position {
    
    protected $_options;
	const POSITION_AFTER  = 'after';
    const POSITION_BEFORE = 'before';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::POSITION_AFTER,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Bottom (after)')
			);
			$this->_options[] = array(
			   'value'=>self::POSITION_BEFORE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Top (before)')
			);
		}
		return $this->_options;
	}
}