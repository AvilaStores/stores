<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Facebook_Dataaction {
    
    protected $_options;
	const DATA_ACTION_LIKE      = 'like';
    const DATA_ACTION_RECOMMEND = 'recommend';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::DATA_ACTION_LIKE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Like')
			);
			$this->_options[] = array(
			   'value'=>self::DATA_ACTION_RECOMMEND,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Recommend')
			);
		}
		return $this->_options;
	}
}