<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();
$table = $installer->getTable('newsletter/subscriber');

$installer->run(
 "ALTER TABLE `{$table}`
	ADD COLUMN `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At' AFTER `change_status_at`;");

$installer->endSetup();