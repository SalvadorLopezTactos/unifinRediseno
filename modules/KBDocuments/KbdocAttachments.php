<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
 //Request object must have these property values:
 //     Module: module name, this module should have a file called TreeData.php
 //     Function: name of the function to be called in TreeData.php, the function will be called statically.
 //     PARAM prefixed properties: array of these property/values will be passed to the function as parameter.

require_once('include/JSON.php');
require_once('include/upload_file.php');

if ('POST' !== $_SERVER['REQUEST_METHOD']) {
    SugarApplication::redirect('index.php?module=KBDocuments');
}

$json = getJSONobj();
$not_a_file = 0;

$divAndEl = explode(",", $_REQUEST['div_name_and_El']);
$div_name = $divAndEl[0];
$element_name = $divAndEl[1];

$ret = array();

$currGuid = create_guid();
$is_file_image = 0;

$upload = new UploadFile($element_name);
if(!$upload->confirm_upload()) {
    $not_a_file = 1;
} else {
    $currGuid .= preg_replace('/[^-a-z0-9_]/i', '_', $_FILES[$element_name]['name']);
    $file_name = "upload://$currGuid";
    if(!$upload->final_move($file_name)) {
        $not_a_file = 1;
    } else {
        $is_file_image = verify_uploaded_image($file_name);
    }
}

if($not_a_file == 1) {
    $response=array('status'=>'failed','div_name'=>$div_name, 'error_message'=>$upload->getErrorMessage());
} else {
    $response=array('status'=>'success','div_name'=>$div_name,'new_file_name'=>$currGuid,'is_file_image'=>$is_file_image);
}
if (!empty($response)) {
    $json = getJSONobj();
    print $json->encode($response);
}
sugar_cleanup();
exit();
?>
