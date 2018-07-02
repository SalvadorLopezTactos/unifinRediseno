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

// $Id: clear_chart_cache.php 45763 2009-04-01 19:16:18Z majed $

global $sugar_config, $mod_strings;

print( $mod_strings['LBL_CLEAR_CHART_DATA_CACHE_FINDING'] . "<br>" );

$search_dir=sugar_cached("");
$all_src_files  = findAllFiles($search_dir.'/xml', array() );

print( $mod_strings['LBL_CLEAR_CHART_DATA_CACHE_DELETING1'] . "<br>" );
foreach( $all_src_files as $src_file ){
	if (preg_match('/\.xml$/',$src_file))
	{
   		print( $mod_strings['LBL_CLEAR_CHART_DATA_CACHE_DELETING2'] . " $src_file<BR>" ) ;
		unlink( "$src_file" );
	}
}

include('modules/Versions/ExpectedVersions.php');


global $expect_versions;

if (isset($expect_versions['Chart Data Cache'])) {
	$version = BeanFactory::getBean('Versions');
	$version->retrieve_by_string_fields(array('name'=>'Chart Data Cache'));

	$version->name = $expect_versions['Chart Data Cache']['name'];
	$version->file_version = $expect_versions['Chart Data Cache']['file_version'];
	$version->db_version = $expect_versions['Chart Data Cache']['db_version'];
	$version->save();
}

echo "\n--- " . $mod_strings['LBL_DONE'] . "---<br />\n";
?>
