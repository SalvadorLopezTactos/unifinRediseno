<?php
/**
 * The file used to manage record for Automizer conditions
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$module_name = 'bc_automizer_condition';
$viewdefs[$module_name] = array(
            'base' =>
            array(
                'view' =>
                array(
                    'record' =>
                    array(
                        'panels' =>
                        array(
                            0 =>
                            array(
                                'name' => 'panel_header',
                                'label' => 'LBL_RECORD_HEADER',
                                'header' => true,
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'picture',
                                        'type' => 'avatar',
                                        'width' => 42,
                                        'height' => 42,
                                        'dismiss_label' => true,
                                        'readonly' => true,
                                    ),
                                    1 => 'name',
                                    2 =>
                                    array(
                                        'name' => 'favorite',
                                        'label' => 'LBL_FAVORITE',
                                        'type' => 'favorite',
                                        'readonly' => true,
                                        'dismiss_label' => true,
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'follow',
                                        'label' => 'LBL_FOLLOW',
                                        'type' => 'follow',
                                        'readonly' => true,
                                        'dismiss_label' => true,
                                    ),
                                ),
                            ),
                            1 =>
                            array(
                                'name' => 'panel_body',
                                'label' => 'LBL_RECORD_BODY',
                                'columns' => 2,
                                'labelsOnTop' => true,
                                'placeholders' => true,
                                'fields' =>
                                array(
                                    0 => 'condition_module',
                                    1 => 'field',
                                    2 => 'operator',
                                    3 => 'value_type',
                                    4 => 'value',
                                    5 => 'condition_order',
                                    6 =>
                                    array(
                                        'name' => 'bc_automizer_condition_bc_survey_automizer_name',
                                    ),
                                ),
                            ),
                            
                        ),
                    ),
                ),
            ),
);
