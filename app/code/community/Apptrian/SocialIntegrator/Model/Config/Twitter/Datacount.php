<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Twitter_Datacount {
    
    protected $_options;
    const DATA_COUNT_NONE       = 'none';
    const DATA_COUNT_HORIZONTAL = 'horizontal';
	const DATA_COUNT_VERTICAL   = 'vertical';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::DATA_COUNT_NONE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('None')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_COUNT_HORIZONTAL,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Horizontal')
			);
            $this->_options[] = array(
			   'value'=>self::DATA_COUNT_VERTICAL,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Vertical')
			);
		}
		return $this->_options;
	}
}