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

use Sugarcrm\Sugarcrm\Denormalization\TeamSecurity\Job\RebuildJob;
use Sugarcrm\Sugarcrm\ProductDefinition\Job\UpdateProductDefinitionJob;
use Sugarcrm\Sugarcrm\Dbal\Connection;
use Doctrine\DBAL\FetchMode;

/**
 * Set up an array of Jobs with the appropriate metadata
 * 'jobName' => array (
 * 		'X' => 'name',
 * )
 * 'X' should be an increment of 1
 * 'name' should be the EXACT name of your function
 *
 * Your function should not be passed any parameters
 * Always  return a Boolean. If it does not the Job will not terminate itself
 * after completion, and the webserver will be forced to time-out that Job instance.
 * DO NOT USE sugar_cleanup(); in your function flow or includes.  this will
 * break Schedulers.  That function is called at the foot of cron.php
 */

/**
 * This array provides the Schedulers admin interface with values for its "Job"
 * dropdown menu.
 */
$job_strings = [
    'refreshJobs',
    'pollMonitoredInboxes',
    'runMassEmailCampaign',
    'pollMonitoredInboxesForBouncedCampaignEmails',
    'pruneDatabase',
    'trimTracker',
    'processWorkflow',
    'processQueue',
    'updateTrackerSessions',
    'sendEmailReminders',
    'cleanJobQueue',

    //Add class to build additional TimePeriods as necessary
    'class::SugarJobCreateNextTimePeriod',
    'class::SugarJobHeartbeat',
    'cleanOldRecordLists',
    'class::SugarJobRemovePdfFiles',
    'class::SugarJobKBContentUpdateArticles',
    'class::\Sugarcrm\Sugarcrm\Elasticsearch\Queue\Scheduler',
    'class::SugarJobRemoveDiagnosticFiles',
    'class::SugarJobRemoveTmpFiles',
    'class::' . RebuildJob::class,
    'class::SugarJobActivityStreamPurger',
    'class::' . UpdateProductDefinitionJob::class,
    'class::' . SugarJobProcessTimeAwareSchedules::class,
    'class::SugarJobDataArchiver',
];

/**
 * Job 0 refreshes all job schedulers at midnight
 * DEPRECATED
 */
function refreshJobs() {
	return true;
}


/**
 * Job 1
 */
