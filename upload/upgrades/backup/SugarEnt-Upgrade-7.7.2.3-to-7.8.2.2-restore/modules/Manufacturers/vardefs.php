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
$dictionary['Manufacturer'] = array(
  'table' => 'manufacturers',
  'favorites' => false,
  'comment' => 'Manufacturers',
  'unified_search' => true,
  'full_text_search' => true,
  'unified_search_default_enabled' => true,
  'fields' => array (
  'id' =>
  array (
    'name' => 'id',
    'vname' => 'LBL_ID',
    'type' => 'id',
    'required'=>true,
    'reportable'=>false,
    'comment' => 'Unique identifier'
  ),
   'deleted' =>
  array (
    'name' => 'deleted',
    'vname' => 'LBL_DELETED',
    'type' => 'bool',
    'required'=>false,
    'reportable'=>false,
    'comment' => 'Record deletion indicator'
  ),
   'date_entered' =>
  array (
    'name' => 'date_entered',
    'vname' => 'LBL_DATE_ENTERED',
    'type' => 'datetime',
    'required'=>true,
    'comment' => 'Date record created',
    'full_text_search' => array(
          'enabled' => true,
          'searchable' => false,
          'aggregations' => array(
              'date_entered' => array(
                  'type' => 'DateRange',
              ),
          ),
    ),
  ),
  'date_modified' =>
  array (
    'name' => 'date_modified',
    'vname' => 'LBL_DATE_MODIFIED',
    'type' => 'datetime',
    'required'=>true,
    'comment' => 'Date record last modified',
    'full_text_search' => array(
          'enabled' => true,
          'searchable' => false,
          'aggregations' => array(
              'date_modified' => array(
                  'type' => 'DateRange',
              ),
          ),
    ),
  ),
    'modified_user_id' =>
  array (
    'name' => 'modified_user_id',
    'rname' => 'user_name',
    'id_name' => 'modified_user_id',
    'vname' => 'LBL_MODIFIED_ID',
    'type' => 'assigned_user_name',
    'table' => 'users',
    'isnull' => 'false',
    'dbType' => 'id',
    'reportable'=>true,
    'comment' => 'User who last modified record',
    'full_text_search' => array(
          'enabled' => true,
          'searchable' => false,
          'type' => 'id',
          'aggregations' => array(
              'modified_user_id' => array(
                  'type' => 'MyItems',
                  'label' => 'LBL_AGG_MODIFIED_BY_ME',
              ),
          ),
    ),
  ),
  'created_by' =>
  array (
    'name' => 'created_by',
    'rname' => 'user_name',
    'id_name' => 'modified_user_id',
    'vname' => 'LBL_CREATED_ID',
    'type' => 'assigned_user_name',
    'table' => 'users',
    'isnull' => 'false',
    'dbType' => 'id',
    'comment' => 'User who created record',
    'full_text_search' => array(
          'enabled' => true,
          'searchable' => false,
          'type' => 'id',
          'aggregations' => array(
              'created_by' => array(
                  'type' => 'MyItems',
                  'label' => 'LBL_AGG_CREATED_BY_ME',
              ),
          ),
    ),
  ),
  'name' =>
  array (
    'name' => 'name',
    'vname' => 'LBL_NAME',
    'type' => 'name',
    'dbType' => 'varchar',
    'len' => '50',
    'required'=>true,
    'comment' => 'Manufacturer name',
    'importable' => 'required',
    'unified_search' => true,
      'full_text_search' => array(
          'enabled' => true,
          'searchable' => true,
          'boost' => 0.78,
      ),
  ),
  'list_order' =>
  array (
    'name' => 'list_order',
    'vname' => 'LBL_LIST_ORDER',
    'type' => 'int',
    'len' => '4',
    'comment' => 'Order within list',
    'importable' => 'required',
  ),
  'status' =>
  array (
    'name' => 'status',
    'vname' => 'LBL_STATUS',
    'type' => 'enum',
    'options' => 'manufacturer_status_dom',
    'len' => 100,
    'dbType'=>'varchar',
    'comment' => 'Manufacturer status',
    'importable' => 'required',
  ),
    'revenue_line_items' => array(
      'name' => 'revenue_line_items',
      'type' => 'link',
      'relationship' => 'revenuelineitems_manufacturers',
      'source' => 'non-db',
      'vname' => 'LBL_REVENUELINEITEMS',
      'workflow' => false
    ),
),
'acls' => array('SugarACLDeveloperOrAdmin' => array('aclModule' => 'Products', 'allowUserRead' => true), 'SugarACLStatic' => false),
'indices' => array (
       array('name' =>'manufacturerspk', 'type' =>'primary', 'fields'=>array('id')),
       array('name' =>'idx_manufacturers', 'type'=>'index', 'fields'=>array('name','deleted'))
                                                      )
                            );
?>
