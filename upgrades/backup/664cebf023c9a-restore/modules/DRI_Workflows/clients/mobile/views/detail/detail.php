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

$viewdefs['DRI_Workflows']['mobile']['view']['detail'] = [
    'templateMeta' => [
        'form' => [
            'buttons' => [
                'EDIT',
                'DUPLICATE',
                'DELETE',
            ],
        ],
        'maxColumns' => '1',
        'widths' => [
            [
                'label' => '10',
                'field' => '30',
            ],
            [
                'label' => '10',
                'field' => '30',
            ],
        ],
        'useTabs' => false,
    ],
    'panels' => [
        [
            'label' => 'LBL_PANEL_DEFAULT',
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_PANEL_DEFAULT',
            'columns' => '1',
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => [
                [
                    'name' => 'name',
                    'readonly' => true,
                    'label' => 'LBL_NAME',
                ],
                'dri_workflow_template_name',
                'available_modules',
                [
                    'name' => 'parent_name',
                    'readonly' => true,
                    'label' => 'LBL_PARENT_NAME',
                ],
                [
                    'name' => 'progress',
                    'type' => 'cj-progress-bar',
                ],
                'assignee_rule',
                'target_assignee',
                'current_stage_name',
                'score',
                'points',
                'state',
                'account_name',
                'contact_name',
                'lead_name',
                'opportunity_name',
                'case_name',
                [
                    'name' => 'description',
                    'span' => 12,
                ],
                'team_name',
                'assigned_user_name',
                'date_modified',
                'modified_by_name',
                'date_entered',
                'created_by_name',
                [
                    'name' => 'tag',
                ],
            ],
        ],
    ],
];
