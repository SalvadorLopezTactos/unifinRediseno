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

$module_name = 'pmse_Emails_Templates';
$viewdefs[$module_name]['base']['view']['recordlist'] = [
    'favorite' => true,
    'following' => false,
    'selection' => [
    ],
    'rowactions' => [
        'actions' => [
            [
                'type' => 'rowaction',
                'css_class' => 'btn',
                'tooltip' => 'LBL_PREVIEW',
                'event' => 'list:preview:fire',
                'icon' => 'sicon-preview',
                'acl_action' => 'view',
            ],
            [
                'type' => 'rowaction',
                'name' => 'designer_button',
                'label' => 'LBL_PMSE_LABEL_DESIGN',
                'event' => 'list:editemailstemplates:fire',
                'acl_action' => 'view',
            ],
            [
                'type' => 'rowaction',
                'name' => 'edit_button',
                'label' => 'LBL_EDIT_BUTTON',
                'event' => 'list:edit_emailstemplates:fire',
                'acl_action' => 'edit',
            ],
            [
                'type' => 'rowaction',
                'name' => 'export_button',
                'label' => 'LBL_PMSE_LABEL_EXPORT',
                'event' => 'list:exportemailstemplates:fire',
                'acl_action' => 'view',
            ],
            [
                'type' => 'rowaction',
                'name' => 'delete_button',
                'event' => 'list:deleteemailstemplates:fire',
                'label' => 'LBL_DELETE_BUTTON',
                'acl_action' => 'delete',
            ],
        ],
    ],
    'last_state' => [
        'id' => 'record-list',
    ],
];
