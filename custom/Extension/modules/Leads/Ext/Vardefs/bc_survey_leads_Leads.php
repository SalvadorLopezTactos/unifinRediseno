<?php

/**
 * The file used to store Relationship Definition 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$dictionary["Lead"]["fields"]["bc_survey_leads"] = array(
    'name' => 'bc_survey_leads',
    'type' => 'link',
    'relationship' => 'bc_survey_leads',
    'source' => 'non-db',
    'module' => 'bc_survey',
    'bean_name' => false,
    'vname' => 'LBL_BC_SURVEY_LEADS_FROM_BC_SURVEY_TITLE',
);