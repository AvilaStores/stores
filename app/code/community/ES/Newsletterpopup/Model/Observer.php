<?php

class ES_Newsletterpopup_Model_Observer
{
    public function beforeSaveSubscriber($observer)
    {
        $subscriber = $observer->getEvent()->getSubscriber();
        $modelSubscriber = Mage::getModel('newsletterpopup/subscriber');
        if ($additionalFields = $modelSubscriber->getAdditionalFields()) {
            $postData = Mage::app()->getRequest()->getPost();
            foreach ($additionalFields as $field) {
                $field['name'] = str_replace('subscriber_', '', $field['name']);
                if (isset($postData[$field['name']])) {
                    $subscriber->setData('subscriber_' . $field['name'], $postData[$field['name']]);
                }
            }
        }

        if (!Mage::getStoreConfig('newsletterpopup/coupon/isactive') || !$subscriber->isObjectNew()) {
            return;
        }

        $code = $modelSubscriber->getCouponCode();
        if (!empty($code)) {
            $subscriber->setCouponCode($code);
        }
    }

    public function afterConfigSave($observer)
    {
        Mage::getModel('newsletterpopup/subscriber')->updateDbColumns();
    }

}