<?php
/**
 * Developed by Korifi Company.
 * Author: Linh <linh@korifi.vn>
 * Date: 1/8/14  Time: 9:10 AM
 * For more Magento Extensions, please check out http://hotextension.com
 */
$installer = $this;

$installer->startSetup();

$installer->run("DROP TABLE IF EXISTS `{$this->getTable('korifi_salenotice_item')}`;
CREATE TABLE `{$this->getTable('korifi_salenotice_item')}` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `order_time` varchar(255) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `{$this->getTable('korifi_salenotice_item_store')}`;
CREATE TABLE `{$this->getTable('korifi_salenotice_item_store')}` (
  `item_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`item_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
$installer->endSetup();