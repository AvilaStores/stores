<?php

class ES_Newsletterpopup_Model_Subscriber
{
    const XML_PATH_EMAIL_ATTACHMENT = 'newsletterpopup/email/attachment';

    public function getCouponCode()
    {
        $rule = Mage::getModel('salesrule/rule');
        $rule->load(Mage::getStoreConfig('newsletterpopup/coupon/roleid'));
        if (!$rule->getId()) {
            return;
        }

        if ($rule->getUseAutoGeneration() == 1) {
            $code = $this->generateCouponCode($rule);
        } else {
            $code = $rule->getCouponCode();
        }

        return $code;
    }

    protected function generateCouponCode($rule)
    {
        $massGenerator = $rule->getCouponMassGenerator();
        $massGenerator->setData(array(
            'rule_id' => Mage::getStoreConfig('newsletterpopup/coupon/roleid'),
            'qty' => 1,
            'length' => Mage::getStoreConfig('newsletterpopup/coupon/length'),
            'format' => Mage::getStoreConfig('newsletterpopup/coupon/format'),
            'prefix' => Mage::getStoreConfig('newsletterpopup/coupon/prefix'),
            'suffix' => Mage::getStoreConfig('newsletterpopup/coupon/suffix'),
            'dash' => Mage::getStoreConfig('newsletterpopup/coupon/dash'),
            'uses_per_coupon' => 1,
            'uses_per_customer' => 1
        ));
        $massGenerator->generatePool();
        $latestCoupon = max($rule->getCoupons());

        return $latestCoupon->getCode();
    }

    public function updateDbColumns()
    {
        if ($fields = $this->getAdditionalFields()) {
            $resource = Mage::getSingleton('core/resource');
            $readConnection = $resource->getConnection('core_read');
            $tableName = $resource->getTableName('newsletter/subscriber');
            $existingColumns = $readConnection->describeTable($tableName);
            if (count($existingColumns) == 0)
                return;


            $resource = Mage::getSingleton('core/resource');
            $table = $resource->getTableName('newsletter/subscriber');
            $writeConnection = $resource->getConnection('core_write');

            foreach ($fields as $field) {
                if (!isset($field['name']) || empty($field['name']) || isset($existingColumns[$field['name']]))
                    continue;
                $writeConnection->query('ALTER TABLE ' . $table . ' ADD ' . $field['name'] . ' VARCHAR(255)');
            }
        }
    }

    public function getAdditionalFields()
    {
        $fields = unserialize(Mage::getStoreConfig('newsletterpopup/popup/fields'));
        if (!is_array($fields) || count($fields) == 0)
            return false;

        usort($fields , array('ES_Newsletterpopup_Model_Subscriber', 'comparePosition'));

        foreach ($fields as $key => $field) {
            $fields[$key]['name'] = 'subscriber_'.$field['name'];
        }

        return $fields;
    }

    static public function comparePosition($a, $b)
    {
        if ($a['position'] < $b['position'])
            return 0;
        return 1;
    }

    public function isValidAdditional($data)
    {
        if ($additionalFields = $this->getAdditionalFields()) {
            foreach ($additionalFields as $field) {
                $field['name'] = str_replace('subscriber_', '', $field['name']);
                if (!isset($data[$field['name']]))
                    continue;
                $value = $data[$field['name']];
                if ((empty($value) || md5($value) == md5($field['label']))
                    && $field['required'] == 1
                ) {
                    Mage::throwException(Mage::helper('newsletterpopup')->__('Field "%s" is required', $field['label']));
                }
            }
        }
        return true;
    }
}