<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Google_Dataalign {
    
    protected $_options;
    const DATA_ALIGN_LEFT  = 'left';
    const DATA_ALIGN_RIGHT = 'right';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::DATA_ALIGN_LEFT,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Left')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_ALIGN_RIGHT,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Right')
			);
		}
		return $this->_options;
	}
}