<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
$module_name = '<module_name>';
$_object_name = '<_object_name>';
$searchFields[$module_name] =
    [
        'name' => ['query_type' => 'default'],
        'status' => ['query_type' => 'default', 'options' => $_object_name . '_status_dom', 'template_var' => 'STATUS_OPTIONS'],
        'priority' => ['query_type' => 'default', 'options' => $_object_name . '_priority_dom', 'template_var' => 'PRIORITY_OPTIONS'],
        'resolution' => ['query_type' => 'default', 'options' => $_object_name . '_resolution_dom', 'template_var' => 'RESOLUTION_OPTIONS'],
        $_object_name . '_number' => ['query_type' => 'default', 'operator' => 'in'],
        'current_user_only' => ['query_type' => 'default', 'db_field' => ['assigned_user_id'], 'my_items' => true, 'vname' => 'LBL_CURRENT_USER_FILTER', 'type' => 'bool'],
        'assigned_user_id' => ['query_type' => 'default'],
        'favorites_only' => [
            'query_type' => 'format',
            'operator' => 'subquery',
            'subquery' => 'SELECT sugarfavorites.record_id FROM sugarfavorites 
			                    WHERE sugarfavorites.deleted=0 
			                        and sugarfavorites.module = \'' . $module_name . '\'
			                        and sugarfavorites.assigned_user_id = \'{0}\'',
            'db_field' => ['id']],
        'open_only' => [
            'query_type' => 'default',
            'db_field' => ['status'],
            'operator' => 'not in',
            'closed_values' => ['Closed', 'Rejected', 'Duplicate'],
            'type' => 'bool',
        ],
        //Range Search Support
        'range_date_entered' => ['query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true],
        'start_range_date_entered' => ['query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true],
        'end_range_date_entered' => ['query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true],
        'range_date_modified' => ['query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true],
        'start_range_date_modified' => ['query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true],
        'end_range_date_modified' => ['query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true],
        //Range Search Support
    ];
