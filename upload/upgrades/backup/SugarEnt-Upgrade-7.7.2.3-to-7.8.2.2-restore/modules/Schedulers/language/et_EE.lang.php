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
global $sugar_config;

$mod_strings = array (
// OOTB Scheduler Job Names:
'LBL_OOTB_WORKFLOW'		=> 'Töötle töövoo ülesandeid',
'LBL_OOTB_REPORTS'		=> 'Run Report Generation Scheduled Tasks',
'LBL_OOTB_IE'			=> 'Vaata sissetulevaid postkaste',
'LBL_OOTB_BOUNCE'		=> 'Run Nightly Process Bounced Campaign Emails',
'LBL_OOTB_CAMPAIGN'		=> 'Run Nightly Mass Email Campaigns',
'LBL_OOTB_PRUNE'		=> 'Prune Database on 1st of Month',
'LBL_OOTB_TRACKER'		=> 'Prune tracker tables',
'LBL_OOTB_PRUNE_RECORDLISTS'		=> 'Prune Old Record Lists',
'LBL_OOTB_REMOVE_TMP_FILES' => 'Remove temporary files',
'LBL_OOTB_REMOVE_DIAGNOSTIC_FILES' => 'Remove diagnostic tool files',
'LBL_OOTB_REMOVE_PDF_FILES' => 'Remove temporary PDF files',
'LBL_UPDATE_TRACKER_SESSIONS' => 'Uuenda tracker_sessions tabelit',
'LBL_OOTB_SEND_EMAIL_REMINDERS'	=> 'Run Email Reminder Notifications',
'LBL_OOTB_CLEANUP_QUEUE' => 'Clean Jobs Queue',
'LBL_OOTB_CREATE_NEXT_TIMEPERIOD' => 'Create Future TimePeriods',
'LBL_OOTB_HEARTBEAT' => 'Sugar Heartbeat',
'LBL_OOTB_KBCONTENT_UPDATE' => 'Update KBContent articles.',
'LBL_OOTB_KBSCONTENT_EXPIRE' => 'Publish approved articles & Expire KB Articles.',
'LBL_OOTB_PROCESS_AUTHOR_JOB' => 'Process Author Scheduled Job',

// List Labels
'LBL_LIST_JOB_INTERVAL' => 'Intervall:',
'LBL_LIST_LIST_ORDER' => 'Planeerijad:',
'LBL_LIST_NAME' => 'Planeerija:',
'LBL_LIST_RANGE' => 'Vahemik:',
'LBL_LIST_REMOVE' => 'Eemalda:',
'LBL_LIST_STATUS' => 'Olek:',
'LBL_LIST_TITLE' => 'Planeerimise loend',
'LBL_LIST_EXECUTE_TIME' => 'Käivitab:',
// human readable:
'LBL_SUN'		=> 'Pühapäev',
'LBL_MON'		=> 'Esmaspäev',
'LBL_TUE'		=> 'Teisipäev',
'LBL_WED'		=> 'Kolmapäev',
'LBL_THU'		=> 'Neljapäev',
'LBL_FRI'		=> 'Reede',
'LBL_SAT'		=> 'Laupäev',
'LBL_ALL'		=> 'Iga päev',
'LBL_EVERY_DAY'	=> 'Iga päev',
'LBL_AT_THE'	=> 'At the',
'LBL_EVERY'		=> 'Iga',
'LBL_FROM'		=> 'Kellelt:',
'LBL_ON_THE'	=> 'On the',
'LBL_RANGE'		=> 'to',
'LBL_AT' 		=> 'at',
'LBL_IN'		=> 'in',
'LBL_AND'		=> 'and',
'LBL_MINUTES'	=> 'minutit',
'LBL_HOUR'		=> 'tundi',
'LBL_HOUR_SING'	=> 'tund',
'LBL_MONTH'		=> 'kuu',
'LBL_OFTEN'		=> 'Nii tihti kui võimalik.',
'LBL_MIN_MARK'	=> 'minute mark',


// crontabs
'LBL_MINS' => 'min',
'LBL_HOURS' => 'hrs',
'LBL_DAY_OF_MONTH' => 'kuupäev',
'LBL_MONTHS' => 'kuu',
'LBL_DAY_OF_WEEK' => 'päev',
'LBL_CRONTAB_EXAMPLES' => 'The above uses standard crontab notation.',
'LBL_CRONTAB_SERVER_TIME_PRE' =>  'The cron specifications run based on the server timezone (',
'LBL_CRONTAB_SERVER_TIME_POST' => '). Please specify the scheduler execution time accordingly.',
// Labels
'LBL_ALWAYS' => 'Alati',
'LBL_CATCH_UP' => 'Execute If Missed',
'LBL_CATCH_UP_WARNING' => 'Kontrolli, kas see töö võib võtta käivituseks aega enam kui hetke.',
'LBL_DATE_TIME_END' => 'Date & Time End',
'LBL_DATE_TIME_START' => 'Date & Time Start',
'LBL_INTERVAL' => 'Intervall',
'LBL_JOB' => 'Töö',
'LBL_JOB_URL' => 'Job URL',
'LBL_LAST_RUN' => 'Viimane edukas käivitus',
'LBL_MODULE_NAME' => 'Sugari Planeerija',
'LBL_MODULE_NAME_SINGULAR' => 'Sugari Planeerija',
'LBL_MODULE_TITLE' => 'Planeerijad',
'LBL_NAME' => 'Töö nimi',
'LBL_NEVER' => 'Mitte kunagi',
'LBL_NEW_FORM_TITLE' => 'Uus ajakava',
'LBL_PERENNIAL' => 'pidev',
'LBL_SEARCH_FORM_TITLE' => 'Planeerija otsing',
'LBL_SCHEDULER' => 'Planeerija:',
'LBL_STATUS' => 'Olek',
'LBL_TIME_FROM' => 'Aktiivne',
'LBL_TIME_TO' => 'Aktiivne',
'LBL_WARN_CURL_TITLE' => 'cURL hoiatus:',
'LBL_WARN_CURL' => 'Hoiatus:',
'LBL_WARN_NO_CURL' => 'Süsteemil pol ecURL andmekogusid lubatud/koostatud PHP moodulis (--with-curl=/path/to/curl_library). Palun kontakteeru oma administraatoriga selle probleemi lahendamiseks. Ilma cURL funktsioonita ei saa Planeerija oma töid läbi viia.',
'LBL_BASIC_OPTIONS' => 'Põhiseadistus',
'LBL_ADV_OPTIONS'		=> 'Laiendatud suvandid',
'LBL_TOGGLE_ADV' => 'Näita laiendatud suvandeid',
'LBL_TOGGLE_BASIC' => 'Näita põhisuvandeid',
// Links
'LNK_LIST_SCHEDULER' => 'Planeerijad',
'LNK_NEW_SCHEDULER' => 'Loo Planeerija',
'LNK_LIST_SCHEDULED' => 'Plaanitud tööd',
// Messages
'SOCK_GREETING' => "See on SugarCRM Planeerijate Teenuse liides. [ saadaolevad käsud: start|restart|shutdown|status ] Lõpetamiseks kirjuta 'quit'. Teenuse sulgemiseks kirjuta 'shutdown'.",
'ERR_DELETE_RECORD' => 'Ajakava kustutamiseks täpsusta kirje numbrit.',
'ERR_CRON_SYNTAX' => 'Invalid Cron syntax',
'NTC_DELETE_CONFIRMATION' => 'Oled kindel, et soovid seda kirjet kustutada?',
'NTC_STATUS' => 'Selle ajakava eemaldamiseks Planeerija rippmenüü loenditest määra staatus mitteaktiivseks.',
'NTC_LIST_ORDER' => 'Määra järjekord, mitmendana see ajakava kuvatakse Planeerija rippmenüü nimekirjades',
'LBL_CRON_INSTRUCTIONS_WINDOWS' => 'To Setup Windows Scheduler',
'LBL_CRON_INSTRUCTIONS_LINUX' => 'To Setup Crontab',
'LBL_CRON_LINUX_DESC' => 'Note: In order to run Sugar Schedulers, add the following line to the crontab file:',
'LBL_CRON_WINDOWS_DESC' => 'Note: In order to run the Sugar schedulers, create a batch file to run using Windows Scheduled Tasks. The batch file should include the following commands:',
'LBL_NO_PHP_CLI' => 'If your host does not have the PHP binary available, you can use wget or curl to launch your Jobs.<br>for wget: <b>*&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;&nbsp;&nbsp;&nbsp;wget --quiet --non-verbose '.$sugar_config['site_url'].'/cron.php > /dev/null 2>&1</b><br>for curl: <b>*&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;&nbsp;&nbsp;&nbsp;curl --silent '.$sugar_config['site_url'].'/cron.php > /dev/null 2>&1',
// Subpanels
'LBL_JOBS_SUBPANEL_TITLE'	=> 'Job Log',
'LBL_EXECUTE_TIME'			=> 'Täitmisaeg',

//jobstrings
'LBL_REFRESHJOBS' => 'Värskenda tööd',
'LBL_POLLMONITOREDINBOXES' => 'Kontrolli Sissetulevate e-kirjade kontosid',
'LBL_PERFORMFULLFTSINDEX' => 'Full-text Search Index System',

'LBL_RUNMASSEMAILCAMPAIGN' => 'Run Nightly Mass Email Campaigns',
'LBL_ASYNCMASSUPDATE' => 'Perform Asynchronous Mass Updates',
'LBL_POLLMONITOREDINBOXESFORBOUNCEDCAMPAIGNEMAILS' => 'Run Nightly Process Bounced Campaign Emails',
'LBL_PRUNEDATABASE' => 'Prune Database on 1st of Month',
'LBL_TRIMTRACKER' => 'Prune Tracker Tables',
'LBL_PROCESSWORKFLOW' => 'Töötle töövoo ülesandeid',
'LBL_PROCESSQUEUE' => 'Käivita Report Generation Scheduled ülesanded',
'LBL_UPDATETRACKERSESSIONS' => 'Uuenda trackeri sessiooni tabeleid',
'LBL_SUGARJOBCREATENEXTTIMEPERIOD' => 'Create Future TimePeriods',
'LBL_SUGARJOBHEARTBEAT' => 'Sugar Heartbeat',
'LBL_SENDEMAILREMINDERS'=> 'Run Email Reminders Sending',
'LBL_CLEANJOBQUEUE' => 'Cleanup Job Queue',
'LBL_CLEANOLDRECORDLISTS' => 'Cleanup Old Record Lists',
'LBL_PMSEENGINECRON' => 'Process Author Scheduler',
);

