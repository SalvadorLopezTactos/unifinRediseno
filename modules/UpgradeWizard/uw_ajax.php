<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/*********************************************************************************

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 * *******************************************************************************/


////	COMMON

function ajaxSqlProgress($persistence, $sql, $type) {
	global $mod_strings;

	// $type is sql_to_check or sql_to_run
	$whatsLeft = count($persistence[$type]);

	ob_start();
	$out  = "<b>{$mod_strings['LBL_UW_PREFLIGHT_QUERY']}</b><br />";
	$out .= round((($persistence['sql_total'] - $whatsLeft) / $persistence['sql_total']) * 100, 1)."%
				{$mod_strings['LBL_UW_DONE']} - {$mod_strings['LBL_UW_PREFLIGHT_QUERIES_LEFT']}: {$whatsLeft}";
	$out .= "<br /><textarea cols='60' rows='3' DISABLED>{$sql}</textarea>";
	echo $out;
	ob_flush();

	if($whatsLeft < 1) {
		$persistence['sql_check_done'] = true;
	}

	return $persistence;
}


///////////////////////////////////////////////////////////////////////////////
////	COMMIT AJAX
/**
 * does post-post-install stuff
 * @param array persistence
 * @return array persistence
 */
function commitAjaxFinalTouches($persistence) {
	global $current_user;
	global $timedate;
	global $mod_strings;
	global $sugar_version;

	if(empty($sugar_version)) {
		require('sugar_version.php');
	}

	// rebuild
	logThis('Performing UWrebuild()...');
	UWrebuild();
	logThis('UWrebuild() done.');

	// upgrade history
	registerUpgrade($persistence);

	// flag to say upgrade has completed
	$persistence['upgrade_complete'] = true;

	// reminders if needed
	///////////////////////////////////////////////////////////////////////////////
	////	HANDLE REMINDERS
	if(count($persistence['skipped_files']) > 0) {
		$desc  = $mod_strings['LBL_UW_COMMIT_ADD_TASK_OVERVIEW']."\n\n";
		$desc .= $mod_strings['LBL_UW_COMMIT_ADD_TASK_DESC_1'];
		$desc .= $persistence['uw_restore_dir']."\n\n";
		$desc .= $mod_strings['LBL_UW_COMMIT_ADD_TASK_DESC_2']."\n\n";

		foreach($persistence['skipped_files'] as $file) {
			$desc .= $file."\n";
		}

		//MFH #13468
		$nowDate = $timedate->nowDbDate();
		$nowTime = $timedate->asDbTime($timedate->getNow());
		$nowDateTime = $nowDate.' '.$nowTime;

		if($_REQUEST['addTaskReminder'] == 'remind') {
			logThis('Adding Task for admin for manual merge.');

			$task = BeanFactory::newBean('Tasks');
			$task->name = $mod_strings['LBL_UW_COMMIT_ADD_TASK_NAME'];
			$task->description = $desc;
			$task->date_due = $nowDate;
			$task->time_due = $nowTime;
			$task->priority = 'High';
			$task->status = 'Not Started';
			$task->assigned_user_id = $current_user->id;
			$task->created_by = $current_user->id;
			$task->date_entered = $nowDateTime;
			$task->date_modified = $nowDateTime;
			$task->team_id = '1';
			$task->save();
		}

		if($_REQUEST['addEmailReminder'] == 'remind') {
			logThis('Sending Reminder for admin for manual merge.');

			$email = BeanFactory::newBean('Emails');
            $email->id = create_guid();
            $email->new_with_id = true;
			$email->assigned_user_id = $current_user->id;
			$email->name = $mod_strings['LBL_UW_COMMIT_ADD_TASK_NAME'];
			$email->description = $desc;
			$email->description_html = nl2br($desc);
			$email->from_name = $current_user->full_name;
			$email->from_addr = $current_user->email1;
			$email->to_addrs_arr = $email->parse_addrs($current_user->email1,'','','');
			$email->cc_addrs_arr = array();
			$email->bcc_addrs_arr = array();
			$email->date_entered = $nowDateTime;
			$email->date_modified = $nowDateTime;
			$email->team_id = '1';
			$email->send();
			$email->save();
		}
	}
	////	HANDLE REMINDERS
	///////////////////////////////////////////////////////////////////////////////

	// clean up
	unlinkUWTempFiles();

	ob_start();
	echo 'done';
	ob_flush();

	return $persistence;
}

/**
 * runs one line of sql
 * @param array $persistence
 * @return array $persistence
 */
