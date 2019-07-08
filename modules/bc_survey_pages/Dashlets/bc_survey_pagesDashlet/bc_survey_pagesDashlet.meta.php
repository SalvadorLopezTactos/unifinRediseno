<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
/**
 * The file used to handle layout of dashlet view for survey pages
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
global $app_strings;

$dashletMeta['bc_survey_pagesDashlet'] = array('module' => 'bc_survey_pages',
    'title' => translate('LBL_HOMEPAGE_TITLE', 'bc_survey_pages'),
    'description' => 'A customizable view into bc_survey_pages',
    'icon' => 'icon_bc_survey_pages_32.gif',
    'category' => 'Module Views');