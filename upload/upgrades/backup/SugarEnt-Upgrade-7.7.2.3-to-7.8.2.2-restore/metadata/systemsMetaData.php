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
$dictionary['systems'] = array (
	'table' => 'systems',
    'fields' => array (
		array(
			'name' =>'system_id',
			'type' =>'int',
			'auto_increment'=>true,
			'required'=>true
		),
		array(
			'name' =>'system_key',
			'type' =>'varchar',
			'len'=>'36'
		),
		array(
			'name' =>'user_id',
			'type' =>'id'
		),
		array(
			'name' =>'last_connect_date',
			'type' => 'datetime'
		),
		array(
			'name' =>'disabled',
			'type' =>'bool',
			'len'=>'1', 
			'default'=>'0',
		),
		array (
			'name' => 'date_entered',
			'type' => 'datetime'
		),
	),
	'indices' => array(
		array(
			'name' =>'systems_pk',
			'type' =>'primary',
			'fields'=> array('system_id')
		),
	),
);
?>
