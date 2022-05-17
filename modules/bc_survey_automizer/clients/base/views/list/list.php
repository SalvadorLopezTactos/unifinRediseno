<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * The file used to manage list for Automizer 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$module_name = 'bc_survey_automizer';
$viewdefs[$module_name]['base']['view']['list'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name' => 'name',
                    'label' => 'LBL_NAME',
                    'default' => true,
                    'enabled' => true,
                    'link' => true,
                ),
                array(
                    'name' => 'status',
                    'label' => 'LBL_STATUS',
                    'default' => true,
                    'enabled' => true,
                    'link' => false,
                ),
                array(
                    'name' => 'target_module',
                    'label' => 'LBL_TARGET_MODULE',
                    'default' => true,
                    'enabled' => true,
                    'link' => false,
                ),
                array(
                    'name' => 'execution_occurs',
                    'label' => 'LBL_EXECUTION_OCCURS',
                    'default' => true,
                    'enabled' => true,
                    'link' => false,
                ),
                array(
                    'name' => 'assigned_user_name',
                    'label' => 'LBL_ASSIGNED_TO_NAME',
                    'default' => true,
                    'enabled' => true,
                    'link' => true,
                ),
                array(
                    'name' => 'date_modified',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'date_entered',
                    'enabled' => true,
                    'default' => true,
                ),
            ),
        ),
    ),
    'orderBy' => array(
        'field' => 'date_modified',
        'direction' => 'desc',
    ),
);
