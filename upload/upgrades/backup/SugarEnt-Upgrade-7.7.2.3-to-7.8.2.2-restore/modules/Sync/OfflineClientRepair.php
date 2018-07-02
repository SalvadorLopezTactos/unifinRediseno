<?php
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

$current_user->is_admin = 1;
$_REQUEST['mode'] = 'execute';
include_once('modules/Administration/RepairIndex.php');


//rrs: if we synced down custom fields the languages were not being updated.
$mod_strings = return_module_language('en_us', 'Administration');
include_once('modules/Administration/QuickRepairAndRebuild.php');
$randc = new RepairAndClear();
$randc->repairAndClearAll(array('clearAll', 'repairDatabase'), array('All Modules'), true, false);
include_once('include/SugarObjects/LanguageManager.php');
LanguageManager::clearLanguageCache();
$current_user->is_admin = 0;
