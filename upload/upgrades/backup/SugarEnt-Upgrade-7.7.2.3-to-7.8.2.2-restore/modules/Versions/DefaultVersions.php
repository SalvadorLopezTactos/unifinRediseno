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
/*********************************************************************************
 * $Header$
 * Description:
 ********************************************************************************/
$default_versions = array();


$new_db = DBManagerFactory::getInstance();

$db_version = '2.5.1';
$dirName ='custom/include/language';
if(is_dir($dirName))
{
	$d = dir($dirName);
	while($entry = $d->read()) {
			 if ($entry != "." && $entry != "..") {
				// echo $dirName."/".$entry;
					  if (is_file($dirName."/".$entry) && substr($entry, -9)=='.lang.php') {
					$custom_lang_file = $dirName."/".$entry;

	if(is_readable($custom_lang_file))
	{
		$pattern = '/\$app_list_strings[\ ]*=[\ ]*array/';
		$subject = @sugar_file_get_contents($custom_lang_file);
		$matches = preg_match($pattern, $subject);
		if($matches > 0)
		{
			$db_version = '0';
		}
	}
	}}}
}
//$default_versions[] = array('name'=>'Custom Labels', 'db_version' =>'3.0', 'file_version'=>'3.0');
$default_versions[] = array('name'=>'Chart Data Cache', 'db_version' =>'3.5.1', 'file_version'=>'3.5.1');
$default_versions[] = array('name'=>'htaccess', 'db_version' =>'3.5.1', 'file_version'=>'3.5.1');
//$default_versions[] = array('name'=>'DST Fix', 'db_version' =>'3.5.1b', 'file_version'=>'3.5.1b');
$default_versions[] = array('name'=>'Rebuild Relationships', 'db_version' =>'4.0.0', 'file_version'=>'4.0.0');
$default_versions[] = array('name'=>'Rebuild Extensions', 'db_version' =>'4.0.0', 'file_version'=>'4.0.0');
//$default_versions[] = array('name'=>'Studio Files', 'db_version' =>'4.5.0', 'file_version'=>'4.5.0');
?>
