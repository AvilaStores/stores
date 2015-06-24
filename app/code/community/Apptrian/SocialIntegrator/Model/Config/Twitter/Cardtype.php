<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Twitter_Cardtype {
    
    protected $_options;
    const CARD_TYPE_SUMMARY             = 'summary';
    const CARD_TYPE_SUMMARY_LARGE_IMAGE = 'summary_large_image';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::CARD_TYPE_SUMMARY,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Summary')
			);
            $this->_options[] = array(
			   'value'=>self::CARD_TYPE_SUMMARY_LARGE_IMAGE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Summary With Large Image')
			);
		}
		return $this->_options;
	}
}