<?php

/**
 * The file used to handle layout of subpanel for survey submission
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$viewdefs['bc_survey_submission']['base']['view']['subpanel-list'] = array(
    'panels' =>
    array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' =>
            array(
                'survey_name' =>
                array(
                    'name' => 'bc_survey_submission_bc_survey_name',
                    'label' => 'LBL_BC_SURVEY_SUBMISSION_BC_SURVEY_FROM_BC_SURVEY_TITLE',
                    'module' => 'bc_survey',
                    'target_record_key' => 'id',
                    'target_module' => 'bc_survey',
                    'width' => '10%',
                ),
                'email_opened' =>
                array(
                    'default' => true,
                    'label' => 'LBL_EMAIL_OPENED',
                    'width' => '10%',
                    'name' => 'email_opened'
                ),
                'survey_send' =>
                array(
                    'default' => true,
                    'label' => 'LBL_SURVEY_SEND',
                    'width' => '10%',
                    'name' => 'survey_send'
                ),
                'schedule_on' =>
                array(
                    'label' => 'LBL_SCHEDULE_ON',
                    'width' => '10%',
                    'default' => true,
                    'name' => 'schedule_on'
                ),
                'status' =>
                array(
                    'default' => true,
                    'studio' => 'visible',
                    'label' => 'LBL_STATUS',
                    'width' => '10%',
                    'name' => 'status'
                ),
                'resubmit' =>
                array(
                    'default' => true,
                    'studio' => 'visible',
                    'label' => 'Resend',
                    'width' => '10%',
                    'name' => 'resubmit'
                ),
                'resend_counter' =>
                array(
                    'default' => true,
                    'studio' => 'visible',
                    'label' => 'Resend Counter',
                    'width' => '10%',
                    'name' => 'resend_counter'
                ),
                'resubmit_counter' =>
                array(
                    'default' => true,
                    'studio' => 'visible',
                    'label' => 'Resubmit Counter',
                    'width' => '10%',
                    'name' => 'resubmit_counter'
                ),
                'submitted_by' =>
                array(
                    'studio' => 'visible',
                    'default' => true,
                    'label' => 'LBL_SUBMITTED_BY',
                    'width' => '10%',
                    'name' => 'submitted_by'
                ),
                'score_percentage' =>
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
    'rowactions' => array(
        'actions' => array(
            array(
                'type' => 'rowaction',
                'name' => 'view_report',
                'event' => 'button:view_report:click',
                'icon' => 'fa-flash', // check out style guide for more options: /#Styleguide/docs/base-icons
                'label' => 'LBL_VIEW_REPORT',
                'acl_action' => 'view',
            ),
            array(
                'type' => 'rowaction',
                'name' => 'attend_survey',
                'event' => 'button:attend_survey:click',
                'label' => 'LBL_ATTEND_SURVEY',
                'acl_action' => 'view',
            ),
            array(
                'type' => 'rowaction',
                'name' => 'resend_survey',
                'event' => 'button:resend_survey:click',
                'label' => 'LBL_RESEND_SURVEY',
                'acl_action' => 'view',
            ),
        ),
    ),
);
