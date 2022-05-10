<?php

/**
 * The file used to handle layout of metafiles for survey answers
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$module_name = 'bc_survey_answers';
$metafiles[$module_name] = array(
    'detailviewdefs' => 'modules/' . $module_name . '/metadata/detailviewdefs.php',
    'editviewdefs' => 'modules/' . $module_name . '/metadata/editviewdefs.php',
    'listviewdefs' => 'modules/' . $module_name . '/metadata/listviewdefs.php',
    'searchdefs' => 'modules/' . $module_name . '/metadata/searchdefs.php',
    'popupdefs' => 'modules/' . $module_name . '/metadata/popupdefs.php',
    'searchfields' => 'modules/' . $module_name . '/metadata/SearchFields.php',
);
?>