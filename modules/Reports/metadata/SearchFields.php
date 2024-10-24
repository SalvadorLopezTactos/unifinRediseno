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
$searchFields['Reports'] =
    [
        'name' => ['query_type' => 'default'],
        'report_module' => ['query_type' => 'default', 'db_field' => ['module']],
        'assigned_user_id' => ['query_type' => 'default'],
        'report_type' => ['query_type' => 'default', 'options' => 'dom_report_types'],
        'team_id' => [
            'query_type' => 'format',
            'operator' => 'subquery',
            'subquery' => 'SELECT team_set_id FROM team_sets_teams WHERE team_id IN ({0})',
            'db_field' => [
                'team_set_id',
            ],
        ],
        'current_user_only' => ['query_type' => 'default', 'db_field' => ['assigned_user_id'], 'my_items' => true, 'vname' => 'LBL_CURRENT_USER_FILTER', 'type' => 'bool'],
        'favorites_only' => [
            'query_type' => 'format',
            'operator' => 'subquery',
            'subquery' => 'SELECT sugarfavorites.record_id FROM sugarfavorites
			                    WHERE sugarfavorites.deleted=0
			                        and sugarfavorites.module = \'Reports\'
			                        and sugarfavorites.assigned_user_id = \'{0}\'',
            'db_field' => ['id']],
    ];
