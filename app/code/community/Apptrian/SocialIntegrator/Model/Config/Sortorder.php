<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Model_Config_Sortorder extends Mage_Core_Model_Config_Data
{
    
    public function _beforeSave()
    {
    
        $result = $this->validate();
        
        if ($result !== true) {
            
            Mage::throwException(implode("\n", $result));
            
        }
        
        return parent::_beforeSave();
        
    }
    
    public function validate()
    {
        
        $errors = array();
        $helper = Mage::helper('apptrian_socialintegrator');
        $value  = $this->getValue();
        
        if (!Zend_Validate::is($value, 'Regex', array('pattern' => '/^[0-9,]+$/'))) {
            $errors[] = $helper->__('Sort order is not valid.');
        }
        
        if (empty($errors)) {
            return true;
        }
        
        return $errors;
        
    }
    
}