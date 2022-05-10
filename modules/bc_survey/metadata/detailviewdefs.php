<?php

/**
 * The file used to handle layout for survey detail view
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$module_name = 'bc_survey';
$viewdefs [$module_name] = array(
            'DetailView' =>
            array(
                'templateMeta' =>
                array(
                    'form' =>
                    array(
                        'buttons' =>
                        array(
                            0 => 'EDIT',
                            1 => 'DUPLICATE',
                            2 => 'DELETE',
                            3 => 'FIND_DUPLICATES',
                        ),
                    ),
                    'maxColumns' => '2',
                    'widths' =>
                    array(
                        0 =>
                        array(
                            'label' => '10',
                            'field' => '30',
                        ),
                        1 =>
                        array(
                            'label' => '10',
                            'field' => '30',
                        ),
                    ),
                    'useTabs' => false,
                    'tabDefs' =>
                    array(
                        'DEFAULT' =>
                        array(
                            'newTab' => false,
                            'panelDefault' => 'expanded',
                        ),
                    ),
                ),
                'panels' =>
                array(
                    'default' =>
                    array(
                        0 =>
                        array(
                            0 =>
                            array(
                                'name' => 'bc_survey_bc_survey_template_name',
                            ),
                            1 => 'name',
                        ),
                        1 =>
                        array(
                            0 =>
                            array(
                                'name' => 'logo',
                                'label' => 'LBL_LOGO',
                            ),
                        ),
                        2 =>
                        array(
                            0 =>
                            array(
                                'name' => 'start_date',
                                'label' => 'LBL_START_DATE',
                            ),
                            1 =>
                            array(
                                'name' => 'end_date',
                                'label' => 'LBL_END_DATE',
                            ),
                        ),
                        3 =>
                        array(
                            0 => 'description',
                            1 =>
                            array(
                                'name' => 'email_template',
                                'studio' => 'visible',
                                'label' => 'LBL_EMAIL_TEMPLATE',
                            ),
                        ),
                        4 =>
                        array(
                            0 =>
                            array(
                                'name' => 'theme',
                                'label' => 'LBL_THEME',
                            ),
                            1 =>
                            array(
                                'name' => 'created_by_name',
                                'label' => 'LBL_CREATED',
                            ),
                        ),
                        5 =>
                        array(
                            0 => 'date_entered',
                            1 => 'assigned_user_name',
                        ),
                    ),
                ),
            ),
);
?>