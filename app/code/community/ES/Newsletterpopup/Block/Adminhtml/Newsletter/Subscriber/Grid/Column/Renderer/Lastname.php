<?php
class ES_Newsletterpopup_Block_Adminhtml_Newsletter_Subscriber_Grid_Column_Renderer_Lastname
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $rowValue = $row->getCustomerLastname();
        if (empty($rowValue)) {
            $rowValue = $row->getSubscriberLastname();
        }
        if (empty($rowValue)) {
            $rowValue = '---';
        }
        return $rowValue;
    }
}