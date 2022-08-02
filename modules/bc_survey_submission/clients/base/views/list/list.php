<?php

$module_name = 'bc_survey_submission';
$viewdefs[$module_name] = array(
            'base' =>
            array(
                'view' =>
                array(
                    'list' =>
                    array(
                        'panels' =>
                        array(
                            0 =>
                            array(
                                'label' => 'LBL_PANEL_1',
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'bc_survey_submission_bc_survey_name',
                                        'label' => 'LBL_BC_SURVEY_SUBMISSION_BC_SURVEY_FROM_BC_SURVEY_TITLE',
                                        'enabled' => true,
                                        'id' => 'BC_SURVEY_SUBMISSION_BC_SURVEYBC_SURVEY_IDA',
                                        'link' => true,
                                        'sortable' => false,
                                        'default' => true,
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'customer_name',
                                        'label' => 'LBL_CUSTOMER_NAME',
                                        'enabled' => true,
                                        'default' => true,
                                        'link' => true,
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'target_parent_type',
                                        'label' => 'LBL_TARGET_PARENT_NAME',
                                        'enabled' => true,
                                        'default' => true,
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'target_parent_name',
                                        'label' => 'LBL_TARGET_LIST_RELATED_TO',
                                        'enabled' => true,
                                        'default' => true,
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'parent_type',
                                        'label' => 'LBL_ORIGIN_PARENT_NAME',
                                        'enabled' => true,
                                        'default' => true,
                                    ),
                                    5 =>
                                    array(
                                        'name' => 'parent_name',
                                        'label' => 'LBL_ORIGIN_LIST_RELATED_TO',
                                        'enabled' => true,
                                        'id' => 'PARENT_ID',
                                        'link' => true,
                                        'sortable' => false,
                                        'default' => true,
                                    ),
                                    6 =>
                                    array(
                                        'name' => 'schedule_on',
                                        'label' => 'LBL_SCHEDULE_ON',
                                        'enabled' => true,
                                        'default' => true,
                                    ),
                                    7 =>
                                    array(
                                        'name' => 'submission_date',
                                        'label' => 'LBL_SUBMISSION_DATE',
                                        'enabled' => true,
                                        'default' => true,
                                    ),
                                    8 =>
                                    array(
                                        'name' => 'survey_send',
                                        'label' => 'LBL_SURVEY_SEND',
                                        'enabled' => true,
                                        'default' => true,
                                    ),
                                    9 =>
                                    array(
                                        'name' => 'email_opened',
                                        'label' => 'LBL_EMAIL_OPENED',
                                        'enabled' => true,
                                        'default' => true,
                                    ),
                                    10 =>
                                    array(
                                        'name' => 'status',
                                        'label' => 'LBL_STATUS',
                                        'enabled' => true,
                                        'default' => true,
                                    ),
                                    11 =>
                                    array(
                                        'name' => 'submission_type',
                                        'label' => 'LBL_SUBMISSION_TYPE',
                                        'enabled' => true,
                                        'default' => true,
                                    ),
                                    12 =>
                                    array(
                                        'name' => 'base_score',
                                        'label' => 'LBL_BASE_SCORE',
                                        'enabled' => true,
                                        'default' => true,
                                    ),
                                    13 =>
                                    array(
                                        'name' => 'obtained_score',
                                        'label' => 'LBL_OBTAINED_SCORE',
                                        'enabled' => true,
                                        'default' => true,
                                    ),
                                    14 =>
                                    array(
                                        'name' => 'score_percentage',
                                        'label' => 'LBL_SCORE_PERCENTAGE',
                                        'enabled' => true,
                                        'default' => true,
                                    ),
                                    15 =>
                                    array(
                                        'name' => 'consent_accepted',
                                        'label' => 'LBL_CONSENT_ACCEPTED',
                                        'enabled' => true,
                                        'default' => true,
                                ),
                            ),
                        ),
                        ),
                        'orderBy' =>
                        array(
                            'field' => 'date_modified',
                            'direction' => 'desc',
                        ),
                    ),
                ),
            ),
);
