<?php
/**
 * The file used for the getting preview page & unsubscibe entryPoint 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$entry_point_registry['preview_survey'] = array(
    'file' => 'custom/biz/classes/submissioncontroller.php',
    'auth' => false
);
$entry_point_registry['unsubscribe'] = array(
    'file' => 'unsubscribe.php',
    'auth' => false
);
$entry_point_registry['export_survey_form'] = array(
    'file' => 'custom/biz/classes/export_survey_form.php',
    'auth' => false
);
$entry_point_registry['exportReportsData'] = array(
    'file' => 'custom/biz/classes/exportReportsData.php',
    'auth' => false
);
$entry_point_registry['questionWiseExport'] = array(
    'file' => 'custom/biz/classes/questionWiseExport.php',
    'auth' => false
);