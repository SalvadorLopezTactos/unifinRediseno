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

 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$mod_strings = array (
		  //Labels for methods in the TrackerReporter.php file that are shown in TrackerDashlet
		  'ShowActiveUsers'      => 'Näta aktiivseid kasutajaid',
		  'ShowLastModifiedRecords' => 'Viimased 10 muudetud kirjet',
		  'ShowTopUser' => 'Top kasutaja',
		  'ShowMyModuleUsage' => 'Minu mooduli kasutus',
		  'ShowMyWeeklyActivities' => 'Minu nädalategevused',
		  'ShowTop3ModulesUsed' => 'Minu Top 3 kasutatud moodulit',
		  'ShowLoggedInUserCount' => 'Aktiivne kasutaja konto',
		  'ShowMyCumulativeLoggedInTime' => 'Minu kumulatiivne Login aeg (sel nädalal)',
		  'ShowUsersCumulativeLoggedInTime' => 'Kasutajate kumulatiivne login aeg (sel nädalal)',
		  
		  //Column header mapping
		  'action' => 'Tegevus',
		  'active_users' => 'Aktiivne kasutaja konto',
		  'date_modified' => 'Viimase tegevuse kuupäev',
		  'different_modules_accessed' => 'Ligipääsetavate kontode arv',
		  'first_name' => 'Eesnimi',
		  'item_id' => 'ID',
		  'item_summary' => 'Nimi',
		  'last_action' => 'Viimane tegevus kuupäev/aeg',
		  'last_name' => 'Perekonnanimi',
		  'module_name' => 'Mooduli nimi',
		  'records_modified' => 'Kokku muudetud kirjeid',
		  'top_module' => 'Top Module Accessed',
		  'total_count' => 'Lehevaatamisi kokku',
		  'total_login_time' => 'Aeg (hh:mm:ss)',
		  'user_name' => 'Kasutajanimi',
		  'users' => 'Kasutajad',
		  
		  //Administration related labels
		  'LBL_ENABLE' => 'Lubatud',
		  'LBL_MODULE_NAME_TITLE' => 'Trackerid',
		  'LBL_MODULE_NAME' => 'Trackerid',
		  'LBL_MODULE_NAME_SINGULAR' => 'Tracker',
		  'LBL_TRACKER_SETTINGS' => 'Trackeri sätted',
		  'LBL_TRACKER_QUERIES_DESC' => 'Trackeri päringud',
		  'LBL_TRACKER_QUERIES_HELP' => 'Track SQL statements when "Log slow queries" is enabled and the query execution time exceeds the "Slow query time threshold" value',
		  'LBL_TRACKER_PERF_DESC' => 'Trackeri toiming',
		  'LBL_TRACKER_PERF_HELP' => 'Track database roundtrips, files accessed and memory usage',
		  'LBL_TRACKER_SESSIONS_DESC' => 'Trackeri sessioonid',
		  'LBL_TRACKER_SESSIONS_HELP' => 'Tracki aktiivseid kasutajaid ja kasutajasessiooni infot',
		  'LBL_TRACKER_DESC' => 'Trackeri tegevused',
		  'LBL_TRACKER_HELP' => 'Tracki kasutajate lehe vaatamine (moodulid ja kirjed) ning kirjete salvestamisi.',
		  'LBL_TRACKER_PRUNE_INTERVAL' => 'Number of days of Tracker data to store when Scheduler prunes the tables',
		  'LBL_TRACKER_PRUNE_RANGE' => 'Päevade arv',
);
?>
