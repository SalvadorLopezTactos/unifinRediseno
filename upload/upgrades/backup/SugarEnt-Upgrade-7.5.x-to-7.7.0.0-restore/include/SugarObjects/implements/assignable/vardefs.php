<?php
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
$vardefs = array(
'fields'=> array(
	'assigned_user_id' =>
		array (
			'name' => 'assigned_user_id',
			'rname' => 'user_name',
			'id_name' => 'assigned_user_id',
			'vname' => 'LBL_ASSIGNED_TO_ID',
			'group'=>'assigned_user_name',
			'type' => 'relate',
			'table' => 'users',
			'module' => 'Users',
			'reportable'=>true,
			'isnull' => 'false',
			'dbType' => 'id',
			'audited'=>true,
            'duplicate_on_record_copy' => 'always',
			'comment' => 'User ID assigned to record',
            'duplicate_merge'=>'disabled',
            'mandatory_fetch' => true,
            'massupdate' => false,
		),
	 'assigned_user_name' =>
	 array (
		    'name' => 'assigned_user_name',
		    'link'=>'assigned_user_link' ,
            'vname' => 'LBL_ASSIGNED_TO',
		    'rname' => 'full_name',
		    'type' => 'relate',
		    'reportable'=>false,
		    'source'=>'non-db',
		    'table' => 'users',
		    'id_name' => 'assigned_user_id',
		    'module'=>'Users',
		    'duplicate_merge'=>'disabled',
            'duplicate_on_record_copy' => 'always',
            'sort_on' => array('last_name'),
            'exportable'=>true,
     ),
		      'assigned_user_link' =>
  array (
        'name' => 'assigned_user_link',
    'type' => 'link',
    'relationship' => strtolower($module).'_assigned_user',
    'vname' => 'LBL_ASSIGNED_TO_USER',
    'link_type' => 'one',
    'module'=>'Users',
    'bean_name'=>'User',
    'source'=>'non-db',
    'duplicate_merge'=>'enabled',
    'id_name' => 'assigned_user_id',
    'table' => 'users',
  ),
),
    'indicies' => array(
        'assigned_user_id' => array(
            'name' => 'idx_' . strtolower($table_name) . '_assigned_del',
            'type' => 'index',
            'fields' => array('deleted', 'assigned_user_id')
        ),
    ),
'relationships'=>array(
	  strtolower($module).'_assigned_user' =>
   array('lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
   'rhs_module'=> $module , 'rhs_table'=> strtolower($table_name), 'rhs_key' => 'assigned_user_id',
   'relationship_type'=>'one-to-many')
));
?>
