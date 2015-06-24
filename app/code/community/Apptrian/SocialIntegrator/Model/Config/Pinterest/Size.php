<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Pinterest_Size {
    
    protected $_options;
    const SIZE_SMALL = 'small';
    const SIZE_LARGE = 'large';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::SIZE_SMALL,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Small')
			);
            $this->_options[] = array(
			   'value'=>self::SIZE_LARGE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Large')
			);
		}
		return $this->_options;
	}
}