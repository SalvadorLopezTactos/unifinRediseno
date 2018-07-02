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
$dictionary['ContractType'] = array('table' => 'contract_types',
	'comment' => 'Specifies the types of contracts available',

'fields' => array (
    'id' => array (
        'name' => 'id',
        'vname' => 'LBL_ID',
        'type' => 'id',
        'required'=>true,
        'reportable'=>false,
        'comment' => 'Unique idenifier'
    ),

   'name' => array (
        'name' => 'name',
        'vname' => 'LBL_TYPE_NAME',
        'type' => 'varchar',
        'len' => '30',
        'comment' => 'Contract type name',
        'importable' => 'required',
   ),
	'list_order' => array (
		'name' => 'list_order',
    	'vname' => 'LBL_LIST_ORDER',
    	'type' => 'int',
    	'len' => '4',
    	'comment' => 'Relative order in drop down list',
    	'importable' => 'required',
  	),
    'date_entered' => array (
    	'name' => 'date_entered',
        'vname' => 'LBL_DATE_ENTERED',
        'type' => 'datetime',
		'required' => true,
		'comment' => 'Date record created'
  	),
  	'date_modified' => array (
    	'name' => 'date_modified',
    	'vname' => 'LBL_DATE_MODIFIED',
    	'type' => 'datetime',
    	'required' => true,
    	'comment' => 'Date record last modified'
  	),
    'modified_user_id' => array (
    	'name' => 'modified_user_id',
    	'vname' => 'LBL_MODIFIED_USER_ID',
    	'dbType' => 'id',
    	'type'=>'id',
    	'comment' => 'Date record last modified'
  	),
  	'created_by' => array (
    	'name' => 'created_by',
    	'vname' => 'LBL_CREATED_BY',
    	'isnull' => 'false',
    	'dbType' => 'id',
    	'type'=>'id',
    	'comment' => 'User ID who created record'
  	),
  	'deleted' => array (
    	'name' => 'deleted',
    	'vname' => 'LBL_DELETED',
    	'type' => 'bool',
    	'required' => false,
    	'default' => '0',
    	'reportable'=>false,
    	'comment' => 'Record deletion indicator'
  	),
  	'documents' => array (
  		'name' => 'documents',
    	'type' => 'link',
    	'relationship' => 'contracttype_documents',
    	'source'=>'non-db',
		'vname'=>'LBL_DOCUMENTS',
  	),
  ),
'acls' => array('SugarACLDeveloperOrAdmin' => array('aclModule'=>'Contracts')),
'indices' => array (
      array('name' =>'contract_types_pk', 'type' =>'primary', 'fields'=>array('id')),
      array('name' => 'idx_contracttype_name', 'type' => 'index', 'fields' => array('name')),
 )
);
?>