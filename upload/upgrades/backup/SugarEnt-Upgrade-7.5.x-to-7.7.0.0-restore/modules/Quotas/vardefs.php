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
 $dictionary['Quota'] =
 	array(
		'table' => 'quotas',
 		'fields' => array(

	'id' =>
	array (
	  'name' => 'id',
	  'vname' => 'LBL_NAME',
	  'type' => 'id',
	  'required' => true,
	  'reportable' => false,
	),

	'user_id' =>
	array (
	  'name' => 'user_id',
	  'vname' => 'LBL_USER_ID',
	  'type' => 'assigned_user_name',
	  'table' => 'users',
	  'required' => false,
	  'isnull' => false,
	  'reportable' => false,
	  'dbType' => 'id',
	  'importable' => 'required',
	),

	'assigned_user_id' =>
	array (
	  'name' => 'assigned_user_id',
	  'vname' => 'LBL_ASSIGNED_USER_ID',
	  'type' => 'assigned_user_name',
	  'table' => 'users',
	  'required' => true,
	  'reportable' => false,
	  'source' => 'non-db',
	),

	'user_name' =>
	array (
		'name' => 'user_name',
		'vname' => 'LBL_USER_NAME',
		'type' => 'varchar',
		'reportable' => false,
		'source' => 'non-db',
		'table' => 'users',
	),

	'user_full_name' =>
	array (
		'name' => 'user_full_name',
		'vname' => 'LBL_USER_FULL_NAME',
		'type' => 'varchar',
		'reportable' => false,
		'source' => 'non-db',
		'table' => 'users',
	),

    'timeperiod_id' =>
        array (
         'name' => 'timeperiod_id',
         'vname' => 'LBL_TIMEPERIOD_ID',
         'type' => 'enum',
         'dbType' => 'id',
         'function' => 'getTimePeriodsDropDownForQuotas',
         'reportable' => true,
        ),

  	'quota_type' =>
 	 array (
    	'name' => 'quota_type',
    	'vname' => 'LBL_QUOTA_TYPE',
    	'type' => 'enum',
    	'len' => 100,
    	'massupdate' => false,
    	'options' => 'forecast_type_dom',
        'reportable'=>false,
  ),

	'amount' =>
	array (
	  'name' => 'amount',
	  'vname' => 'LBL_AMOUNT',
	  'type' => 'currency',
	  'required' => true,
	  'reportable' => true,
	  'importable' => 'required',
	),

	'amount_base_currency' =>
	array (
	  'name' => 'amount_base_currency',
	  'vname' => 'LBL_AMOUNT_BASE_CURRENCY',
	  'type' => 'currency',
	  'required' => true,
	  'reportable' => false,
	),

	'currency_id' =>
	array (
	  'name' => 'currency_id',
	  'vname' => 'LBL_CURRENCY',
	  'type' => 'currency_id',
	  'dbType' => 'id',
	  'required' => true,
	  'reportable' => false,
	  'importable' => 'required',
      'default'=>'-99',
      'function' => 'getCurrencies',
      'function_bean' => 'Currencies',
	),
    'base_rate' =>
    array (
         'name' => 'base_rate',
         'vname' => 'LBL_BASE_RATE',
         'type' => 'decimal',
         'len' => '26,6',
    ),
    'currency_symbol' =>
  	array (
    	'name' => 'currency_symbol',
    	'vname' => 'LBL_LIST_SYMBOL',
    	'type' => 'varchar',
    	'len' => '36',
    	'source' => 'non-db',
		'table' => 'currency',
     	'required' => true,
  ),

	'committed' =>
	array (
	  'name' => 'committed',
	  'vname' => 'LBL_COMMITTED',
	  'type' => 'bool',
	  'default' => '0',
	  'required' => false,
	  'reportable' => false,
	),

    'modified_user_id' =>
  	array (
    	'name' => 'modified_user_id',
    	'rname' => 'user_name',
    	'id_name' => 'modified_user_id',
    	'vname' => 'LBL_ASSIGNED_TO',
    	'type' => 'assigned_user_name',
    	'table' => 'users',
    	'isnull' => 'false',
    	'dbType' => 'id',
    	'reportable'=>true,
  	),
  	'created_by' =>
  	array (
    	'name' => 'created_by',
    	'vname' => 'LBL_CREATED_BY',
    	'type' => 'id',
    	'len' => '36',
        'reportable'=>false,
  	),
  	'date_entered' =>
  	array (
    	'name' => 'date_entered',
    	'vname' => 'LBL_DATE_ENTERED',
    	'type' => 'datetime',
        'reportable'=>false,
  	),
	'date_modified' =>
  	array (
    	'name' => 'date_modified',
    	'vname' => 'LBL_DATE_MODIFIED',
    	'type' => 'datetime',
        'reportable'=>false,
  	),
	'deleted' =>
  	array (
	    'name' => 'deleted',
    	'vname' => 'LBL_DELETED',
    	'type' => 'bool',
    	'reportable'=>false,
  	),
    'name' =>
    array (
       'name' => 'name',
       'type' => 'id',
       'source'=>'non-db',
    ),


    		),	//ends "fields" array

	'indices' => array(
       	  array('name' =>'quotaspk', 'type' =>'primary', 'fields'=>array('id')),
       	  array('name' =>'idx_quota_user_tp', 'type' =>'index', 'fields'=>array('user_id', 'timeperiod_id')),
	),
);

?>
