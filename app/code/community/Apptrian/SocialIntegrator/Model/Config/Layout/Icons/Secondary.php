<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Layout_Icons_Secondary {
    
    protected $_options;
	const LAYOUT_HORIZONTAL = 'secondary-social-icons-horizontal-layout';
    const LAYOUT_VERTICAL   = 'secondary-social-icons-vertical-layout';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::LAYOUT_HORIZONTAL,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Horizontal')
			);
			$this->_options[] = array(
			   'value'=>self::LAYOUT_VERTICAL,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Vertical')
			);		
		}
		return $this->_options;
	}
}
