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
/**
 * Known Entry Points as of 4.5
 * acceptDecline.php
 * campaign_tracker.php
 * campaign_trackerv2.php
 * cron.php
 * dictionary.php
 * download.php
 * emailmandelivery.php
 * export_dataset.php
 * export.php
 * image.php
 * index.php
 * install.php
 * json.php
 * json_server.php
 * leadCapture.php
 * maintenance.php
 * metagen.php
 * pdf.php
 * phprint.php
 * process_queue.php
 * process_workflow.php
 * removeme.php
 * schedulers.php
 * soap.php
 * su.php
 * sugar_version.php
 * TreeData.php
 * tree_level.php
 * tree.php
 * vcal_server.php
 * vCard.php
 * zipatcher.php
 * WebToLeadCapture.php
 * HandleAjaxCall.php */
 /*
  * for 50, added:
  * minify.php
  */
  /*
  * for 510, added:
  * dceActionCleanup.php
  */
$GLOBALS['starttTime'] = microtime(true);

if (!defined('SUGAR_BASE_DIR')) {
    define('SUGAR_BASE_DIR', str_replace('\\', '/', realpath(dirname(__FILE__) . '/..')));
}

set_include_path(
    SUGAR_BASE_DIR . PATH_SEPARATOR .
    SUGAR_BASE_DIR . '/vendor' . PATH_SEPARATOR .
    get_include_path()
);

if (!defined('PHP_VERSION_ID')) {
    $version_array = explode('.', phpversion());
    define('PHP_VERSION_ID', ($version_array[0]*10000 + $version_array[1]*100 + $version_array[2]));
}

if(empty($GLOBALS['installing']) && !file_exists('config.php'))
{
	header('Location: install.php');
	exit ();
}

// config|_override.php
if(is_file('config.php')) {
    require_once('config.php'); // provides $sugar_config
}

// load up the config_override.php file.  This is used to provide default user settings
if(is_file('config_override.php')) {
    require_once('config_override.php');
}


if(empty($GLOBALS['installing']) &&empty($sugar_config['dbconfig']['db_name']))
{
	    header('Location: install.php');
	    exit ();
}

if (!empty($sugar_config['xhprof_config']))
{
    require_once 'include/SugarXHprof/SugarXHprof.php';
    SugarXHprof::getInstance()->start();
}

// make sure SugarConfig object is available
require_once 'include/SugarObjects/SugarConfig.php';

require_once('include/utils.php');
register_shutdown_function('sugar_cleanup');
///////////////////////////////////////////////////////////////////////////////
////	DATA SECURITY MEASURES
require_once('include/clean.php');
clean_special_arguments();
clean_incoming_data();
////	END DATA SECURITY MEASURES
///////////////////////////////////////////////////////////////////////////////

// cn: set php.ini settings at entry points
setPhpIniSettings();

require_once('sugar_version.php'); // provides $sugar_version, $sugar_db_version, $sugar_flavor

require_once('include/utils/sugar_file_utils.php');
require_once('include/utils/autoloader.php');
SugarAutoLoader::init();
//check to see if custom utils exist and load them too
// not doing it in utils since autoloader is not loaded there yet
foreach(SugarAutoLoader::existing('include/custom_utils.php', 'custom/include/custom_utils.php', SugarAutoLoader::loadExtension('utils')) as $file) {
	require_once $file;
}

require_once('include/database/DBManagerFactory.php');
require_once('include/dir_inc.php');

require_once('include/Localization/Localization.php');
require_once('include/TimeDate.php');
require_once('include/modules.php'); // provides $moduleList, $beanList, $beanFiles, $modInvisList, $adminOnlyList, $modInvisListActivities

require_once('data/SugarBean.php');
require_once('include/utils/mvc_utils.php');
require_once('include/SugarObjects/LanguageManager.php');
require_once('include/SugarObjects/VardefManager.php');

require_once('include/utils/file_utils.php');
require_once('include/SugarLogger/LoggerManager.php');
require_once('modules/Trackers/BreadCrumbStack.php');
require_once('modules/Trackers/Tracker.php');
require_once('modules/Trackers/TrackerManager.php');
require_once('modules/Administration/updater_utils.php');
require_once('modules/Users/User.php');
require_once('modules/Users/authentication/AuthenticationController.php');
require_once('include/utils/LogicHook.php');
require_once('include/MVC/SugarModule.php');
require_once('include/SugarCache/SugarCache.php');
require_once('modules/Currencies/Currency.php');
require_once('include/MVC/SugarApplication.php');
require_once 'data/SugarACL.php';

require_once('include/upload_file.php');
UploadStream::register();
//
//SugarApplication::startSession();

///////////////////////////////////////////////////////////////////////////////
////    Handle loading and instantiation of various Sugar* class
if (!defined('SUGAR_PATH')) {
    define('SUGAR_PATH', realpath(dirname(__FILE__) . '/..'));
}
if(empty($GLOBALS['installing'])){
///////////////////////////////////////////////////////////////////////////////
////	SETTING DEFAULT VAR VALUES
$GLOBALS['log'] = LoggerManager::getLogger('SugarCRM');
$error_notice = '';
$use_current_user_login = false;

// Allow for the session information to be passed via the URL for printing.
if(isset($_GET['PHPSESSID'])){
    if(!empty($_COOKIE['PHPSESSID']) && strcmp($_GET['PHPSESSID'],$_COOKIE['PHPSESSID']) == 0) {
        session_id($_REQUEST['PHPSESSID']);
    }else{
        unset($_GET['PHPSESSID']);
    }
}

    LogicHook::initialize()->call_custom_logic('', 'entry_point_variables_setting');

if(!empty($sugar_config['session_dir'])) {
	session_save_path($sugar_config['session_dir']);
}

$GLOBALS['sugar_version'] = $sugar_version;
$GLOBALS['sugar_flavor'] = $sugar_flavor;
$GLOBALS['js_version_key'] = get_js_version_key();

SugarApplication::preLoadLanguages();

$timedate = TimeDate::getInstance();
$GLOBALS['timedate'] = $timedate;

$db = DBManagerFactory::getInstance();
$db->resetQueryCount();
$locale = Localization::getObject();

// Emails uses the REQUEST_URI later to construct dynamic URLs.
// IIS does not pass this field to prevent an error, if it is not set, we will assign it to ''.
if (!isset ($_SERVER['REQUEST_URI'])) {
	$_SERVER['REQUEST_URI'] = '';
}

$current_user = BeanFactory::getBean('Users');
$current_entity = null;
$system_config = Administration::getSettings();

LogicHook::initialize()->call_custom_logic('', 'after_entry_point');
}


////	END SETTING DEFAULT VAR VALUES
///////////////////////////////////////////////////////////////////////////////

?>
