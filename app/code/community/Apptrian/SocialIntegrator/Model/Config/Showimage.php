<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Showimage
{
    
    protected $_options;
    const SHOW_IMAGE_NONE      = 'none';
    const SHOW_IMAGE_IMAGE     = 'image';
    const SHOW_IMAGE_THUMBNAIL = 'thumbnail';
    
    public function toOptionArray()
    {
        if (!$this->_options) {
			$this->_options[] = array(
			   'value'=>self::SHOW_IMAGE_NONE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Do not show')
			);
			$this->_options[] = array(
			   'value'=>self::SHOW_IMAGE_IMAGE,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Image')
			);
            $this->_options[] = array(
			   'value'=>self::SHOW_IMAGE_THUMBNAIL,
			   'label'=>Mage::helper('apptrian_socialintegrator')->__('Thumbnail')
			);
		}
		return $this->_options;
	}
    
}