<?php

/**
 * The file used to store survey relationship definition 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$dictionary["bc_survey"]["fields"]["bc_survey_contacts"] = array(
    'name' => 'bc_survey_contacts',
    'type' => 'link',
    'relationship' => 'bc_survey_contacts',
    'source' => 'non-db',
    'module' => 'Contacts',
    'bean_name' => 'Contact',
    'vname' => 'LBL_BC_SURVEY_CONTACTS_FROM_CONTACTS_TITLE',
);