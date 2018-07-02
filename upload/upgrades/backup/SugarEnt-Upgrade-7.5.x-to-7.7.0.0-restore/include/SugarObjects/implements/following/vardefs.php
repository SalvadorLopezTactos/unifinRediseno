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
    'fields' => array(
        'following' => array(
            'massupdate' => false,
            'name' => 'following',
            'vname' => 'LBL_FOLLOWING',
            'type' => 'bool',
            'source' => 'non-db',
            'comment' => 'Is user following this record',
            'studio' => 'false',
            'link' => 'following_link',
            'rname' => 'id',
            'rname_exists' => true,
        ),
        'following_link' => array(
            'name' => 'following_link',
            'type' => 'link',
            'relationship' => strtolower($module).'_following',
            'source' => 'non-db',
            'vname' => 'LBL_FOLLOWING',
        ),
    ),
    'relationships' => array(
        strtolower($module).'_following' => array(
            'lhs_module'=> $module,
            'lhs_table'=> $table_name,
            'lhs_key' => 'id',
            'rhs_module'=> 'Users',
            'rhs_table'=> 'users',
            'rhs_key' => 'id',
            'relationship_type'=>'user-based',
            'join_table'=> 'subscriptions',
            'join_key_lhs'=>'parent_id',
            'join_key_rhs'=>'created_by',
            'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => $module,
            'user_field'=>'created_by',
        ),
    ),
    'indices' => array(
    ),
);