function commitAjaxRunSql($persistence) {
	global $db;

	if(!isset($persistence['commit_sql_errors'])) {
		$persistence['commit_sql_errors'] = array();
	}

	// This flag is determined by the preflight check in the installer
	if($persistence['schema_change'] == 'sugar') {

		if(isset($persistence['sql_to_run'])
			&& count($persistence['sql_to_run']) > 0
			&& !empty($persistence['sql_to_run'])) {

			$sql = array_shift($persistence['sql_to_run']);
			$sql = trim($sql);

			if(!empty($sql)) {
				logThis("[RUNNING SQL QUERY] {$sql}");
				$db->query($sql);

				$error = $db->lastError();
				if(!empty($error)) {
					logThis('************************************************************');
					logThis('*** ERROR: SQL Commit Error!');
					logThis('*** Query: [ '.$sql.' ]');
					logThis('************************************************************');
					$persistence['commit_sql_errors'][] = getFormattedError($error, $sql);
				}
				$persistence = ajaxSqlProgress($persistence, $sql, 'sql_to_run');
			}

		} else {
			ob_start();
			echo 'done';
			ob_flush();
		}
	} else {
		ob_start();
		echo 'done';
		ob_flush();
	}

	return $persistence;
}

/**
 * returns errors found during SQL operations
 * @param array persistence
 * @return string Error message or empty string on success
 */
function commitAjaxGetSqlErrors($persistence) {
	global $mod_strings;

	$out = '';
	if(isset($persistence['commit_sql_errors']) && !empty($persistence['commit_sql_errors'])) {
		$out = "<div class='error'>";
		foreach($persistence['commit_sql_errors'] as $error) {
			$out .= $error;
		}
		$out .= "</div>";
	}

	if(empty($out)) {
		$out = $mod_strings['LBL_UW_COMMIT_ALL_SQL_SUCCESSFULLY_RUN'];
	}

	ob_start();
	echo $out;
	ob_flush();
}

/**
 * parses the sql upgrade file for sequential querying
 * @param array persistence
 * @return array persistence
 */
function commitAjaxPrepSql($persistence) {
	return preflightCheckJsonPrepSchemaCheck($persistence, false);
}


/**
 * handles post-install tasks
 */
function commitAjaxPostInstall($persistence) {
	global $mod_strings;
	global $sugar_config;
	global $sugar_version;

	if(empty($sugar_version)) {
		require('sugar_version.php');
	}

	// update versions info
	if(!updateVersions($sugar_version)) {
		echo $mod_strings['ERR_UW_COMMIT_UPDATE_VERSIONS'];
	}

	logThis('Starting post_install()...');
	$postInstallResults = "<b>{$mod_strings['LBL_UW_COMMIT_POSTINSTALL_RESULTS']}</b><br />
							<a href='javascript:toggleNwFiles(\"postInstallResults\");'>{$mod_strings['LBL_UW_SHOW']}</a><br />
							<div id='postInstallResults' style='display:none'>";
	$file = $persistence['unzip_dir']. "/" . constant('SUGARCRM_POST_INSTALL_FILE');
	if(is_file($file)) {
		include($file);
		ob_start();
		post_install();
	}

	require( "sugar_version.php" );

	if (!rebuildConfigFile($sugar_config, $sugar_version)) {
		logThis('*** ERROR: could not write config.php! - upgrade will fail!');
		$errors[] = $mod_strings['ERR_UW_CONFIG_WRITE'];
	}

	$res = ob_get_contents();
	$postInstallResults .= (empty($res)) ? $mod_strings['LBL_UW_SUCCESS'] : $res;
	$postInstallResults .= "</div>";

	ob_start();
	echo $postInstallResults;
	ob_flush();

	logThis('post_install() done.');
}
////	END COMMIT AJAX
///////////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////////
////	PREFLIGHT JSON STYLE

/**
 * loads the sql file into an array
 * @param array persistence
 * @param bool preflight Flag to load for Preflight or Commit
 * @return array persistence
 */
