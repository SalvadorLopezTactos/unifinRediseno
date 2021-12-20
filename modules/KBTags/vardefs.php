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

$dictionary['KBTag'] = array('table' => 'kbtags'
                               ,'fields' => array (
  'id' => 
  array (
    'name' => 'id',
    'vname' => 'LBL_TAG_NAME',
    'type' => 'id',
    'len' => '36',
    'required'=>true,
    'reportable'=>false,
  ),  
  'parent_tag_id' => 
  array (
    'name' => 'parent_tag_id',
    'vname' => 'LBL_PARENT_TAG_ID',
    'type' => 'id',
    'len' => '36',
    'required'=>false,
    'reportable'=>false,
  ),
  'tag_name' => 
  array (
    'name' => 'tag_name',
    'vname' => 'LBL_NAME',
    'type' => 'varchar',
    'required'=>true
  ),
   'root_tag' => 
  array (
    'name' => 'root_tag',
    'vname' => 'LBL_ROOT_TAG',
    'type' => 'bool',
    'default' => 0,
    'reportable'=>false,
  ), 
   'date_entered' => 
  array (
    'name' => 'date_entered',
    'vname' => 'LBL_DATE_ENTERED',
    'type' => 'datetime',
  ),
  'created_by' => 
  array (
    'name' => 'created_by',
    'rname' => 'user_name',
    'id_name' => 'modified_user_id',
    'vname' => 'LBL_CREATED',
    'type' => 'assigned_user_name',
    'table' => 'users',
    'isnull' => 'false',
    'dbType' => 'id',
    'source'=>'db',
  ),    
  'revision'=>
  array (
    'name' => 'revision',
    'vname' => 'LBL_REVISION',
    'type' => 'varchar',
    'len' => 100,
  ),    
  'deleted' => 
  array (
    'name' => 'deleted',
    'vname' => 'LBL_DELETED',
    'type' => 'bool',
    'default' => 0,
    'reportable'=>false,
  ),
  'date_modified' => 
  array (
    'name' => 'date_modified',
    'vname' => 'LBL_DATE_MODIFIED',
    'type' => 'datetime',
  ),
//'created_by_link' =>
//  array (
//    'name' => 'created_by_link',
//    'type' => 'link',
//    'relationship' => 'revisions_created_by',
//    'vname' => 'LBL_CREATED_BY_USER',
//    'link_type' => 'one',
//    'module'=>'Users',
//    'bean_name'=>'User',
//    'source'=>'non-db',
//  ),  
), 
'indices' => array (
       array('name' =>'kbtagspk', 'type' =>'primary', 'fields'=>array('id'))
),



'relationships' => array (
 
   )


);

VardefManager::createVardef('KBTags','KBTag', array(
'team_security',
));
?>
