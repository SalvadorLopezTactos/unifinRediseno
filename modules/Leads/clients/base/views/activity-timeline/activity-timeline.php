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

$viewdefs['Leads']['base']['view']['activity-timeline'] = [
    'activity_modules' => [
        [
            'module' => 'Calls',
            'record_date' => 'date_start',
            'fields' => [
                'name',
                'status',
                'duration',
                'direction',
                'description',
                'invitees',
                'date_entered_by',
                'date_modified_by',
                'assigned_user_name',
            ],
        ],
        [
            'module' => 'Emails',
            'record_date' => 'date_sent',
            'fields' => [
                'name',
                'date_sent',
                'from_collection',
                'to_collection',
                'cc_collection',
                'bcc_collection',
                'description_html',
                'attachments_collection',
                'assigned_user_name',
            ],
        ],
        [
            'module' => 'Meetings',
            'record_date' => 'date_start',
            'fields' => [
                'name',
                'status',
                'duration',
                'type',
                'description',
                'invitees',
                'data_entered_by',
                'date_modified_by',
                'assigned_user_name',
            ],
        ],
        [
            'module' => 'Notes',
            'record_date' => 'date_entered',
            'fields' => [
                'name',
                'contact_name',
                'description',
                'filename',
                'date_entered_by',
                'date_modified_by',
                'assigned_user_name',
            ],
        ],
    ],
];
