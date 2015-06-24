<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Twitter_Secondarydata {
    
    protected $_options;
    const SECONDARY_DATA_CATEGORY = 'category';
    const SECONDARY_DATA_LOCATION = 'location';
    const SECONDARY_DATA_WEBSITE  = 'website';
    
    public function toOptionArray(){
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::SECONDARY_DATA_CATEGORY,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Category')
			);
            $this->_options[] = array(
			    'value'=>self::SECONDARY_DATA_LOCATION,
			    'label'=>Mage::helper('apptrian_socialintegrator')->__('Location')
			);
            $this->_options[] = array(
                'value'=>self::SECONDARY_DATA_WEBSITE,
                'label'=>Mage::helper('apptrian_socialintegrator')->__('Website')
            );
		}
		return $this->_options;
	}
}