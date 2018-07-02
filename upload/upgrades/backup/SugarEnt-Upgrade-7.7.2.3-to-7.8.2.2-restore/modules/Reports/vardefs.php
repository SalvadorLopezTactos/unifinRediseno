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
$dictionary['SavedReport'] = array ( 'table' => 'saved_reports',
    'visibility' => array('ReportVisibility' => true),
    'favorites'=>true,
    'fields' => array (
  'id' =>
  array (
    'name' => 'id',
    'vname' => 'LBL_ID',
    'type' => 'id',
    'required'=>true,
    'reportable'=>false,
  ),
  'name' =>
  array (
  	'name' => 'name',
    'vname' => 'LBL_NAME',
    'type' => 'varchar',
    'len'=>'255',
    'required'=>true,
  ),
  'module' =>
  array (
    'name' => 'module',
    'vname' => 'LBL_MODULE',
    'type' => 'enum',
    'function' => 'getModulesDropdown',
    'required' => true,
  ),
  'report_type' =>
  array (
  	'name' => 'report_type',
    'vname' => 'LBL_REPORT_TYPE',
    'type' => 'enum',
    'options' => 'dom_report_types',
    'required' => true,
  ),
  'content' =>
  array (
  	'name' => 'content',
    'vname' => 'LBL_CONTENT',
    'type' => 'longtext',
  ),
   'deleted' =>
  array (
    'name' => 'deleted',
    'vname' => 'LBL_DELETED',
    'type' => 'bool',
    'required'=>false,
    'reportable'=>false,
  ),
   'date_entered' =>
  array (
    'name' => 'date_entered',
    'vname' => 'LBL_DATE_ENTERED',
    'type' => 'datetime',
    'required'=>true,
  ),
  'date_modified' =>
  array (
    'name' => 'date_modified',
    'vname' => 'LBL_DATE_MODIFIED',
    'type' => 'datetime',
    'required'=>true,
  ),
  'assigned_user_id' =>
  array (
    'name' => 'assigned_user_id',
    'vname' => 'LBL_ASSIGNED_TO',
      'type' => 'id',
    'isnull' => 'false',
    'massupdate' => false,
    'reportable'=>false,
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
    'reportable'=>false,
  ),
 'assigned_user_name' =>
  array (
    'name' => 'assigned_user_name',
    'vname' => 'LBL_ASSIGNED_TO_NAME',
    'type' => 'relate',
	'link' => 'assigned_user_link',
    'rname' => 'name',
    'reportable'=>false,
    'source'=>'non-db',
    'table' => 'users',
    'id_name' => 'assigned_user_id',
    'module'=>'Users',
    'exportable'=> true,
  ),
  'assigned_user_link' =>
   array (
	 'name' => 'assigned_user_link',
	 'type' => 'link',
	 'relationship' => 'report_assigned_user',
	 'vname' => 'LBL_ASSIGNED_TO_USER',
	 'link_type' => 'one',
	 'module'=>'Users',
	 'bean_name'=>'User',
	 'source'=>'non-db',
	 'duplicate_merge'=>'enabled',
	 'rname' => 'user_name',
	 'id_name' => 'assigned_user_id',
	 'table' => 'users',
  ),
  'created_by' =>
  array (
    'name' => 'created_by',
    'rname' => 'user_name',
    'id_name' => 'modified_user_id',
    'vname' => 'LBL_ASSIGNED_TO',
    'type' => 'assigned_user_name',
    'table' => 'users',
    'isnull' => 'false',
    'dbType' => 'id'
  ),
  'is_published' =>
  array (
  	'name' => 'is_published',
    'vname' => 'LBL_IS_PUBLISHED',
    'type' => 'bool',
    'default'=>0,
    'required'=>true,
  ),
  'last_run_date' => array(
    'name' => 'last_run_date',
    'rname' => 'date_modified',
    'id_name' => 'report_cache_id',
    'vname' => 'LBL_REPORT_LAST_RUN_DATE',
    'type' => 'relate',
    'dbType' => 'datetime',
    'table' => 'report_cache',
    'isnull' => 'true',
    'module' => 'Reports',
    'reportable' => false,
    'source' => 'non-db',
    'massupdate' => false,
    'duplicate_merge' => 'disabled',
    'hideacl' => true,
    'width' => '15',
  ),
  'report_cache_id' => array(
    'name' => 'report_cache_id',
    'rname' => 'id',
    'id_name' => 'report_cache_id',
    'vname' => 'LBL_REPORT_CACHE_ID',
    'type' => 'relate',
    'dbType' => 'id',
    'table' => 'report_cache',
    'isnull' => 'true',
    'module' => 'Reports',
    'reportable' => false,
    'source' => 'non-db',
    'massupdate' => false,
    'duplicate_merge' => 'disabled',
    'hideacl' => true,
    'studio' => false,
  ),
  'chart_type' =>
  array (
  	'name' => 'chart_type',
    'vname' => 'LBL_CHART_TYPE',
    'type' => 'varchar',
    'required'=>true,
    'default'=>'none',
    'len' => 36
  ),
    'schedule_type' =>
  array (
  	'name' => 'schedule_type',
    'vname' => 'LBL_SCHEDULE_TYPE',
    'type' => 'varchar',
    'len'=>'3',
    'default'=>'pro',
  ),
 'favorite' =>
  array (
    'name' => 'favorite',
    'vname' => 'LBL_FAVORITE',
    'type' => 'bool',
    'required' => false,
    'reportable' => false,
  ),
),
'indices' => array (
       array('name' =>'save_reportspk', 'type' =>'primary', 'fields'=>array('id')),
       array('name' =>'idx_rep_owner_module_name', 'type'=>'index', 'fields'=>array('assigned_user_id','name','deleted')),
       array('name' => 'idx_savedreport_module', 'type' => 'index', 'fields' => array('module')),
       array('name' => 'idx_savedreport_date_entered', 'type' => 'index', 'fields' => array('date_entered')),
),
'relationships'=>array(
    /*
	'reports_team_name_relationship' =>
		array (
			'lhs_module'        => 'Reports',
            'lhs_table'         => 'saved_reports',
            'lhs_key'           => 'team_set_id',
            'rhs_module'        => 'Teams',
            'rhs_table'         => 'teams',
            'rhs_key'           => 'id',
            'relationship_type' => 'many-to-many',
            'join_table'        => 'team_sets',
            'join_key_lhs'      => 'id',
            'join_key_rhs'      => 'primary_team_id',
		),
    */
    'report_assigned_user' =>
        array('lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
              'rhs_module'=> 'Reports' , 'rhs_table'=> 'saved_reports', 'rhs_key' => 'assigned_user_id',
              'relationship_type'=>'one-to-many'
			 ),
   ),
);

VardefManager::createVardef('Reports','SavedReport', array(
'team_security',
));
?>
