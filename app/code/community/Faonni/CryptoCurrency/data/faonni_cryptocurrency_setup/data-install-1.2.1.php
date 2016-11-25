<?php
/**
 * Faonni Group
 *  
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade module to newer
 * versions in the future.
 * 
 * @package     Faonni_CryptoCurrency
 * @copyright   Copyright (c) 2016 Faonni Group(support@faonni.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();
$tables = $connection->listTables();

foreach ($tables as $tableName){
	$columns = $connection->describeTable($tableName);
	foreach ($columns as $column){
		if ($column['DATA_TYPE'] == 'decimal' && $column['PRECISION'] == 12) {
			$connection->modifyColumn($tableName, $column['COLUMN_NAME'], 'decimal(18,10)');
		} elseif ($column['DATA_TYPE'] == 'varchar' && false !== strpos($column['COLUMN_NAME'], 'currency_code') && $column['LENGTH'] < 5) {
			$connection->modifyColumn($tableName, $column['COLUMN_NAME'], 'varchar(5)');
		} elseif ($column['DATA_TYPE'] == 'varchar' && false !== strpos($column['COLUMN_NAME'], 'currency_') && $column['LENGTH'] < 5) {
			$connection->modifyColumn($tableName, $column['COLUMN_NAME'], 'varchar(5)');
		}	
	}
}

$installer->endSetup();