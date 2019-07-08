<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
/**
 * The file used to handle dashlet layout for survey template
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
global $app_strings;

$dashletMeta['bc_survey_templateDashlet'] = array('module' => 'bc_survey_template',
    'title' => translate('LBL_HOMEPAGE_TITLE', 'bc_survey_template'),
    'description' => 'A customizable view into bc_survey_template',
    'icon' => 'icon_bc_survey_template_32.gif',
    'category' => 'Module Views');