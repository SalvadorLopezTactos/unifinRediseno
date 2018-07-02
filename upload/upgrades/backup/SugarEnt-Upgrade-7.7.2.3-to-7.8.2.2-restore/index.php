<?php
//ini_set('error_log','/var/www/deveast/hunter_prod/sugarcrm_php.log');
//ini_set('error_log','C:\wamp\www\sugarcrm_unifin\sugarcrm_php.log');
//ini_set('log_errors', TRUE);
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', TRUE);
if(!defined('sugarEntry'))define('sugarEntry', true);
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

define('ENTRY_POINT_TYPE', 'gui');
include ('include/MVC/preDispatch.php');
$startTime = microtime(true);
require_once('include/entryPoint.php');
ob_start();

SugarAutoLoader::requireWithCustom('include/MVC/SugarApplication.php');
$appClass = SugarAutoLoader::customClass('SugarApplication');
$app = new $appClass();
/*
$app->startSession() is now part of SugarApplication::execute() method.
We only load session if the entry point requires it.
*/
$app->execute();
