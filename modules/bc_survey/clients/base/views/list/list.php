<?php

/**
 * The file used to set layout of list view
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$module_name = 'bc_survey';
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
                                'name' => 'name',
                                'label' => 'LBL_NAME',
                                'enabled' => true,
                                'link' => true,
                                'default' => true,
                            ),
                            // Survey Status :: LoadedTech Customization
                            1 =>
                            array(
                                'name' => 'survey_status',
                                'label' => 'LBL_SURVEY_STATUS',
                                'enabled' => true,
                                'default' => true,
                                'css_class' => 'full-width',
                                'link' => false,
                            ),
                            // Survey Status :: LoadedTech Customization END
                            2 =>
                            array(
                                'name' => 'start_date',
                                'label' => 'LBL_START_DATE',
                                'enabled' => true,
                                'default' => true,
                            ),
                            3 =>
                            array(
                                'name' => 'end_date',
                                'label' => 'LBL_END_DATE',
                                'enabled' => true,
                                'default' => true,
                            ),
                            4 =>
                            array(
                                'name' => 'survey_send_status',
                                'label' => 'LBL_SURVEY_SEND_STATUS',
                                'enabled' => true,
                                'default' => true,
                                'css_class' => 'full-width',
                                'link' => false,
                            ),
                            5 =>
                            array(
                                'name' => 'team_name',
                                'label' => 'LBL_TEAMS',
                                'enabled' => true,
                                'default' => true,
                            ),
                            6 =>
                            array(
                                'name' => 'assigned_user_name',
                                'label' => 'LBL_ASSIGNED_TO_NAME',
                                'id' => 'ASSIGNED_USER_ID',
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
