<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Parent_Buttons {
    
    protected $_options;
	const PARENT_CONTENT    = 'content';
	const PARENT_LEFT       = 'left';
	const PARENT_RIGHT      = 'right';
    const PARENT_FOOTER     = 'footer';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
					'value'=>self::PARENT_CONTENT,
					'label'=>Mage::helper('apptrian_socialintegrator')->__('Content (content)')
			);
			$this->_options[] = array(
					'value'=>self::PARENT_LEFT,
					'label'=>Mage::helper('apptrian_socialintegrator')->__('Left (left)')
			);
			$this->_options[] = array(
					'value'=>self::PARENT_RIGHT,
					'label'=>Mage::helper('apptrian_socialintegrator')->__('Right (right)')
			);
			$this->_options[] = array(
					'value'=>self::PARENT_FOOTER,
					'label'=>Mage::helper('apptrian_socialintegrator')->__('Footer (footer)')
			);
		}
		return $this->_options;
	}
}