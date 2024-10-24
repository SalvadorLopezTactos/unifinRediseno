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

$_module_name = '<_module_name>';
$viewdefs['<module_name>']['base']['view']['activity-card-definition'] = [
    'module' => '<module_name>',
    'record_date' => 'date_entered',
    'fields' => [
        'name',
        $_module_name . '_number',
        'date_entered',
        'assigned_user_name',
        'priority',
        'status',
        'resolution',
    ],
    'card_menu' => [
        [
            'type' => 'cab_actiondropdown',
            'buttons' => [
                [
                    'type' => 'unlinkcab',
                    'icon' => 'sicon-unlink',
                    'label' => 'LBL_UNLINK_BUTTON',
                ],
            ],
        ],
    ],
];
