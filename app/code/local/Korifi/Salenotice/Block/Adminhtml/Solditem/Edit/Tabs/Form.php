<?php
/**
 * Developed by Korifi Company.
 * Author: Linh <linh@korifi.vn>
 * Date: 1/8/14  Time: 9:26 AM
 * For more Magento Extensions, please check out http://hotextension.com
 */
class Korifi_Salenotice_Block_Adminhtml_Solditem_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareLayout(){

        return parent::_prepareLayout();
    }

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('solditem_form', array('legend' => Mage::helper('salenotice')->__('General')));

        $fieldset->addField('product_id', 'text', array(
            'label' => Mage::helper('salenotice')->__('Product ID'),
            'required' => true,
            'title' => 'Product ID',
            'name' => 'product_id',
            'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
        ));

        $fieldset->addField('shipping_address', 'text', array(
            'label' => Mage::helper('salenotice')->__('Shipping Address'),
            'title' => 'Shipping Address',
            'name' => 'shipping_address',
            'required' => true,
        ));

        $fieldset->addField('order_time', 'text', array(
            'label' => Mage::helper('salenotice')->__('Time ago'),
            'title' => 'Time ago',
            'name' => 'order_time',
            'required' => true,
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'multiselect', array(
                'name' => 'stores[]',
                'label' => Mage::helper('salenotice')->__('Store View'),
                'title' => Mage::helper('salenotice')->__('Store View'),
                'required' => true,
                'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
        }



        if (Mage::getSingleton('adminhtml/session')->getItemData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getItemData());
            Mage::getSingleton('adminhtml/session')->setItemData(null);
        } elseif (Mage::registry('item_data')) {
            $form->setValues(Mage::registry('item_data')->getData());
        }

        return parent::_prepareForm();
    }

}