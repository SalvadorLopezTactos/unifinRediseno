<?php

/**
 * The file used to handle layout for survey listview
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$module_name = 'bc_survey';
$listViewDefs [$module_name] = array(
            'NAME' =>
            array(
                'width' => '32%',
                'label' => 'LBL_NAME',
                'default' => true,
                'link' => true,
            ),
            'START_DATE' =>
            array(
                'type' => 'datetimecombo',
                'label' => 'LBL_START_DATE',
                'width' => '10%',
                'default' => true,
            ),
            'END_DATE' =>
            array(
                'type' => 'datetimecombo',
                'label' => 'LBL_END_DATE',
                'width' => '10%',
                'default' => true,
            ),
            'BC_SURVEY_BC_SURVEY_TEMPLATE_NAME' =>
            array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_BC_SURVEY_BC_SURVEY_TEMPLATE_FROM_BC_SURVEY_TEMPLATE_TITLE',
                'id' => 'BC_SURVEY_BC_SURVEY_TEMPLATEBC_SURVEY_TEMPLATE_IDA',
                'width' => '10%',
                'default' => true,
            ),
            'ASSIGNED_USER_NAME' =>
            array(
                'width' => '9%',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'module' => 'Employees',
                'id' => 'ASSIGNED_USER_ID',
                'default' => true,
            ),
);
?>