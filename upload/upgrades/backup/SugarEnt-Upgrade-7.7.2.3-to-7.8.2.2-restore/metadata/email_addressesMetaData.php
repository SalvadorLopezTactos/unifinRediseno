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

/**
 * Core email_address table
 */
$dictionary['email_addresses'] = array(
	'table'		=> 'email_addresses',
	'fields'	=> array(
		'id' => array(
			'name'			=> 'id',
			'type'			=> 'id',
		    'vname'         => 'LBL_EMAIL_ADDRESS_ID',
			'required'		=> true,
		),
		'email_address' =>array(
			'name'			=> 'email_address',
			'type'			=> 'varchar',
			'vname'         => 'LBL_EMAIL_ADDRESS',
			'length'		=> 100,
			'required'		=> true,
		),
		'email_address_caps' => array(
			'name'			=> 'email_address_caps',
			'type'			=> 'varchar',
		    'vname'         => 'LBL_EMAIL_ADDRESS_CAPS',
			'length'		=> 100,
			'required'		=> true,
                        'reportable'            => false,
		),
		'invalid_email' => array(
			'name'			=> 'invalid_email',
			'type'			=> 'bool',
			'default'		=> 0,
		    'vname'         => 'LBL_INVALID_EMAIL',
		),
		'opt_out' => array(
			'name'			=> 'opt_out',
			'type'			=> 'bool',
			'default'		=> 0,
		    'vname'         => 'LBL_OPT_OUT',
		),
		'date_created' => array(
			'name'			=> 'date_created',
			'type'			=> 'datetime',
			'vname'         => 'LBL_DATE_CREATE',
		),
		'date_modified' => array(
			'name'			=> 'date_modified',
			'type'			=> 'datetime',
		    'vname'         => 'LBL_DATE_MODIFIED',
		),
		'deleted' => array(
			'name'			=> 'deleted',
			'type'			=> 'bool',
			'default'		=> 0,
		    'vname'         => 'LBL_DELETED',
		),
	),
	'indices' => array(
		array(
			'name'			=> 'email_addressespk',
			'type'			=> 'primary',
			'fields'		=> array('id')
		),
		array(
			'name'			=> 'idx_ea_caps_opt_out_invalid',
			'type'			=> 'index',
			'fields'		=> array('email_address_caps','opt_out','invalid_email')
		),
		array(
			'name'			=> 'idx_ea_opt_out_invalid',
			'type'			=> 'index',
			'fields'		=> array('email_address', 'opt_out', 'invalid_email')
		),
	),
);

// hack for installer
if (file_exists("cache/modules/EmailAddresses/EmailAddressvardefs.php"))
{
    include("cache/modules/EmailAddresses/EmailAddressvardefs.php");
} else {
    $dictionary['EmailAddress'] = $dictionary['email_addresses'];
}

/**
 * Relationship table linking email addresses to an instance of a Sugar Email object
 */
$dictionary['emails_email_addr_rel'] = array(
	'table' => 'emails_email_addr_rel',
	'comment' => 'Normalization of multi-address fields such as To:, CC:, BCC',
	'fields' => array(
		'id' => array(
			'name'			=> 'id',
			'type'			=> 'id',
			'required'		=> true,
			'comment'		=> 'GUID',
		),
		'email_id' => array(
			'name'			=> 'email_id',
			'type'			=> 'id',
			'required'		=> true,
			'comment'		=> 'Foriegn key to emails table NOT unique',
		),
		'address_type' => array(
			'name'			=> 'address_type',
			'type'			=> 'varchar',
			'len'			=> 4,
			'required'		=> true,
			'comment'		=> 'Type of entry, TO, CC, or BCC',
		),
		'email_address_id' => array(
			'name'			=> 'email_address_id',
			'type'			=> 'id',
			'required'		=> true,
			'comment'		=> 'Foriegn key to emails table NOT unique',
		),
		'deleted' => array(
			'name'			=> 'deleted',
			'type'			=> 'bool',
			'default'		=> 0,
		),
	),
	'indices' => array(
		array(
			'name'		=> 'emails_email_addr_relpk',
			'type'		=> 'primary',
			'fields'	=> array('id'),
		),
		array(
			'name'		=> 'idx_eearl_email_id',
			'type'		=> 'index',
			'fields'	=> array('email_id', 'address_type'),
		),
		array(
			'name'		=> 'idx_eearl_address_id',
			'type'		=> 'index',
			'fields'	=> array('email_address_id'),
		),
	),
);

/**
 * Relationship table linking email addresses to various SugarBeans or type Person
 */
$dictionary['email_addr_bean_rel'] = array(
	'table' => 'email_addr_bean_rel',
	'fields' => array(
		array(
			'name'			=> 'id',
			'type'			=> 'id',
			'required'		=> true,
		),
		array(
			'name'			=> 'email_address_id',
			'type'			=> 'id',
			'required'		=> true,
		),
		array(
			'name'			=> 'bean_id',
			'type'			=> 'id',
			'required'		=> true,
		),
		array(
			'name'			=> 'bean_module',
			'type'			=> 'varchar',
			'len'			=> 100,
			'required'		=> true,
		),
		array(
			'name'			=> 'primary_address',
			'type'			=> 'bool',
			'default'		=> '0',
		),
		array(
			'name'			=> 'reply_to_address',
			'type'			=> 'bool',
			'default'		=> '0',
		),
		array(
			'name'			=> 'date_created',
			'type'			=> 'datetime'
		),
		array(
			'name'			=> 'date_modified',
			'type'			=> 'datetime'
		),
		array(
			'name'			=> 'deleted',
			'type'			=> 'bool',
			'default'		=> 0,
		),
	),
	'indices' => array(
		array(
			'name'			=> 'email_addresses_relpk',
			'type'			=> 'primary',
			'fields'		=> array('id')
		),
		array(
			'name'			=> 'idx_email_address_id',
			'type'			=> 'index',
			'fields'		=> array('email_address_id')
		),
		array(
			'name'			=> 'idx_bean_id',
			'type'			=> 'index',
			'fields'		=> array('bean_id', 'bean_module'),
		),
	),
    'relationships' => array (
	    //Defined in Person/Company template vardefs
	),
);
