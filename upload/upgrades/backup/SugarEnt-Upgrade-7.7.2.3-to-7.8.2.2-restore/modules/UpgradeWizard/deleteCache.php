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
 //		Module: module name, this module should have a file called TreeData.php
 //		Function: name of the function to be called in TreeData.php, the function will be called statically.
 //		PARAM prefixed properties: array of these property/values will be passed to the function as parameter.

require_once('include/JSON.php');

//require_once('modules/UpgradeWizard/uw_utils.php');

$json = getJSONobj();

//Clean modules from cache
$cachedir = sugar_cached("modules");
if(is_dir($cachedir)){
	$allModFiles = array();
	$allModFiles = findAllFiles($cachedir,$allModFiles);
   foreach($allModFiles as $file){
       	if(file_exists($file)){
			unlink($file);
       	}
   }
}
//Clean jsLanguage from cache
$cachedir = sugar_cached("jsLanguage");
if(is_dir($cachedir)){
	$allModFiles = array();
	$allModFiles = findAllFiles($cachedir,$allModFiles);
   foreach($allModFiles as $file){
	   	if(file_exists($file)){
			unlink($file);
	   	}
	}
}
//Clean smarty from cache
$cachedir = sugar_cached("smarty");
if(is_dir($cachedir)){
	$allModFiles = array();
	$allModFiles = findAllFiles($cachedir,$allModFiles);
   foreach($allModFiles as $file){
       	if(file_exists($file)){
			unlink($file);
       	}
   }
}

$response = '';
//$GLOBALS['log']->fatal('file name '.$file_name);
//$GLOBALS['log']->fatal('file size loaded '.filesize($file_name));
/*
if($allModFiles != null){
	foreach($allModFiles as $f){
		$GLOBALS['log']->fatal('file name '.$f);
		$response .= $f;
	}
}
*/
if (!empty($response)) {
    echo $response;
}
sugar_cleanup();
exit();
?>
