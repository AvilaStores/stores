<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Parent_Icons {
    
    protected $_options;
	const PARENT_AFTER_BODY_START = 'after_body_start';
	const PARENT_TOP_CONTAINER    = 'top_container';
	const PARENT_TOP_MENU         = 'top_menu';
	const PARENT_CONTENT          = 'content';
	const PARENT_LEFT             = 'left';
	const PARENT_RIGHT            = 'right';
    const PARENT_FOOTER           = 'footer';
    const PARENT_BOTTOM_CONTAINER = 'bottom_container';
    const PARENT_BEFORE_BODY_END  = 'before_body_end';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::PARENT_AFTER_BODY_START,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Page Top (after_body_start)')
			);
			$this->_options[] = array(
					'value'=>self::PARENT_TOP_CONTAINER,
					'label'=>Mage::helper('apptrian_socialintegrator')->__('Header (top.container)')
			);
			$this->_options[] = array(
					'value'=>self::PARENT_TOP_MENU,
					'label'=>Mage::helper('apptrian_socialintegrator')->__('Top Menu (top.menu)')
			);
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
			$this->_options[] = array(
					'value'=>self::PARENT_BOTTOM_CONTAINER,
					'label'=>Mage::helper('apptrian_socialintegrator')->__('Footer (bottom.container)')
			);
			$this->_options[] = array(
					'value'=>self::PARENT_BEFORE_BODY_END,
					'label'=>Mage::helper('apptrian_socialintegrator')->__('Page Bottom (before_body_end)')
			);
		}
		return $this->_options;
	}
}