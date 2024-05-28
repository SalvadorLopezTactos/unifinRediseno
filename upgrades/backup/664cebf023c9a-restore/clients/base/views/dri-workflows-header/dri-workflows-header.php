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

$viewdefs['base']['view']['dri-workflows-header'] = [
    'fields' => [
        [
            'name' => 'dri_workflow_template_id',
        ],
    ],
    'right_buttons' => [
        [
            'type' => 'actiondropdown',
            'name' => 'main_dropdown',
            'buttons' => [
                [
                    'type' => 'rowaction',
                    'icon' => 'sicon-plus',
                    'name' => 'start_cycle',
                    'event' => 'parent:start_cycle:click',
                    'tooltip' => 'LBL_START_CYCLE_BUTTON_TITLE',
                    'acl_action' => 'edit',
                    'acl_module' => 'DRI_Workflows',
                    'label' => ' ',
                ],
            ],
        ],
    ],
    'left_buttons' => [
        [
            'type' => 'actiondropdown',
            'name' => 'main_dropdown',
            'buttons' => [
                [
                    'type' => 'rowaction',
                    'icon' => 'sicon-settings',
                    'name' => 'widget_layout_configuration',
                    'event' => 'parent:widget_layout_configuration:click',
                    'tooltip' => 'LBL_WIDGET_LAYOUT_CONFIGURATION',
                    'acl_action' => 'edit',
                    'acl_module' => 'DRI_Workflows',
                    'label' => ' ',
                ],
            ],
        ],
    ],
    'last_state' => [
        'id' => 'dri-workflows-header',
        'defaults' => [
            'show_more' => 'less',
        ],
    ],
];
