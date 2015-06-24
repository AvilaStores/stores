<?php
class ES_Newsletterpopup_Block_Adminhtml_Newsletter_Subscriber_Grid
    extends Mage_Adminhtml_Block_Newsletter_Subscriber_Grid
{
    protected function _prepareColumns()
    {
        $subscriberModel = Mage::getModel('newsletterpopup/subscriber');
        $additionalFields = $subscriberModel->getAdditionalFields();
        if ($additionalFields) {
            $lastColumn = 'lastname';
            foreach ($additionalFields as $field) {
                if ($field['name'] == 'subscriber_firstname' || $field['name'] == 'subscriber_lastname') {
                    continue;
                }

                $this->addColumnAfter($field['name'], array(
                    'header'    => $field['label'],
                    'index'     => $field['name'],
                    'default'   => '---',
                ), $lastColumn);
                $lastColumn = $field['name'];
            }
        }

        parent::_prepareColumns();

        if ($additionalFields) {
            foreach ($additionalFields as $field) {
                if ($field['name'] == 'subscriber_firstname') {
                    $this->getColumn('firstname')->setData('renderer', 'newsletterpopup/adminhtml_newsletter_subscriber_grid_column_renderer_firstname');
                } elseif ($field['name'] == 'subscriber_lastname') {
                    $this->getColumn('lastname')->setData('renderer', 'newsletterpopup/adminhtml_newsletter_subscriber_grid_column_renderer_lastname');
                }
            }
        }

        return $this;
    }
}