function preflightCheckJsonPrepSchemaCheck($persistence, $preflight=true) {
	global $mod_strings;
	global $db;
	global $sugar_db_version;
	global $manifest;

	unset($persistence['sql_to_run']);

	$persistence['sql_to_check'] = array();
	$persistence['sql_to_check_backup'] = array();

	if(isset($persistence['sql_check_done'])) {
		// reset flag to not check (on Recheck)
		unset($persistence['sql_check_done']);
		unset($persistence['sql_errors']);
	}

	// get schema script if not loaded
	if($preflight)
		logThis('starting schema preflight check...');
	else
		logThis('Preparing SQL statements for sequential execution...');

    if (empty($sugar_db_version))
    {
        include('sugar_version.php');
    }

	if(!isset($manifest['version']) || empty($manifest['version'])) {
		include($persistence['unzip_dir'].'/manifest.php');
	}

    $origVersion = implodeVersion($sugar_db_version);
    $destVersion = implodeVersion($manifest['version']);

    $script_name = $db->getScriptType();
    $sqlScript = $persistence['unzip_dir']."/scripts/{$origVersion}_to_{$destVersion}_{$script_name}.sql";

	$newTables = array();

	logThis('looking for schema script at: '.$sqlScript);
	if(is_file($sqlScript)) {
		logThis('found schema upgrade script: '.$sqlScript);
		$fp = sugar_fopen($sqlScript, 'r');

		if(!empty($fp)) {
			$completeLine = '';
			while($line = fgets($fp)) {
				if(strpos($line, '--') === false) {
					$completeLine .= " ".trim($line);
					if(strpos($line, ';') !== false) {
						$completeLine = str_replace(';','',$completeLine);
						$persistence['sql_to_check'][] = $completeLine;
						$completeLine = ''; //reset for next loop
					}
				}
			}

			$persistence['sql_total'] = count($persistence['sql_to_check']);
		} else {
			logThis('*** ERROR: could not read schema script: '.$sqlScript);
			$persistence['sql_errors'][] = $mod_strings['ERR_UW_FILE_NOT_READABLE'].'::'.$sqlScript;
		}
	}

	// load a new array if for commit
	if($preflight) {
		$persistence['sql_to_check_backup'] = $persistence['sql_to_check'];
		$persistence['sql_to_run'] = $persistence['sql_to_check'];
		echo "1% ".$mod_strings['LBL_UW_DONE'];
	} else {
		$persistence['sql_to_run'] = $persistence['sql_to_check'];
		unset($persistence['sql_to_check']);
	}

	return $persistence;
}

function preflightCheckJsonSchemaCheck($persistence) {
	global $mod_strings;
	global $db;

	if(!isset($persistence['sql_check_done']) || $persistence['sql_check_done'] != true) {
		// must keep sql in order
		$completeLine = array_shift($persistence['sql_to_check']);
		$whatsLeft = count($persistence['sql_to_check']);

		// populate newTables array to prevent "getting sample data" from non-existent tables
		$newTables = array();
		if(strtoupper(substr($completeLine,1,5)) == 'CREAT')
			$newTables[] = getTableFromQuery($completeLine);

        logThis('Verifying statement: '.$completeLine);
		$bad = $db->verifySQLStatement($completeLine, $newTables);

		if(!empty($bad)) {
			logThis('*** ERROR: schema change script has errors: '.$completeLine);
            logThis('*** '.$bad);
			$persistence['sql_errors'][] = getFormattedError($bad, $completeLine);
		}

		$persistence = ajaxSqlProgress($persistence, $completeLine, 'sql_to_check');
	} else {
		$persistence['sql_to_check'] = $persistence['sql_to_check_backup'];
		echo 'done';
	}

	return $persistence;
}


function preflightCheckJsonGetSchemaErrors($persistence) {
	global $mod_strings;

	if(isset($persistence['sql_errors']) && count($persistence['sql_errors'] > 0)) {
		$out = "<b class='error'>{$mod_strings['ERR_UW_PREFLIGHT_ERRORS']}:</b> ";
		$out .= "<a href='javascript:void(0);toggleNwFiles(\"sqlErrors\");'>{$mod_strings['LBL_UW_SHOW_SQL_ERRORS']}</a><div id='sqlErrors' style='display:none'>";
		foreach($persistence['sql_errors'] as $sqlError) {
			$out .= "<br><span class='error'>{$sqlError}</span>";
		}
		$out .= "</div><hr />";
	} else {
		$out = '';
	}

	// reset errors if Rechecking
	if(isset($persistence['sql_errors']))
	echo $out;

	return $persistence;
}



function preflightCheckJsonAlterTableCharset() {
	global $mod_strings;
	global $sugar_db_version;
	global $persistence;

	if(empty($sugar_db_version))
		include('sugar_version.php');

    $alterTableSchema = '<i>'.$mod_strings['LBL_UW_PREFLIGHT_NOT_NEEDED'].'</i>';

	ob_start();
	echo $alterTableSchema;
	ob_flush();
}


///////////////////////////////////////////////////////////////////////////////
////	SYSTEMCHECK AJAX FUNCTIONS

