<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
/**
 * The file used to add dashlet for bc_survey submission_date 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
global $app_strings;

$dashletMeta['bc_submission_dataDashlet'] = array('module' => 'bc_submission_data',
    'title' => translate('LBL_HOMEPAGE_TITLE', 'bc_submission_data'),
    'description' => 'A customizable view into bc_submission_data',
    'icon' => 'icon_bc_submission_data_32.gif',
    'category' => 'Module Views');