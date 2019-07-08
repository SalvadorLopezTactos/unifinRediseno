<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
/**
 * The file used to handle layout of dashlet view for survey questions
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
global $app_strings;

$dashletMeta['bc_survey_questionsDashlet'] = array('module' => 'bc_survey_questions',
    'title' => translate('LBL_HOMEPAGE_TITLE', 'bc_survey_questions'),
    'description' => 'A customizable view into bc_survey_questions',
    'icon' => 'icon_bc_survey_questions_32.gif',
    'category' => 'Module Views');