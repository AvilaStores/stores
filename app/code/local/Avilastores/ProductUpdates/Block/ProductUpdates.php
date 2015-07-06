<?php
class Avilastores_ProductUpdates_Block_ProductUpdates extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getProductUpdates()     
     { 
        if (!$this->hasData('productupdates')) {
            $this->setData('productupdates', Mage::registry('productupdates'));
        }
        return $this->getData('productupdates');
        
    }
}