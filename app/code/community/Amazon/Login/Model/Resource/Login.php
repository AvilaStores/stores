<?php
/**
 * Login with Amazon
 *
 * @category    Amazon
 * @package     Amazon_Login
 * @copyright   Copyright (c) 2014 Amazon.com
 * @license     http://opensource.org/licenses/Apache-2.0  Apache License, Version 2.0
 */

class Amazon_Login_Model_Resource_Login extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('amazon_login/login', 'login_id');
    }
}
