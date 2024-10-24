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


$layout_defs['History'] = [
    // default subpanel provided by this SugarBean
    'default_subpanel_define' => [
        'subpanel_title' => 'LBL_DEFAULT_SUBPANEL_TITLE',
        'top_buttons' => [
            ['widget_class' => 'SubPanelTopCreateNoteButton'],
            ['widget_class' => 'SubPanelTopArchiveEmailButton'],
            ['widget_class' => 'SubPanelTopSummaryButton'],
        ],

//TODO try and merge with the activities
        'list_fields' => [
            'Meetings' => [
                'columns' => [
                    [
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelIcon',
                        'module' => 'Meetings',
                        'width' => '2%',
                    ],
                    [
                        'name' => 'name',
                        'vname' => 'LBL_LIST_SUBJECT',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'width' => '28%',
                    ],
                    [
                        'name' => 'status',
                        'vname' => 'LBL_LIST_STATUS',
                        'width' => '10%',
                    ],
                    [
                        'name' => 'contact_name',
                        'module' => 'Contacts',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'target_record_key' => 'contact_id',
                        'target_module' => 'Contacts',
                        'vname' => 'LBL_LIST_CONTACT',
                        'width' => '20%',
                    ],
                    [
                        'name' => 'parent_name',
                        'module' => 'Meetings',
                        'vname' => 'LBL_LIST_RELATED_TO',
                        'width' => '22%',
                    ],
                    [
                        'name' => 'date_modified',
                        //'db_alias_to' => 'the_date',
                        'vname' => 'LBL_LIST_LAST_MODIFIED',
                        'width' => '10%',
                    ],
                    [
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelEditButton',
                        'module' => 'Meetings',
                        'width' => '4%',
                    ],
                    [
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelRemoveButton',
                        'linked_field' => 'meetings',
                        'module' => 'Meetings',
                        'width' => '4%',
                    ],
                ],
                'where' => "(meetings.status='Held' OR meetings.status='Not Held')",
                'order_by' => 'meetings.date_modified',
            ],
            'Emails' => [
                'columns' => [
                    [
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelIcon',
                        'module' => 'Emails',
                        'width' => '2%',
                    ],
                    [
                        'name' => 'name',
                        'vname' => 'LBL_LIST_SUBJECT',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'width' => '28%',
                    ],
                    [
                        'name' => 'status',
                        'vname' => 'LBL_LIST_STATUS',
                        'width' => '10%',
                    ],
                    [
                        'name' => 'contact_name',
                        'module' => 'Contacts',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'target_record_key' => 'contact_id',
                        'target_module' => 'Contacts',
                        'vname' => 'LBL_LIST_CONTACT',
                        'width' => '20%',
                    ],
                    [
                        'name' => 'parent_name',
                        'module' => 'Emails',
                        'vname' => 'LBL_LIST_RELATED_TO',
                        'width' => '22%',
                    ],
                    [
                        'name' => 'date_modified',
                        //'db_alias_to' => 'the_date',
                        'vname' => 'LBL_LIST_LAST_MODIFIED',
                        'width' => '10%',
                    ],
                    [
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelEditButton',
                        'module' => 'Emails',
                        'width' => '4%',
                    ],
                    [
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelRemoveButton',
                        'linked_field' => 'emails',
                        'module' => 'Emails',
                        'width' => '4%',
                    ],
                ],
                'where' => "(emails.state='Archived')",
                'order_by' => 'emails.date_modified',
            ],
            'Notes' => [
                'columns' => [
                    [
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelIcon',
                        'module' => 'Notes',
                        'width' => '2%',
                    ],
                    [
                        'name' => 'name',
                        'vname' => 'LBL_LIST_SUBJECT',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'width' => '28%',
                    ],
                    [ // this column does not exist on
                        'name' => 'status',
                        'vname' => 'LBL_LIST_STATUS',
                        'width' => '10%',
                    ],
                    [
                        'name' => 'contact_name',
                        'module' => 'Contacts',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'target_record_key' => 'contact_id',
                        'target_module' => 'Contacts',
                        'vname' => 'LBL_LIST_CONTACT',
                        'width' => '20%',
                    ],
                    [
                        'name' => 'parent_name',
                        'module' => 'Notes',
                        'vname' => 'LBL_LIST_RELATED_TO',
                        'width' => '22%',
                    ],
                    [
                        'name' => 'date_modified',
                        //'db_alias_to' => 'the_date',
                        'vname' => 'LBL_LIST_LAST_MODIFIED',
                        'width' => '10%',
                    ],
                    [
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelEditButton',
                        'module' => 'Notes',
                        'width' => '4%',
                    ],
                    [
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelRemoveButton',
                        'linked_field' => 'notes',
                        'module' => 'Notes',
                        'width' => '4%',
                    ],
                ],
                'where' => '',
                'order_by' => 'notes.date_modified',
            ],
            'Tasks' => [
                'columns' => [
                    [
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelIcon',
                        'module' => 'Tasks',
                        'width' => '2%',
                    ],
                    [
                        'name' => 'name',
                        'vname' => 'LBL_LIST_SUBJECT',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'width' => '28%',
                    ],
                    [
                        'name' => 'status',
                        'vname' => 'LBL_LIST_STATUS',
                        'width' => '10%',
                    ],
                    [
                        'name' => 'contact_name',
                        'module' => 'Contacts',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'target_record_key' => 'contact_id',
                        'target_module' => 'Contacts',
                        'vname' => 'LBL_LIST_CONTACT',
                        'width' => '20%',
                    ],
                    [
                        'name' => 'parent_name',
                        'module' => 'Tasks',
                        'vname' => 'LBL_LIST_RELATED_TO',
                        'width' => '22%',
                    ],
                    [
                        'name' => 'date_modified',
                        //'db_alias_to' => 'the_date',
                        'vname' => 'LBL_LIST_LAST_MODIFIED',
                        'width' => '10%',
                    ],
                    [
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelEditButton',
                        'module' => 'Tasks',
                        'width' => '4%',
                    ],
                    [
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelRemoveButton',
                        'linked_field' => 'tasks',
                        'module' => 'Tasks',
                        'width' => '4%',
                    ],
                ],
                'where' => "(tasks.status='Completed' OR tasks.status='Deferred')",
                'order_by' => 'tasks.date_start',
            ],
            'Calls' => [
                'columns' => [
                    [
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelIcon',
                        'module' => 'Calls',
                        'width' => '2%',
                    ],
                    [
                        'name' => 'name',
                        'vname' => 'LBL_LIST_SUBJECT',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'width' => '28%',
                    ],
                    [
                        'name' => 'status',
                        'vname' => 'LBL_LIST_STATUS',
                        'width' => '10%',
                    ],
                    [
                        'name' => 'contact_name',
                        'module' => 'Contacts',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'target_record_key' => 'contact_id',
                        'target_module' => 'Contacts',
                        'vname' => 'LBL_LIST_CONTACT',
                        'width' => '20%',
                    ],
                    [
                        'name' => 'parent_name',
                        'module' => 'Meetings',
                        'vname' => 'LBL_LIST_RELATED_TO',
                        'width' => '22%',
                    ],
                    [
                        'name' => 'date_modified',
                        //'db_alias_to' => 'the_date',
                        'vname' => 'LBL_LIST_LAST_MODIFIED',
                        'width' => '10%',
                    ],
                    [
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelEditButton',
                        'module' => 'Calls',
                        'width' => '4%',
                    ],
                    [
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelRemoveButton',
                        'linked_field' => 'calls',
                        'module' => 'Calls',
                        'width' => '4%',
                    ],
                ],
                'where' => "(calls.status='Held' OR calls.status='Not Held')",
                'order_by' => 'calls.date_modified',
            ],
        ],
    ],
];
