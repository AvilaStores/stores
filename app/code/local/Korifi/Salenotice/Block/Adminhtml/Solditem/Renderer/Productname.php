<?php
/**
 * Developed by Korifi Company.
 * Author: Linh <linh@korifi.vn>
 * Date: 1/8/14  Time: 10:34 AM
 * For more Magento Extensions, please check out http://hotextension.com
 */
class Korifi_Salenotice_Block_Adminhtml_Solditem_Renderer_Productname extends  Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{

    public function render(Varien_Object $row)
    {
        $value =  $row->getData($this->getColumn()->getIndex());
        $_product= Mage::getModel('catalog/product')->load($value);
        return $_product->getName();
    }
}