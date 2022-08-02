<?php

// created: 2016-08-03 09:00:29
$viewdefs['bc_survey_submission']['base']['view']['subpanel-for-accounts-bc_survey_submission_accounts'] = array(
    'panels' =>
    array(
        0 =>
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' =>
            array(
                0 =>
                array(
                    'name' => 'bc_survey_submission_bc_survey_name',
                    'label' => 'LBL_BC_SURVEY_SUBMISSION_BC_SURVEY_FROM_BC_SURVEY_TITLE',
                    'module' => 'bc_survey',
                    'target_record_key' => 'id',
                    'target_module' => 'bc_survey',
                    'default' => true,
                    'enabled' => true,
                ),
                1 =>
                array(
                    'name' => 'parent_type',
                    'label' => 'LBL_ORIGIN_PARENT_NAME',
                    'enabled' => true,
                    'default' => true,
                ),
                2 =>
                array(
                    'name' => 'parent_name',
                    'label' => 'LBL_ORIGIN_LIST_RELATED_TO',
                    'enabled' => true,
                    'id' => 'PARENT_ID',
                    'link' => true,
                    'sortable' => false,
                    'default' => true,
                ),
                3 =>
                array(
                    'default' => true,
                    'label' => 'LBL_EMAIL_OPENED',
                    'name' => 'email_opened',
                    'enabled' => true,
                ),
                4 =>
                array(
                    'default' => true,
                    'label' => 'LBL_SURVEY_SEND',
                    'name' => 'survey_send',
                    'enabled' => true,
                ),
                5 =>
                array(
                    'label' => 'LBL_SCHEDULE_ON',
                    'default' => true,
                    'name' => 'schedule_on',
                    'enabled' => true,
                ),
                6 =>
                array(
                    'default' => true,
                    'studio' => 'visible',
                    'label' => 'LBL_STATUS',
                    'name' => 'status',
                    'enabled' => true,
                ),
                7 =>
                array(
                    'default' => true,
                    'studio' => 'visible',
                    'label' => 'Resend',
                    'name' => 'resubmit',
                    'enabled' => true,
                ),
                8 =>
                array(
                    'default' => true,
                    'studio' => 'visible',
                    'label' => 'Resend Counter',
                    'width' => '10%',
                    'name' => 'resubmit_counter'
                ),
                9 =>
                array(
                    'studio' => 'visible',
                    'default' => true,
                    'label' => 'LBL_SUBMITTED_BY',
                    'name' => 'submitted_by',
                    'enabled' => true,
                ),
                10 =>
                array(
                    'name' => 'score_percentage',
                    'studio' => 'visible',
                    'default' => true,
                    'label' => 'LBL_SCORE_PERCENTAGE',
                    'width' => '10%',
                ),
            ),
        ),
    ),
    'rowactions' =>
    array(
        'actions' =>
        array(
            0 =>
            array(
                'type' => 'rowaction',
                'name' => 'view_report',
                'event' => 'button:view_report:click',
                'icon' => 'fa-flash',
                'label' => 'LBL_VIEW_REPORT',
                'acl_action' => 'view',
            ),
            1 =>
            array(
                'type' => 'rowaction',
                'name' => 'attend_survey',
                'event' => 'button:attend_survey:click',
                'label' => 'LBL_ATTEND_SURVEY',
                'acl_action' => 'view',
            ),
        ),
    ),
    'type' => 'subpanel-list',
);
