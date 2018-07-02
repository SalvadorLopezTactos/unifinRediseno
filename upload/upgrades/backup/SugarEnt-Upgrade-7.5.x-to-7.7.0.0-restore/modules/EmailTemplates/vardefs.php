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
$dictionary['EmailTemplate'] = array(
    'table' => 'email_templates',
    'favorites' => false,
    'comment' => 'Templates used in email processing',
	'fields' => array(
		'id' => array(
			'name' => 'id',
			'vname' => 'LBL_ID',
			'type' => 'id',
			'required' => true,
			'reportable'=>false,
			'comment' => 'Unique identifier'
		),
		'date_entered' => array(
			'name' => 'date_entered',
			'vname' => 'LBL_DATE_ENTERED',
			'type' => 'datetime',
			'required'=>true,
			'comment' => 'Date record created'
		),
		'date_modified' => array(
			'name' => 'date_modified',
			'vname' => 'LBL_DATE_MODIFIED',
			'type' => 'datetime',
			'required'=>true,
			'comment' => 'Date record last modified'
		),
		'modified_user_id' => array(
			'name' => 'modified_user_id',
			'rname' => 'user_name',
			'id_name' => 'modified_user_id',
			'vname' => 'LBL_ASSIGNED_TO',
			'type' => 'assigned_user_name',
			'table' => 'users',
			'reportable'=>true,
			'isnull' => 'false',
			'dbType' => 'id',
			'comment' => 'User who last modified record'
		),
		'created_by' => array(
			'name' => 'created_by',
			'vname' => 'LBL_CREATED_BY',
			'type' => 'id',
			'len'=> '36',
			'comment' => 'User who created record'
		),
		'published' => array(
			'name' => 'published',
			'vname' => 'LBL_PUBLISHED',
			'type' => 'varchar',
			'len' => '3',
			'comment' => ''
		),
		'name' => array(
			'name' => 'name',
			'vname' => 'LBL_NAME',
			'type' => 'varchar',
			'len' => '255',
			'comment' => 'Email template name',
			'importable' => 'required',
            'required' => true
		),
		'description' => array(
			'name' => 'description',
			'vname' => 'LBL_DESCRIPTION',
			'type' => 'text',
			'comment' => 'Email template description'
		),
		'subject' => array(
			'name' => 'subject',
			'vname' => 'LBL_SUBJECT',
			'type' => 'varchar',
			'len' => '255',
			'comment' => 'Email subject to be used in resulting email'
		),
		'body' => array(
			'name' => 'body',
			'vname' => 'LBL_BODY',
			'type' => 'text',
			'comment' => 'Plain text body to be used in resulting email'
		),
		'body_html' => array(
			'name' => 'body_html',
			'vname' => 'LBL_PLAIN_TEXT',
			'type' => 'html',
			'comment' => 'HTML formatted email body to be used in resulting email'
		),
		'deleted' => array(
			'name' => 'deleted',
			'vname' => 'LBL_DELETED',
			'type' => 'bool',
			'required' => false,
			'reportable'=>false,
			'comment' => 'Record deletion indicator'
		),
		'assigned_user_id' => array (
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
			'comment' => 'User ID assigned to record',
            'duplicate_merge'=>'disabled'
		),
    	 'assigned_user_name' => array (
        	 'name' => 'assigned_user_name',
        	 'link'=>'assigned_user_link' ,
        	 'vname' => 'LBL_ASSIGNED_TO_NAME',
        	 'rname' => 'user_name',
        	 'type' => 'relate',
        	 'reportable'=>false,
        	 'source'=>'non-db',
        	 'table' => 'users',
        	 'id_name' => 'assigned_user_id',
        	 'module'=>'Users',
        	 'duplicate_merge'=>'disabled',
             'exportable'=> true,
    	 ),
		 'assigned_user_link' => array (
    		 'name' => 'assigned_user_link',
    		 'type' => 'link',
    		 'relationship' => 'emailtemplates_assigned_user',
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
		'base_module' => array(
			'name' => 'base_module',
			'vname' => 'LBL_BASE_MODULE',
			'type' => 'varchar',
			'len' => '50',
			'comment' => 'In Workflow alert templates, the module to which this template is associated'
		),
		'from_name' => array(
			'name' => 'from_name',
			'vname' => 'LBL_FROM_NAME',
			'type' => 'varchar',
			'len' => '255',
			'reportable'=>false,
		),
		'from_address' => array(
			'name' => 'from_address',
			'vname' => 'LBL_FROM_ADDRESS',
			'type' => 'varchar',
			'len' => '255',
			'reportable'=>false,
		),
        'text_only' => array(
            'name' => 'text_only',
            'vname' => 'LBL_TEXT_ONLY',
            'type' => 'bool',
            'required' => false,
            'reportable'=>false,
            'comment' => 'Should be checked if email template is to be sent in text only'
        ),
        'type' => array(
            'name' => 'type',
            'vname' => 'LBL_TYPE',
            'type' => 'enum',
            'required' => false,
            'reportable'=> false,
            'options' => 'emailTemplates_type_list',
            'comment' => 'Type of the email template'
       ),
	),
	'indices' => array(
		array(
			'name' => 'email_templatespk',
			'type' =>'primary',
			'fields'=>array('id')
		),
		array(
			'name' => 'idx_email_template_name',
			'type'=>'index',
			'fields'=>array('name')
		),
        array('name' => 'idx_emailtemplate_type', 'type' => 'index', 'fields' => array('type')),
        array('name' => 'idx_emailtemplate_date_modified', 'type' => 'index', 'fields' => array('date_modified')),
        array('name' => 'idx_emailtemplate_date_entered', 'type' => 'index', 'fields' => array('date_entered')),
	),
	'relationships' => array(
	'emailtemplates_assigned_user' =>
       array('lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
       'rhs_module'=> 'EmailTemplates' , 'rhs_table'=> 'email_templates', 'rhs_key' => 'assigned_user_id',
       'relationship_type'=>'one-to-many')
	),
);

VardefManager::createVardef('EmailTemplates','EmailTemplate', array(
'team_security',
));