function pollMonitoredInboxes() {

    $_bck_up = array('team_id' => $GLOBALS['current_user']->team_id, 'team_set_id' => $GLOBALS['current_user']->team_set_id);
	$GLOBALS['log']->info('----->Scheduler fired job of type pollMonitoredInboxes()');
	global $dictionary;
	global $app_strings;



	$ie = BeanFactory::newBean('InboundEmail');
	$emailUI = new EmailUI();
	$r = $ie->db->query('SELECT id, name FROM inbound_email WHERE is_personal = 0 AND deleted=0 AND status=\'Active\' AND mailbox_type != \'bounce\'');
	$GLOBALS['log']->debug('Just got Result from get all Inbounds of Inbound Emails');

	while($a = $ie->db->fetchByAssoc($r)) {
		$GLOBALS['log']->debug('In while loop of Inbound Emails');
		$ieX = BeanFactory::getBean('InboundEmail', $a['id'], array('disable_row_level_security' => true));
        $GLOBALS['current_user']->team_id = $ieX->team_id;
        $GLOBALS['current_user']->team_set_id = $ieX->team_set_id;
		$mailboxes = $ieX->mailboxarray;
        $leaveMessagesOnMailServer = $ieX->get_stored_options("leaveMessagesOnMailServer", 0);
		foreach($mailboxes as $mbox) {
			$ieX->mailbox = $mbox;
			$newMsgs = array();
			$msgNoToUIDL = array();
			$connectToMailServer = false;
			if ($ieX->isPop3Protocol()) {
				$msgNoToUIDL = $ieX->getPop3NewMessagesToDownloadForCron();
				// get all the keys which are msgnos;
				$newMsgs = array_keys($msgNoToUIDL);
			}
            if ($ieX->connectToImapServer() == 'true') {
				$connectToMailServer = true;
			} // if

			$GLOBALS['log']->debug('Trying to connect to mailserver for [ '.$a['name'].' ]');
			if($connectToMailServer) {
				$GLOBALS['log']->debug('Connected to mailserver');
				if (!$ieX->isPop3Protocol()) {
                    $ieX->conn->selectMailbox($mbox);
                    $newMsgs = $ieX->getNewIds();
				}
				if(is_array($newMsgs)) {
					$current = 1;
					$total = count($newMsgs);
					$sugarFolder = new SugarFolder();
					$groupFolderId = $ieX->groupfolder_id;
					$isGroupFolderExists = false;
					$users = array();
					if ($groupFolderId != null && $groupFolderId != "") {
						$sugarFolder->retrieve($groupFolderId);
						$isGroupFolderExists = true;
						$_REQUEST['team_id'] = $sugarFolder->team_id;
						$_REQUEST['team_set_id'] = $sugarFolder->team_set_id;
                        $_REQUEST['acl_team_set_id'] = $sugarFolder->acl_team_set_id;
					} // if
					$messagesToDelete = array();
					if ($ieX->isMailBoxTypeCreateCase()) {
						$users[] = $sugarFolder->assign_to_id;
						$GLOBALS['log']->debug('Getting users for teamset');
						$teamSet = BeanFactory::newBean('TeamSets');
						$usersList = $teamSet->getTeamSetUsers($sugarFolder->team_set_id, true);
						$GLOBALS['log']->debug('Done Getting users for teamset');
						$users = array();
						foreach($usersList as $userObject) {
							if ($userObject->is_group) {
								continue;
							} // if
							$users[] = $userObject->id;
						} // foreach
						$distributionMethod = $ieX->get_stored_options("distrib_method", "");
						if ($distributionMethod != 'roundRobin') {
							$counts = $emailUI->getAssignedEmailsCountForUsers($users);
						} else {
							$lastRobin = $emailUI->getLastRobin($ieX);
						}
						$GLOBALS['log']->debug('distribution method id [ '.$distributionMethod.' ]');
					}
					foreach($newMsgs as $k => $msgNo) {
                        try {
                            $uid = $msgNo;
                            if ($ieX->isPop3Protocol()) {
                                $uid = $msgNoToUIDL[$msgNo];
                            }
                            if ($isGroupFolderExists) {
                                $_REQUEST['team_id'] = $sugarFolder->team_id;
                                $_REQUEST['team_set_id'] = $sugarFolder->team_set_id;
                                $_REQUEST['acl_team_set_id'] = $sugarFolder->acl_team_set_id;
                                if ($ieX->importEmailFromUid($uid)) {
                                    // add to folder
                                    $sugarFolder->addBean($ieX->email);
                                    if ($ieX->isPop3Protocol()) {
                                        $messagesToDelete[] = $msgNo;
                                    } else {
                                        $messagesToDelete[] = $uid;
                                    }
                                    if ($ieX->isMailBoxTypeCreateCase()) {
                                        $userId = "";
                                        if ($distributionMethod == 'roundRobin') {
                                            if (sizeof($users) == 1) {
                                                $userId = $users[0];
                                                $lastRobin = $users[0];
                                            } else {
                                                $userIdsKeys = array_flip($users); // now keys are values
                                                $thisRobinKey = $userIdsKeys[$lastRobin] + 1;
                                                if (!empty($users[$thisRobinKey])) {
                                                    $userId = $users[$thisRobinKey];
                                                    $lastRobin = $users[$thisRobinKey];
                                                } else {
                                                    $userId = $users[0];
                                                    $lastRobin = $users[0];
                                                }
                                            } // else
                                        } else {
                                            if (sizeof($users) == 1) {
                                                foreach ($users as $k => $value) {
                                                    $userId = $value;
                                                } // foreach
                                            } else {
                                                asort($counts); // lowest to highest
                                                $countsKeys = array_flip($counts); // keys now the 'count of items'
                                                $leastBusy = array_shift($countsKeys); // user id of lowest item count
                                                $userId = $leastBusy;
                                                $counts[$leastBusy] = $counts[$leastBusy] + 1;
                                            }
                                        } // else
                                        $GLOBALS['log']->debug('userId [ '.$userId.' ]');
                                        $ieX->handleCreateCase($ieX->email, $userId);
                                    } // if
                                    if (!$leaveMessagesOnMailServer) {
                                        $ieX->conn->deleteMessage($uid);
                                    }
                                } // if
                            } else {
                                if ($ieX->isAutoImport()) {
                                    $ieX->importEmailFromUid($uid);
                                } else {
                                    /*If the group folder doesn't exist then download only those messages
                                     which has caseid in message*/
                                    $ieX->getMessagesInEmailCache($msgNo, $uid);
                                    $email = BeanFactory::newBean('Emails');
                                    $email->name = $ieX->conn->getSubject($uid);
                                    $email->from_addr = implode(',', $ieX->conn->getFromAddresses($uid));
                                    $email->reply_to_email  = implode(',', $ieX->conn->getReplyToAddresses($uid));
                                    if (!empty($email->reply_to_email)) {
                                        $contactAddr = $email->reply_to_email;
                                    } else {
                                        $contactAddr = $email->from_addr;
                                    }
                                    $mailBoxType = $ieX->mailbox_type;
                                    if (($mailBoxType == 'support') || ($mailBoxType == 'pick')) {
                                        $c = BeanFactory::newBean('Cases');
                                        $GLOBALS['log']->debug('looking for a case for '.$email->name);
                                        if ($ieX->getCaseIdFromCaseNumber($email->name, $c)) {
                                            $ieX->importEmailFromUid($uid);
                                        } else {
                                            $ieX->handleAutoresponse($email, $contactAddr);
                                        } // else
                                    } else {
                                        $ieX->handleAutoresponse($email, $contactAddr);
                                    } // else
                                } // else
                            } // else
                        } catch (Exception $e) {
                            $GLOBALS['log']->fatal(
                                'pollMonitoredInboxes unable to import email with UID ' . $uid . ': ' .
                                $e->getMessage()
                            );
                        }
                        $GLOBALS['log']->debug('***** On message [ '.$current.' of '.$total.' ] *****');
                        $current++;
					} // foreach
					// update Inbound Account with last robin
					if ($ieX->isMailBoxTypeCreateCase() && $distributionMethod == 'roundRobin') {
						$emailUI->setLastRobin($ieX, $lastRobin);
					} // if

				} // if
			} else {
				$GLOBALS['log']->fatal("SCHEDULERS: could not get an IMAP connection resource for ID [ {$a['id']} ]. Skipping mailbox [ {$a['name']} ].");
				// cn: bug 9171 - continue while
			} // else
		} // foreach
	} // while
    $GLOBALS['current_user']->team_id = $_bck_up['team_id'];
    $GLOBALS['current_user']->team_set_id = $_bck_up['team_set_id'];
	return true;
}

