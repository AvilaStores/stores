<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Google_Dataannotation {
    
    protected $_options;
    const DATA_ANNOTATION_NONE   = 'none';
    const DATA_ANNOTATION_BUBBLE = 'bubble';
	const DATA_ANNOTATION_INLINE = 'inline';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::DATA_ANNOTATION_NONE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('None')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_ANNOTATION_BUBBLE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Bubble')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_ANNOTATION_INLINE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Inline')
			);
		}
		return $this->_options;
	}
}