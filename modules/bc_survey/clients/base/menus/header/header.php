<?php

/**
 * The file used to set layout of header od module 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$moduleName = 'bc_survey';

$viewdefs[$moduleName]['base']['menu']['header'] = array(
    array(
        'route' => "#$moduleName/create",
        'label' => 'LNK_NEW_RECORD',
        'acl_action' => 'create',
        'acl_module' => $moduleName,
        'icon' => 'fa-plus',
    ),
    array(
        'route' => "#$moduleName/create",
        'label' => 'LNK_NEW_RECORD_POLL',
        'acl_module' => $moduleName,
        'icon' => 'fa-plus',
    ),
    array(
        'route' => "#$moduleName",
        'label' => 'LNK_LIST',
        'acl_action' => 'list',
        'acl_module' => $moduleName,
        'icon' => 'fa-bars',
    ),
    array(
        'route' => "#$moduleName",
        'label' => 'LNK_LIST_POLL',
        'acl_action' => 'list',
        'acl_module' => $moduleName,
        'icon' => 'fa-bars',
    ),
    array(
        'route' => "#bc_survey_submission",
        'label' => 'LNK_LIST_SUBMISSION',
        'acl_action' => 'list',
        'acl_module' => "bc_survey_submission",
        'icon' => 'fa-bars',
    ),
);