/**
 * Job 2
 */
function runMassEmailCampaign() {
	if (!class_exists('LoggerManager')){

	}
	$GLOBALS['log'] = LoggerManager::getLogger('emailmandelivery');
	$GLOBALS['log']->debug('Called:runMassEmailCampaign');

	if (!class_exists('DBManagerFactory')){
		require('include/database/DBManagerFactory.php');
	}

	global $beanList;
	global $beanFiles;
	require("config.php");
	require('include/modules.php');
	if(!class_exists('AclController')) {
		require('modules/ACL/ACLController.php');
	}

	require('modules/EmailMan/EmailManDelivery.php');
	return true;
}

/**
 *  Job 3
 */
function pruneDatabase() {
    $pruneBatchSize = SugarConfig::getInstance()->get('prune_job_batch_size', 500);
	$GLOBALS['log']->info('----->Scheduler fired job of type pruneDatabase()');

	$db = DBManagerFactory::getInstance();
	$tables = $db->getTablesArray();
    $conn = DBManagerFactory::getInstance()->getConnection();

	if(!empty($tables)) {
        foreach ($tables as $table) {
			// find tables with deleted=1
			$columns = $db->get_columns($table);
			// no deleted - won't delete
            if (empty($columns['deleted'])) {
                continue;
            }
            if (in_array($table . '_cstm', $tables)) {
			    $custom_columns = $db->get_columns($table.'_cstm');
                if (!empty($custom_columns['id_c'])) {
                    while (true) {
                        $ids = $conn->createQueryBuilder()
                            ->select('id')
                            ->from($table)
                            ->where('deleted = 1')
                            ->setMaxResults($pruneBatchSize)
                            ->execute()
                            ->fetchAll(FetchMode::COLUMN);
                        if (!is_countable($ids) || count($ids) === 0) {
                            break;
                        }
                        if (!$conn->isAutoCommit()) {
                            $conn->beginTransaction();
                        }
                        $conn->executeUpdate(
                            'DELETE FROM ' . $table . '_cstm WHERE id_c IN (?)',
                            [$ids],
                            [Connection::PARAM_STR_ARRAY]
                        );
                        $conn->executeUpdate(
                            'DELETE FROM ' . $table . ' WHERE id IN (?)',
                            [$ids],
                            [Connection::PARAM_STR_ARRAY]
                        );
                        if (!$conn->isAutoCommit()) {
                            $conn->commit();
                        }
                    }
                }
            } else {
                $db->query('DELETE FROM ' . $table . ' WHERE deleted = 1');
                $db->commit();
            }
		} // foreach() tables

		return true;
	}
	return false;
}


