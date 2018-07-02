<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

// $Id: contracts_productsMetaData.php 55782 2010-04-02 21:07:20Z clee $


$dictionary['contracts_products'] = array (
	'table' => 'contracts_products',
	'fields' => array (
		array('name' => 'id', 'type' => 'varchar', 'len' => '36'),
		array('name' => 'product_id', 'type' => 'varchar', 'len' => '36'),
		array('name' => 'contract_id', 'type' => 'varchar', 'len' => '36'),
		array('name' => 'date_modified', 'type' => 'datetime'),
		array('name' => 'deleted', 'type' => 'bool', 'len' => '1', 'default' => '0', 'required' => false),
	),
	'indices' => array (
		array('name' => 'contracts_prod_pk', 'type' =>'primary', 'fields'=>array('id')),
		array('name' => 'contracts_prod_alt', 'type'=>'alternate_key', 'fields'=>array('contract_id', 'product_id')),
	),
	'relationships' => array (
		'contracts_products' => array(
			'lhs_module' => 'Contracts',
			'lhs_table' => 'contracts',
			'lhs_key' => 'id',
			'rhs_module' => 'Products',
			'rhs_table' => 'products',
			'rhs_key' => 'id',
			'relationship_type' => 'many-to-many',
			'join_table' => 'contracts_products',
			'join_key_lhs' => 'contract_id',
			'join_key_rhs' => 'product_id'
		),
	),
);
?>
