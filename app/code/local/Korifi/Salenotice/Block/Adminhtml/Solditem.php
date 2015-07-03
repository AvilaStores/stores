<?php
/**
 * Developed by Korifi Company.
 * Author: Linh <linh@korifi.vn>
 * Date: 1/8/14  Time: 9:19 AM
 * For more Magento Extensions, please check out http://hotextension.com
 */
class Korifi_Salenotice_Block_Adminhtml_Solditem extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_controller = 'adminhtml_solditem';
        $this->_blockGroup = 'salenotice';
        $this->_headerText = Mage::helper('salenotice')->__('Sold Item Notification');
        $this->_addButtonLabel = Mage::helper('salenotice')->__('Add New Item');
        parent::__construct();
    }

}