///**
// * Job 4
// */

function trimTracker()
{
    global $sugar_config, $timedate;
	$GLOBALS['log']->info('----->Scheduler fired job of type trimTracker()');
	$db = DBManagerFactory::getInstance();

	$admin = Administration::getSettings('tracker');
	require('modules/Trackers/config.php');
	$trackerConfig = $tracker_config;

    require_once('include/utils/db_utils.php');
    $prune_interval = !empty($admin->settings['tracker_prune_interval']) ? $admin->settings['tracker_prune_interval'] : 30;
	foreach($trackerConfig as $tableName=>$tableConfig) {

		//Skip if table does not exist
		if(!$db->tableExists($tableName)) {
		   continue;
		}

	    $timeStamp = db_convert("'". $timedate->asDb($timedate->getNow()->get("-".$prune_interval." days")) ."'" ,"datetime");
		if($tableName == 'tracker_sessions') {
		   $query = "DELETE FROM $tableName WHERE date_end < $timeStamp";
		} else {
		   $query = "DELETE FROM $tableName WHERE date_modified < $timeStamp";
		}

	    $GLOBALS['log']->info("----->Scheduler is about to trim the $tableName table by running the query $query");
		$db->query($query);
	} //foreach
    return true;
}

/* Job 5
 *
 */
function pollMonitoredInboxesForBouncedCampaignEmails() {
	$GLOBALS['log']->info('----->Scheduler job of type pollMonitoredInboxesForBouncedCampaignEmails()');

	$ie = BeanFactory::newBean('InboundEmail');
	$r = $ie->db->query('SELECT id FROM inbound_email WHERE deleted=0 AND status=\'Active\' AND mailbox_type=\'bounce\'');

	while($a = $ie->db->fetchByAssoc($r)) {
		$ieX = BeanFactory::getBean('InboundEmail', $a['id'], array('disable_row_level_security' => true));
        $ieX->connectToImapServer();
        $GLOBALS['log']->info("Bounced campaign scheduler connected to mail server id: {$a['id']} ");

        $mailboxes = $ieX->mailboxarray;
        foreach ($mailboxes as $mailbox) {
            if ($ieX->isPop3Protocol()) {
                $newMsgs = $ieX->getPop3NewMessagesToDownload();
            } else {
                $ieX->conn->selectMailbox($mailbox);
                $newMsgs = $ieX->getNewIds();
            }

            if (is_array($newMsgs)) {
                foreach ($newMsgs as $k => $msgNo) {
                    try {
                        $uid = $msgNo;
                        if ($ieX->isPop3Protocol()) {
                            $uid = $ieX->getUIDLForMessage($msgNo);
                        }
                        $GLOBALS['log']->info("Bounced campaign scheduler will import message no: $msgNo");
                        $ieX->importEmailFromUid($uid);
                    } catch (Exception $e) {
                        $GLOBALS['log']->fatal(
                            'pollMonitoredInboxesForBouncedCampaignEmails unable to import email with UID ' . $uid .
                            ': ' . $e->getMessage()
                        );
                    }
                }
            }
        }
	}

	return true;
}