function systemCheckJsonGetFiles($persistence) {
	global $sugar_config;
	global $mod_strings;

	// add directories here that should be skipped when doing file permissions checks (cache/upload is the nasty one)
	$skipDirs = array(
		$sugar_config['upload_dir'],
		'themes',
	);

	if(!isset($persistence['dirs_checked'])) {
		$the_array = array();
		$files = array();
		$dir = getcwd();
		$d = dir($dir);
		while($f = $d->read()) {
		    if($f == "." || $f == "..") // skip *nix self/parent
		        continue;

		    if(is_dir("$dir/$f"))
				$the_array[] = clean_path("$dir/$f");
			else {
				$files[] = clean_path("$dir/$f");
			}
		}
		$persistence['files_to_check'] = $files;
		$persistence['dirs_to_check'] = $the_array;
		$persistence['dirs_total']	= count($the_array);
		$persistence['dirs_checked'] = false;

		$out = "1% {$mod_strings['LBL_UW_DONE']}";

		return $persistence;
	} elseif($persistence['dirs_checked'] == false) {
		$dir = array_pop($persistence['dirs_to_check']);

		$files = uwFindAllFiles($dir, array(), true, $skipDirs);

		$persistence['files_to_check'] = array_merge($persistence['files_to_check'], $files);

		$whatsLeft = count($persistence['dirs_to_check']);

		if(!isset($persistence['dirs_to_check']) || $whatsLeft < 1) {
			$whatsLeft = 0;
			$persistence['dirs_checked'] = true;
		}

		$out  = round((($persistence['dirs_total'] - $whatsLeft) / 21) * 100, 1)."% {$mod_strings['LBL_UW_DONE']}";
		$out .= " [{$mod_strings['LBL_UW_SYSTEM_CHECK_CHECKING_JSON']} {$dir}]";
	} else {
		$out = "Done";
	}

	echo trim($out);

	return $persistence;
}



/**
 * checks files for permissions
 * @param array files Array of files with absolute paths
 * @return string result of check
 */
function systemCheckJsonCheckFiles($persistence) {
	global $mod_strings;
	global $persistence;

	$filesNotWritable = array();
	$i=0;
	$filesOut = "
		<a href='javascript:void(0); toggleNwFiles(\"filesNw\");'>{$mod_strings['LBL_UW_SHOW_NW_FILES']}</a>
		<div id='filesNw' style='display:none;'>
		<table cellpadding='3' cellspacing='0' border='0'>
		<tr>
			<th align='left'>{$mod_strings['LBL_UW_FILE']}</th>
			<th align='left'>{$mod_strings['LBL_UW_FILE_PERMS']}</th>
			<th align='left'>{$mod_strings['LBL_UW_FILE_OWNER']}</th>
			<th align='left'>{$mod_strings['LBL_UW_FILE_GROUP']}</th>
		</tr>";

	$isWindows = is_windows();
	foreach($persistence['files_to_check'] as $file) {
		// admin deletes a bad file mid-check:
		if(!file_exists($file))
			continue;

		if($isWindows) {
			if(!is_writable_windows($file)) {
				logThis('WINDOWS: File ['.$file.'] not readable - saving for display');
				// don't warn yet - we're going to use this to check against replacement files
				$filesNotWritable[$i] = $file;
				$filesNWPerms[$i] = substr(sprintf('%o',fileperms($file)), -4);
				$filesOut .= "<tr>".
								"<td valign='top'><span class='error'>{$file}</span></td>".
								"<td valign='top'>{$filesNWPerms[$i]}</td>".
								"<td valign='top'>".$mod_strings['ERR_UW_CANNOT_DETERMINE_USER']."</td>".
								"<td valign='top'>".$mod_strings['ERR_UW_CANNOT_DETERMINE_GROUP']."</td>".
							  "</tr>";
			}
		} else {
			if(!is_writable($file)) {
				logThis('File ['.$file.'] not writable - saving for display');
				// don't warn yet - we're going to use this to check against replacement files
				$filesNotWritable[$i] = $file;
				$filesNWPerms[$i] = substr(sprintf('%o',fileperms($file)), -4);
				$owner = posix_getpwuid(fileowner($file));
				$group = posix_getgrgid(filegroup($file));
				$filesOut .= "<tr>".
								"<td valign='top'><span class='error'>{$file}</span></td>".
								"<td valign='top'>{$filesNWPerms[$i]}</td>".
								"<td valign='top'>".$owner['name']."</td>".
								"<td valign='top'>".$group['name']."</td>".
							  "</tr>";
			}
		}
		$i++;
	}

	$filesOut .= '</table></div>';
	// not a stop error
	$persistence['filesNotWritable'] = (count($filesNotWritable) > 0) ? true : false;

	if(count($filesNotWritable) < 1) {
		$filesOut = "{$mod_strings['LBL_UW_FILE_NO_ERRORS']}";
		$persistence['step']['systemCheck'] = 'success';
	}

	echo $filesOut;
	return $persistence;
}
