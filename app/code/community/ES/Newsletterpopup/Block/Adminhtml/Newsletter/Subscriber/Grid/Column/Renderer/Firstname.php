<?php
class ES_Newsletterpopup_Block_Adminhtml_Newsletter_Subscriber_Grid_Column_Renderer_Firstname
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $rowValue = $row->getCustomerFirstname();
        if (empty($rowValue)) {
            $rowValue = $row->getSubscriberFirstname();
        }
        if (empty($rowValue)) {
            $rowValue = '---';
        }
        return $rowValue;
    }
}