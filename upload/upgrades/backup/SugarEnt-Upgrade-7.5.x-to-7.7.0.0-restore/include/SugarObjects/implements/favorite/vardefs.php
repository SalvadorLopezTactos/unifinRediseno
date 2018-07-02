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
        'my_favorite' => array(
            'massupdate' => false,
            'name' => 'my_favorite',
            'vname' => 'LBL_FAVORITE',
            'type' => 'bool',
            'source' => 'non-db',
            'comment' => 'Favorite for the user',
            'studio' => array(
                // This field is on sidecar list and record views by default
                'list' => false,
                'recordview' => false,
            ),
            'link' => 'favorite_link',
            'rname' => 'id',
            'rname_exists' => true,
        ),
        'favorite_link' => array(
            'name' => 'favorite_link',
            'type' => 'link',
            'relationship' => strtolower($module).'_favorite',
            'source' => 'non-db',
            'vname' => 'LBL_FAVORITE',
        ),
    ),
    'relationships' => array(
        strtolower($module).'_favorite' => array(
            'lhs_module'=> $module,
            'lhs_table'=> $table_name,
            'lhs_key' => 'id',
            'rhs_module'=> 'Users',
            'rhs_table'=> 'users',
            'rhs_key' => 'id',
            'relationship_type'=>'user-based',
            'join_table'=> 'sugarfavorites',
            'join_key_lhs'=>'record_id',
            'join_key_rhs'=>'modified_user_id',
            'relationship_role_column' => 'module',
            'relationship_role_column_value' => $module,
            'user_field'=>'created_by',
        ),
    ),
    'indices' => array(
    ),
);

