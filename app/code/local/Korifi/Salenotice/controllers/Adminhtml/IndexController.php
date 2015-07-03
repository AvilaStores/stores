<?php
/**
 * Developed by Korifi Company.
 * Author: Linh <linh@korifi.vn>
 * Date: 1/8/14  Time: 8:48 AM
 * For more Magento Extensions, please check out http://hotextension.com
 */
 class Korifi_Salenotice_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action{

     protected function _initAction() {
         $this->loadLayout()
             ->_setActiveMenu('sales/notify')
             ->_addBreadcrumb(Mage::helper('adminhtml')->__('salenotice'), Mage::helper('adminhtml')->__('Sold Item Notification'));
         return $this;
     }

     function indexAction(){
         $this->_initAction();
         $this->_addContent($this->getLayout()->createBlock('salenotice/adminhtml_solditem'));
         $this->renderLayout();
     }

     function newAction(){
         $this->_forward('edit');
     }

     function editAction(){
         $_item_id = $this->getRequest()->getParam('id');
         $_item = Mage::getModel('salenotice/solditem')->load($_item_id);
         if($_item_id==0 || $_item->getItemId()){
             Mage::register('item_data', $_item);
             $this->loadLayout();
             $this->_setActiveMenu('sales/notify');
             $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Sold Item Notification'), Mage::helper('adminhtml')->__('Sold Item Notification'));
             $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
             $this->_addContent($this->getLayout()->createBlock('salenotice/adminhtml_solditem_edit'))
                 ->_addLeft($this->getLayout()->createBlock('salenotice/adminhtml_solditem_edit_tabs'));

             $this->renderLayout();
         }else{
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('salenotice')->__('Item does not exist'));
             $this->_redirect('*/*/');
         }
     }

     function saveAction(){
         if ($data = $this->getRequest()->getPost()) {
             try {

                 $model = Mage::getModel('salenotice/solditem');
                 $model->setData($data);
                 $model->setItemId($this->getRequest()->getParam('id'));
                 $model->save();
                 Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved'));
                 Mage::getSingleton('adminhtml/session')->setFormData(false);

                 if ($this->getRequest()->getParam('back')) {
                     $this->_redirect('*/*/edit', array('id' => $model->getId()));
                     return;
                 }
                 $this->_redirect('*/*/');
                 return;

             }catch (Exception $e){
                 Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                 Mage::getSingleton('adminhtml/session')->setFormData($this->getRequest()->getPost());
                 $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                 return;
             }
         }
         $this->_redirect('*/*/');
     }

     public function massDeleteAction() {
         $itemIds = $this->getRequest()->getParam('soliditemIds');
         if (!is_array($itemIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
         } else {
             try {
                 foreach ($itemIds as $itemId) {
                     $model = Mage::getModel('salenotice/solditem')->load($itemId);
                     $model->delete();

                 }
                 Mage::getSingleton('adminhtml/session')->addSuccess(
                     Mage::helper('adminhtml')->__(
                         'Total of %d record(s) were successfully deleted', count($itemIds)
                     )
                 );
             } catch (Exception $e) {
                 Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
             }
         }
         $this->_redirect('*/*/index');
     }
     public function deleteAction() {
         if( $this->getRequest()->getParam('id') > 0 ) {
             try {
                 $model = Mage::getModel('salenotice/solditem');

                 $model->setId($this->getRequest()->getParam('id'))
                     ->delete();

                 Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                 $this->_redirect('*/*/');
             } catch (Exception $e) {
                 Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                 $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
             }
         }
         $this->_redirect('*/*/');
     }
 }