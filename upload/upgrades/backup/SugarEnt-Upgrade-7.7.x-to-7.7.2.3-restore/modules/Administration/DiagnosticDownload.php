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

global $current_user;


if (!is_admin($current_user)) sugar_die("Unauthorized access to administration.");
if (isset($GLOBALS['sugar_config']['hide_admin_diagnostics']) && $GLOBALS['sugar_config']['hide_admin_diagnostics'])
{
    sugar_die("Unauthorized access to diagnostic tool.");
}

if(!isset($_REQUEST['guid']) || !isset($_REQUEST['time']))
{
	die('Did not receive a filename to download');
}

ini_set('zlib.output_compression','Off');

$time = str_replace(array('.', '/', '\\'), '', $_REQUEST['time']);
$guid = str_replace(array('.', '/', '\\'), '', $_REQUEST['guid']);
$path = sugar_cached("diagnostic/{$guid}/diagnostic{$time}.zip");
$filesize = filesize($path);
ob_clean();
header('Content-Description: File Transfer');
header('Content-type: application/octet-stream');
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment; filename=$guid.zip");
header("Content-Transfer-Encoding: binary");
header("Content-Length: $filesize");
readfile($path);



?>
