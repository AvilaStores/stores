<?php
class Avilastores_ProductUpdates_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/productupdates?id=15 
    	 *  or
    	 * http://site.com/productupdates/id/15 	
    	 */
    	/* 
		$productupdates_id = $this->getRequest()->getParam('id');

  		if($productupdates_id != null && $productupdates_id != '')	{
			$productupdates = Mage::getModel('productupdates/productupdates')->load($productupdates_id)->getData();
		} else {
			$productupdates = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($productupdates == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$productupdatesTable = $resource->getTableName('productupdates');
			
			$select = $read->select()
			   ->from($productupdatesTable,array('productupdates_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$productupdates = $read->fetchRow($select);
		}
		Mage::register('productupdates', $productupdates);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}