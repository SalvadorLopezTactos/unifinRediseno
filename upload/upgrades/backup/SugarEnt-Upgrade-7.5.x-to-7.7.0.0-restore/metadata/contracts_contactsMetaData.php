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




$dictionary['contracts_contacts'] = array (
	'table' => 'contracts_contacts',
	'fields' => array (
		array('name' => 'id', 'type' => 'varchar', 'len' => '36'),
		array('name' => 'contact_id', 'type' => 'varchar', 'len' => '36'),
		array('name' => 'contract_id', 'type' => 'varchar', 'len' => '36'),
		array('name' => 'date_modified', 'type' => 'datetime'),
		array('name' => 'deleted', 'type' => 'bool', 'len' => '1', 'default' => '0', 'required' => false),
	),
	'indices' => array (
		array('name' => 'contracts_contacts_pk', 'type' =>'primary', 'fields'=>array('id')),
		array('name' => 'contracts_contacts_alt', 'type'=>'alternate_key', 'fields'=>array('contact_id','contract_id')),
	),
	'relationships' => array (
		'contracts_contacts' => array(
			'lhs_module' => 'Contracts',
			'lhs_table' => 'contracts',
			'lhs_key' => 'id',
			'rhs_module' => 'Contacts',
			'rhs_table' => 'contacts',
			'rhs_key' => 'id',
			'relationship_type' => 'many-to-many',
			'join_table' => 'contracts_contacts',
			'join_key_lhs' => 'contract_id',
			'join_key_rhs' => 'contact_id',
		),
	),
);
?>
