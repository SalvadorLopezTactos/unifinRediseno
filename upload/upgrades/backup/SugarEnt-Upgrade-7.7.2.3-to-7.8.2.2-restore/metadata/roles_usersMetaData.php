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
$dictionary['roles_users'] = array ( 

	'table' => 'roles_users',

	'fields' => array (
		array (
			'name' => 'id',
			'type' => 'varchar',
			'len' => '36',
		),
		array (
			'name' => 'role_id',
			'type' => 'varchar',
			'len' => '36',
		),
		array (
			'name' => 'user_id',
			'type' => 'varchar',
			'len' => '36',
		)
      , array ('name' => 'date_modified','type' => 'datetime'),
		array (
			'name' => 'deleted',
			'type' => 'bool',
			'len' => '1',
			'default' => '0'
		),
	),
	
	'indices' => array (
		array (
			'name' => 'roles_userspk',
			'type' => 'primary',
			'fields' => array ( 'id' )
		),
		array (
			'name' => 'idx_ru_role_id',
			'type' => 'index',
			'fields' => array ('role_id')
		),
		array (
			'name' => 'idx_ru_user_id',
			'type' => 'index',
			'fields' => array ('user_id')
		),
	),
	'relationships' => array ('roles_users' => array('lhs_module'=> 'Roles', 'lhs_table'=> 'roles', 'lhs_key' => 'id',
							  'rhs_module'=> 'Users', 'rhs_table'=> 'users', 'rhs_key' => 'id',
							  'relationship_type'=>'many-to-many',
							  'join_table'=> 'roles_users', 'join_key_lhs'=>'role_id', 'join_key_rhs'=>'user_id')),
	
)
                                  
?>