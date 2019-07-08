<?php

/**
 * The file used to handle edit layout for survey template
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$module_name = 'bc_survey_template';
$viewdefs [$module_name] = array(
    'EditView' =>
    array(
        'templateMeta' =>
        array(
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
                    0 => 'name',
                    1 => 'assigned_user_name',
                ),
                1 =>
                array(
                    0 => 'description',
                    1 =>
                    array(
                        'name' => 'bc_survey_pages_bc_survey_template_name',
                    ),
                ),
                2 =>
                array(
                    0 =>
                    array(
                        'name' => 'date_entered',
                        'comment' => 'Date record created',
                        'label' => 'LBL_DATE_ENTERED',
                    ),
                    1 =>
                    array(
                        'name' => 'date_modified',
                        'comment' => 'Date record last modified',
                        'label' => 'LBL_DATE_MODIFIED',
                    ),
                ),
                3 =>
                array(
                    0 =>
                    array(
                        'name' => 'created_by_name',
                        'label' => 'LBL_CREATED',
                    ),
                    1 => '',
                ),
                4 =>
                array(
                    0 => array(
                        'customCode' => '{$ADD_PAGE_BUTTON}',
                        'hideLabel' => true,
                    ),
                ),
            ),
        ),
    ),
);
?>