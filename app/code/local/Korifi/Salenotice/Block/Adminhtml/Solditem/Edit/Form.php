<?php
/**
 * Developed by Korifi Company.
 * Author: Linh <linh@korifi.vn>
 * Date: 1/8/14  Time: 9:25 AM
 * For more Magento Extensions, please check out http://hotextension.com
 */
class Korifi_Salenotice_Block_Adminhtml_Solditem_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form(array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post',
                'enctype' =>'multipart/form-data'
            )
        );

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }

}