/**
 * Job 6
 */
function processWorkflow() {
	include_once('process_workflow.php');
	return true;
}

/**
 * Job 7
 */
function processQueue() {
    include_once('process_queue.php');
    return true;
}


/**
 * Job 9
 */
function updateTrackerSessions() {
    global $sugar_config, $timedate;
	$GLOBALS['log']->info('----->Scheduler fired job of type updateTrackerSessions()');
	$db = DBManagerFactory::getInstance();
    require_once('include/utils/db_utils.php');
	//Update tracker_sessions to set active flag to false
    $sessionTimeout = $timedate->getNow()->get("-6 hours")->asDb();
    $dateExpression = db_convert('?', "datetime");
    $statement = "UPDATE tracker_sessions set active = ? where active = ? and date_end < $dateExpression";
    $params = [0, 1, $sessionTimeout];
    $db->getConnection()
        ->executeUpdate(
            $statement,
            $params
        );
	return true;
}

/**
 * Job 12
 */
function sendEmailReminders()
{
    $GLOBALS['log']->info('----->Scheduler fired job of type sendEmailReminders()');
    $reminder = new EmailReminder();
    return $reminder->process();
}

/**
 * Job 20
 */
function cleanOldRecordLists() {
    global $timedate;

	$GLOBALS['log']->info('----->Scheduler fired job of type cleanOldRecordLists()');
    $delTime = time()-3600; // Nuke anything an hour old.

    $hourAgo = $timedate->asDb($timedate->getNow()->modify("-1 hour"));

    $db = DBManagerFactory::getInstance();

    $query = "DELETE FROM record_list WHERE date_modified < '".$db->quote($hourAgo)."'";
    $db->query($query,true);

	return true;
}

function cleanJobQueue($job)
{
    $td = TimeDate::getInstance();
    // soft delete all jobs that are older than cutoff
    $soft_cutoff = 7;
    if(isset($GLOBALS['sugar_config']['jobs']['soft_lifetime'])) {
        $soft_cutoff = $GLOBALS['sugar_config']['jobs']['soft_lifetime'];
    }
    $soft_cutoff_date = $job->db->quoted($td->getNow()->modify("- $soft_cutoff days")->asDb());
    $job->db->query("UPDATE {$job->table_name} SET deleted=1 WHERE status='done' AND date_modified < ".$job->db->convert($soft_cutoff_date, 'datetime'));
    // hard delete all jobs that are older than hard cutoff
    $hard_cutoff = 21;
    if(isset($GLOBALS['sugar_config']['jobs']['hard_lifetime'])) {
        $hard_cutoff = $GLOBALS['sugar_config']['jobs']['hard_lifetime'];
    }
    $hard_cutoff_date = $job->db->quoted($td->getNow()->modify("- $hard_cutoff days")->asDb());
    $job->db->query("DELETE FROM {$job->table_name} WHERE status='done' AND date_modified < ".$job->db->convert($hard_cutoff_date, 'datetime'));
    return true;
}

if (SugarAutoLoader::existing('custom/modules/Schedulers/_AddJobsHere.php')) {
	require('custom/modules/Schedulers/_AddJobsHere.php');
}

$extfile = SugarAutoLoader::loadExtension('schedulers');
if($extfile) {
    require $extfile;
}

$extfile = SugarAutoLoader::loadExtension('app_schedulers');
if($extfile) {
    require $extfile;
}
