<?php

/**
 * The file used to set functions related survey
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */

/**
 * send custom email of survey to customer
 *
 * @author     Biztech Consultancy
 * @param      string - $to
 * @param      string - $subject
 * @param      string - $body
 * @param      string - $module_id
 * @param      string - $module_type
 * @return     String
 */
function CustomSendEmail($to = '', $subject = '', $body = '', $module_id = '', $module_type = '', $typeOfRec = 'to') {
    global $current_user;

    $administrationObj = new Administration();
    $administrationObj->retrieveSettings('SurveySmtp');
    if ($to != '') {
        require_once('modules/Mailer/MailerFactory.php');
        require_once 'modules/OutboundEmailConfiguration/OutboundEmailConfigurationPeer.php';
        $notify_fromname = $administrationObj->settings['notify_fromname'];
        $notify_fromaddress = $administrationObj->settings['notify_fromaddress'];
        $fromname = (!empty($administrationObj->settings['SurveySmtp_survey_notify_fromname'])) ? $administrationObj->settings['SurveySmtp_survey_notify_fromname'] : $notify_fromname;
        $fromaddress = (!empty($administrationObj->settings['SurveySmtp_survey_notify_fromaddress'])) ? $administrationObj->settings['SurveySmtp_survey_notify_fromaddress'] : $notify_fromaddress;
        $configurations = array();
        $configurations["from_email"] = $fromaddress;
        $configurations["from_name"] = $fromname;
        $configurations["display_name"] = "{$fromname} ({$fromaddress})";
        $configurations["personal"] = 0;

        $smtp_req = (!empty($administrationObj->settings['SurveySmtp_survey_mail_smtpauth_req'])) ? $administrationObj->settings['SurveySmtp_survey_mail_smtpauth_req'] : $administrationObj->settings['mail_smtpauth_req'];

        if (empty($smtp_req) || $smtp_req != '1') {
            $smtp_req = 0;
        } else {
            $smtp_req = 1;
        }
        $outboundEmail = new OutboundEmail();
        $outboundEmail->mail_sendtype = 'SMTP';
        $outboundEmail->mail_smtpserver = (!empty($administrationObj->settings['SurveySmtp_survey_mail_smtp_host'])) ? $administrationObj->settings['SurveySmtp_survey_mail_smtp_host'] : $administrationObj->settings['mail_smtpserver'];
        $outboundEmail->mail_smtpport = (!empty($administrationObj->settings['SurveySmtp_survey_mail_smtpport'])) ? $administrationObj->settings['SurveySmtp_survey_mail_smtpport'] : $administrationObj->settings['mail_smtpport'];
        $outboundEmail->mail_smtpauth_req = $smtp_req;
        $outboundEmail->mail_smtpuser = (!empty($administrationObj->settings['SurveySmtp_survey_mail_smtp_username'])) ? $administrationObj->settings['SurveySmtp_survey_mail_smtp_username'] : $administrationObj->settings['mail_smtpuser'];
        $outboundEmail->mail_smtppass = (!empty($administrationObj->settings['SurveySmtp_survey_mail_smtp_password'])) ? $administrationObj->settings['SurveySmtp_survey_mail_smtp_password'] : $administrationObj->settings['mail_smtppass'];
        $outboundEmail->mail_smtpssl = (!empty($administrationObj->settings['SurveySmtp_survey_mail_smtpssl'])) ? $administrationObj->settings['SurveySmtp_survey_mail_smtpssl'] : $administrationObj->settings['mail_smtpssl'];
        $outboundEmailConfiguration = OutboundEmailConfigurationPeer::buildOutboundEmailConfiguration(
                        $current_user, $configurations, $outboundEmail
        );

        $mailer = MailerFactory::getMailer($outboundEmailConfiguration);

        $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
        $body = trim($body);
        try {
            // reuse the mailer, but process one send per recipient
            $mailer->clearRecipients();
            // Recipient as to
            if (empty($typeOfRec) || $typeOfRec == 'to') {
                $mailer->addRecipientsTo(new EmailIdentity($to, ''));
            }
            // Recipient as cc
            else if ($typeOfRec == 'cc') {
                $mailer->addRecipientsCc(new EmailIdentity($to, ''));
            }
            // Recipient as bcc
            else if ($typeOfRec == 'bcc') {
                $mailer->addRecipientsBcc(new EmailIdentity($to, ''));
            }
            $error = false; // true=encountered an error; false=no errors
            $textOnly = EmailFormatter::isTextOnly($body);
            if ($textOnly) {
                $mailer->setTextBody($body);
            } else {
                $textBody = strip_tags(br2nl($body)); // need to create the plain-text part
                $mailer->setTextBody($textBody);
                $mailer->setHtmlBody($body);
            }

            $mailer->setSubject($subject);


            if ($error) {
                throw new MailerException("Failed to add message content", MailerException::InvalidMessageBody);
            }

            $mailer->send();
            updateHealthStatus('success');
            $is_send = 'send';
        } catch (MailerException $me) {

            $message = $me->getMessage();
            $GLOBALS["log"]->warn("Notifications: error sending e-mail (method: {$mailTransmissionProtocol}), (error: {$message})");
            $is_send = $message;
            updateHealthStatus($message);
        }


        $emailObj = new Email();
        if ($is_send != 'send') {
            $GLOBALS['log']->info("Mailer error: " . $is_send);
        } else {
            $emailObj->to_addrs = $to;
            // $emailObj->type = 'out';
            $emailObj->deleted = '0';
            $emailObj->name = $subject;
            $emailObj->description = null;
            $emailObj->description_html = from_html($body);
            $emailObj->from_addr = $fromname;
            $emailObj->parent_type = $module_type;
            $emailObj->parent_id = $module_id;
            $user_id = $current_user->id;
            $emailObj->date_sent = TimeDate::getInstance()->nowDb();
            $emailObj->assigned_user_id = $user_id;
            $emailObj->modified_user_id = $user_id;
            $emailObj->created_by = $user_id;
            $emailObj->status = 'sent';
            $emailObj->sentFrom = 'Survey module';
            $emailObj->save();
        }
    } else {
        $recipient_moduleObj = BeanFactory::getBean($module_type, $module_id);
        $is_send = 'Unable to retrieve email address to send survey mail for ' . $recipient_moduleObj->name . '.';
    }
    return $is_send;
}

/*
 * Update Health Status for SMTP
 */

function updateHealthStatus($status = '') {
    global $db;
    $select = "SELECT * FROM config WHERE category = 'SurveyPlugin' AND name='HealthCheck-SMTP' ";
    $result = $db->query($select);

    if ($result->num_rows != 0) {
        $update = "UPDATE config SET value = '{$status}' WHERE category = 'SurveyPlugin' AND name='HealthCheck-SMTP' ";
        $db->query($update);
    } else {
        $update = "INSERT INTO config( `category`,`name`,`value`) values('SurveyPlugin','HealthCheck-SMTP', '$status') ";
        $db->query($update);
    }
}

/**
 * get report data for survey report
 *
 * @author     Biztech Consultancy
 * @param      string - $type
 * @param      string - $survey_id
 * @param      string - $name
 * @param      string - $module_type
 * @param      string - $status
 * @return     Array
 */
function getReportData($type = '', $survey_id = '', $name = '', $module_type = '', $status = '', $submission_start_date = '', $submission_end_date = '', $submission_type = '', $status_type = '', $sort = '', $sort_order = '', $page = '', $global_filter_by = '', $GF_QueLogic_Passed_Submissions = array()) {
    global $db, $app_list_strings;
    require_once('include/SugarQuery/SugarQuery.php');
    if ($type == 'status') {

        $query = new SugarQuery();
        $query->from(BeanFactory::getBean('bc_survey_submission'));
        $query->join('bc_survey_submission_bc_survey', array('alias' => 'related_survey'));
        $query->select->fieldRaw("related_survey.id", "survey_id");
        $query->select(array("status", "id", "email_opened", "survey_send", "related_survey.name", "submission_type", "target_parent_id", "target_parent_type"));
        $query->where()->equals('related_survey.id', $survey_id);
        if ($status_type == 'openended') {
            $query->where()->equals('submission_type', 'Open Ended');
        } else if ($status_type == 'email') {
            $query->where()->equals('submission_type', 'Email');
        }
        if (!empty($GF_QueLogic_Passed_Submissions)) {
        $query->where()->in('bc_survey_submission.id', $GF_QueLogic_Passed_Submissions);
        }
        $scDataQryRes = $query->execute();

        $email_not_opened = 0;
        $pending = 0;
        $submitted = 0;
        foreach ($scDataQryRes as $status_row) {
                if ($status_row['status'] == 'Pending' && $status_row['email_opened'] == 0) {
                    $email_not_opened++;
                } elseif ($status_row['status'] == 'Pending' && $status_row['email_opened'] == 1) {
                    $pending++;
                } elseif ($status_row['status'] == 'Submitted') {
                    $submitted++;
                }
                $survey['name'] = htmlspecialchars_decode($status_row['name'], ENT_QUOTES);
            }
        $survey['Pending'] = $pending;
        $survey['Submitted'] = $submitted;
        $survey['email_not_opened'] = $email_not_opened;
        if ($survey['Pending'] == 0 && $survey['Submitted'] == 0 && $survey['email_not_opened'] == 0) {
            $survey = "There is no submission for this Survey.";
        }

        return $survey;
    } elseif ($type == 'question') {
        $query = new SugarQuery();
        $query->from(BeanFactory::getBean('bc_survey_questions'));
        $query->join('bc_survey_pages_bc_survey_questions', array('alias' => 'bc_survey_pages'));
        $query->select->fieldRaw("bc_survey_pages.page_sequence", "page_seq");
        $query->select->fieldRaw("bc_survey_pages.name", "pagename");
        $query->join('bc_survey_bc_survey_questions', array('alias' => 'bc_survey'));
        $query->select(array("name", "id", "question_sequence"));
        $query->orderByRaw('bc_survey_pages.page_sequence,question_sequence');
        $query->where()->equals('bc_survey.id', $survey_id);
        $query->where()->notEquals('question_type', 'section-header');
        // To avoid display Rich Text Type Question In Question Wise Report. By GSR
        $query->where()->notEquals('question_type', 'richtextareabox');
        // End
        $que_result = $query->execute();

        $question_array = array();
        $totalPages_array = array();
        $totalPages = count(array_unique(array_column($que_result, 'page_seq')));
        foreach ($que_result as $que_row) {
            if ($que_row['page_seq'] == $page) {
                $question_array[$que_row['id']] = array($que_row['name'], $que_row['page_seq'], $que_row['id'], $que_row['pagename'], $que_row['question_sequence'], $totalPages);
            }
        }
        return $question_array;
    } elseif ($type == 'individual') {
        $query = new SugarQuery();
        $query->from(BeanFactory::getBean('bc_survey_submission'));
        $query->join('bc_survey_submission_bc_survey', array('alias' => 'bc_survey'));

        // select fields
        $query->select->fieldRaw("bc_survey_submission.id", "submission_id");
        $query->select->fieldRaw("schedule_on", "send_date");
        $query->select->fieldRaw("submission_date", "receive_date");
        $query->select->fieldRaw("bc_survey_submission.date_modified", "date_modified");
        $query->select(array("id", "target_parent_type", "target_parent_id", "status", "email_opened", "customer_name", "send_date", "submission_type", "change_request", "consent_accepted"));

        $query->where()->contains('bc_survey.id', "{$survey_id}");
        if ($status_type == 'openended') {
            $query->where()->equals('submission_type', 'Open Ended');
        } else if ($status_type == 'email') {
            $query->where()->equals('submission_type', 'Email');
        }
        $query->where()->equals('status', "Submitted");

        if (!empty($name)) {

            $query->where()->contains('customer_name', "{$name}");
        }

        if (!empty($module_type)) {

            $query->where()->equals('target_parent_type', $module_type);
        }

        if (!empty($submission_type) && $submission_type != 'Combined') {

            $query->where()->contains('submission_type', "{$submission_type}");
        }

        if (!empty($status)) {
            if ($status == 'Pending') {

                $query->where()->queryAnd()->equals('status', 'Pending')->equals('email_opened', '0');
            } elseif ($status == 'Pending_open') {

                $query->where()->queryAnd()->equals('status', 'Pending')->equals('email_opened', '1');
            } else {

                $query->where()->queryAnd()->equals('status', 'Submitted');
            }
        }

        if ($global_filter_by == 'by_question_logic' && !empty($GF_QueLogic_Passed_Submissions)) {
            $query->where()->in('bc_survey_submission.id', $GF_QueLogic_Passed_Submissions);
        }

        if (!empty($submission_start_date) && !empty($submission_end_date)) {
            $toDbStartSubmission = TimeDate::getInstance()->to_db_date($submission_start_date, false);
            $toDbEndSubmission = TimeDate::getInstance()->to_db_date($submission_end_date, false);

            $query->where()->dateBetween('submission_date', array($toDbStartSubmission, $toDbEndSubmission));
        }

//       
        if (!empty($sort)) {
            $query->orderBy($sort, $sort_order);
        } else {
            $query->orderBy('bc_survey_submission.date_modified', 'DESC');
        }
//        
        $result = $query->execute();

        $module_types = array();
        $dbFormat = TimeDate::getInstance()->get_db_date_time_format();
        foreach ($result as $row) {
            // check related survey
                        if ($row['status'] == 'Pending' && $row['email_opened'] == 0) {
                            $status_value = "Not viewed";
                        } elseif ($row['status'] == 'Pending' && $row['email_opened'] == 1) {
                            $status_value = "Viewed";
                        } elseif ($row['status'] == 'Submitted') {
                            $status_value = "Submitted";
                        }
                        if ($row['receive_date'] != "N/A") {
                $dateRec = date($dbFormat, strtotime($row['receive_date']));
                            $receive_date = TimeDate::getInstance()->to_display_date_time($dateRec);
                        } else {
                            $receive_date = $row['receive_date'];
                        }
                        if (empty($row['target_parent_id'])) {
                            $row['target_parent_id'] = $row['customer_name'];
                        }
                        //$module_name = (!empty($app_list_strings['moduleList'][$row['target_parent_type']])) ? $app_list_strings['moduleList'][$row['target_parent_type']] : $row['target_parent_type'];
                        $module_name = $row['target_parent_type'];
            $dateSend = date($dbFormat, strtotime($row['send_date']));
                        $module_types[$row['id']] = array(
                            'customer_name' => $row['customer_name'],
                            'submission_id' => $row['id'],
                            'module_type' => !empty($module_name) ? $module_name : '-',
                            'submission_type' => $row['submission_type'],
                            'survey_status' => $status_value,
                            'send_date' => TimeDate::getInstance()->to_display_date_time($dateSend),
                            'module_id' => $row['target_parent_id'],
                            'receive_date' => $receive_date,
                            'change_request' => $row['change_request'],
                            'consent_accepted' => $row['consent_accepted'] == 1 ? 'Yes' : 'No');
                    }

        return $module_types;
    }
}

/**
 * send survey email to given records
 *
 * @author     Biztech Consultancy
 * @param      string - $records
 * @param      string - $module_name
 * @param      string - $survey_id
 * @param      string - $schedule_on_date
 * @param      string - $schedule_on_time
 * @param      bool - $isSendNow
 * @return     Array
 */
function sendSurveyEmailsModuleRecords($records = '', $module_name = '', $survey_id = '', $schedule_on_date = '', $schedule_on_time = '', $isSendNow = false, $beanFromLogicHook = '', $recipient_as = 'to', $origin_parent_type = '', $origin_parent_id = '', $email_automation = false) {
    global $sugar_config, $db, $current_user, $timeDate;
    $schedule_date = "";
    $returnDataSurvey = array();
    $is_send = '';


    $bean_records = explode(",", $records);
    $bean_records_count = count($bean_records);
    /*
     * Get survey details
     */

    $recipients[$module_name] = $bean_records;

    $optOutCount = 0;
    $firsttimecount = 0;

    $rec_module = $module_name;

    $tobe_Submission = array();

    foreach ($recipients[$module_name] as $rec_module_id) {

        require_once('include/SugarQuery/SugarQuery.php');
        $query = new SugarQuery();
        $query->from(BeanFactory::getBean('bc_survey_submission'));
        $query->join('bc_survey_submission_bc_survey', array('alias' => 'bc_survey'));
        $query->select(array("id", "date_entered", "date_modified", "survey_send", "status"));
        $query->where()->queryAnd()->equals('target_parent_id', $rec_module_id)->equals('bc_survey.id', $survey_id);

        $checkQryRes = $query->execute();

        switch ($module_name) {
            case "Accounts":
                $focus = new Account();
                break;
            case "Contacts":
                $focus = new Contact();
                break;
            case "Leads":
                $focus = new Lead();
                break;
            case "Prospects":
                $focus = new Prospect();
                break;
        }

        $focus->retrieve($rec_module_id);
        $record_name = $focus->name;
        if (empty($record_name)) {
            $focus = $beanFromLogicHook;
            $record_name = $focus->name;
        }
        if ($email_automation == true) {
            $checkQry = "SELECT
                              submission.id,
                              submission.status,
                              submission.survey_send,
                              submission.date_entered,
                              submission.date_modified
                            FROM bc_survey_submission as submission
                              INNER JOIN bc_survey_submission_bc_survey_c as relation
                                ON relation.bc_survey_submission_bc_surveybc_survey_submission_idb = submission.id
                            WHERE submission.target_parent_id = '{$rec_module_id}'
                                AND relation.bc_survey_submission_bc_surveybc_survey_ida = '{$survey_id}'
                                AND submission.deleted = 0 order by submission.customer_name asc";
            $checkQryRes = $db->query($checkQry);
            //$count_num_rows = 0;
            $result = $db->fetchByAssoc($checkQryRes);
            $sub_id = $result['id'];
            $count_num_rows = 0;
            if (!empty($result)) {
                $count_num_rows++;
            }

            if ($count_num_rows != 0) {
                $is_send = "already_sent";
                $returnDataSurvey['submission_id'] = $result['id'];
                $returnDataSurvey['status'] = $result['status'];
            }
        }
        if (($email_automation == true && $is_send != 'already_sent') || $email_automation == false) {
            if ($focus->email_opt_out == 0) {
                /*
                 * Store survey data start
                 */
                $is_send = 'scheduled';
                if ($is_send == 'scheduled' && ($isSendNow || $bean_records_count <= 500)) {

                    if (!empty($schedule_on_date) && !(empty($schedule_on_time))) {
                        $gmtdatetime = TimeDate::getInstance()->to_db($schedule_on_date . " " . $schedule_on_time);
                    } else {
                        $gmtdatetime = TimeDate::getInstance()->nowDb();
                    }

                    $survey = BeanFactory::getBean('bc_survey', $survey_id);

                    //Get Survey Questions score weight
                    $base_score = $survey->base_score;

                    //assigned user and team
                    //origin
                    if (!empty($origin_parent_id) && !empty($origin_parent_type)) {
                        $oOrigin = BeanFactory::getBean($origin_parent_type, $origin_parent_id);
                    }
                    $assigned_user_id = $oOrigin->assigned_user_id;
                    $team_id = $oOrigin->team_id;
                    $team_set_id = $oOrigin->team_set_id;


                    $survey_submission = new bc_survey_submission();
                    $survey_submission->submission_date = '';
                    $survey_submission->email_opened = 0;
                    if (!empty($gmtdatetime)) {
                        $survey_submission->survey_send = 0;
                    }
                    $survey_submission->name = $record_name;
                    $survey_submission->customer_name = $record_name;
                    $survey_submission->schedule_on = $gmtdatetime;
                    $survey_submission->status = 'Pending';
                    $survey_submission->recipient_as = 'to';
                    $survey_submission->base_score = $base_score;
                    $survey_submission->parent_type = $oOrigin->module_name;
                    $survey_submission->parent_id = $oOrigin->id;
                    $survey_submission->target_parent_type = $rec_module;
                    $survey_submission->target_parent_id = $rec_module_id;
                    $survey_submission->assigned_user_id = $assigned_user_id;
                    $survey_submission->team_set_id = $team_set_id;
                    $survey_submission->team_id = $team_id;
                    $survey_submission->submission_type = 'Email';
                    $survey_submission->bc_survey_submission_bc_surveybc_survey_ida = $survey->id;

                    $survey_submission->save();
                    $submission_id = $survey_submission->id;
                    $survey_submission->load_relationship('bc_survey_submission_bc_survey');
                    $survey_submission->bc_survey_submission_bc_survey->add($survey->id);
                    $returnDataSurvey['submission_id'] = $survey_submission->id;
                } else {
                    $tobe_Submission[] = array('module_id' => $rec_module_id, 'module_name' => $module_name, 'survey_id' => $survey_id);
                }

                $firsttimecount++;
            } else {
                $returnDataSurvey['alreadyOptOut']['records'][$rec_module_id] = $record_name;
                $optOutCount++;
                $is_send = 'optOut';
            }
        }
    }


    // Insert all to be records into mediator table of submission
    if (!empty($tobe_Submission)) {
        $counter_sub = 0;
        $insert_queries = array();
        $insert = "INSERT into survey_submission_pending_entries(module_name,module_id,survey_id) VALUES";

        foreach ($tobe_Submission as $k => $sub_data) {

            if ($counter_sub < 10) {
                // create new entry if not exists
                $insert .= "('{$sub_data['module_name']}','{$sub_data['module_id']}','{$sub_data['survey_id']}'),";
                $counter_sub++;
            }
            if ($counter_sub == 10) {
                // insert into table when 10 rows are added to query
                $insert = rtrim($insert, ',');
                $insert_queries[] = $insert;
                // reset variables
                $insert = "INSERT into survey_submission_pending_entries(module_name,module_id,survey_id) VALUES";
                $counter_sub = 0;
            }
        }
        if (!empty($insert)) {
            // insert into table when remaining queries are not added to insert variable
            $insert = rtrim($insert, ',');
            $insert_queries[] = $insert;
        }

        foreach ($insert_queries as $i => $query) {
            if ($query != 'INSERT into survey_submission_pending_entries(module_name,module_id,survey_id) VALUES') {
                $db->query($query);
            }
        }
    }
    $returnDataSurvey['MailSentSuccessfullyFirstTime'] = $firsttimecount;
    $returnDataSurvey['alreadyOptOut']['count'] = $optOutCount;
    $survey = BeanFactory::getBean('bc_survey', $survey_id);
    $survey->survey_send_status = 'active';
    $survey->save();
    $returnDataSurvey['is_send'] = $is_send;
    return $returnDataSurvey;
}

/**
 * get individual person submitted data
 *
 * @author     Biztech Consultancy
 * @param      string - $survey_id
 * @param      string - $module_id
 * @param      string - $module_type
 * @return     Array
 */
function getPerson_SubmissionData($survey_id = '', $module_id = '', $module_type = '', $oSubmission = '') {
    global $db, $sugar_config;
    $html = "";
    $focus = "";
    $que_seqList = array();
    // get individual response for a person
    $oSurvey = BeanFactory::getBean('bc_survey', $survey_id);
    $resultArray['survey_name'] = $oSurvey->name;
    $resultArray['description'] = nl2br($oSurvey->description);

    // survey related submission
    // current record of module recipient
    if ($oSubmission->target_parent_id == $module_id) {

        $resultArray['submission_id'] = $oSubmission->id;
        $resultArray['status'] = $oSubmission->status;
        $resultArray['target_parent_type'] = $oSubmission->target_parent_type;
        $resultArray['customer_name'] = $oSubmission->customer_name;
        $resultArray['base_score'] = $oSubmission->base_score;
        $resultArray['obtained_score'] = $oSubmission->obtained_score;
        $resultArray['send_date'] = $oSubmission->last_send_on;
        $resultArray['receive_date'] = $oSubmission->submission_date;
        $resultArray['base_score'] = $oSubmission->base_score;
        // submission related submitted data
        $dataQry = "SELECT bc_submission_data_bc_survey_submissionbc_submission_data_idb FROM bc_submission_data_bc_survey_submission_c WHERE deleted = 0 AND bc_submission_data_bc_survey_submissionbc_survey_submission_ida = '{$oSubmission->id}' ";
        $resQry = $db->query($dataQry);
        while ($row = $db->fetchByAssoc($resQry)) {
            $submittedData[] = $row['bc_submission_data_bc_survey_submissionbc_submission_data_idb'];
        }
        //  $submittedData = $oSubmission->get_linked_beans('bc_submission_data_bc_survey_submission', 'bc_submission_data');

        $submitedAndIds = array();
        foreach ($submittedData as $oSubmissionDataId) {
            // get related questions submitted
            require_once('include/SugarQuery/SugarQuery.php');
            $query = new SugarQuery();
            $query->from(BeanFactory::getBean('bc_submission_data'));
            $query->join('bc_submission_data_bc_survey_answers', array('alias' => 'related_survey_answers'));
            $query->select(array("related_survey_answers.id"));
            $query->where()->queryAnd()->equals('bc_submission_data.id', $oSubmissionDataId);

            $scDataQryRes = $query->execute();
            foreach ($scDataQryRes as $subAns) {
                $oSubmissionData = BeanFactory::getBean('bc_submission_data', $oSubmissionDataId);

                $query = new SugarQuery();
                $query->from(BeanFactory::getBean('bc_survey_answers'));
                $query->join('bc_survey_answers_bc_survey_questions', array('alias' => 'related_survey_questions'));

                $query->select(array("related_survey_questions.id"));
                $query->where()->queryAnd()->equals('bc_survey_answers.id', $subAns['id']);

                $scDataQryRes = $query->execute();

                if (!empty($scDataQryRes)) {

                    foreach ($scDataQryRes as $subQue) {
                        $query = new SugarQuery();
                        $query->from(BeanFactory::getBean('bc_survey_questions'));
                        $query->join('bc_survey_pages_bc_survey_questions', array('alias' => 'related_survey_pages'));

                        $query->select->fieldRaw("related_survey_pages.page_sequence", "page_sequence");

                        $query->where()->queryAnd()->equals('bc_survey_questions.id', $subQue['id']);

                        $scDataQryRes = $query->execute();
                        foreach ($scDataQryRes as $subPage) {
                            $submitedAndIds[$subPage['page_sequence']][] = $subAns['id'];
                        }
                    }
                } else {
                    $submittedQueData = $oSubmissionData->get_linked_beans('bc_submission_data_bc_survey_questions', 'bc_survey_questions');
                    foreach ($submittedQueData as $oSubmissionQue) {
                        $submittedPageData = $oSubmissionQue->get_linked_beans('bc_survey_pages_bc_survey_questions', 'bc_survey_pages');
                        foreach ($submittedPageData as $oSubmissionPage) {

                            $submitedAndIds[$oSubmissionPage->page_sequence][] = $subAns['id'];
                        }
                    }
                }
            }
        }

        $submittedData = $oSubmission->get_linked_beans('bc_submission_data_bc_survey_submission', 'bc_submission_data');
        // get actual survey pages and details
        $surveyPages = $oSurvey->get_linked_beans('bc_survey_pages_bc_survey', 'bc_survey_pages', array('page_sequence'));
        foreach ($surveyPages as $oPage) {
            //$resultArray['pages'][$oPage->id]['page_seq'] = $oPage->page_sequence;
            //  if ($oPage->page_sequence == $page) {
            $queList = $oPage->get_linked_beans('bc_survey_pages_bc_survey_questions', 'bc_survey_questions');
            foreach ($queList as $oQuestion) {
                if ($oQuestion->question_type != 'section-header') {
                    // result of Question Detail
                    $resultArray['pages'][$oPage->id][$oQuestion->id]['matrix_rows'] = $oQuestion->matrix_row;
                    $resultArray['pages'][$oPage->id][$oQuestion->id]['matrix_cols'] = $oQuestion->matrix_col;
                    $resultArray['pages'][$oPage->id][$oQuestion->id]['question_title'] = $oQuestion->name;
                    $resultArray['pages'][$oPage->id][$oQuestion->id]['max_size'] = $oQuestion->maxsize;
                    $resultArray['pages'][$oPage->id][$oQuestion->id]['base_weight'] = $oQuestion->base_weight;
                    $resultArray['pages'][$oPage->id][$oQuestion->id]['enable_scoring'] = $oQuestion->enable_scoring;
                    $resultArray['pages'][$oPage->id][$oQuestion->id]['question_id'] = $oQuestion->id;
                    $resultArray['pages'][$oPage->id][$oQuestion->id]['question_type'] = $oQuestion->question_type;
                    $resultArray['pages'][$oPage->id][$oQuestion->id]['que_seq'] = $oQuestion->question_sequence;
                    $resultArray['pages'][$oPage->id][$oQuestion->id]['page_seq'] = $oPage->page_sequence;

                    $ansList = $oQuestion->get_linked_beans('bc_survey_answers_bc_survey_questions', 'bc_survey_answers');
                    if ($oQuestion->question_type == 'radio-button' || $oQuestion->question_type == 'check-box' || $oQuestion->question_type == 'multiselectlist' || $oQuestion->question_type == 'dropdownlist' || $oQuestion->question_type == 'boolean') {
                        foreach ($ansList as $oAnswer) {

                            if (in_array($oAnswer->id, $submitedAndIds[$oPage->page_sequence]) && $oAnswer->answer_type != 'other') {
                                $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$oAnswer->id]['answer_id'] = $oAnswer->id;
                                $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$oAnswer->id]['name'] = $oAnswer->answer_name;
                                $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$oAnswer->id]['score_weight'] = $oAnswer->score_weight;
                            }
                        }
                    }
                    // get answers of other than multi select question type
                    else if ($oQuestion->question_type != 'radio-button' || $oQuestion->question_type != 'check-box' || $oQuestion->question_type != 'multiselectlist' || $oQuestion->question_type != 'dropdownlist' || $oQuestion->question_type == 'boolean') {
                        foreach ($submitedAndIds[$oPage->page_sequence] as $key => $subAns) {
                            // check for answer
                            $oAnswer = BeanFactory::getBean('bc_survey_answers', $subAns);
                            $subData = $oAnswer->get_linked_beans('bc_submission_data_bc_survey_answers', 'bc_submission_data');
                            foreach ($subData as $sub) {
                                $quesSubList = $sub->get_linked_beans('bc_submission_data_bc_survey_questions', 'bc_survey_questions');
                                foreach ($quesSubList as $subQue) {
                                    if ($subQue->id == $oQuestion->id) {
                                        $submitted_ans_id = $subAns;
                                        $submitted_ans_name = $oAnswer->answer_name;
                                        $submitted_ans_seq = $oAnswer->answer_sequence;
                                    }
                                }
                            }
                        }
                        // submitted answer
                        $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$submitted_ans_id]['answer_id'] = $submitted_ans_id;
                        $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$submitted_ans_id]['name'] = $submitted_ans_name;
                        $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$submitted_ans_id]['answer_sequence'] = $submitted_ans_seq;
                    }
                    if ($oQuestion->enable_otherOption == 1) {

                        $submitted_ans_id = '';
                        $submitted_ans_name = '';
                        foreach ($submittedData as $oSubmissionData) {
                            $current_submited_id = '';
                            // check answer for current question only
                            $submittedQueList = $oSubmissionData->get_linked_beans('bc_submission_data_bc_survey_questions', 'bc_survey_questions');
                            foreach ($submittedQueList as $subQue) {
                                if ($subQue->id == $oQuestion->id) {
                                    $current_submited_id = $oSubmissionData->id;
                                }
                            }
                            if (!empty($current_submited_id)) {
                                // get related questions submitted
                                $submittedAnsList = $oSubmissionData->get_linked_beans('bc_submission_data_bc_survey_answers', 'bc_survey_answers', array('date_modified'));

                                foreach ($submittedAnsList as $subAns) {

                                    if (!in_array($subAns->id, $optionIds) && $subAns->answer_type != 'other') {
                                        $submitted_ans_id = $subAns->id;
                                        $submitted_ans_name = $subAns->answer_name;
                                    }
                                }
                            }
                        }
                        if ($submitted_ans_id) {
                            // submitted answer
                            $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$submitted_ans_id]['answer_id'] = $submitted_ans_id;
                            $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$submitted_ans_id]['name'] = $submitted_ans_name;
                        }
                    }
                    // if answer is not given then set blank answer for the same
                    if (!isset($resultArray['pages'][$oPage->id][$oQuestion->id]['answers'])) {
                        $resultArray['pages'][$oPage->id][$oQuestion->id]['answers']['n/a']['answer_id'] = 'N/A';
                        $resultArray['pages'][$oPage->id][$oQuestion->id]['answers']['n/a']['name'] = 'N/A';
                    }
                }
            }
        }
    }
    //  }
    // Arrange question as per page wise sequence
    // get page wise sequence
    if (isset($resultArray['pages']) && !empty($resultArray['pages'])) {
        foreach ($resultArray['pages'] as $pageKey => $pData) {
            foreach ($pData as $qId => $pDetail) {
                // sort question by question sequence
                $sorted_ques[$pDetail['que_seq']] = $pDetail;
            }
            foreach ($sorted_ques as $que_seq => $que_detail) {
                // check sequence for current page

                $que_seqList[$pDetail['page_seq']][$pageKey][$que_seq][$que_detail['question_id']] = $que_detail;
            }
            ksort($que_seqList[$pDetail['page_seq']][$pageKey]);
        }
        ksort($que_seqList);
    }
    $orderedSurvey = array();
    // $counter = 0;
    // re create ordered list for question sequence wise data
    foreach ($que_seqList as $pageSeq => $pageDetail) {
        foreach ($pageDetail as $pageId => $page_que_Detail) {
            foreach ($pageDetail as $pId => $questionDetails) {
                foreach ($questionDetails as $queSeq => $questionDetail) {
                    foreach ($questionDetail as $queId => $qDetail) {
                        //  $counter++;
                        $orderedSurvey['pages'][$pageId][$queId] = $qDetail;
                    }
                }
            }
        }
    }

    $detail_array = array();
    $i = 0;
    // while ($row = $db->fetchByAssoc($result)) {
    //get module_name
    $moduleName = empty($resultArray['target_parent_type']) ? $module_type : $resultArray['target_parent_type'];
    if (empty($record_name)) {
        switch ($moduleName) {
            case "Accounts":
                $focus = new Account();
                break;
            case "Contacts":
                $focus = new Contact();
                break;
            case "Leads":
                $focus = new Lead();
                break;
            case "Prospects":
                $focus = new Prospect();
                break;
        }
        $focus->retrieve($module_id);
        $record_name = $focus->name;
        $html .= "<h2 class='title'>Individual Report for {$record_name}</h2>";
    }

    if ($resultArray['status'] == 'Pending') {
        $html = "<div id='individual'>There is no submission response for this Survey.</div>";
    } else if ($resultArray['status'] == null) {
        $html = '';
    } else {
        if ($resultArray['status'] == 'Submitted') {
            foreach ($orderedSurvey['pages'] as $page_id => $page_detail) {
                // question detail
                $ansKey = array();
                foreach ($page_detail as $que_id => $que_detail) {
                    //Contact Information then retrieve all answer from db & store in variable
                    if (!empty($que_detail['question_type']) && $que_detail['question_type'] == 'contact-information') {
                        foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                            $contact_information = JSON::decode(html_entity_decode($ans_detail['name']));
                            $detail_array[$que_detail['question_id']][$que_detail['question_title']][$ans_detail['answer_id']] = $contact_information;
                        }
                    }
                    // Matrix type then get rows & columns value & generate selected answer layout
                    else if (!empty($que_detail['question_type']) && $que_detail['question_type'] == 'matrix') {
                        // set matrix answer to question array
                        $matrix_row = json_decode(base64_decode(($que_detail['matrix_rows'])));
                        $matrix_col = json_decode(base64_decode(($que_detail['matrix_cols'])));
                        $detail_array[$que_detail['question_id']][$que_detail['question_title']]['matrix_rows'] = $matrix_row;
                        $detail_array[$que_detail['question_id']][$que_detail['question_title']]['matrix_cols'] = $matrix_col;
                        $answer = getAnswerSubmissionDataForMatrix($survey_id, $module_id, $que_detail['question_id']);
                        $detail_array[$que_detail['question_id']][$que_detail['question_title']]['answer_detail'] = $answer;
                    }
                    //Net Promoter Score then retrieve all answer from db & store in variable
                    else if (!empty($que_detail['question_type']) && $que_detail['question_type'] == 'netpromoterscore') {
                        $ansKey = array_keys($que_detail['answers']);
                        $detail_array[$que_detail['question_id']][$que_detail['question_title']]['nps'] = $que_detail['answers'][$ansKey[0]]['answer_id'];
                        $detail_array[$que_detail['question_id']][$que_detail['question_title']]['nps_value'][$que_detail['answers'][$ansKey[0]]['answer_id']] = $que_detail['answers'][$ansKey[0]]['name'];
                    }
                    //Net Promoter Score then retrieve all answer from db & store in variable
                    else if (!empty($que_detail['question_type']) && $que_detail['question_type'] == 'emojis') {
                        $ansKey = array_keys($que_detail['answers']);
                        $detail_array[$que_detail['question_id']][$que_detail['question_title']]['emojis_val']['emojis_ans_seq'] = $que_detail['answers'][$ansKey[0]]['answer_sequence'];
                        $detail_array[$que_detail['question_id']][$que_detail['question_title']]['emojis_val']['emojis_ans_text'] = $que_detail['answers'][$ansKey[0]]['name'];
                    }
                    // Rating then generate selected star value
                    elseif (!empty($que_detail['question_type']) && $que_detail['question_type'] == 'rating') {
                        foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                            $rating_value = $ans_detail['name'];
                            $site_url = $sugar_config['site_url'];
                            $rating = '';
                            for ($star = 1; $star <= $rating_value; $star++) {
                                $rating .= "<img src='{$site_url}/custom/include/survey-img/fullstar.png' alt='{$star} star'>";
                            }

                            $total_star = $que_detail['max_size'];
                            $remaining_star_value = $total_star - $rating_value;
                            for ($star = 1; $star <= $remaining_star_value; $star++) {
                                $rating .= "<img src='{$site_url}/custom/include/survey-img/nullstar.png' alt='no star'>";
                            }
                        }
                        $detail_array[$que_detail['question_id']][$que_detail['question_title']][$ans_detail['answer_id']] = $rating;
                    }
                    // CommentBox, TextBox , DateTime
                    elseif (!empty($que_detail['question_type']) && $que_detail['question_type'] != 'image' && $que_detail['question_type'] != 'video' && $que_detail['question_type'] != 'additional-text' && $que_detail['question_type'] != 'richtextareabox') {
                        foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                            $detail_array[$que_detail['question_id']][$que_detail['question_title']][$ans_detail['answer_id']] = $ans_detail['name'];
                        }
                    }

                    // Other type of Question
                    elseif (!empty($que_detail['question_type']) && $que_detail['question_type'] != 'image' && $que_detail['question_type'] != 'video' && $que_detail['question_type'] != 'additional-text' && $que_detail['question_type'] != 'richtextareabox') {
                        foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                            if (array_key_exists($que_detail['question_title'], $detail_array)) {
                                $detail_array[$que_detail['question_id']][$que_detail['question_title']][$ans_detail['answer_id']] = $ans_detail['name'];
                            } else {
                                $detail_array[$que_detail['question_id']][$que_detail['question_title']][$ans_detail['answer_id']] = $ans_detail['name'];
                            }
                        }
                    }
                }
            }
        }
    }

    return $detail_array;
}

/**
 * get all person submitted data export
 *
 * @author     Biztech Consultancy
 * @param      string - $survey_id
 * @param      string - $module_id
 * @param      string - $module_type
 * @return     Array
 */
function getPerson_SubmissionExportData($survey_id = '', $module_id = '', $export = '', $customer_name = '', $submission_id = '') {
    global $db, $sugar_config;
    $resultArray = array();
    $que_seqList = array();
    // get individual response for a person
    $oSurvey = BeanFactory::getBean('bc_survey', $survey_id);
    $resultArray['survey_name'] = $oSurvey->name;
    $resultArray['description'] = nl2br($oSurvey->description);
    if (empty($submission_id)) {
        $submissionList = $oSurvey->get_linked_beans('bc_survey_submission_bc_survey', 'bc_survey_submission');
    } else {
        $submissionList = array();
        $oSubmission = BeanFactory::getBean('bc_survey_submission', $submission_id);
        $submissionList[] = $oSubmission;
    }
    $answer_row = '';
    $answer_col = '';
    // get actual survey pages and details
    $surveyPages = $oSurvey->get_linked_beans('bc_survey_pages_bc_survey', 'bc_survey_pages');
    $totalPages = count($surveyPages);
    // survey related submission
    foreach ($submissionList as $oSubmission) {

        // current record of module recipient
        if (((!empty($oSubmission->customer_name) && $oSubmission->customer_name == $customer_name))) {

            $resultArray['submission_id'] = $oSubmission->id;
            $resultArray['status'] = $oSubmission->status;
            $resultArray['target_parent_type'] = $oSubmission->target_parent_type;
            $resultArray['customer_name'] = $oSubmission->customer_name;
            $resultArray['base_score'] = $oSubmission->base_score;
            $resultArray['obtained_score'] = $oSubmission->obtained_score;
            $resultArray['send_date'] = $oSubmission->last_send_on;
            $resultArray['receive_date'] = $oSubmission->submission_date;
            $resultArray['base_score'] = $oSubmission->base_score;
            $selected_lang = $oSubmission->submission_language;

            // list of lang wise survey detail
            if (!empty($selected_lang)) {
                $list_lang_detail_array = return_app_list_strings_language($selected_lang);
                $list_lang_detail = $list_lang_detail_array[$survey_id];
            } else {
                $list_lang_detail = '';
            }

            $resultArray['description'] = (!empty($list_lang_detail[$survey_id . '_survey_description'])) ? $list_lang_detail[$survey_id . '_survey_description'] : nl2br($oSurvey->description);

            // submission related submitted data
            $submittedData = $oSubmission->get_linked_beans('bc_submission_data_bc_survey_submission', 'bc_submission_data');
            $submitedAndIds = array();
            foreach ($submittedData as $oSubmissionData) {
                // get related questions submitted
                require_once('include/SugarQuery/SugarQuery.php');
                $query = new SugarQuery();
                $query->from(BeanFactory::getBean('bc_submission_data'));
                $query->join('bc_submission_data_bc_survey_answers', array('alias' => 'related_survey_answers'));
                $query->select(array("related_survey_answers.id"));
                $query->where()->queryAnd()->equals('bc_submission_data.id', $oSubmissionData->id);

                $scDataQryRes = $query->execute();
                foreach ($scDataQryRes as $subAns) {
                    $query = new SugarQuery();
                    $query->from(BeanFactory::getBean('bc_survey_answers'));
                    $query->join('bc_survey_answers_bc_survey_questions', array('alias' => 'related_survey_questions'));

                    $query->select(array("related_survey_questions.id"));
                    $query->where()->queryAnd()->equals('bc_survey_answers.id', $subAns['id']);

                    $scDataQryRes = $query->execute();

                    if (!empty($scDataQryRes)) {

                        foreach ($scDataQryRes as $subQue) {
                            $query = new SugarQuery();
                            $query->from(BeanFactory::getBean('bc_survey_questions'));
                            $query->join('bc_survey_pages_bc_survey_questions', array('alias' => 'related_survey_pages'));

                            $query->select->fieldRaw("related_survey_pages.page_sequence", "page_sequence");

                            $query->where()->queryAnd()->equals('bc_survey_questions.id', $subQue['id']);

                            $scDataQryRes = $query->execute();
                            foreach ($scDataQryRes as $subPage) {
                                $submitedAndIds[$subPage['page_sequence']][] = $subAns['id'];
                            }
                        }
                    } else {
                        $submittedQueData = $oSubmissionData->get_linked_beans('bc_submission_data_bc_survey_questions', 'bc_survey_questions');
                        foreach ($submittedQueData as $oSubmissionQue) {
                            $submittedPageData = $oSubmissionQue->get_linked_beans('bc_survey_pages_bc_survey_questions', 'bc_survey_pages');
                            foreach ($submittedPageData as $oSubmissionPage) {

                                $submitedAndIds[$oSubmissionPage->page_sequence][] = $subAns['id'];

                                //}
                            }
                        }
                    }
                }
                //  }
            }

            foreach ($surveyPages as $oPage) {

                $queList = $oPage->get_linked_beans('bc_survey_pages_bc_survey_questions', 'bc_survey_questions', array('question_sequence'));
                foreach ($queList as $oQuestion) {
                    if ($oQuestion->question_type != 'section-header') {
                        // result of Question Detail
                        $resultArray['pages'][$oPage->id][$oQuestion->id]['matrix_rows'] = $oQuestion->matrix_row;
                        $resultArray['pages'][$oPage->id][$oQuestion->id]['matrix_cols'] = $oQuestion->matrix_col;
                        $resultArray['pages'][$oPage->id][$oQuestion->id]['question_title'] = (!empty($list_lang_detail[$oQuestion->id . '_que_title'])) ? $list_lang_detail[$oQuestion->id . '_que_title'] : $oQuestion->name;
                        $resultArray['pages'][$oPage->id][$oQuestion->id]['max_size'] = $oQuestion->maxsize;
                        $resultArray['pages'][$oPage->id][$oQuestion->id]['base_weight'] = $oQuestion->base_weight;
                        $resultArray['pages'][$oPage->id][$oQuestion->id]['enable_scoring'] = $oQuestion->enable_scoring;
                        $resultArray['pages'][$oPage->id][$oQuestion->id]['question_id'] = $oQuestion->id;
                        $resultArray['pages'][$oPage->id][$oQuestion->id]['question_title'] = $oQuestion->name;
                        $resultArray['pages'][$oPage->id][$oQuestion->id]['question_type'] = $oQuestion->question_type;
                        $resultArray['pages'][$oPage->id][$oQuestion->id]['page_seq'] = $oPage->page_sequence;
                        $resultArray['pages'][$oPage->id][$oQuestion->id]['que_seq'] = $oQuestion->question_sequence;
                        $resultArray['pages'][$oPage->id][$oQuestion->id]['enable_otherOption'] = $oQuestion->enable_otherOption;

                        $ansList = $oQuestion->get_linked_beans('bc_survey_answers_bc_survey_questions', 'bc_survey_answers');
                        if ($oQuestion->question_type == 'radio-button' || $oQuestion->question_type == 'check-box' || $oQuestion->question_type == 'multiselectlist' || $oQuestion->question_type == 'dropdownlist' || $oQuestion->question_type == 'boolean') {
                            $optionIds = array();
                            foreach ($ansList as $oAnswer) {

                                if (isset($submitedAndIds[$oPage->page_sequence]) && in_array($oAnswer->id, $submitedAndIds[$oPage->page_sequence]) && $oAnswer->answer_type != 'other') {
                                    $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$oAnswer->id]['answer_id'] = $oAnswer->id;
                                    $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$oAnswer->id]['answer_name'] = (!empty($list_lang_detail[$oAnswer->id])) ? $list_lang_detail[$oAnswer->id] : $oAnswer->answer_name;
                                    $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$oAnswer->id]['score_weight'] = $oAnswer->score_weight;
                                } else if ($oAnswer->answer_type == 'other') {
                                    $otherScore = $oAnswer->score_weight;
                                }
                                $optionIds[] = $oAnswer->id;
                            }
                        }
                        // get answers of other than multi select question type
                        else if ($oQuestion->question_type != 'radio-button' || $oQuestion->question_type != 'check-box' || $oQuestion->question_type != 'multiselectlist' || $oQuestion->question_type != 'dropdownlist' || $oQuestion->question_type == 'boolean') {
                            foreach ($submitedAndIds[$oPage->page_sequence] as $key => $subAns) {
                                $submitted_ans_id = '';
                                $submitted_ans_name = '';
                                // check for answer
                                $oAnswer = BeanFactory::getBean('bc_survey_answers', $subAns);

                                $subData = $oAnswer->get_linked_beans('bc_submission_data_bc_survey_answers', 'bc_submission_data');
                                foreach ($subData as $sub) {
                                    $quesSubList = $sub->get_linked_beans('bc_submission_data_bc_survey_questions', 'bc_survey_questions');
                                    foreach ($quesSubList as $subQue) {
                                        if ($subQue->id == $oQuestion->id) {
                                            $submitted_ans_id = $subAns;
                                            $submitted_ans_name = $oAnswer->answer_name;
                                            $submitted_ans_seq = $oAnswer->answer_sequence;
                                        } else {
                                            // submitted answer
                                            $resultArray['pages'][$oPage->id][$subQue->id]['answers'][$submitted_ans_id]['answer_id'] = $subAns;
                                            $resultArray['pages'][$oPage->id][$subQue->id]['answers'][$submitted_ans_id]['answer_name'] = $oAnswer->answer_name;
                                            $resultArray['pages'][$oPage->id][$subQue->id]['answers'][$submitted_ans_id]['answer_sequence'] = $oAnswer->answer_sequence;
                                        }
                                    }
                                    // submitted answer
                                    $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$submitted_ans_id]['answer_id'] = $submitted_ans_id;
                                    $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$submitted_ans_id]['answer_name'] = $submitted_ans_name;
                                    $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$submitted_ans_id]['answer_sequence'] = $submitted_ans_seq;
                                }
                            }
                        }
                        if ($oQuestion->enable_otherOption == 1) {

                            $submitted_ans_id = '';
                            $submitted_ans_name = '';
                            foreach ($submittedData as $oSubmissionData) {
                                $current_submited_id = '';

                                // check answer for current question only
                                $submittedQueList = $oSubmissionData->get_linked_beans('bc_submission_data_bc_survey_questions', 'bc_survey_questions');
                                foreach ($submittedQueList as $subQue) {
                                    if ($subQue->id == $oQuestion->id) {
                                        $current_submited_id = $oSubmissionData->id;
                                    }
                                }
                                if (!empty($current_submited_id)) {
                                    // get related questions submitted

                                    $submittedAnsList = $oSubmissionData->get_linked_beans('bc_submission_data_bc_survey_answers', 'bc_survey_answers', array('date_modified'));

                                    foreach ($submittedAnsList as $subAns) {

                                        if (!in_array($subAns->id, $optionIds) && $subAns->answer_type != 'other') {
                                            $submitted_ans_id = $subAns->id;
                                            $submitted_ans_name = $subAns->answer_name;
                                        }
                                    }
                                }
                            }

                            if (!empty($submitted_ans_id)) {
                                // submitted answer
                                $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$submitted_ans_id]['answer_id'] = $submitted_ans_id;
                                $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$submitted_ans_id]['answer_name'] = $submitted_ans_name;
                                $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$submitted_ans_id]['score_weight'] = $otherScore;
                            }
                        }
                        // if answer is not given then set blank answer for the same
                        if (!isset($resultArray['pages'][$oPage->id][$oQuestion->id]['answers'])) {
                            $resultArray['pages'][$oPage->id][$oQuestion->id]['answers']['n/a']['answer_id'] = 'N/A';
                            $resultArray['pages'][$oPage->id][$oQuestion->id]['answers']['n/a']['answer_name'] = 'N/A';
                        }
                    }
                }
            }
        }
    }

    // Arrange question as per page wise sequence
    // get page wise sequence
    if (isset($resultArray['pages']) && !empty($resultArray['pages'])) {
        foreach ($resultArray['pages'] as $pageKey => $pData) {
            foreach ($pData as $qId => $pDetail) {
                unset($pDetail['answers']['']);
                // sort question by question sequence
                $que_seqList[$pDetail['page_seq']][$pageKey][$pDetail['que_seq']][$pDetail['question_id']] = $pDetail;
            }
            ksort($que_seqList[$pDetail['page_seq']][$pageKey]);
        }
        ksort($que_seqList);
    }
    $orderedSurvey = array();

    // re create ordered list for question sequence wise data
    foreach ($que_seqList as $pageSeq => $pageDetail) {
        foreach ($pageDetail as $pageId => $page_que_Detail) {
            foreach ($pageDetail as $pId => $questionDetails) {
                foreach ($questionDetails as $queSeq => $questionDetail) {
                    foreach ($questionDetail as $queId => $qDetail) {
                        //  $counter++;
                        $orderedSurvey['pages'][$pageId][$queId] = $qDetail;
                    }
                }
            }
        }
    }

    $survey_details = array();
    if (isset($orderedSurvey['pages']) && !empty($orderedSurvey['pages'])) {
        foreach ($orderedSurvey['pages'] as $page_id => $page_detail) {
            // question detail
            foreach ($page_detail as $que_id => $que_detail) {
                $detail_array = array();

                if (!empty($que_detail['question_type']) && $que_detail['question_type'] == 'contact-information') {
                    // answer detail
                    foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                        $contact_information = JSON::decode(html_entity_decode($ans_detail['answer_name']));
                    }
                    $contactString = '';
                    if (!empty($contact_information)) {
                        foreach ($contact_information as $key => $value) {
                            $contactString .= $key . " : " . $value . ",";
                        }
                        $detail_array[$que_detail['question_title']] = $contactString;
                        $detail_array['answerId'] = $ans_id;
                    } else {
                        $detail_array[$que_detail['question_title']] = 'Not Answered';
                    }
                }
                // Matrix type then get rows & columns value & generate selected answer layout
                else if (!empty($que_detail['question_type']) && $que_detail['question_type'] == 'matrix' && !$export) {
                    // set matrix answer to question array
                    $matrix_row = json_decode(base64_decode(($que_detail['matrix_rows'])));
                    $matrix_col = json_decode(base64_decode(($que_detail['matrix_cols'])));
                    if (str_split($customer_name, 8)[0] == 'Web Link') {
                        $module_id = $customer_name;
                    }
                    $answer = getAnswerSubmissionDataForMatrix($survey_id, $module_id, $que_detail['question_id'], '', $submission_id);
                    foreach ($answer as $key => $anss_matrix) {
                        foreach ($anss_matrix as $key_seq => $anss_matrix_final) {
                            if (!empty($anss_matrix_final)) {
                                if (!empty($anss_matrix_new)) {
                                    $anss_matrix_new = $anss_matrix_new . ',' . $anss_matrix_final;
                                } else {
                                    $anss_matrix_new = $anss_matrix_final;
                                }
                                $detail_array[$que_detail['question_title']] = $anss_matrix_new;
                            }
                        }
                    }
                    $i++;
                }  // Matrix type then get rows & columns value & generate selected answer layout when not export
                else if (!empty($que_detail['question_type']) && $que_detail['question_type'] == 'matrix' && $export) {
                    // set matrix answer to question array
                    $matrix_row = json_decode(base64_decode(($que_detail['matrix_rows'])));
                    $matrix_col = json_decode(base64_decode(($que_detail['matrix_cols'])));
                    if (str_split($customer_name, 8)[0] == 'Web Link') {
                        $module_id = $customer_name;
                    }
                    $answer = getAnswerSubmissionDataForMatrix($survey_id, $module_id, $que_detail['question_id'], '', $submission_id);
                    foreach ($answer as $key => $anss_matrix) {
                        foreach ($anss_matrix as $key_seq => $anss_matrix_final) {
                            if (!empty($anss_matrix_final)) {

                                $splited_answer = explode('_', $anss_matrix_final);
                                $aRow = $splited_answer[0];
                                $aCol = $splited_answer[1];
                                $answer_row = $matrix_row->$aRow;
                                $answer_col = $matrix_col->$aCol;


                                if (!empty($answer_row) && !empty($answer_col)) {
                                    $survey_details[$que_detail['question_id']][$que_detail['question_title'] . '(' . $answer_row . ')'] = $answer_col;
                                }
                            }
                        }
                    }
                    foreach ($matrix_row as $mat_row) {
                        foreach ($matrix_col as $mat_col) {
                            if (!isset($survey_details[$que_detail['question_id']][$que_detail['question_title'] . '(' . $mat_row . ')'])) {
                                $survey_details[$que_detail['question_id']][$que_detail['question_title'] . '(' . $mat_row . ')'] = 'N/A';
                            }
                        }
                    }
                } else if (!empty($que_detail['question_type']) && ($que_detail['question_type'] == 'check-box' || $que_detail['question_type'] == 'multiselectlist') && !($export)) {
                    // answer detail
                    foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                        if (array_key_exists($que_detail['question_title'], $detail_array)) {
                            array_push($detail_array[$que_detail['question_title']], $ans_detail['answer_id']);
                            $detail_array['answerId'][] = $ans_detail['answer_id'];
                        } else {
                            $detail_array[$que_detail['question_title']][] = $ans_detail['answer_id'];
                            $detail_array['answerId'][] = $ans_detail['answer_id'];
                        }
                    }
                } else if (!empty($que_detail['question_type']) && ($que_detail['question_type'] == 'check-box' || $que_detail['question_type'] == 'multiselectlist') && ($export)) {
                    // answer detail
                    foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                        if (array_key_exists($que_detail['question_title'], $detail_array)) {
                            $detail_array[$que_detail['question_title']] = $detail_array[$que_detail['question_title']] . ',' . $ans_detail['answer_name'];
                        } else {
                            $detail_array[$que_detail['question_title']] = $ans_detail['answer_name'];
                            $survey_details[$que_detail['question_id']]['answerId'] = $ans_id;
                        }
                    }
                } else if (!empty($que_detail['question_type']) && ($que_detail['question_type'] == 'radio-button' || $que_detail['question_type'] == 'dropdownlist' || $que_detail['question_type'] == 'boolean') && !($export)) {
                    // answer detail
                    foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                        if (array_key_exists($que_detail['question_title'], $detail_array)) {
                            $detail_array[$que_detail['question_title']] = $ans_detail['answer_id'];
                            $detail_array['answerId'] = $ans_detail['answer_id'];
                        } else {
                            $detail_array[$que_detail['question_title']] = $ans_detail['answer_id'];
                            $detail_array['answerId'] = $ans_detail['answer_id'];
                        }
                    }
                } else if (!empty($que_detail['question_type']) && ($que_detail['question_type'] == 'radio-button' || $que_detail['question_type'] == 'dropdownlist' || $que_detail['question_type'] == 'boolean') && ($export)) {
                    // answer detail
                    foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                        if (array_key_exists($que_detail['question_title'], $detail_array)) {
                            $detail_array[$que_detail['question_title']] = $ans_detail['answer_name'];
                            $detail_array['answerId'] = $ans_detail['answer_id'];
                        } else {
                            $detail_array[$que_detail['question_title']] = $ans_detail['answer_name'];
                            $detail_array['answerId'] = $ans_detail['answer_id'];
                        }
                    }
                } else if (!empty($que_detail['question_type']) && $que_detail['question_type'] == 'emojis' && !($export)) {
                    // answer detail
                    foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                        if (array_key_exists($que_detail['question_title'], $detail_array)) {
                            $detail_array[$que_detail['question_title']] = $ans_detail['answer_id'];
                            $detail_array['answerId'] = $ans_detail['answer_id'];
                            $detail_array['answer_name'] = $ans_detail['answer_name'];
                            $detail_array['answer_sequence'] = $ans_detail['answer_sequence'];
                        } else {
                            $detail_array[$que_detail['question_title']] = $ans_detail['answer_id'];
                            $detail_array['answerId'] = $ans_detail['answer_id'];
                            $detail_array['answer_name'] = $ans_detail['answer_name'];
                            $detail_array['answer_sequence'] = $ans_detail['answer_sequence'];
                        }
                    }
                } else if (!empty($que_detail['question_type']) && $que_detail['question_type'] == 'emojis' && ($export)) {
                    // answer detail
                    foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                        if (array_key_exists($que_detail['question_title'], $detail_array)) {
                            $detail_array[$que_detail['question_title']] = $ans_detail['answer_name'];
                            $detail_array['answerId'] = $ans_detail['answer_id'];
                            $detail_array['answer_name'] = $ans_detail['answer_name'];
                            $detail_array['answer_sequence'] = $ans_detail['answer_sequence'];
                        } else {
                            $detail_array[$que_detail['question_title']] = $ans_detail['answer_name'];
                            $detail_array['answerId'] = $ans_detail['answer_id'];
                            $detail_array['answer_name'] = $ans_detail['answer_name'];
                            $detail_array['answer_sequence'] = $ans_detail['answer_sequence'];
                        }
                    }
                } else if (!empty($que_detail['question_type']) && $que_detail['question_type'] == 'doc-attachment' && !($export)) {
                    // answer detail
                    foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                        if (array_key_exists($que_detail['question_title'], $detail_array)) {
                            $detail_array[$que_detail['question_title']] = $ans_detail['answer_name'];
                            $detail_array['answerId'] = $ans_detail['answer_id'];
                        } else {
                            $detail_array[$que_detail['question_title']] = $ans_detail['answer_name'];
                            $detail_array['answerId'] = $ans_detail['answer_id'];
                        }
                    }
                }
                //if key already exist then store multiple answer in same question array
                if (array_key_exists($que_detail['question_id'], $survey_details) && !$export) {
                    $queAnsArray = $survey_details[$que_detail['question_id']];
                    $queArr = array_keys($queAnsArray);
                    $Question = $queArr[0];
                    // answer detail
                    foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                        array_push($survey_details[$que_detail['question_id']][$Question], $ans_detail['answer_name']);
                    }
                } //if not matrix then store single answer
                else if ($export && $que_detail['question_type'] == 'matrix') {
                    if (empty($survey_details[$que_detail['question_id']])) {
                        foreach ($matrix_row as $key => $row_value) {
                            $survey_details[$que_detail['question_id']][$que_detail['question_title'] . '(' . $row_value . ')'] = '';
                        }
                    }
                } else if (array_key_exists($que_detail['question_id'], $survey_details) && $export) {
                    $queAnsArray = $survey_details[$que_detail['question_id']];
                    $queArr = array_keys($queAnsArray);
                    $Question = $queArr[0];
                    // answer detail
                    foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                        if ($que_detail['question_type'] == 'multiselectlist' || $que_detail['question_type'] == 'checkbox') {
                            $survey_details[$que_detail['question_id']][$Question] = $survey_details[$que_detail['question_id']][$Question] . ',' . $ans_detail['answer_name'];
                        }
                    }
                } else if ((!empty($que_detail['question_type']) && $que_detail['question_type'] != 'matrix' && $que_detail['question_type'] != 'image' && $que_detail['question_type'] != 'video' && $que_detail['question_type'] != 'additional-text' && $que_detail['question_type'] != 'richtextareabox')) {
                    // answer detail
                    if (empty($detail_array)) {
                        foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                            if (!empty($survey_details[$que_detail['question_id']]) && ($que_detail['question_type'] == 'multiselectlist' || $que_detail['question_type'] == 'checkbox' )) {
                                $survey_details[$que_detail['question_id']][$que_detail['question_title']] = $survey_details[$que_detail['question_id']][$que_detail['question_title']] . ',' . $ans_detail['answer_name'];
                            } else {
                                $survey_details[$que_detail['question_id']][$que_detail['question_title']] = $ans_detail['answer_name'];
                                $survey_details[$que_detail['question_id']]['answerId'] = $ans_id;
                            }
                        }
                    } else {
                        $survey_details[$que_detail['question_id']] = $detail_array;
                    }
                } else if ($que_detail['question_type'] != 'image' && $que_detail['question_type'] != 'video' && $que_detail['question_type'] != 'additional-text' && $que_detail['question_type'] != 'richtextareabox') {
                    // answer detail
                    if (empty($detail_array)) {
                        foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                            if (!empty($survey_details[$que_detail['question_id']]) && ($que_detail['question_type'] == 'multiselectlist' || $que_detail['question_type'] == 'checkbox' )) {
                                $survey_details[$que_detail['question_id']][$que_detail['question_title']] = $survey_details[$que_detail['question_id']][$que_detail['question_title']] . ',' . $ans_detail['answer_name'];
                            } else {
                                $survey_details[$que_detail['question_id']][$que_detail['question_title']] = $ans_detail['answer_name'];
                                $survey_details[$que_detail['question_id']]['answerId'] = $ans_id;
                            }
                        }
                    } else {
                        $survey_details[$que_detail['question_id']] = $detail_array;
                    }
                }
                if ($que_detail['question_type'] == 'scale') {
                    // answer detail
                    foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                        $survey_details[$que_detail['question_id']]['answer_name'] = $ans_detail['answer_name'];
                        $survey_details[$que_detail['question_id']]['answerId'] = $ans_id;
                    }
                }
            }
        }
    }
    return $survey_details;
}

/**
 * get all data export
 *
 * @author     Biztech Consultancy
 * @param      string - $survey_id
 * @param      string - $module_id
 * @param      string - $module_type
 * @return     Array
 */
function getAllExportData($type = '', $survey_id, $name = '', $module_type = '', $submission_type = '', $status = '', $submission_start_date = '', $submission_end_date = '') {
    $submtData = array();
    $submtData = getReportData($type, $survey_id, $name, $module_type, $status, $submission_start_date, $submission_end_date, $submission_type);
    $submitDataArry = array();
    $submitted_question_obj = new bc_survey_submit_question();
    // To Improve Performance While Exporting report from Survey Report.
    // By Biztech. 
    $iSNewDataArray = $submitted_question_obj->custom_retrieve_by_string_fields(array('survey_ID' => $survey_id));
    foreach ($submtData as $sbmtId => $sbmtData) {
        $submitDataArry = $submitted_question_obj->custom_retrieve_by_string_fields(array('survey_ID' => $survey_id, 'submission_id' => $sbmtId));

        $submtData[$sbmtId]['Response'] = $submitDataArry;
        unset($submtData[$sbmtId]['module_id']);
        unset($submtData[$sbmtId]['submission_id']);
    }
    // End
    if (empty($iSNewDataArray)) {
        foreach ($submtData as $sbmtId => $sbmtData) {
            $questionAnsArray = array();
            $sbmtSurvData = getPerson_SubmissionExportData($survey_id, $sbmtData['module_id'], true, $sbmtData['customer_name'], $sbmtData['submission_id']);
            foreach ($sbmtSurvData as $queAns) {
                $question = array_keys($queAns);
                foreach ($question as $key => $answers) {
                    $questionAnsArray[] = array($question[$key] => $queAns[$question[$key]]);
                }
            }
            $submtData[$sbmtId]['Response'] = $questionAnsArray;
            unset($submtData[$sbmtId]['module_id']);
            unset($submtData[$sbmtId]['submission_id']);
        }
    }
    return $submtData;
}

/**
 * send survey reminder email
 *
 * @author     Biztech Consultancy
 * @param      string - $records
 * @param      string - $module_name
 * @param      string - $survey_id
 * @return     string
 */
function sendSurveyReminderEmails($records = '', $module_name = '', $survey_id = '') {
    global $db;
    require_once('include/SugarQuery/SugarQuery.php');
    $query = new SugarQuery();
    $query->from(BeanFactory::getBean('bc_survey_submission'));
    $query->join('bc_survey_submission_bc_survey', array('alias' => 'related_survey'));
    $query->select(array("id"));
    $query->where()->queryAnd()->equals('target_parent_id', $records)->equals('related_survey.id', $survey_id)->equals('target_parent_type', $module_name);

    $scDataQryRes = $query->execute();

    foreach ($scDataQryRes as $result) {
        // $result = $db->fetchByAssoc($runQuery);
        $submission_id = $result['id'];

        //load record of submission and update resend values
        $survey_submission = new bc_survey_submission();
        $survey_submission->retrieve($submission_id);
        $resend_counter = $survey_submission->resend_counter + 1; // update counter
        $survey_submission->resend_counter = $resend_counter;
        $survey_submission->resend = 1;
        $survey_submission->save();

        $is_send = 'scheduled';
    }
    return $is_send;
}

/**
 * create content for mail status popup after survey send clicked
 *
 * @author     Biztech Consultancy
 * @param      array - $customersSummaryData
 * @param      string - $survey_id
 * @param      string - $module_name
 * @param      string - $total_seleted_records
 * @param      string - $isSendNow
 * @param      string - $record_name
 * @return     string
 */
function createContentForMailStatusPopup($customersSummaryData = '', $survey_id = '', $module_name = '', $total_seleted_records = '', $isSendNow = '', $record_name = '', $isSendSuccess = '', $isDetailView = '', $surveySingularModule = '') {
    if (empty($total_seleted_records)) {
        $total_seleted_records = 1;
    }
    $customersFirstTimeSuccSentArray = (isset($customersSummaryData['MailSentSuccessfullyFirstTime']) && !empty($customersSummaryData['MailSentSuccessfullyFirstTime'])) ? $customersSummaryData['MailSentSuccessfullyFirstTime'] :
            array();
    $customersResponseSubmitted = (isset($customersSummaryData['ResponseSubmitted']) && !empty($customersSummaryData['ResponseSubmitted'])) ? $customersSummaryData['ResponseSubmitted'] :
            array();
    $customersPendingResponse = (isset($customersSummaryData['ResponseNotSubmitted']) && !empty($customersSummaryData['ResponseNotSubmitted'])) ? $customersSummaryData['ResponseNotSubmitted'] :
            array();
    $surveyUnsubscribeCustomers = (isset($customersSummaryData['unsubscribeCustomers']) && !empty($customersSummaryData['unsubscribeCustomers'])) ? $customersSummaryData['unsubscribeCustomers'] : array();
    $alreadyOptOutCustomers = (isset($customersSummaryData['alreadyOptOut']) && !empty($customersSummaryData['alreadyOptOut'])) ? $customersSummaryData['alreadyOptOut'] : array();
    $allOptCustomers = array_merge($surveyUnsubscribeCustomers, $alreadyOptOutCustomers);
    if (!empty($customersPendingResponse['records'])) {
        $pending_res_record = "";
        foreach ($customersPendingResponse['records'] as $record_id => $pending_res) {
            if (empty($pending_res_record)) {
                $pending_res_record = $record_id;
            } else {
                $pending_res_record .= "," . $record_id;
            }
        }
    }
    if (!empty($allOptCustomers['records'])) {
        $opted_out_record = "";
        foreach ($allOptCustomers['records'] as $record_id => $opted_out) {
            if (empty($opted_out_record)) {
                $opted_out_record = $record_id;
            } else {
                $opted_out_record .= "," . $record_id;
            }
        }
    }
    $html = '';
    $html .= "<html>
             <head>
             </head>
             <body>
              <div class='main-t-survey'>
             ";
    // first section
    if (!empty($customersFirstTimeSuccSentArray) && $customersFirstTimeSuccSentArray > 0 && !$isSendNow) {
        $html .= "<table width='100%'>
                    <thead>
                    <tr class='title'>
                        <td colspan='3'><span>Your email will be delivered to <strong style='color: #008000'>{$customersFirstTimeSuccSentArray}</strong> {$surveySingularModule}(s) very soon.</td>
                    </tr>
                    </thead>
                  </table>";
    }

    // second section
    if (!empty($customersResponseSubmitted) && $customersResponseSubmitted > 0) {
        $html .= "<table width='100%'>
                    <thead>
                        <tr class='title'>
                            <td colspan='4'><span>Your email has been already delivered to <strong style='color: #008000'>{$customersResponseSubmitted}</strong> {$surveySingularModule}(s) and also received their response.</span></td>
                        </tr>
                    </thead>
                 </table>";
    }

    // third section
    if (!empty($customersPendingResponse['count']) && $customersPendingResponse['count'] > 0) {
        $html .= "<table width='100%'>
                    <thead>
                        <tr class='title'>
                            <td colspan='4'><span> Survey Sent to  <strong style='color: #008000'>{$customersPendingResponse['count']}</strong> {$surveySingularModule}(s) , Pending Response.
                            <strong>
                               <input class='btn btn-primary' type='button' name='ViewPendingRes'  value='View' data-survey-id='{$survey_id}' data-survey-module='{$module_name}' data-pending-response-record='{$pending_res_record}' >
                           </strong>
                           </span>
                           </td>
                        </tr>
                      </thead>
                 </table>";
    }

    // fourth section
    if (!empty($allOptCustomers['count']) && $allOptCustomers['count'] > 0) {
        $url = '#bc_survey/' . $survey_id . '/layout/survey_sent_summary_view/opted_out';
        $html .= "<table width='100%'><thead><tr class='title'>
                   <td colspan='3'><span>Your email will not be send to <strong style='color: #008000'>{$allOptCustomers['count']}</strong> {$surveySingularModule}(s) due to opted-out email-address.</span>
                       <strong>
                                 <input class='btn btn-primary' type='button' name='ViewOptedOutRes' value='View' data-survey-id='{$survey_id}' data-survey-module='{$module_name}' data-opted-out-record='{$opted_out_record}' onclick='' >
                       </strong>
                   </td>
               </tr></thead>
             </table>";
    }

    // fourth section
    if ($isSendNow && $isSendSuccess == 'send') {
        $html .= "<table width='100%'><thead><tr class='title'>
                   <td colspan='3'><span>Your email successfully delievered to <strong style='color: #008000'>{$record_name}</strong>.</span> 
                   </td>
               </tr></thead>
             </table>";
    } else if ($isSendNow && !empty($isSendSuccess)) {
        $html .= "<table width='100%'><thead><tr class='title'>
                   <td colspan='3'><span style='color :red;'>{$isSendSuccess}</strong> Please contact Administrator.</span> 
                   </td>
               </tr></thead>
             </table>";
    }

    // for display button
    if (!$isDetailView) {
        $html .= "<table width='100%'><thead><tr><td style='background-color: #0b578f;font-size: 14px;color: #ffffff;width: 40%;text-align: center'>Total {$total_seleted_records} {$surveySingularModule}(s) selected</td></tr><thead></table>";
    }
    $html .= "</div>
             <style type='text/css'>
             .main-t-survey{max-height:350px; }
             .main-t-survey table{border: 1px solid #DDD; padding:10px; margin:0px 0px 10px 0px;}
             .main-t-survey tr.title{background: #F7F7F7; border-top: 1px solid #DDD; border-bottom: 1px solid #DDD;}
             .main-t-survey tr{background: #fff; border-top: 1px solid #DDD; border-bottom: 1px solid #DDD;}
             .main-t-survey tr td, .main-t-survey tr th{color: #23527C; padding:8px; text-align:left;width: auto;float: none;}
             .dialog_style .ui-dialog-titlebar{ background: #FFF none repeat scroll 0% 0%; color: #565656;  border: medium none;}
             </style>";
    $html .= "</body>
             </html>";
    return $html;
}

/**
 * get opted out email customers
 *
 * @author     Biztech Consultancy
 * @param      string - $moduleID
 * @param      string - $module_name
 * @return     array
 */
function getOptOutEmailCustomers($moduleID = '', $moduleName = '') {
    require_once 'include/SugarEmailAddress/SugarEmailAddress.php';
    $SugarEmailAddress = new SugarEmailAddress();
    global $db;
    switch ($moduleName) {
        case "Accounts":
            $focus = new Account();
            break;
        case "Contacts":
            $focus = new Contact();
            break;
        case "Leads":
            $focus = new Lead();
            break;
        case "Prospects":
            $focus = new Prospect();
            break;
    }
    $focus->retrieve($moduleID);
    $survey_reciever = $focus->name;
    $email = $focus->email1;

    // retrieve email address detail
    $emailAddressDetail = $SugarEmailAddress->getAddressesByGUID($moduleID, $moduleName);
    $optOutEmailDetails = array();

    foreach ($emailAddressDetail as $emailAddQryRes) {
        $optOutEmailDetails['email_add'] = $emailAddQryRes['email_address'];
        $optOutEmailDetails['email_add_id'] = $emailAddQryRes['email_address_id'];
        $optOutEmailDetails['email_optOut'] = $emailAddQryRes['opt_out'];
        $optOutEmailDetails['beanID'] = $emailAddQryRes['bean_id'];
    }
    return $optOutEmailDetails;
}

/**
 * get email template by survey id
 *
 * @author     Biztech Consultancy
 * @param      string - $surveyID
 * @param      string - $surveyModule
 * @return     array
 */
function getEmailTemplateBySurveyID($surveyID = '') {
    global $db;
    $oEmailTemplate = BeanFactory::getBean('EmailTemplates');
    $oEmailTemplate->retrieve_by_string_fields(array('survey_id' => $surveyID));
    $emailTempId = $oEmailTemplate->id;

    $emailTemplateID = (!empty($emailTempId)) ? $emailTempId : '';
    return $emailTemplateID;
}

/**
 * submit survey response calculation
 *
 * @author     Biztech Consultancy
 * @param      string - $submit_survey_answerID
 * @param      string - $sent_surveyID
 * @param      string - $survey_receiverID
 * @param      string - $answerType
 * @param      string - $submisstion_id
 * @param      string - $delete_flag
 * @param      string - $submitted_que
 */
function submitSurveyResponseCalulation($submit_survey_answerID, $sent_surveyID = '', $survey_receiverID = '', $answerType = '', $submisstion_id = '', $delete_flag = '', $submitted_que = '', $isNotAttempt = '', $forcedelete = 0) {
    global $db;
    //check resubmission or not if resubmission then delete old data
    $oSubmission = BeanFactory::getBean('bc_survey_submission');
    $oSubmission->retrieve($submisstion_id);
    $answersData = '';
    $resubmit_status = $oSubmission->resubmit;

    $submit_survey_answerIDInq = (is_array($submit_survey_answerID)) ? implode("','", $submit_survey_answerID) : '';
    $submit_survey_answerID = (is_array($submit_survey_answerID)) ? $submit_survey_answerID : array();
    if (($resubmit_status == '1' || $forcedelete == 1) && $delete_flag == 0) {
        //remove old data
        $rm_old_qry = "delete from bc_survey_submit_answer_calculation WHERE sent_survey_id = '{$sent_surveyID}'
                                  and   survey_receiver_id = '{$survey_receiverID}'
                                      and answer_type = '{$answerType}' and question_id = '{$submitted_que}' and submission_id = '{$submisstion_id}'";
        $db->query($rm_old_qry);
    }
    if ($isNotAttempt == 0) {
        // first get if we submitted answer exists
        $answerTypeArray = array('image', 'video');
        if (!in_array($answerType, $answerTypeArray)) {
            if ($db->dbType == "mssql") {
                $check_if_answer_AlreadySubmit = "Select 
                                          id,
                                          answer_type as AnswerType,
                                          submit_answer_id as SubmitAns 
                                      from bc_survey_submit_answer_calculation
                                      where CONVERT(VARCHAR ,sent_survey_id) = '{$sent_surveyID}'
                                      and   CONVERT(VARCHAR ,survey_receiver_id) = '{$survey_receiverID}'
                                      and CONVERT(VARCHAR ,submit_answer_id) in ('{$submit_survey_answerIDInq}')
                                      and CONVERT(VARCHAR ,submission_id) in ('{$submisstion_id}')
                                      and CONVERT(VARCHAR ,question_id) in ('{$submitted_que}')";
            } else {
                $check_if_answer_AlreadySubmit = "Select 
                                          id,
                                          answer_type as AnswerType,
                                          submit_answer_id as SubmitAns 
                                      from bc_survey_submit_answer_calculation
                                      where sent_survey_id = '{$sent_surveyID}'
                                      and   survey_receiver_id = '{$survey_receiverID}'
                                      and submit_answer_id in ('{$submit_survey_answerIDInq}')
                                      and submission_id = '{$submisstion_id}' and question_id = '{$submitted_que}'";
            }
            $runQuery = $db->query($check_if_answer_AlreadySubmit);
            $count_num_rows = 0;
            while ($existAns = $db->fetchbyAssoc($runQuery)) {
                $count_num_rows++;
            }
            if ($count_num_rows != 0) {
                $existAns = $db->fetchbyAssoc($runQuery);
                if ($answerType == 'matrix') {
                    if (is_array($submit_survey_answerID)) {
                        $answersData = '';
                        foreach ($submit_survey_answerID as $k1 => $data) {
                            foreach ($data as $k => $ans) {
                                $answersData .= $ans . ',';
                            }
                        }
                    }
                } else if ($answerType == 'contact-information') {
                    $contactInfo = count(array_count_values($submit_survey_answerID[$submitted_que]));
                    if ($contactInfo <= 1) {
                        $answersData = '';
                } else {
                          $submittedAnsContactArr = array();
                        foreach ($submit_survey_answerID[$submitted_que] as $name => $val) {
                            $submittedAnsContactArr[$submitted_que][$name] = html_entity_decode($val);
                    }
                        $answersData = json_encode($submittedAnsContactArr, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
                       
                    }
                } else {
                    $answersData = implode(',', $submit_survey_answerID);
                }
                if (in_array('selection_default_value_dropdown', $submit_survey_answerID)) {
                    $answersData = '';
                }
                $answersData = addslashes($answersData);
                $db->query(" Update bc_survey_submit_answer_calculation
                       set submit_answer_id = '{$answersData}'
                           where sent_survey_id = '{$sent_surveyID}'
                                  and   survey_receiver_id = '{$survey_receiverID}'
                                      and answer_type = '{$answerType}' 
                                          and question_id = '{$submitted_que}' 
                                              and submission_id = '{$submisstion_id}'
                ");
            } else {
                $id = create_guid();
                if ($answerType == 'matrix') {
                    if (is_array($submit_survey_answerID)) {
                        $answersData = '';
                        foreach ($submit_survey_answerID as $k1 => $data) {
                            foreach ($data as $k => $ans) {
                                $answersData .= $ans . ',';
                            }
                        }
                    }
                } else if ($answerType == 'contact-information') {
                    $contactInfo = count(array_count_values($submit_survey_answerID[$submitted_que]));
                    if ($contactInfo <= 1) {
                        $answersData = '';
                } else {
                        $submittedAnsContactArr = array();
                        foreach ($submit_survey_answerID[$submitted_que] as $name => $val) {
                            $submittedAnsContactArr[$submitted_que][$name] = html_entity_decode($val);
                    }
                        $answersData = json_encode($submittedAnsContactArr, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
                    }
                } else {
                    $answersData = implode(',', $submit_survey_answerID);
                }
                if (in_array('selection_default_value_dropdown', $submit_survey_answerID)) {
                    $answersData = '';
                }
                $answersData = addslashes($answersData);
                if ($db->dbType == "mssql") {
                    $db->query(" Insert into bc_survey_submit_answer_calculation
                         (id,answer_type,submit_answer_id,sent_survey_id,survey_receiver_id,question_id, submission_id)
                         Values ('{$id}','{$answerType}','{$answersData}','{$sent_surveyID}','{$survey_receiverID}','{$submitted_que}','{$submisstion_id}')
                ");
                } else {
                $db->query(' Insert into bc_survey_submit_answer_calculation
                         (id,answer_type,submit_answer_id,sent_survey_id,survey_receiver_id,question_id, submission_id)
                         Values ("' . $id . '","' . $answerType . '","' . $answersData . '","' . $sent_surveyID . '","' . $survey_receiverID . '","' . $submitted_que . '","' . $submisstion_id . '")
                ');
            }
        }
    }
}
}

/**
 * get answer submission count for all
 *
 * @author     Biztech Consultancy
 * @param      string - $surveyID
 * @return array
 */
function getAnswerSubmissionCount($surveyID = '', $status_type = '', $global_filter = array(), $GF_QueLogic_Passed_Submissions = array(), $que_id = '') {
    global $db;
    $submissionTypeArray = array();
    switch ($status_type) {
        case 'openended':
            $submissionTypeArray = array('Open Ended');
            break;
        case 'email':
            $submissionTypeArray = array('Email');
            break;
        case 'combined':
            $submissionTypeArray = array('Email', 'Open Ended');
            break;
    }
    $submissionTypeImplodeVal = implode("','", $submissionTypeArray);
    $GF_QueLogic_Passed_SubmissionsImplode = implode("','", $GF_QueLogic_Passed_Submissions);
    if ($db->dbType == "mssql") {
    $whereCond = " NOT CONVERT(NVARCHAR(MAX), bc_survey_submit_answer_calculation.submit_answer_id) = '' ";
    $selectEachAnswerSubCount = "SELECT 
                                bc_survey_submit_answer_calculation.survey_receiver_id AS recId,
                                bc_survey_submit_answer_calculation.question_id AS queId,
                                bc_survey_submit_answer_calculation.submit_answer_id AS ansSubmitCount,
                                bc_survey_submit_answer_calculation.answer_type AS ans_type,
                                bc_survey_submit_answer_calculation.submission_id AS sub_id,
                                bc_survey_submission.submission_date
                            FROM
                                bc_survey_submit_answer_calculation
                                left join bc_survey_submission on bc_survey_submission.id = bc_survey_submit_answer_calculation.submission_id
                                and bc_survey_submission.deleted = 0
                            WHERE
                                bc_survey_submit_answer_calculation.sent_survey_id = '{$surveyID}'
                                and bc_survey_submit_answer_calculation.question_id = '{$que_id}'
                                and bc_survey_submission.submission_type in ('{$submissionTypeImplodeVal}')
                                    and {$whereCond} 
                                     and bc_survey_submission.id in ('{$GF_QueLogic_Passed_SubmissionsImplode}')
                                and bc_survey_submit_answer_calculation.answer_type not in ('commentbox', 'textbox', 'contact-information', 'date-time')
    ";
    }else{
      $selectEachAnswerSubCount = "SELECT 
                                bc_survey_submit_answer_calculation.survey_receiver_id AS recId,
                                bc_survey_submit_answer_calculation.question_id AS queId,
                                bc_survey_submit_answer_calculation.submit_answer_id AS ansSubmitCount,
                                bc_survey_submit_answer_calculation.answer_type AS ans_type,
                                bc_survey_submit_answer_calculation.submission_id AS sub_id,
                                bc_survey_submission.submission_date
                            FROM
                                bc_survey_submit_answer_calculation
                                left join bc_survey_submission on bc_survey_submission.id = bc_survey_submit_answer_calculation.submission_id
                                and bc_survey_submission.deleted = 0
                            WHERE
                                bc_survey_submit_answer_calculation.sent_survey_id = '{$surveyID}'
                                and bc_survey_submit_answer_calculation.question_id = '{$que_id}'
                                and bc_survey_submission.submission_type in ('{$submissionTypeImplodeVal}')
                                    and bc_survey_submit_answer_calculation.submit_answer_id != ''
                                     and bc_survey_submission.id in ('{$GF_QueLogic_Passed_SubmissionsImplode}')
                                and bc_survey_submit_answer_calculation.answer_type not in ('commentbox', 'textbox', 'contact-information', 'date-time')
    ";
    }
    $runQuery = $db->query($selectEachAnswerSubCount);
    $submit_answer_Array = array();
    $is_matrix = false;
    $matri_all_count_array = array();
    $countEachAns = array();
    $scale_answer_Array = array();
    $scale_Count = array();
    while ($resultCountData = $db->fetchByAssoc($runQuery)) {
                if (($status_type == 'openended' && str_split($resultCountData['recId'], 8)[0] == 'Web Link') || ($status_type == 'email' && str_split($resultCountData['recId'], 8)[0] != 'Web Link') || ($status_type == 'combined' || $status_type == '')) {
                    $explodeData = explode(',', $resultCountData['ansSubmitCount']);
                    if ($resultCountData['ans_type'] == 'matrix') {
                        $qid = $resultCountData['queId'];
                        $is_matrix = true;
                        if (is_array($explodeData)) {
                            foreach ($explodeData as $ansID) {
                                if (!empty($ansID)) {
                                    $matrix = explode('_', $ansID);

                                    $count = (isset($matri_all_count_array[$qid][$matrix[0]][$matrix[1]])) ? $matri_all_count_array[$qid][$matrix[0]][$matrix[1]] : 0;
                                    $count++;
                                    $matri_all_count_array[$qid][$matrix[0]][$matrix[1]] = $count;
                                }
                            }
                            $countEachAns['matrix'] = $matri_all_count_array;
                        }
                    }

                    if ($resultCountData['ans_type'] == 'scale') {
                        $qid = $resultCountData['queId'];
                        $scalecount = 0;
                        foreach ($explodeData as $k => $data) {
                            if ($data != '') {
                                $scale_answer_Array[$qid][] = $data;
                                $scalecount++;
                                $countEachAns['scale'][$qid] = (!isset($countEachAns['scale'][$qid])) ? 1 : $countEachAns['scale'][$qid] + 1;
                            }
                        }
                        $scale_Count[$qid] = array_count_values($scale_answer_Array[$qid]);
                    }
                    if ($resultCountData['ans_type'] != 'scale') {
                    if (is_array($explodeData)) {
                            $submit_answer_Array = array_merge($submit_answer_Array, $explodeData);
                    } else {
                        $submit_answer_Array[] = $explodeData;
                    }
                }
            }
        }
    $GLOBALS['log']->fatal('This is the result : $countEachAns for scale', print_r($countEachAns, 1));
    $countEachAnsData = array();
    $countEachAnsData = array_count_values($submit_answer_Array);
    $countEachAnsData = $countEachAnsData + $countEachAns + $scale_Count;
    return $countEachAnsData;
}

function getTrendQuestionWiseSubmissionData($surveyID, $submission_type, $accessbileSubmissionIds = array()) {
    global $db;
    $submissionTypeArray = array();
    switch ($submission_type) {
        case 'openended':
            $submissionTypeArray = array('Open Ended');
            break;
        case 'email':
            $submissionTypeArray = array('Email');
            break;
        case 'combined':
            $submissionTypeArray = array('Email', 'Open Ended');
            break;
    }
    $submissionTypeImplodeVal = implode("','", $submissionTypeArray);
    $submittedDataArrayQuestion = array();
    $trendDataQuestionReportArray = array();
    $trendDataQuestionChartReportArray = array();
    $nowDate = TimeDate::getInstance()->nowDbDate();
    $dateField = " DATE(ss.submission_date) ";
    $whereCond = " subData.submit_answer_id != '' ";
    $groupByMssql = '';
    $ansIDCol = ' subData.submit_answer_id ';
    if ($db->dbType == "mssql") {
        $dateField = " CONVERT(VARCHAR(10), ss.submission_date, 120) ";
        $whereCond = " NOT CONVERT(NVARCHAR(MAX), subData.submit_answer_id) = '' ";
        $ansIDCol = ' CONVERT(NVARCHAR(MAX), subData.submit_answer_id) ';
        $groupByMssql = ',ss.id, subData.submit_answer_id '; // MSSQL support bugfix
    }
    $q = "SELECT 
                CASE
                            WHEN {$ansIDCol} = '' THEN 0
                            ELSE COUNT(*)
                        END AS subCount, 
                {$dateField} AS submissionDate,
                subData.question_id AS queId,
                ss.id as submissionID
            FROM
                bc_survey_submit_answer_calculation AS subData
                    LEFT JOIN
                bc_survey_submission AS ss ON ss.id = subData.submission_id
                    AND ss.deleted = 0
            WHERE
                subData.sent_survey_id = '{$surveyID}'
                and {$dateField} <= '{$nowDate}'
                and ss.submission_type in ('{$submissionTypeImplodeVal}')
                     and ss.status = 'Submitted'
            GROUP BY ss.submission_date, subData.question_id {$groupByMssql}
            ORDER BY ss.submission_date";
    $runQ = $db->query($q);
    while ($data = $db->fetchByAssoc($runQ)) {
        if (in_array($data['submissionID'], $accessbileSubmissionIds)) {
        $submittedDataArrayQuestion[$data['queId']][$data['submissionDate']][] = $data['subCount'];
    }
    }
    $returnDataArray = array();

    if (!empty($submittedDataArrayQuestion)) {
        foreach ($submittedDataArrayQuestion as $qID => $submittedDataArray) {
            $trendDataQuestionReportArray['by_day'] = array();
            $trendDataQuestionReportArray['by_week'] = array();
            $trendDataQuestionReportArray['by_month'] = array();
            $trendDataQuestionReportArray['by_year'] = array();
            $trendDataQuestionChartReportArray['by_day'][] = array('Range', 'Response Count');
            $trendDataQuestionChartReportArray['by_week'][] = array('Range', 'Response Count');
            $trendDataQuestionChartReportArray['by_month'][] = array('Range', 'Response Count');
            $trendDataQuestionChartReportArray['by_year'][] = array('Range', 'Response Count');
            $submission_Firstdate = min(array_keys($submittedDataArray));
            $submission_FirstdateTimestamp = strtotime($submission_Firstdate);
            $nowDateTimestamp = strtotime($nowDate);
            $datetime1 = new DateTime("@$submission_FirstdateTimestamp");
            $datetime2 = new DateTime("@$nowDateTimestamp");
            $interval = $datetime1->diff($datetime2);
            $datesRange = getDate_range($submission_Firstdate, $nowDate, '+1 day', 'Y-m-d');
            $datesRange = array_flip($datesRange);
            $weekExtendDate = date('Y-m-d', strtotime($submission_Firstdate . '+6 days'));
            $datesRangeWeek = getDate_range($submission_Firstdate, $weekExtendDate, '+1 day', 'Y-m-d');
            $datesRangeWeek = array_flip($datesRangeWeek);
            $returnData = array();
            $monthDataArray = array();
            $yearDataArray = array();
            $defaultLoadVal = 'by_day';
            if ($interval->days > 7 && $interval->days < 31) {
                $defaultLoadVal = 'by_week';
            } else if (($interval->days > 31 || $interval->days > 30) && $interval->days < 365) {
                $defaultLoadVal = 'by_month';
            } else if ($interval->days > 365) {
                $defaultLoadVal = 'by_year';
            }
            foreach ($datesRange as $date => $key) {
                $year = date('Y', strtotime($date));
                $month = date('M', strtotime($date));
                $responsecount = (!empty($submittedDataArray[$date])) ? array_sum($submittedDataArray[$date]) : 0;
                $returnData[$date] = $responsecount;
                $monthDataArray[$year][$month][] = $responsecount;
                $yearDataArray[$year][] = $responsecount;
            }
            $totalSubmissionCount = array_sum($returnData);
            $weekCount = 1;
            $weekResponseCountArr = array();
            $lastKeyArr = (!empty(array_keys($returnData))) ? array_keys($returnData) : array();
            $lastKey = end($lastKeyArr);
            foreach ($returnData as $date => $responsecount) {
                $percent = (($responsecount / $totalSubmissionCount) * 100);
                $dateValDate = date('d', strtotime($date));
                $dateValMonth = date('M', strtotime($date));
                $dateValYear = date('Y', strtotime($date));
                $value = $dateValMonth . ' ' . $dateValDate . ' ' . $dateValYear;
                $trendDataQuestionReportArray['by_day'][$value]['value'] = $value;
                $trendDataQuestionReportArray['by_day'][$value]['percent'] = number_format($percent, 2);
                $trendDataQuestionReportArray['by_day'][$value]['count'] = $responsecount;
                $trendDataQuestionChartReportArray['by_day'][] = array((string) $value, $responsecount);

                if ($interval->days > 7) {
                    if ($weekCount == 1) {
                        $startWeekDate = $date;
                    }
                    $weekResponseCountArr[] = $responsecount;
                    if ($weekCount >= 7 || $date == $lastKey) {
                        $endWeekDate = $date;
                        $weekRsCount = array_sum($weekResponseCountArr);
                        $weekpercent = (($weekRsCount / $totalSubmissionCount) * 100);
                        $startdateValDate = date('d', strtotime($startWeekDate));
                        $startdateValMonth = date('M', strtotime($startWeekDate));
                        $startdateValYear = date('Y', strtotime($startWeekDate));
                        $startWeekvalue = $startdateValMonth . ' ' . $startdateValDate . ' ' . $startdateValYear;
                        $enddateValDate = date('d', strtotime($endWeekDate));
                        $enddateValMonth = date('M', strtotime($endWeekDate));
                        $enddateValYear = date('Y', strtotime($endWeekDate));
                        $endWeekvalue = $enddateValMonth . ' ' . $enddateValDate . ' ' . $enddateValYear;
                        $value = $startWeekvalue . ' - ' . $endWeekvalue;
                        $trendDataQuestionReportArray['by_week'][$value]['value'] = $value;
                        $trendDataQuestionReportArray['by_week'][$value]['percent'] = number_format($weekpercent, 2);
                        $trendDataQuestionReportArray['by_week'][$value]['count'] = $weekRsCount;
                        $trendDataQuestionChartReportArray['by_week'][] = array((string) $value, $weekRsCount);
                        $weekCount = 0;
                        unset($weekResponseCountArr);
                    }
                    $weekCount++;
                }
            }
            foreach ($monthDataArray as $yearVal => $monthData) {
                foreach ($monthData as $m => $mCountArr) {
                    $value = $m . ' ' . $yearVal;
                    $monthRsCount = array_sum($mCountArr);
                    $monthpercent = (($monthRsCount / $totalSubmissionCount) * 100);
                    $trendDataQuestionReportArray['by_month'][$value]['value'] = $value;
                    $trendDataQuestionReportArray['by_month'][$value]['percent'] = number_format($monthpercent, 2);
                    $trendDataQuestionReportArray['by_month'][$value]['count'] = $monthRsCount;
                    $trendDataQuestionChartReportArray['by_month'][] = array((string) $value, $monthRsCount);
                }
            }
            foreach ($yearDataArray as $yearVal => $yearData) {
                $value = $yearVal;
                $yearRsCount = array_sum($yearData);
                $yearpercent = (($yearRsCount / $totalSubmissionCount) * 100);
                $trendDataQuestionReportArray['by_year'][$value]['value'] = $value;
                $trendDataQuestionReportArray['by_year'][$value]['percent'] = number_format($yearpercent, 2);
                $trendDataQuestionReportArray['by_year'][$value]['count'] = $yearRsCount;
                $trendDataQuestionChartReportArray['by_year'][] = array((string) $value, $yearRsCount);
            }
            if (empty($trendDataQuestionReportArray['by_week'])) {
                $lastKeyArr = (!empty(array_keys($datesRangeWeek))) ? array_keys($datesRangeWeek) : array();
                $lastKey = end($lastKeyArr);
                foreach ($datesRangeWeek as $date => $respon) {
                    if ($weekCount == 1) {
                        $startWeekDate = $date;
                    }
                    $weekResponseCountArr[] = (isset($returnData[$date])) ? $returnData[$date] : '';
                    if ($weekCount >= 7 || $date == $lastKey) {
                        $endWeekDate = $date;
                        $weekRsCount = array_sum($weekResponseCountArr);
                        $weekpercent = (($weekRsCount / $totalSubmissionCount) * 100);
                        $startdateValDate = date('d', strtotime($startWeekDate));
                        $startdateValMonth = date('M', strtotime($startWeekDate));
                        $startdateValYear = date('Y', strtotime($startWeekDate));
                        $startWeekvalue = $startdateValMonth . ' ' . $startdateValDate . ' ' . $startdateValYear;
                        $enddateValDate = date('d', strtotime($endWeekDate));
                        $enddateValMonth = date('M', strtotime($endWeekDate));
                        $enddateValYear = date('Y', strtotime($endWeekDate));
                        $endWeekvalue = $enddateValMonth . ' ' . $enddateValDate . ' ' . $enddateValYear;
                        $value = $startWeekvalue . ' - ' . $endWeekvalue;
                        $trendDataQuestionReportArray['by_week'][$value]['value'] = $value;
                        $trendDataQuestionReportArray['by_week'][$value]['percent'] = number_format($weekpercent, 2);
                        $trendDataQuestionReportArray['by_week'][$value]['count'] = $weekRsCount;
                        $trendDataQuestionChartReportArray['by_week'][] = array((string) $value, $weekRsCount);
                        $weekCount = 0;
                        unset($weekResponseCountArr);
                    }
                    $weekCount++;
                }
            }
            $returnDataArray[$qID]['defaultLoadVal'] = $defaultLoadVal;
            $returnDataArray[$qID]['trendQuestionChartData'] = $trendDataQuestionChartReportArray;
            $returnDataArray[$qID]['trendQuestiontableData'] = $trendDataQuestionReportArray;
            unset($trendDataQuestionReportArray);
            unset($trendDataQuestionChartReportArray);
        }
    }
    if (empty($returnDataArray)) {
        $returnDataArray['defaultLoadVal'] = '';
        $returnDataArray['trendQuestionChartData'] = array();
        $returnDataArray['trendQuestiontableData'] = array();
    }
    return $returnDataArray;
}

/*
 * Get Trend Report Data For Status Wise Report.
 */

function getTrendWiseSubmissionData($surveyID, $submission_type, $accessbileSubmissionIds = array()) {
    global $db;
    $submissionTypeArray = array();
    switch ($submission_type) {
        case 'openended':
            $submissionTypeArray = array('Open Ended');
            break;
        case 'email':
            $submissionTypeArray = array('Email');
            break;
        case 'combined':
            $submissionTypeArray = array('Email', 'Open Ended');
            break;
    }
    $submissionTypeImplodeVal = implode("','", $submissionTypeArray);
    $submittedDataArray = array();
    $monthDataArray = array();
    $yearDataArray = array();
    $trendDataStatusReportArray = array();
    $trendDataStatusChartReportArray = array();
    $nowDate = TimeDate::getInstance()->nowDbDate();
    $dateField = " DATE(subData.submission_date) ";
    $defaultLoadVal = '';
    $groupByMssql = '';
    if ($db->dbType == "mssql") {
        $dateField = " CONVERT(VARCHAR(10), subData.submission_date, 120) ";
        $groupByMssql = ",subData.id ";
    }
    $q = "SELECT
                COUNT(*) AS subCount,
                {$dateField}  AS submissionDate,
                subData.id as submissionID
              FROM
                bc_survey_submission AS subData
              LEFT JOIN
                bc_survey_submission_bc_survey_c AS ss ON ss.bc_survey_submission_bc_surveybc_survey_submission_idb = subData.id 
                AND ss.deleted = 0
              WHERE
                ss.bc_survey_submission_bc_surveybc_survey_ida = '{$surveyID}'
                and {$dateField} <= '{$nowDate}'
                and subData.submission_type in ('{$submissionTypeImplodeVal}')
            GROUP BY subData.submission_date {$groupByMssql}
            ORDER BY subData.submission_date";
    $runQ = $db->query($q);
    while ($data = $db->fetchByAssoc($runQ)) {
        if (in_array($data['submissionID'], $accessbileSubmissionIds)) {
        $submittedDataArray[$data['submissionDate']][] = $data['subCount'];
    }
    }
    $trendDataStatusReportArray['by_day'] = array();
    $trendDataStatusReportArray['by_week'] = array();
    $trendDataStatusReportArray['by_month'] = array();
    $trendDataStatusReportArray['by_year'] = array();
    $trendDataStatusChartReportArray['by_day'][] = array('Range', 'Response Count');
    $trendDataStatusChartReportArray['by_week'][] = array('Range', 'Response Count');
    $trendDataStatusChartReportArray['by_month'][] = array('Range', 'Response Count');
    $trendDataStatusChartReportArray['by_year'][] = array('Range', 'Response Count');
    if (!empty($submittedDataArray)) {
        $submission_Firstdate = min(array_keys($submittedDataArray));
        $submission_FirstdateTimestamp = strtotime($submission_Firstdate);
        $nowDateTimestamp = strtotime($nowDate);
        $datetime1 = new DateTime("@$submission_FirstdateTimestamp");
        $datetime2 = new DateTime("@$nowDateTimestamp");
        $interval = $datetime1->diff($datetime2);
        $datesRange = getDate_range($submission_Firstdate, $nowDate, '+1 day', 'Y-m-d');
        $datesRange = array_flip($datesRange);
        $weekExtendDate = date('Y-m-d', strtotime($submission_Firstdate . '+6 days'));
        $datesRangeWeek = getDate_range($submission_Firstdate, $weekExtendDate, '+1 day', 'Y-m-d');
        $datesRangeWeek = array_flip($datesRangeWeek);
        $returnData = array();
        $defaultLoadVal = 'by_day';
        if ($interval->days > 7 && $interval->days < 31) {
            $defaultLoadVal = 'by_week';
        } else if (($interval->days > 31 || $interval->days > 30) && $interval->days < 365) {
            $defaultLoadVal = 'by_month';
        } else if ($interval->days > 365) {
            $defaultLoadVal = 'by_year';
        }
        foreach ($datesRange as $date => $key) {
            $year = date('Y', strtotime($date));
            $month = date('M', strtotime($date));
            $responsecount = (!empty($submittedDataArray[$date])) ? array_sum($submittedDataArray[$date]) : 0;
            $returnData[$date] = $responsecount;
            $monthDataArray[$year][$month][] = $responsecount;
            $yearDataArray[$year][] = $responsecount;
        }
        $totalSubmissionCount = array_sum($returnData);
        $weekCount = 1;
        $weekResponseCountArr = array();
        $lastKeyArr = (!empty(array_keys($returnData))) ? array_keys($returnData) : array();
        $lastKey = end($lastKeyArr);
        foreach ($returnData as $date => $responsecount) {
            $percent = (($responsecount / $totalSubmissionCount) * 100);
            $dateValDate = date('d', strtotime($date));
            $dateValMonth = date('M', strtotime($date));
            $dateValYear = date('Y', strtotime($date));
            $value = $dateValMonth . ' ' . $dateValDate . ' ' . $dateValYear;
            $trendDataStatusReportArray['by_day'][$value]['value'] = $value;
            $trendDataStatusReportArray['by_day'][$value]['percent'] = number_format($percent, 2);
            $trendDataStatusReportArray['by_day'][$value]['count'] = $responsecount;
            $trendDataStatusChartReportArray['by_day'][] = array((string) $value, $responsecount);

            if ($interval->days > 7) {
                if ($weekCount == 1) {
                    $startWeekDate = $date;
                }
                $weekResponseCountArr[] = $responsecount;
                if ($weekCount >= 7 || $date == $lastKey) {
                    $endWeekDate = $date;
                    $weekRsCount = array_sum($weekResponseCountArr);
                    $weekpercent = (($weekRsCount / $totalSubmissionCount) * 100);
                    $startdateValDate = date('d', strtotime($startWeekDate));
                    $startdateValMonth = date('M', strtotime($startWeekDate));
                    $startdateValYear = date('Y', strtotime($startWeekDate));
                    $startWeekvalue = $startdateValMonth . ' ' . $startdateValDate . ' ' . $startdateValYear;
                    $enddateValDate = date('d', strtotime($endWeekDate));
                    $enddateValMonth = date('M', strtotime($endWeekDate));
                    $enddateValYear = date('Y', strtotime($endWeekDate));
                    $endWeekvalue = $enddateValMonth . ' ' . $enddateValDate . ' ' . $enddateValYear;
                    $value = $startWeekvalue . ' - ' . $endWeekvalue;
                    $trendDataStatusReportArray['by_week'][$value]['value'] = $value;
                    $trendDataStatusReportArray['by_week'][$value]['percent'] = number_format($weekpercent, 2);
                    $trendDataStatusReportArray['by_week'][$value]['count'] = $weekRsCount;
                    $trendDataStatusChartReportArray['by_week'][] = array((string) $value, $weekRsCount);
                    $weekCount = 0;
                    unset($weekResponseCountArr);
                }
                $weekCount++;
            }
        }
        foreach ($monthDataArray as $yearVal => $monthData) {
            foreach ($monthData as $m => $mCountArr) {
                $value = $m . ' ' . $yearVal;
                $monthRsCount = array_sum($mCountArr);
                $monthpercent = (($monthRsCount / $totalSubmissionCount) * 100);
                $trendDataStatusReportArray['by_month'][$value]['value'] = $value;
                $trendDataStatusReportArray['by_month'][$value]['percent'] = number_format($monthpercent, 2);
                $trendDataStatusReportArray['by_month'][$value]['count'] = $monthRsCount;
                $trendDataStatusChartReportArray['by_month'][] = array((string) $value, $monthRsCount);
            }
        }
        foreach ($yearDataArray as $yearVal => $yearData) {
            $value = $yearVal;
            $yearRsCount = array_sum($yearData);
            $yearpercent = (($yearRsCount / $totalSubmissionCount) * 100);
            $trendDataStatusReportArray['by_year'][$value]['value'] = $value;
            $trendDataStatusReportArray['by_year'][$value]['percent'] = number_format($yearpercent, 2);
            $trendDataStatusReportArray['by_year'][$value]['count'] = $yearRsCount;
            $trendDataStatusChartReportArray['by_year'][] = array((string) $value, $yearRsCount);
        }
        if (empty($trendDataStatusReportArray['by_week'])) {
            $lastKeyArr = (!empty(array_keys($datesRangeWeek))) ? array_keys($datesRangeWeek) : array();
            $lastKey = end($lastKeyArr);
            foreach ($datesRangeWeek as $date => $respon) {
                if ($weekCount == 1) {
                    $startWeekDate = $date;
                }
                $weekResponseCountArr[] = (isset($returnData[$date])) ? $returnData[$date] : '';
                if ($weekCount >= 7 || $date == $lastKey) {
                    $endWeekDate = $date;
                    $weekRsCount = array_sum($weekResponseCountArr);
                    $weekpercent = (($weekRsCount / $totalSubmissionCount) * 100);
                    $startdateValDate = date('d', strtotime($startWeekDate));
                    $startdateValMonth = date('M', strtotime($startWeekDate));
                    $startdateValYear = date('Y', strtotime($startWeekDate));
                    $startWeekvalue = $startdateValMonth . ' ' . $startdateValDate . ' ' . $startdateValYear;
                    $enddateValDate = date('d', strtotime($endWeekDate));
                    $enddateValMonth = date('M', strtotime($endWeekDate));
                    $enddateValYear = date('Y', strtotime($endWeekDate));
                    $endWeekvalue = $enddateValMonth . ' ' . $enddateValDate . ' ' . $enddateValYear;
                    $value = $startWeekvalue . ' - ' . $endWeekvalue;
                    $trendDataStatusReportArray['by_week'][$value]['value'] = $value;
                    $trendDataStatusReportArray['by_week'][$value]['percent'] = number_format($weekpercent, 2);
                    $trendDataStatusReportArray['by_week'][$value]['count'] = $weekRsCount;
                    $trendDataStatusChartReportArray['by_week'][] = array((string) $value, $weekRsCount);
                    $weekCount = 0;
                    unset($weekResponseCountArr);
                }
                $weekCount++;
            }
        }
    }
    $trendDataStatusReportArray['defaultLoadVal'] = $defaultLoadVal;
    $trendDataStatusReportArray['trendStatuslineChartData'] = $trendDataStatusChartReportArray;
    return $trendDataStatusReportArray;
}

function getDate_range($first, $last, $step = '+1 day', $output_format = 'd/m/Y') {
    $dates = array();
    $current = strtotime($first);
    $last = strtotime($last);
    while ($current <= $last) {
        $dates[] = date($output_format, $current);
        $current = strtotime($step, $current);
    }
    return $dates;
}

/**
 * get answer submission response for answered and skipped persons
 *
 * @author     Biztech Consultancy
 * @param      string - $surveyID
 * @return array
 */
function getAnswerSubmissionAnsweredAndSkipped($surveyID = '', $status_type = '', $total_submitted_response = '', $global_filter = array(), $GF_QueLogic_Passed_Submissions = array()) {
    global $db;
    $submissionTypeArray = array();
    switch ($status_type) {
        case 'openended':
            $submissionTypeArray = array('Open Ended');
            break;
        case 'email':
            $submissionTypeArray = array('Email');
            break;
        case 'combined':
            $submissionTypeArray = array('Email', 'Open Ended');
            break;
    }
    $submissionTypeImplodeVal = implode("','", $submissionTypeArray);
    $GF_QueLogic_Passed_Submissions = implode("','", $GF_QueLogic_Passed_Submissions);
    if ($db->dbType == "mssql") {
    $selectEachAnswerSubCount = "SELECT bc_survey_submit_answer_calculation.question_id AS queId,
                                    COUNT(*) as answered
                                FROM
                                    bc_survey_submit_answer_calculation
                                    left join bc_survey_submission on bc_survey_submission.id = bc_survey_submit_answer_calculation.submission_id
                                    and bc_survey_submission.deleted = 0
                                WHERE
                                    bc_survey_submit_answer_calculation.sent_survey_id = '{$surveyID}'
                                    and bc_survey_submission.id in ('{$GF_QueLogic_Passed_Submissions}')
                                    and CONVERT(VARCHAR,bc_survey_submit_answer_calculation.submit_answer_id) != ''
                                    and bc_survey_submission.submission_type in ('{$submissionTypeImplodeVal}')
                                    group by bc_survey_submit_answer_calculation.question_id";
    } else {
    $selectEachAnswerSubCount = "SELECT 
                               
                                bc_survey_submit_answer_calculation.question_id AS queId,
                                COUNT(*) as answered
                            FROM
                                bc_survey_submit_answer_calculation
                                left join bc_survey_submission on bc_survey_submission.id = bc_survey_submit_answer_calculation.submission_id
                                and bc_survey_submission.deleted = 0
                            WHERE
                                bc_survey_submit_answer_calculation.sent_survey_id = '{$surveyID}'
                                and bc_survey_submission.id in ('{$GF_QueLogic_Passed_Submissions}')
                                and bc_survey_submit_answer_calculation.submit_answer_id != ''
                                and bc_survey_submission.submission_type in ('{$submissionTypeImplodeVal}')
                                group by bc_survey_submit_answer_calculation.question_id";
    }
    $runQuery = $db->query($selectEachAnswerSubCount);
    $result_array = array();
    while ($resultCountData = $db->fetchByAssoc($runQuery)) {
        $result_array[$resultCountData['queId']] = array('answered' => $resultCountData['answered'], 'skipped' => ($total_submitted_response - $resultCountData['answered']));
            }

    return $result_array;
}

/**
 * get answer submission data for matrix type of question
 *
 * @author     Biztech Consultancy
 * @param      string - $surveyID
 * @param      string - $moduleID
 * @param      string - $questionID
 * @return array
 */
function getAnswerSubmissionDataForMatrix($surveyID = '', $moduleID = '', $questionID = '', $status_type = '', $submission_id = '', $global_filter = array(), $GF_QueLogic_Passed_Submissions = array()) {
    global $db;
    if (!empty($moduleID)) {
        $selectEachAnswerSubCount = "SELECT 
                                bc_survey_submit_answer_calculation.question_id AS queId,
                                bc_survey_submit_answer_calculation.submit_answer_id AS ansSubmitCount,
                                bc_survey_submit_answer_calculation.answer_type AS ans_type,
                                bc_survey_submit_answer_calculation.survey_receiver_id AS survey_receiver_id,
                                bc_survey_submit_answer_calculation.submission_id AS sub_id 
                            FROM
                                bc_survey_submit_answer_calculation
                            WHERE
                                bc_survey_submit_answer_calculation.sent_survey_id = '{$surveyID}' 
                            AND
                                bc_survey_submit_answer_calculation.survey_receiver_id = '{$moduleID}' 
                            AND
                                bc_survey_submit_answer_calculation.question_id = '{$questionID}' 
    ";
        if (!empty($submission_id)) {
            $selectEachAnswerSubCount .= "AND
                                bc_survey_submit_answer_calculation.submission_id = '{$submission_id}' ";
        }
    } else {
        $selectEachAnswerSubCount = "SELECT 
                                bc_survey_submit_answer_calculation.question_id AS queId,
                                bc_survey_submit_answer_calculation.submit_answer_id AS ansSubmitCount,
                                bc_survey_submit_answer_calculation.answer_type AS ans_type,
                                bc_survey_submit_answer_calculation.survey_receiver_id AS survey_receiver_id,
                                bc_survey_submit_answer_calculation.submission_id AS sub_id
                            FROM
                                bc_survey_submit_answer_calculation
                            WHERE
                                bc_survey_submit_answer_calculation.sent_survey_id = '{$surveyID}' 
                            AND
                                bc_survey_submit_answer_calculation.question_id = '{$questionID}' 
    ";
        if (!empty($submission_id)) {
            $selectEachAnswerSubCount .= "AND
                                bc_survey_submit_answer_calculation.submission_id = '{$submission_id}' ";
        }
    }
    $runQuery = $db->query($selectEachAnswerSubCount);
    $explodeData = array();

    while ($resultCountData = $db->fetchByAssoc($runQuery)) {
        if (in_array($resultCountData['sub_id'], $GF_QueLogic_Passed_Submissions) || empty($GF_QueLogic_Passed_Submissions)) {
        // retrieve sub id from data

                if (($status_type == 'openended' && str_split($resultCountData['survey_receiver_id'], 8)[0] == 'Web Link') || ($status_type == 'email' && str_split($resultCountData['survey_receiver_id'], 8)[0] != 'Web Link') || ($status_type == 'combined' || $status_type == '')) {

                    if (isset($explodeData[$resultCountData['survey_receiver_id']])) {
                        $new_data = explode(',', $resultCountData['ansSubmitCount']);
                        foreach ($new_data as $data) {
                            if (!empty($data)) {
                                array_push($explodeData[$resultCountData['survey_receiver_id']], $data);
                            }
                        }
                    } else {
                        if (!empty($resultCountData['ansSubmitCount'])) {
                            $explodeData[$resultCountData['survey_receiver_id']] = explode(',', $resultCountData['ansSubmitCount']);
                        }
                    }
                }
            }
        }


    return $explodeData;
}

/**
 * get question wise data for question wise report
 *
 * @author     Biztech Consultancy
 * @param      string - $surveyID
 * @param      string - $que_id
 * @param      string - $question_obj
 * @return array
 */
function getQuestionWiseData($survey_id = '', $que_id = '', $question_obj = '', $survey_type, $page = '', $global_filter = array(), $accesible_submissions = array()) {
    global $db, $sugar_config;
    if ($survey_type == 'email') {
        $array_survey_type = array('Email');
    } else if ($survey_type == 'openended') {
        $array_survey_type = array('Open Ended');
    } else {
        $array_survey_type = array('Email', 'Open Ended');
    }
    $subType = implode("','", $array_survey_type);
    $oQuestion = BeanFactory::getBean('bc_survey_questions', $que_id);
    $subIdsQ = "SELECT
                       bc_survey_submission.id as submissionID,
                    sdsa.bc_submission_data_bc_survey_answersbc_survey_answers_ida AS ansID,
                    sa.answer_name,
                    sa.answer_sequence
                  FROM
                    bc_submission_data_bc_survey_questions_c AS sdsq
                  JOIN
                        bc_submission_data_bc_survey_answers_c AS sdsa 
                        ON sdsq.bc_submission_data_bc_survey_questionsbc_submission_data_idb = sdsa.bc_submission_data_bc_survey_answersbc_submission_data_idb 
                    AND sdsq.bc_submission_data_bc_survey_questionsbc_survey_questions_ida = '{$que_id}' 
                    AND sdsq.deleted = 0 AND sdsa.deleted = 0
                  LEFT JOIN
                        bc_survey_answers AS sa ON sa.id = sdsa.bc_submission_data_bc_survey_answersbc_survey_answers_ida AND sa.deleted = 0
                        left join bc_submission_data_bc_survey_submission_c as sdss
                        on sdss.bc_submission_data_bc_survey_submissionbc_submission_data_idb = sdsq.bc_submission_data_bc_survey_questionsbc_submission_data_idb
                        and sdss.deleted = 0
                        left join bc_survey_submission on bc_survey_submission.id = sdss.bc_submission_data_bc_survey_submissionbc_survey_submission_ida
                        and bc_survey_submission.deleted = 0
                        where bc_survey_submission.submission_type in ('{$subType}') and bc_survey_submission.status = 'Submitted'
                        order by bc_survey_submission.submission_date desc";
    $runQ = $db->query($subIdsQ);
    while ($subIdsData = $db->fetchByAssoc($runQ)) {
        $include = true;
        if ($oQuestion->question_type == 'contact-information') {
            $contactInfo = count(array_count_values(json_decode($subIdsData['answer_name'], true)));
            if ($contactInfo <= 1) {
                $include = false;
            }
        }
        if ($subIdsData['answer_name'] != '' && in_array($subIdsData['submissionID'], $accesible_submissions) && $include) {
        $submitedAndIds[$subIdsData['ansID']]['answer_id'] = $subIdsData['ansID'];
            $submitedAndIds[$subIdsData['ansID']]['answer_name'] = htmlentities($subIdsData['answer_name']);
        $submitedAndIds[$subIdsData['ansID']]['answer_sequence'] = $subIdsData['answer_sequence'];
    }
    }

    if ($oQuestion->question_type != 'section-header') {
        // result of Question Detail
        $resultArray[$oQuestion->id]['matrix_rows'] = $oQuestion->matrix_row;
        $resultArray[$oQuestion->id]['matrix_cols'] = $oQuestion->matrix_col;
        $resultArray[$oQuestion->id]['question_title'] = $oQuestion->name;
        $resultArray[$oQuestion->id]['max_size'] = $oQuestion->maxsize;
        $resultArray[$oQuestion->id]['base_weight'] = $oQuestion->base_weight;
        $resultArray[$oQuestion->id]['enable_scoring'] = $oQuestion->enable_scoring;
        $resultArray[$oQuestion->id]['question_id'] = $oQuestion->id;
        $resultArray[$oQuestion->id]['question_type'] = $oQuestion->question_type;
        $resultArray[$oQuestion->id]['que_seq'] = $oQuestion->question_sequence;
        $resultArray[$oQuestion->id]['page_seq'] = $oPage->page_sequence;

        $ansList = $oQuestion->get_linked_beans('bc_survey_answers_bc_survey_questions', 'bc_survey_answers');
        if ($oQuestion->question_type == 'radio-button' || $oQuestion->question_type == 'check-box' || $oQuestion->question_type == 'multiselectlist' || $oQuestion->question_type == 'dropdownlist' || $oQuestion->question_type == 'boolean') {
            foreach ($ansList as $oAnswer) {

                if (array_key_exists($oAnswer->id, $submitedAndIds)) {
                    $resultArray[$oQuestion->id]['answers'][$oAnswer->id]['answer_id'] = $oAnswer->id;
                    $resultArray[$oQuestion->id]['answers'][$oAnswer->id]['answer_name'] = htmlentities($oAnswer->answer_name);
                    $resultArray[$oQuestion->id]['answers'][$oAnswer->id]['score_weight'] = $oAnswer->score_weight;
                }
            }
        }
        // get answers of other than multi select question type
        else if ($oQuestion->question_type != 'radio-button' || $oQuestion->question_type != 'check-box' || $oQuestion->question_type != 'multiselectlist' || $oQuestion->question_type != 'dropdownlist' || $oQuestion->question_type != 'boolean') {
            $resultArray[$oQuestion->id]['answers'] = $submitedAndIds;
        }
        // if answer is not given then set blank answer for the same
        if (!isset($resultArray[$oQuestion->id]['answers'])) {
            $resultArray[$oQuestion->id]['answers']['n/a']['answer_id'] = 'N/A';
            $resultArray[$oQuestion->id]['answers']['n/a']['answer_name'] = 'N/A';
        }
    }

    return $resultArray;
}

/**
 * get daily bases line chart data for the status report
 *
 * @author     Biztech Consultancy
 * @param      string - $survey_id
 * @return array
 */
function getLineChart($survey_id = '', $status_type = '', $accesible_submissionsAll = array()) {
    global $db, $current_user;
    require_once('include/SugarQuery/SugarQuery.php');
    $timedate = new TimeDate();
    if ($survey_id) {
        $query = new SugarQuery();
        $query->from(BeanFactory::getBean('bc_survey_submission'));
        $query->join('bc_survey_submission_bc_survey', array('alias' => 'bc_survey'));
        // select fields
        if ($db->dbType == "mssql") {
            $query->select->fieldRaw("CONVERT(date, bc_survey.start_date)", "start_date"); // bc_survey.start_date
            $query->select->fieldRaw("CONVERT(date, bc_survey_submission.date_entered)", "optional_start_date"); // bc_survey_submission.date_entered
        } else {
            $query->select->fieldRaw("bc_survey.start_date", "start_date");
            $query->select->fieldRaw("bc_survey_submission.date_entered", "optional_start_date");
        }
        $query->select(array("status", "id", "email_opened", "survey_send", "date_entered", "submission_date", "submission_type", "target_parent_id", "target_parent_type"));
        // where condition
        $query->where()->equals('bc_survey.id', $survey_id);
        $query->where()->in('bc_survey_submission.id', $accesible_submissionsAll);

        if ($status_type == 'openended') {
            $query->where()->equals('submission_type', 'Open Ended');
        } else if ($status_type == 'email') {
            $query->where()->equals('submission_type', 'Email');
        }
        // order by
        $query->orderBy('date_modified', 'ASC');
        $status_result = $query->execute();

        $email_not_opened = 0;
        $pending = 0;
        $submitted = 0;
        $result[] = array('Date', 'Submitted', 'Viewed');
        $date_check = '';
        $count = 0;
        $flag = 0;
        $inserted_dates = array();
        // asort($db->fetchByAssoc($status_result));
        foreach ($status_result as $status_row) {
                if (empty($status_row['submission_date'])) {
                    $status_row['submission_date'] = !empty($status_row['start_date']) ? $status_row['start_date'] : $status_row['optional_start_date'];
                }

                $user_tz = $current_user->getUserDateTimePreferences();
                $match = array();
                preg_match('/\(GMT(.*)\)$/i', $user_tz['userGmt'], $match);
                $new_date = date_create($status_row['submission_date']);
                $to_db_date_new = $timedate->asDb($new_date);
                $date_only_array = explode(' ', $to_db_date_new);
                $gmtdatetime = $date_only_array[0];

                $date = TimeDate::getInstance()->to_display_date($gmtdatetime);
                if ($date != $date_check && $date_check != '') {
                    if (!array_key_exists($date, $inserted_dates)) {
                        $pending = 0; // reset pending counter
                        $submitted = 0; // reset submitted counter
                    }
                }

                // Retrieve the values stored previously
                foreach ($result as $k => $values) {
                    if ($values[0] == $date) {
                        $pending = $values[2];
                        $submitted = $values[1];
                    }
                }

                if ($status_row['status'] == 'Pending' && $status_row['email_opened'] == 0) {
                    $email_not_opened++;
                } elseif ($status_row['status'] == 'Pending' && $status_row['email_opened'] == 1) {
                    $pending++;
                } elseif ($status_row['status'] == 'Submitted') {
                    $submitted++;
                }
                if ($date_check == '') { // first time only
                    $date_check = $date;
                    $count++; // update the counter
                }
                //get chart data 
                if ($count <= 0) { // for date enter first time
                    if ($date_check != $date) {
                        $result[] = array($date,
                            (int) number_format($submitted), (int) number_format($pending));
                        $inserted_dates[$date] = $date;
                        $count++; // update the counter
                    }
                } else { // new record
                    if (array_key_exists($date, $inserted_dates) && ($submitted != 0 || $pending != 0)) { // if date already enter for chart display then update values
                        foreach ($result as $key => $value) {
                            if ($value[0] == $date) { // update existing values
                                $value[0] = $date;
                                $value[1] = (int) number_format($submitted);
                                $value[2] = (int) number_format($pending);
                                $result[$key] = $value;
                                $flag = 0;
                            }
                        }
                    } else { // for new date update flag and insert new entry for chart data
                        $flag = 1;
                    }

                    if ($flag == 1) {
                        if (!array_key_exists($date, $inserted_dates)) { // check if date already not exist then insert date
                            $result[] = array($date, (int) number_format($submitted), (int) number_format($pending));
                            $inserted_dates[$date] = $date;
                            $flag = 0;
                        }
                    }
                }
                $date_check = $date;  // set current date to compare it
            }

        return $result;
    }
}

/**
 * Function : getHealthStatus
 *    Get Health Status of CRM that all required configuration like license,schedule,SMTP setting,PHP version,site url,etc  are proper or not
 * 
 * @return array -  'license_status' - license status
 *                  'scheduler_status' - scheduler status
 *                  'siteurl_status' - siteurl status
 *                  'smtp_status' - smtp status
 *                  'php_status' - php status
 *                  'file_permission_status' - file permission status
 *                  'curl_status' - curl status
 */
function getHealthStatus() {
    //Get Health Status of CRM
    global $sugar_config;
    $admin = new Administration();
    $admin->retrieveSettings('SurveyPlugin');

    $licVal = $admin->settings['SurveyPlugin_LastValidation'];
    $licModEnabled = $admin->settings['SurveyPlugin_ModuleEnabled'];
    $isLicenseIssue = " <a href='index.php?module=Administration&action=surveyconfiguration' onlick='javascript:void()'>[To Configure Setting. Please click here</a>.]";
    if ($licVal && $licModEnabled) {
        $isLicenseIssue = "";
    }

    //*********************************License Status
    $license_status = $admin->settings['SurveyPlugin_LastValidationMsg'];
    if (empty($license_status)) {
        $license_status = '<img src="themes/default/images/green_camp.gif" width="16" height="16" align="baseline" border="0" alt=""> <b style="color:green;">License is correctly configured for Survey Rocket Plugin.</b>';
    } else {
        $license_status = '<img src="themes/default/images/red_camp.gif" width="16" height="16" align="baseline" border="0" alt=""> <b style="color:red;">' . $license_status . '</b>' . $isLicenseIssue;
    }


    //**********************************Get Scheduler Status of CRM to send scheduled survey
    $scheduler = BeanFactory::getBean('Schedulers');
    $scheduler->retrieve_by_string_fields(array('job' => 'function::sendScheduledSurveys'));
    $schedul_status = array();
    if ($scheduler->id) {
        $scheduler_found = true;
        $scheduler_id = $scheduler->id;
        $scheduler_status = $scheduler->status;
        $last_ran = $scheduler->last_run;

        global $mod_strings, $current_language;
        $temp_mod_strings = $mod_strings;
        $mod_strings = return_module_language($current_language, 'Schedulers');

        $scheduler->get_list_view_data(); //sets some vars we need
        $interval = $scheduler->intervalHumanReadable;

        $mod_strings = $temp_mod_strings;

        //format last_ran
        if (!empty($last_ran)) {
            global $current_user, $timedate;
            if ($scheduler_status == 'Active') {
                $schedul_status['send']['status'] = '<img src="themes/default/images/green_camp.gif" width="16" height="16" align="baseline" border="0" alt=""> <b style="color:green;">' . $scheduler_status . '</b>';
            } else {
                $isSchedularStatus = " <a href='index.php?module=Schedulers&action=EditView&record={$scheduler_id}' onlick='javascript:void()'>[To Configure Setting. Please click here</a>.]";
                $schedul_status['send']['status'] = '<img src="themes/default/images/red_camp.gif" width="16" height="16" align="baseline" border="0" alt=""> <b style="color:red;">' . $scheduler_status . '</b>' . $isSchedularStatus;
            }
            $schedul_status['send']['desc'] = '<img src="themes/default/images/green_camp.gif" width="16" height="16" align="baseline" border="0" alt=""><b style="color:green;"> Last successful run of scheduler job "' . $scheduler->name . '" is ' . $timedate->to_display_date_time($last_ran, true, true, $current_user) . '</b>';
        } else {
            if ($scheduler_status == 'Active') {
                $schedul_status['send']['status'] = '<img src="themes/default/images/green_camp.gif" width="16" height="16" align="baseline" border="0" alt=""> <b style="color:green;">' . $scheduler_status . '</b>';
            } else {
                $isSchedularStatus = " <a href='index.php?module=Schedulers&action=EditView&record={$scheduler_id}' onlick='javascript:void()'>[To Configure Setting. Please click here</a>.]";
                $schedul_status['send']['status'] = '<img src="themes/default/images/red_camp.gif" width="16" height="16" align="baseline" border="0" alt=""> <b style="color:red;">' . $scheduler_status . '</b>' . $isSchedularStatus;
            }
            $schedul_status['send']['desc'] = '<img src="themes/default/images/green_camp.gif" width="16" height="16" align="baseline" border="0" alt=""><b style="color:green;"> Scheduler job "' . $scheduler->name . '" exists but there is no any successful run found.</b>';
        }
    } else {
        $schedul_status['send']['desc'] = '<b style="color:red;">The Survey Rocket scheduler job is missing.</b>';
        $schedul_status['send']['status'] = '<img src="themes/default/images/green_camp.gif" width="16" height="16" align="baseline" border="0" alt=""> -';
    }

    //*******************************************************site URL status
    $site = $sugar_config['site_url'];
    $current = $_SERVER['HTTP_REFERER'];

    if (!strchr($current, $site)) {
        $site_url_status = '<img src="themes/default/images/red_camp.gif" width="16" height="16" align="baseline" border="0" alt=""> <span style="color:red;">' . 'Current URL is <b style="color:black">' . $current . '</b> and Site URL is <b style="color:black">' . $site . '</b> which is <b style="color:red">not valid</b></span>';
    } else {
        $site_url_status = '<img src="themes/default/images/green_camp.gif" width="16" height="16" align="baseline" border="0" alt=""> <b style="color:green;">' . 'Current URL is <b style="color:black">' . $current . '</b> and Site URL is <b style="color:black">' . $site . '</b> which is <b style="color:green">valid<b></b>';
    }

    //*******************************************************current PHP Version
    $php_version = phpversion();
    $re_php_version = '/(5\.[4-9]\.[0-9])/';
    $re_php7_version = '/(7\.[0-1]\.[0-9])/';

    if (preg_match($re_php_version, $php_version) || preg_match($re_php7_version, $php_version)) {
        $php_ver = '<img src="themes/default/images/green_camp.gif" width="16" height="16" align="baseline" border="0" alt=""> <b style="color:green;">Current PHP version is ' . $php_version . ' which is compatible for the plugin.</b>';
    } else {
        $php_ver = '<img src="themes/default/images/red_camp.gif" width="16" height="16" align="baseline" border="0" alt=""> <b style="color:red;">Current PHP version is ' . $php_version . ' which is not compatible for the plugin.</b>';
    }
    // CURL status
    if (!function_exists('curl_version')) {
        $curl_status = '<img src="themes/default/images/red_camp.gif" width="16" height="16" align="baseline" border="0" alt=""> ' . '<b style="color:red">Please enable PHP cURL extension.</b>';
    } else {
        $curl_status = '<img src="themes/default/images/green_camp.gif" width="16" height="16" align="baseline" border="0" alt=""> ' . '<b style="color:green">PHP cURL extension is enabled.</b>';
    }

    //********************************************************SMTP Status

    $admin->retrieveSettings();
    // Biztech: To Resolve Survey Warning/Notices. 
    // $smtp_status = (!empty($admin->settings['SurveyPlugin_HealthCheck-SMTP'])) ? $admin->settings['SurveyPlugin_HealthCheck-SMTP'] : '';
    // End
    $customSMTPSetting = array();
    if ($admin->settings['SurveySmtp_survey_mail_smtp_username'] !== null && $admin->settings['SurveySmtp_survey_mail_smtp_username'] != '') {
        $customSMTPSetting[] = $admin->settings['SurveySmtp_survey_mail_smtp_username'];
    }
    if ($admin->settings['SurveySmtp_survey_mail_smtp_password'] !== null && $admin->settings['SurveySmtp_survey_mail_smtp_password'] != '') {
        $customSMTPSetting[] = $admin->settings['SurveySmtp_survey_mail_smtp_password'];
    }

    $defaultSMTPSetting = array();
    if ($admin->settings['mail_smtpuser'] !== null && $admin->settings['mail_smtpuser'] != '') {
        $defaultSMTPSetting[] = $admin->settings['mail_smtpuser'];
    }
    if ($admin->settings['mail_smtppass'] !== null && $admin->settings['mail_smtppass'] != '') {
        $defaultSMTPSetting[] = $admin->settings['mail_smtppass'];
    }

    if (empty($customSMTPSetting) && empty($defaultSMTPSetting)) {
        $isSMTPMsg = " <a href='index.php?module=Administration&action=surveysmtp' onlick='javascript:void()'>[To Configure Setting. Please click here</a>.]";
        $smtp_status = '<img src="themes/default/images/green_camp.gif" width="16" height="16" align="baseline" border="0" alt=""> ' . '<b style="color:red">SMTP must configure properly to send survey emails.</b>' . $isSMTPMsg;
    } else {
        $smtp_status = '<img src="themes/default/images/green_camp.gif" width="16" height="16" align="baseline" border="0" alt=""> ' . '<b style="color:green">SMTP configured correctly.</b>';
    }
    //result of all health checkup
    $result = array();
    $result['license_status'] = $license_status;
    $result['scheduler_status'] = $schedul_status;
    $result['siteurl_status'] = $site_url_status;
    $result['smtp_status'] = $smtp_status;
    $result['php_status'] = $php_ver;
    $result['curl_status'] = $curl_status;

    return $result;
}

/*
 * Get submitted answer filter by recevier
 * 
 * @return array - $ques_subAnsdataArray - question wise submitted data
 */

function getSubmittedAnswerByReciever($surveyId = '', $survey_recieverID = '') {
    global $db;
    $ques_subAnsArray = array();
    $ques_subAnsdataArray = array();
    $getSubAnsQuery = "SELECT question_id, submit_answer_id FROM bc_survey_submit_answer_calculation
                       WHERE survey_receiver_id = '{$survey_recieverID}' 
                       AND sent_survey_id = '{$surveyId}'
                       ";
    $runQuery = $db->query($getSubAnsQuery);
    while ($resultData = $db->fetchByAssoc($runQuery)) {
        if (strpos($resultData['submit_answer_id'], ',') !== false) {
            $ques_subAnsArray[] = explode(',', $resultData['submit_answer_id']);
        } else {
            $ques_subAnsArray[] = $resultData['submit_answer_id'];
        }
    }
    foreach ($ques_subAnsArray as $subAnswers) {
        if (is_array($subAnswers) && $subAnswers != '') {
            foreach ($subAnswers as $subAns) {
                $ques_subAnsdataArray[] = $subAns;
            }
        } else {
            $ques_subAnsdataArray[] = $subAnswers;
        }
    }
    return $ques_subAnsdataArray;
}

/*
 * Get Global filter by logic submissions
 */

function getGlobalFilterByQuestionLogicSubmissions($survey_id, $submission_id, $global_logic) {
    global $current_user, $db;
    $datef = $current_user->getPreference('datef');
    $timef = $current_user->getPreference('timef');
    $status = false;
    // retrieve answered question given in logic
    $logic_que_id = $global_logic->que_id;
    $logic_operator = $global_logic->logic_operator;
    $logic_values = $global_logic->logic_values;

    if ($logic_que_id == "0") {
        return true;
    }

    $qAns = "select submit_answer_id as subAnsID from bc_survey_submit_answer_calculation 
            where sent_survey_id = '{$survey_id}' and submission_id = '{$submission_id}' 
            and question_id = '{$logic_que_id}'";
    $runQ = $db->query($qAns);
    $ansArray = array();
    $oQuestion = BeanFactory::getBean('bc_survey_questions', $logic_que_id);

    $preStored_answer_QueTypes = array('radio-button', 'dropdownlist', 'boolean', 'emojis');
    $preStored_answer_MultiQueTypes = array('check-box', 'multiselectlist');
    while ($subAndDataArra = $db->fetchByAssoc($runQ)) {
        $ansArray = explode(',', $subAndDataArra['subAnsID']);
        foreach ($ansArray as $oAnswerData) {
            if (!empty($oAnswerData)) {
                // Multi Choice Ques Comapre
                $oAnswer = BeanFactory::getBean('bc_survey_answers', $oAnswerData);
                if (in_array($oQuestion->question_type, $preStored_answer_QueTypes)) {
                    foreach ($logic_values as $match_value) {
                        $ansList = explode(',', $oAnswer->id);
                        if ($logic_operator == 'equals_to') {
                            if (in_array($match_value, $ansList)) {
                                return true;
                            }
                        } else if ($logic_operator == 'not_equals_to') {
                            if (!in_array($match_value, $ansList)) {
                                return true;
                            }
                        }
                    }
                } else if (in_array($oQuestion->question_type, $preStored_answer_MultiQueTypes)) {
                    foreach ($logic_values as $match_value) {
                        if ($logic_operator == 'equals_to') {
                            if (in_array($match_value, $ansArray)) {
                                return true;
                            }
                        } else if ($logic_operator == 'not_equals_to') {
                            if (!in_array($match_value, $ansArray)) {
                                return true;
                            }
                        }
                    }
                }
                // Rating
                else if ($oQuestion->question_type == 'rating') {
                    if ($logic_operator == 'between' || $logic_operator == 'not_between') {
                        $values = json_decode($logic_values, true);
                        $v1 = $values[0];
                        $v2 = $values[1];
                        if ($logic_operator == 'between') {
                            if ($oQuestion->advance_type == 'Float') {
                                if (((float) $oAnswerData > (float) $v1 && (float) $oAnswerData < (float) $v2)) {
                                    return true;
                                }
                            } else {
                                if (((int) $oAnswerData > (int) $v1 && (int) $oAnswerData < (int) $v2)) {
                                    return true;
                                }
                            }
                        } else if ($logic_operator == 'not_between') {
                            if ($oQuestion->advance_type == 'Float') {
                                if (((float) $oAnswerData < (float) $v1 || (float) $oAnswerData > (float) $v2)) {
                                    return true;
                                }
                            } else {
                                if (((int) $oAnswerData < (int) $v1 || (int) $oAnswerData > (int) $v2)) {
                                    return true;
                                }
                            }
                        }
                    } else {
                    foreach ($logic_values as $match_value) {
                        if ($logic_operator == 'equals_to') {
                                if ($match_value == $oAnswerData) {
                                return true;
                            }
                        } else if ($logic_operator == 'not_equals_to') {
                                if ($match_value != $oAnswerData) {
                                return true;
                            }
                        } else if ($logic_operator == 'gt_equals_to') {
                                if ((int) $oAnswerData >= (int) $match_value) {
                                return true;
                            }
                        } else if ($logic_operator == 'gt') {
                                if ((int) $oAnswerData > (int) $match_value) {
                                return true;
                            }
                        } else if ($logic_operator == 'lt_equals_to') {
                                if ((int) $oAnswerData <= (int) $match_value) {
                                return true;
                            }
                        } else if ($logic_operator == 'lt') {
                                if ((int) $oAnswerData < (int) $match_value) {
                                return true;
                            }
                        }
                    }
                }
                }
                // Net promoter score
                else if ($oQuestion->question_type == 'netpromoterscore') {
                    $Detractors = array('0', '1', '2', '3', '4', '5', '6');
                    $Passives = array('7', '8');
                    $Promoters = array('9', '10');
                    foreach ($logic_values as $match_value) {
                        if ($logic_operator == 'equals_to') {
                            if ($match_value == '0-6' && in_array($oAnswer->answer_name, $Detractors)) {
                                return true;
                            } else if ($match_value == '7-8' && in_array($oAnswer->answer_name, $Passives)) {
                                return true;
                            } else if ($match_value == '9-10' && in_array($oAnswer->answer_name, $Promoters)) {
                                return true;
                            }
                        } else if ($logic_operator == 'not_equals_to') {
                            if ($match_value == '0-6' && !in_array($oAnswer->answer_name, $Detractors)) {
                                return true;
                            } else if ($match_value == '7-8' && !in_array($oAnswer->answer_name, $Passives)) {
                                return true;
                            } else if ($match_value == '9-10' && !in_array($oAnswer->answer_name, $Promoters)) {
                                return true;
                            }
                        }
                    }
                }
                // Text and Comment 
                else if ($oQuestion->question_type == 'commentbox' || ($oQuestion->question_type == 'textbox' && ($oQuestion->advance_type == 'Char' || $oQuestion->advance_type == 'Email' || empty($oQuestion->advance_type) ))) {
                    if (!empty($logic_operator)) {
                        $oAnswerData = strtolower($oAnswerData);
                        foreach ($logic_values as $match_value) {
                            $match_value = strtolower($match_value);
                            if ($logic_operator == 'equals_to') {
                                if ($match_value == $oAnswerData) {
                                    return true;
                                }
                            } else if ($logic_operator == 'not_equals_to') {
                                if ($match_value != $oAnswerData) {
                                    return true;
                                }
                            } else if ($logic_operator == 'contains') {
                                if (strpos($oAnswerData, $match_value) !== false) {
                                    return true;
                                }
                            } else if ($logic_operator == 'starts_with') {
                                if (startsWith($oAnswerData, $match_value)) {
                                    return true;
                                }
                            } else if ($logic_operator == 'ends_with') {
                                if (endsWith($oAnswerData, $match_value)) {
                                    return true;
                                }
                            } else if ($logic_operator == 'not_contains') {
                                if (strpos($oAnswerData, $match_value) === false) {
                                    return true;
                            }
                        }
                    }
                }
                }
                // Numeric and Scale 
                else if ($oQuestion->question_type == 'scale' || ($oQuestion->question_type == 'textbox' && ($oQuestion->advance_type == 'Integer' || $oQuestion->advance_type == 'Float' || empty($oQuestion->advance_type) ))) {
                    if (!empty($logic_operator)) {
                        if ($logic_operator == 'between' || $logic_operator == 'not_between') {
                            $values = json_decode($logic_values, true);
                            $v1 = $values[0];
                            $v2 = $values[1];
                            if ($logic_operator == 'between') {
                                if ($oQuestion->advance_type == 'Float') {
                                    if (((float) $oAnswerData > (float) $v1 && (float) $oAnswerData < (float) $v2)) {
                                        return true;
                                    }
                                } else {
                                    if (((int) $oAnswerData > (int) $v1 && (int) $oAnswerData < (int) $v2)) {
                                        return true;
                                    }
                                }
                            } else if ($logic_operator == 'not_between') {
                                if ($oQuestion->advance_type == 'Float') {
                                    if (((float) $oAnswerData < (float) $v1 || (float) $oAnswerData > (float) $v2)) {
                                        return true;
                                    }
                                } else {
                                    if (((int) $oAnswerData < (int) $v1 || (int) $oAnswerData > (int) $v2)) {
                                        return true;
                                    }
                                }
                            }
                        } else {
                        foreach ($logic_values as $match_value) {
                            if ($logic_operator == 'equals_to') {
                                    if ($match_value == $oAnswerData) {
                                    return true;
                                }
                            } else if ($logic_operator == 'not_equals_to') {
                                    if ($match_value != $oAnswerData) {
                                    return true;
                                }
                            } else if ($logic_operator == 'gt_equals_to') {
                                if ($oQuestion->advance_type == 'Integer') {
                                        if ((int) $oAnswerData >= (int) $match_value) {
                                        return true;
                                    }
                                } else if ($oQuestion->advance_type == 'Float') {
                                        if ((float) $oAnswerData >= (float) $match_value) {
                                        return true;
                                    }
                                } else {
                                        if ((int) $oAnswerData >= (int) $match_value) {
                                        return true;
                                    }
                                }
                            } else if ($logic_operator == 'gt') {
                                if ($oQuestion->advance_type == 'Integer') {
                                        if ((int) $oAnswerData > (int) $match_value) {
                                        return true;
                                    }
                                } else if ($oQuestion->advance_type == 'Float') {
                                        if ((float) $oAnswerData > (float) $match_value) {
                                        return true;
                                    }
                                } else {
                                        if ((int) $oAnswerData > (int) $match_value) {
                                        return true;
                                    }
                                }
                            } else if ($logic_operator == 'lt') {
                                if ($oQuestion->advance_type == 'Integer') {
                                        if ((int) $oAnswerData < (int) $match_value) {
                                        return true;
                                    }
                                } else if ($oQuestion->advance_type == 'Float') {
                                        if ((float) $oAnswerData < (float) $match_value) {
                                        return true;
                                    }
                                } else {
                                        if ((int) $oAnswerData < (int) $match_value) {
                                        return true;
                                    }
                                }
                            } else if ($logic_operator == 'lt_equals_to') {
                                if ($oQuestion->advance_type == 'Integer') {
                                        if ((int) $oAnswerData <= (int) $match_value) {
                                        return true;
                                    }
                                } else if ($oQuestion->advance_type == 'Float') {
                                        if ((float) $oAnswerData <= (float) $match_value) {
                                        return true;
                                    }
                                } else {
                                        if ((int) $oAnswerData <= (int) $match_value) {
                                        return true;
                                    }
                                }
                            }
                        }
                    }
                }
                }
                // Contact Information
                else if ($oQuestion->question_type == 'contact-information') {
                    foreach ($logic_values as $match_value) {
                        if ($logic_operator == 'contains') {
                            if (strpos($subAndDataArra['subAnsID'], $match_value) !== false) {
                                return true;
                            }
                        } else if ($logic_operator == 'not_contains') {
                            if (strpos($subAndDataArra['subAnsID'], $match_value) === false) {
                                return true;
                        }
                    }
                }
                }
                // Date and DateTime
                else if ($oQuestion->question_type == 'date-time') {
                    if ($logic_operator == 'between' || $logic_operator == 'not_between') {
                        $values = json_decode($logic_values, true);
                        if ($oQuestion->is_datetime == 0) {
                            $match_value1 = $values[0];
                            $match_value2 = $values[1];
                            $compare_match_value1 = strtotime(TimeDate::getInstance()->to_db_date($match_value1, false));
                            $compare_match_value2 = strtotime(TimeDate::getInstance()->to_db_date($match_value2, false));
                            $answer_name = strtotime(date($datef, strtotime($oAnswerData)));
                        } else {
                            $match_value1 = $values[0] . ' ' . $values[1];
                            $match_value2 = $values[2] . ' ' . $values[3];
                            $date1 = date($datef, strtotime($match_value1));
                            $timeVal1 = date($timef, strtotime($match_value1));

                            $date2 = date($datef, strtotime($match_value2));
                            $timeVal2 = date($timef, strtotime($match_value2));



                            $ansdateVal = date($datef, strtotime($oAnswerData));
                            $anstimeVal = date($timef, strtotime($oAnswerData));
                            $mergeVal1 = $date1 . ' ' . $timeVal1;
                            $mergeVal2 = $date2 . ' ' . $timeVal2;
                            $ansDateTimeVal = $ansdateVal . ' ' . $anstimeVal;

                            $compare_match_value1 = strtotime(date($datef . ' ' . $timef, strtotime($mergeVal1)));
                            $compare_match_value2 = strtotime(date($datef . ' ' . $timef, strtotime($mergeVal2)));

                            $answer_name = strtotime(date($datef . ' ' . $timef, strtotime($ansDateTimeVal)));
                        }
                        if ($logic_operator == 'between') {
                            if (($answer_name > $compare_match_value1 && $answer_name < $compare_match_value2)) {
                                return true;
                            }
                        } else if ($logic_operator == 'not_between') {
                            if (($answer_name < $compare_match_value1 || $answer_name > $compare_match_value2)) {
                                return true;
                            }
                        }
                    } else {
                    foreach ($logic_values as $k => $match_value) {
                        if ($k == 0) {
                            $match_value_date = $match_value;
                        } else {
                            $match_value_time = $match_value;
                        }
                    }
                    if ($oQuestion->is_datetime == 0) {
                        $match_value = strtotime(TimeDate::getInstance()->to_db_date($match_value_date, false));
                        $answer_name = strtotime(date($datef, strtotime($oAnswerData)));
                    } else {
                        $match_value_date = $match_value_date . ' ' . $match_value_time;
                        $date1 = date($datef, strtotime($match_value_date));
                        $timeVal1 = date($timef, strtotime($match_value_date));
                        $date2 = date($datef, strtotime($oAnswerData));
                        $timeVal2 = date($timef, strtotime($oAnswerData));
                        $mergeVal1 = $date1 . ' ' . $timeVal1;
                        $mergeVal2 = $date2 . ' ' . $timeVal2;
                        $match_value = strtotime(date($datef . ' ' . $timef, strtotime($mergeVal1)));
                        $answer_name = strtotime(date($datef . ' ' . $timef, strtotime($mergeVal2)));
                    }
                    }
                    if ($logic_operator == 'equals_to') {
                        if ($match_value == $answer_name) {
                            return true;
                        }
                    } else if ($logic_operator == 'not_equals_to') {
                        if ($match_value != $answer_name) {
                            return true;
                        }
                    } else if ($logic_operator == 'gt_equals_to') {
                        if ($answer_name >= (int) $match_value) {
                            return true;
                        }
                    } else if ($logic_operator == 'gt') {
                        if ($answer_name > (int) $match_value) {
                            return true;
                        }
                    } else if ($logic_operator == 'lt') {
                        if ($answer_name < (int) $match_value) {
                            return true;
                        }
                    } else if ($logic_operator == 'lt_equals_to') {
                        if ($answer_name <= (int) $match_value) {
                            return true;
                        }
                    }
                }
                // Matrix
                else if ($oQuestion->question_type == 'matrix') {
                    foreach ($logic_values as $match_value) {
                        if (in_array($match_value, $ansArray)) {
                            return true;
                        }
                    }
                }
            }
        }
    }
    return $status;
}

function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === '' || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    if ($needle === '') {
        return true;
    }
    $diff = \strlen($haystack) - \strlen($needle);
    return $diff >= 0 && strpos($haystack, $needle, $diff) !== false;
}

function standard_deviation($aValues, $bSample = true) {
    $sd_array = array();
    $variance = 0;
    if (!empty($aValues)) {
        sort($aValues);
        $aCount = count($aValues);
        $Mean = array_sum($aValues) / $aCount;
        // IF true  = Even else Odd
        if ($aCount % 2 == 0) {
            $medianCount = (int) ((($aCount / 2) + (($aCount + 2) / 2)) / 2);
            $fposition = ($medianCount - 1);
            $lposition = $medianCount;
            $medianFirst = $aValues[$fposition];
            $medianLast = $aValues[$lposition];
            $median = (($medianFirst + $medianLast) / 2);
        } else {
            $medianKey = (($aCount + 1) / 2) - 1;
            $median = $aValues[$medianKey];
        }
        foreach ($aValues as $i) {
            $variance += pow($i - $Mean, 2);
        }
        $variance /= (($bSample ? count($aValues) - 1 : count($aValues)) == 0) ? 1 : ($bSample ? count($aValues) - 1 : count($aValues));
        $variance = (is_nan($variance) || is_infinite($variance)) ? 0 : $variance;
        $sd = sqrt($variance);
        $sd_array['Mean'] = (float) number_format($Mean, 2);
        $sd_array['Median'] = $median;
        $sd_array['Variance'] = (float) number_format($variance, 2);
        $sd_array['SD'] = (float) number_format($sd, 2);
    } else {
        $sd_array['Mean'] = '';
        $sd_array['Median'] = '';
        $sd_array['Variance'] = '';
        $sd_array['SD'] = '';
    }
    return $sd_array;
}

// v4.1: Function related to Export Features.
// On 16-04-2019

function getTrendTableHtmlStructure($rowDataArray) {
    $quetitle = $rowDataArray['quetitle'];
    $qSeq = $rowDataArray['qSeq'];
    $answeredCount = $rowDataArray['answeredCount'];
    $skippedCount = $rowDataArray['skippedCount'];
    $path_Img = $rowDataArray['path_Img'];
    $trendDataArray = $rowDataArray['trendDataArra'];
    $exportAS = $rowDataArray['exportAS'];
    $fromIndividualQuestion = $rowDataArray['fromIndividualQuestion'];
    $imgHtml = '<img src="' . trim($path_Img) . '" height="250px" width="500px">';
    if ($fromIndividualQuestion && $exportAS == 'image') {
        $imgHtml = '<img src="' . trim($path_Img) . '">';
    }
    $trendHtml = '';
    $trendHtml .= '';
    $trendHtml .= '<table class="report_question_table" align="">
                    <tbody>
                       <tr class="question">
                          <td colspan="3">&nbsp;<span style="text-align:left;"><b>' . $qSeq . '</b></span>&nbsp; <b>' . $quetitle . '</b></td>
                       </tr>
                    </tbody>
                 </table>';
    $trendHtml .= '<p align="center"><b>Answered Persons :&nbsp;</b>' . $answeredCount . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Skipped Persons :&nbsp;</b>' . $skippedCount . '</p>';
    $trendHtml .= '<span>' . $imgHtml . '</span><br><br>
                     <table  border="1" width="100%">
                                <thead>
                                   <tr class="thead">
                                      <td>
                                         <b>Date Range</b>
                                      </td>
                                      <td>
                                         <b>Response Percent</b>
                                      </td>
                                      <td>
                                         <b>Response Count</b>
                                      </td>
                                   </tr>
                                </thead>
                                <tbody>';
    foreach ($trendDataArray as $trendData) {
        $trendHtml .= '<tr>
                                      <td>' . $trendData['value'] . '</td>
                                      <td>' . $trendData['percent'] . '%</td>
                                      <td>' . $trendData['count'] . '</td>
                                   </tr>';
    }
    $trendHtml .= ' </tbody>
                             </table>';
    $trendHtml .= '<br>';
    return $trendHtml;
}

function getMatrixHtmlStructure($matrixDataArray = array()) {
    $quetitle = $matrixDataArray['quetitle'];
    $answeredCount = $matrixDataArray['answeredCount'];
    $skippedCount = $matrixDataArray['skippedCount'];
    $path_matrixImg = $matrixDataArray['path_Img'];
    $statsEnable = $matrixDataArray['statsEnable'];
    $matrixDataArra = $matrixDataArray['matrixDataArra'];
    $qSeq = $matrixDataArray['qSeq'];
    $statsColCount = $matrixDataArray['statsColCount'];
    $statsDataArra = $matrixDataArray['statsDataArra'];
    $showEndBR = $matrixDataArray['showEndBR'];
    $exportAS = $matrixDataArray['exportAS'];
    $fromIndividualQuestion = $matrixDataArray['fromIndividualQuestion'];
    $imgHtml = '<img src="' . trim($path_matrixImg) . '" height="250px" width="500px">';
    if ($fromIndividualQuestion && $exportAS == 'image') {
        $imgHtml = '<img src="' . trim($path_matrixImg) . '">';
    }
    $colArray = array();
    $colArray = array_values($matrixDataArray['matrixDataArra']);
    $colArrayVal = $colArray[0];
    $matrixhtml = '';
    $matrixhtml .= '   <table class="" align="">
                           <tbody>
                              <tr class="question">
                                 <td colspan="3">&nbsp;<b><span style="">' . $qSeq . '.</span>&nbsp;' . $quetitle . '</b></td>
                              </tr>
                           </tbody>
                        </table>
                        <p align="center"><b>Answered Persons :&nbsp;</b>' . $answeredCount . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Skipped Persons :&nbsp;</b>' . $skippedCount . '</p>
                           <span>' . $imgHtml . '</span><br><br>';
    if ($exportAS == 'pdf') {
        $matrixhtml .= '   <table class="" border="1" width="100%" style="">';
    } else {
        $matrixhtml .= '   <table class="" border="1" width="75%" style="margin-left:180px;">';
    }

    $matrixhtml .= ' <tbody>
                                          <tr>
                                             <th class="" style="">&nbsp;</th>';
    $stCOunt = 1;
    $totalOptCount = count($statsColCount);
    foreach ($colArrayVal as $key => $matrixData) {
        if ($statsEnable && $stCOunt <= $totalOptCount) {
            $statsHtml = '<span class="" style="">(' . $statsColCount[$key] . ')</span>';
        } else {
            $statsHtml = '';
        }
        $matrixhtml .= '     <th class="" style="text-align:center;">' . $statsHtml . '&nbsp;&nbsp;<b>' . $key . '</b> </th>';
        $stCOunt++;
    }
    $matrixhtml .= '</tr></tbody><tbody>';
    foreach ($matrixDataArra as $key => $matrixData) {
        $matrixhtml .= '<tr>';
        $matrixhtml .= '     <th class="" style="text-align:center;"><b>' . $key . '</b></th>';
        foreach ($matrixData as $col => $colVal) {
            $colVal = (empty($colVal)) ? 0 : $colVal;
            $matrixhtml .= '     <th class="" style="text-align:center;">' . $colVal . '</th>';
        }
        $matrixhtml .= '    </tr>';
    }
    $matrixhtml .= '     </tbody>
                                    </table>';
    if ($statsEnable) {
        $matrixhtml .= '
                                 <br> 
                                       <table class="" border="1" width="100%">
                                          <tbody>
                                             <tr class="thead">
                                                <th rowspan="2" style="text-align:center;"><b>Row</b></th>
                                                <th colspan="2" style="text-align:center;"><b>Range</b></th>
                                                <th colspan="2" style="text-align:center;"><b>Least Frequent</b></th>
                                                <th colspan="2" style="text-align:center;"><b>Most Frequent</b></th>
                                                <th rowspan="2" style="text-align:center;"><b>Mean</b></th>
                                                <th rowspan="2" style="text-align:center;"><b>Median</b></th>
                                                <th rowspan="2" style="text-align:center;"><b>Standard Deviation</b></th>
                                                <th rowspan="2" style="text-align:center;"><b>Variance</b></th>
                                             </tr>
                                             <tr class="thead">
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Frequency</th>
                                                <th>Value</th>
                                                <th>Frequency</th>
                                                <th>Value</th>
                                             </tr>
                                          </tbody>
                                          <tbody>';
        $isEmpty = true;
        foreach ($statsDataArra as $key => $statsData) {
            $isEmpty = false;
            $matrixhtml .= '   <tr class="">
                                                <td>' . $key . '</td>
                                                <td>' . $statsData['range']['from'] . '</td>
                                                <td>' . $statsData['range']['to'] . '</td>
                                                <td>' . $statsData['leastFreq']['lfreqCount'] . '</td>
                                                <td>' . $statsData['leastFreq']['lfreqVal'] . '</td>
                                                <td>' . $statsData['mostFreq']['mfreqCount'] . '</td>
                                                <td>' . $statsData['mostFreq']['mfreqVal'] . '</td>
                                                <td style="text-align: center;">' . $statsData['mean'] . '</td>
                                                <td style="text-align: center;">' . $statsData['median'] . '</td>
                                                <td style="text-align: center;">' . $statsData['sd'] . '</td>
                                                <td style="text-align: center;">' . $statsData['variance'] . '</td>
                                             </tr>';
        }
        if ($isEmpty) {
            $matrixhtml .= '<tr><td colspan="11" style="text-align: center;"> There is no stats data for this question.</td></tr>';
        }
        $matrixhtml .= ' </tbody>
                                       </table><br>
                                    ';
    }
    if ($showEndBR) {
    $matrixhtml .= '<br>';
    }
    if ($fromIndividualQuestion && $exportAS == 'image') {
        $matrixhtml .= '<br>';
    }
    return $matrixhtml;
}

function getChoiceTypeHtmlStructure($rowDataArray) {
    $quetitle = $rowDataArray['quetitle'];
    $answeredCount = $rowDataArray['answeredCount'];
    $skippedCount = $rowDataArray['skippedCount'];
    $path_matrixImg = $rowDataArray['path_Img'];
    $statsEnable = $rowDataArray['statsEnable'];
    $IsEnableScore = $rowDataArray['enable_scoring'];
    $statsColCount = $rowDataArray['statsColCount'];
    $choiceDataArra = $rowDataArray['choiceDataArra'];
    $qSeq = $rowDataArray['qSeq'];
    $base_score = $rowDataArray['base_score'];
    $average_score = $rowDataArray['average_score'];
    $statsDataArra = $rowDataArray['statsDataArra'];
    $showEndBR = $rowDataArray['showEndBR'];
    $qType = $rowDataArray['qType'];
    $exportAS = $rowDataArray['exportAS'];
    $fromIndividualQuestion = $rowDataArray['fromIndividualQuestion'];
    $imgHtml = '<img src="' . trim($path_matrixImg) . '" height="250px" width="500px">';
    if ($fromIndividualQuestion && $exportAS == 'image') {
        $imgHtml = '<img src="' . trim($path_matrixImg) . '">';
    }
    $choiceHtml = '';
    $choiceHtml .= ' <table class="" align="">
                           <tbody>
                              <tr class="question">
                                 <td colspan="3">&nbsp;<b><span style="">' . $qSeq . '.</span>&nbsp;' . $quetitle . '</b></td>
                              </tr>
                           </tbody>
                        </table>
                        <p align="center"><b>Answered Persons :&nbsp;</b>' . $answeredCount . '&nbsp;&nbsp;<b>Skipped Persons :&nbsp;</b>' . $skippedCount . '</p>
                          <span>' . $imgHtml . '</span><br><br>';
    if ($exportAS == 'pdf') {
        $choiceHtml .= '   <table class="" border="1" width="100%" style="">';
    } else {
        $choiceHtml .= '   <table class="" border="1" width="76%" style="margin-left:160px;">';
    }
    $choiceHtml .= ' <tbody>
                                          <tr>';

    $choiceHtml .= '<th class="" style="text-align:left;">&nbsp;<b>Submitted Data</b> </th>';
    if ($IsEnableScore) {
        $choiceHtml .= '<th class="" style="text-align:left;">&nbsp;<b>Weight</b> </th>';
    }
    $choiceHtml .= '<th class="" style="text-align:left;">&nbsp;<b>Percentage</b> </th>';
    $choiceHtml .= '<th class="" style="text-align:left;">&nbsp;<b>Count</b> </th>';
    $choiceHtml .= '</tr></tbody><tbody>';
    $stCOunt = 1;
    $totalOptCount = count($statsColCount);
    foreach ($choiceDataArra as $key => $choiceData) {
        $firstColVal = $choiceData['column'];
        if ($qType == 'emojis' && $exportAS == 'image') {
            $emojisImges = array(
                1 => "<img src='custom/include/images/ext-unsatisfy.png' width='3%' />",
                2 => "<img src='custom/include/images/unsatisfy.png' width='3%'   />",
                3 => "<img src='custom/include/images/nuteral.png' width='3%'  />",
                4 => "<img src='custom/include/images/satisfy.png' width='3%'  />",
                5 => "<img src='custom/include/images/ext-satisfy.png' width='3%' />",
            );
            $Img = $emojisImges[$choiceData['ansSeq']];
            $firstColVal = $Img . '&nbsp;&nbsp;' . $firstColVal;
        } else if ($qType == 'rating' && $exportAS == 'image') {
            $Img = '';
            for ($x = 1; $x <= $choiceData['column']; $x++) {
                $Img .= '<i class="fa fa-star fa-2x" style="font-size:18px;color:#F4B30A; margin-right:3px;">&nbsp; </i>';
            }
            $firstColVal = $Img;
        } else if (($qType == 'check-box' || $qType == 'radio-button') && $exportAS == 'image') {
            if (isset($choiceData['radio_image'])) {
                $Img = '<img src="' . $choiceData['radio_image'] . '" width="2%">';
                $firstColVal = $Img . '&nbsp;&nbsp;' . $firstColVal;
            }
        } else {
            $Img = '';
        }
        $choiceHtml .= '<tr>';
        if ($statsEnable && $stCOunt <= $totalOptCount) {
            $statsHtml = '<span class="" style="text-align:left;">(' . $statsColCount[$key] . ')</span>';
        } else {
            $statsHtml = '';
        }
        $choiceHtml .= '     <td class="" style="text-align:left;">' . $statsHtml . '&nbsp;&nbsp;' . $firstColVal . '</td>';
        if ($IsEnableScore) {
            $choiceHtml .= '     <td class="" style="text-align:left;">' . $choiceData['weight'] . '</td>';
        }
        $choiceHtml .= '     <td class="" style="text-align:left;">' . $choiceData['percent'] . '</td>';
        $choiceHtml .= '     <td class="" style="text-align:left;">' . $choiceData['Count'] . '</td>';
        $choiceHtml .= '    </tr>';
        $stCOunt++;
    }
    $choiceHtml .= '     </tbody>
                                    </table>';
    if ($statsEnable) {
        $choiceHtml .= '
                                    <br>
                                       <table class="" border="1" width="100%">
                                          <tbody>
                                             <tr class="thead">
                                                <th colspan="2" style="text-align:center;"><b>Range</b></th>
                                                <th colspan="2" style="text-align:center;"><b>Least Frequent</b></th>
                                                <th colspan="2" style="text-align:center;"><b>Most Frequent</b></th>
                                                <th rowspan="2" style="text-align:center;"><b>Mean</b></th>
                                                <th rowspan="2" style="text-align:center;"><b>Median</b></th>
                                                <th rowspan="2" style="text-align:center;"><b>Standard Deviation</b></th>
                                                <th rowspan="2" style="text-align:center;"><b>Variance</b></th>
                                             </tr>
                                             <tr class="thead">
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Frequency</th>
                                                <th>Value</th>
                                                <th>Frequency</th>
                                                <th>Value</th>
                                             </tr>
                                          </tbody>
                                          <tbody>';
        $isEmpty = false;
        $choiceHtml .= '   <tr class="">
                                                <td>' . $statsDataArra['range']['from'] . '</td>
                                                <td>' . $statsDataArra['range']['to'] . '</td>
                                                <td>' . $statsDataArra['leastFreq']['lfreqCount'] . '</td>
                                                <td>' . $statsDataArra['leastFreq']['lfreqVal'] . '</td>
                                                <td>' . $statsDataArra['mostFreq']['mfreqCount'] . '</td>
                                                <td>' . $statsDataArra['mostFreq']['mfreqVal'] . '</td>
                                                <td style="text-align: center;">' . $statsDataArra['mean'] . '</td>
                                                <td style="text-align: center;">' . $statsDataArra['median'] . '</td>
                                                <td style="text-align: center;">' . $statsDataArra['sd'] . '</td>
                                                <td style="text-align: center;">' . $statsDataArra['variance'] . '</td>
                                             </tr>';

        if ($isEmpty) {
            $choiceHtml .= '<tr><td colspan="11" style="text-align: center;"> There is no stats data for this question.</td></tr>';
        }
        $choiceHtml .= ' </tbody>
                                       </table><br>
                                    ';
    }
    if ($IsEnableScore) {
        $choiceHtml .= '<p align="center" style=""><b>Average Score :&nbsp;</b><b style="color:green;">' . $average_score . '</b> out of ' . $base_score . '</p>';
    }
    if ($showEndBR) {
    $choiceHtml .= '<br>';
    }
    if ($fromIndividualQuestion && $exportAS == 'image') {
        $choiceHtml .= '<br>';
    }
    return $choiceHtml;
}

function getNonChoiceTypeHtmlStructure($rowDataArray) {
    $quetitle = $rowDataArray['quetitle'];
    $answeredCount = $rowDataArray['answeredCount'];
    $skippedCount = $rowDataArray['skippedCount'];
    $nonchoiceDataArra = $rowDataArray['nonchoiceDataArra'];
    $fromIndividualQuestion = $rowDataArray['fromIndividualQuestion'];
    $showEndBR = $rowDataArray['showEndBR'];
    $qSeq = $rowDataArray['qSeq'];
    $qType = $rowDataArray['qType'];
    $nonchoiceHtml = '';
    $nonchoiceHtml .= '<table class="" align="">
                           <tbody>
                              <tr class="question">
                                 <td  >&nbsp;<b><span style="">' . $qSeq . '.</span>&nbsp;' . $quetitle . '</b></td>
                              </tr>
                           </tbody>
                        </table>
                        <p align="center"><b>Answered Persons :&nbsp;</b>' . $answeredCount . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Skipped Persons :&nbsp;</b>' . $skippedCount . '</p>';
    if ($qType == 'contact-information') {
        $nonchoiceHtml .= '    <table  border="1" width="100%">
                                       <tbody>
                                        <tr class="respond_con">
                                              <td style="text-align: left;" colspan="2" ><b>Submitted Data</b></td>
                                           </tr>';
        $isData = 0;
        foreach ($nonchoiceDataArra as $contactInfoArr) {
            foreach ($contactInfoArr as $contactInfo) {
                $isData = 1;
                $nonchoiceHtml .= '<tr><th colspan="2"></th></tr>';
                $name = htmlentities(html_entity_decode($contactInfo['Name'], ENT_QUOTES));
                $email = $contactInfo['Email Address'];
                $company = htmlentities(html_entity_decode($contactInfo['Company'], ENT_QUOTES));
                $phno = $contactInfo['Phone Number'];
                $st1 = htmlentities(html_entity_decode($contactInfo['Address'], ENT_QUOTES));
                $st2 = htmlentities(html_entity_decode($contactInfo['Address2'], ENT_QUOTES));
                $city = htmlentities(html_entity_decode($contactInfo['City/Town'], ENT_QUOTES));
                $state = htmlentities(html_entity_decode($contactInfo['State/Province'], ENT_QUOTES));
                $zip = $contactInfo['Zip/Postal Code'];
                $country = htmlentities(html_entity_decode($contactInfo['Country'], ENT_QUOTES));
                $nonchoiceHtml .= '   <tr class="respond_con">
                                              <th style="text-align: left;"><b>Name :</b></th>
                                              <td>' . $name . '</td>
                                           </tr>
                                           <tr class="respond_con">
                                              <th style="text-align: left;"><b>Email Address :</b></th>
                                              <td>' . $email . '</td>
                                           </tr>
                                           <tr class="respond_con">
                                              <th style="text-align: left;"><b>Company :</b></th>
                                              <td>' . $company . '</td>
                                           </tr>
                                           <tr class="respond_con">
                                              <th style="text-align: left;"><b>Phone Number :</b></th>
                                              <td>' . $phno . '</td>
                                           </tr>
                                           <tr class="respond_con">
                                              <th style="text-align: left;"><b>Street1 :</b></th>
                                              <td>' . $st1 . '</td>
                                           </tr>
                                           <tr class="respond_con">
                                              <th style="text-align: left;"><b>Street2 :</b></th>
                                              <td>' . $st2 . '</td>
                                           </tr>
                                           <tr class="respond_con">
                                              <th style="text-align: left;"><b>City/Town :</b></th>
                                              <td>' . $city . '</td>
                                           </tr>
                                           <tr class="respond_con">
                                              <th style="text-align: left;"><b>State/Province :</b></th>
                                              <td>' . $state . '</td>
                                           </tr>
                                           <tr class="respond_con">
                                              <th style="text-align: left;"><b>Zip/Postal Code :</b></th>
                                              <td>' . $zip . '</td>
                                           </tr>
                                           <tr class="respond_con">
                                              <th style="text-align: left;"><b>Country :</b></th>
                                              <td>' . $country . '</td>
                                           </tr>
                                       ';
            }
        }
        if ($isData == 0) {
            $nonchoiceHtml .= '<tr class="" style="">
                              <td style="text-align: left;" colspan="2">There is no submission for this question.</td>
                           </tr>';
        }
        $nonchoiceHtml .= '   </tbody>
                                     </table>';
        if ($showEndBR) {
            $nonchoiceHtml .= '<br>';
        }
    } else {
        $nonchoiceHtml .= '<table class="report_question_table" align="" border="1" width="100%">
                        <tbody>
                           <tr class="thead">
                              <td style="text-align: left;"><b>Submitted Data</b>    </td>
                           </tr>';


        if (strlen(implode($nonchoiceDataArra)) == 0) {
            $nonchoiceHtml .= '<tr class="" style="">
                              <td style="text-align: left;">There is no submission for this question.</td>
                           </tr>';
        } else {
        foreach ($nonchoiceDataArra as $text) {
            if ($text != '') {
                $nonchoiceHtml .= '<tr class="" style="">
                              <td style="text-align: left;">' . nl2br($text) . '</td>
                           </tr>';
            }
        }
        }
        $nonchoiceHtml .= '</tbody>
                     </table>';
    if ($showEndBR) {
    $nonchoiceHtml .= '<br>';
    }
    if (!$fromIndividualQuestion) {
        $nonchoiceHtml = html_entity_decode($nonchoiceHtml);
    }
    }
    return $nonchoiceHtml;
}

function getCommonHeaderHtmlStructure($rowDataArray) {
    $surveyTitle = $rowDataArray['surveyTitle'];
    $totalResponse = $rowDataArray['totalResponse'];
    $commonHtml = '';
    $commonHtml .= '<div style="text-align:center;"><b>Question Summary Report for ' . $surveyTitle . '</b> &nbsp;<b>(Total Responses :  ' . $totalResponse . ')</b></div><br><br>';
    if ($rowDataArray['trend'] == 'trend') {
        $commonHtml .= '<span style="width:100%;text-align:center;"><b>Trend Report</b></span><br/>';
    }
    return $commonHtml;
}

function getQuestionWiseTrendExportReportData($survey_id = '', $survey_type = '', $accesible_submissions = array(), $selectedRange = array(), $qID = '', $fromIndividualQuestion = false) {
    global $db;
    $trendsQReportDataMainArray = array();
    $trendsQReportDataArray = array();
    $trendsQReportDataMainArray = getTrendQuestionWiseSubmissionData($survey_id, $survey_type, $accesible_submissions, $qID, $fromIndividualQuestion);
    $returnExportData = array();
    if ($fromIndividualQuestion) {
        $trendsQReportDataArray[$qID] = $trendsQReportDataMainArray[$qID];
    } else {
        $trendsQReportDataArray = $trendsQReportDataMainArray;
    }
    foreach ($trendsQReportDataArray as $qID => $trendReportData) {
        $range = ($selectedRange['range'] == 'default') ? $trendReportData['defaultLoadVal'] : $selectedRange['range'];
        $returnExportData[$qID]['trendQuestionChartData'] = $trendReportData['trendQuestionChartData'][$range];
        $returnExportData[$qID]['trendQuestionTableData'] = $trendReportData['trendQuestiontableData'][$range];
    }
    return $returnExportData;
}

function getQuestionWiseExportReportData($survey_id = '', $survey_type, $total_submitted_que, $GF_QueLogic_Passed_Submissions = array(), $questionID = '', $fromIndividualQuestion = false) {
    global $db;
    $choiceQType = array('check-box', 'radio-button', 'dropdownlist', 'multiselectlist', 'boolean', 'netpromoterscore', 'emojis');
//$choiceQType = array('netpromoterscore');
    $textType = array('textbox', 'commentbox', 'date-time', 'contact-information');
    $otherChoiceQType = array('scale', 'rating');
    $matrixChoiceQType = array('matrix');
    $appnedQuesWhere = '';
    if ($fromIndividualQuestion) {
        $appnedQuesWhere = " and bc_survey_questions.id = '{$questionID}'";
    }
    $q = "SELECT
                bc_survey_questions.id,
                bc_survey_questions.name,
                bc_survey_questions.is_image_option,
                question_type,
                question_sequence,
                enable_scoring,
                base_weight,
                bc_survey_pages.page_sequence,
                maxsize
              FROM
                bc_survey_questions
              LEFT JOIN
                bc_survey_bc_survey_questions_c ON bc_survey_bc_survey_questions_c.bc_survey_bc_survey_questionsbc_survey_questions_idb = bc_survey_questions.id AND bc_survey_questions.deleted = 0 AND bc_survey_bc_survey_questions_c.deleted = 0
              LEFT JOIN
                bc_survey_pages_bc_survey_questions_c ON bc_survey_pages_bc_survey_questions_c.bc_survey_pages_bc_survey_questionsbc_survey_questions_idb = bc_survey_questions.id AND bc_survey_pages_bc_survey_questions_c.deleted = 0
              LEFT JOIN
                bc_survey_pages ON bc_survey_pages.id = bc_survey_pages_bc_survey_questions_c.bc_survey_pages_bc_survey_questionsbc_survey_pages_ida AND bc_survey_pages.deleted = 0
              WHERE
                bc_survey_bc_survey_questions_c.bc_survey_bc_survey_questionsbc_survey_ida = '{$survey_id}'
                 {$appnedQuesWhere}
              ORDER BY
                bc_survey_pages.page_sequence,
                bc_survey_questions.question_sequence ASC";
    $runQ = $db->query($q);
    $queSubArrayCount = array();
    $returnChartDataArray = array();
    $statsSubmittedAnsSeqNumArray = array();
    $statsSubmittedAnsCountArray = array();
    $statsDataArra = array();
    $submissionIds = implode("','", $GF_QueLogic_Passed_Submissions);
    $chartColor = array("#02c2da", "#3b4fbc", "#f12765", "#9c27b0", "#f3b221", "#8daf26", "#93451a", "#ff4e00", "#ff9800",
        "#494763", "#279688", "#fd767e", "#a7e13a", "#31588a", "#0962ea", "#4fc1e9", "#12d6c5", "#b7d083", "#bf8df2", "#aee7e5", "#9b9fce",
        "#828e50", "#cafb8b", "#d46a67", "#e98998", "#f2d27f", "#c86833", "#30a7bc", "#0579c1", "#ff312d", "#e89788", "#fd3262", "#edb195",
        "#2aa7c9", "#e5ee2f", "#8cd0e5", "#de786a", "#f8b976", "#2dde98", "#ff6c5f", "#fc4309", "#ff765c", "#ffb646", "#ff9900", "#ff6600",
        "#ffd55d", "#ff7c81", "#c0f6d2", "#a2e4f5", "#f5b697");
    $AnsweredAndSkippedPerson = getAnswerSubmissionAnsweredAndSkipped($survey_id, $survey_type, $total_submitted_que, '', $GF_QueLogic_Passed_Submissions);
    while ($data = $db->fetchByAssoc($runQ)) {
        $tableDataArray = array();
        $statsDataArra = array();
        $multi_data = array();
        $tableStrucutureDataArray = array();
        $qType = $data['question_type'];
        $is_image_option = $data['is_image_option'];
        $enable_scoring = $data['enable_scoring'];
        $queId = $data['id'];
        $qTitle = $data['name'];
        $base_score = $data['base_weight'];
        $question_sequence = $data['question_sequence'];
        $getSubQ = "SELECT
                                    COUNT(*) AS total_submitted_que
                                  FROM
                                    bc_submission_data_bc_survey_questions_c
                                  LEFT JOIN
                                    bc_submission_data_bc_survey_submission_c 
                                    ON bc_submission_data_bc_survey_submission_c.bc_submission_data_bc_survey_submissionbc_submission_data_idb = bc_submission_data_bc_survey_questions_c.bc_submission_data_bc_survey_questionsbc_submission_data_idb
                                    left join bc_survey_submission on bc_survey_submission.id = bc_submission_data_bc_survey_submission_c.bc_submission_data_bc_survey_submissionbc_survey_submission_ida
                                    and bc_survey_submission.deleted = 0
                                  WHERE
                                    bc_submission_data_bc_survey_questions_c.deleted = 0 
                                    AND bc_submission_data_bc_survey_questionsbc_survey_questions_ida = '{$queId}'
                                    and bc_survey_submission.status = 'Submitted' and bc_survey_submission.id in ('{$submissionIds}')
                                  GROUP BY
                                    bc_submission_data_bc_survey_questionsbc_survey_questions_ida ";
        $runQ2 = $db->query($getSubQ);
        $tSubmissionQ = $db->fetchByAssoc($runQ2);

        $total_submitted_queScore = (empty($tSubmissionQ['total_submitted_que'])) ? 0 : $tSubmissionQ['total_submitted_que'];
        $answered = ($AnsweredAndSkippedPerson[$queId] == null) ? 0 : (int) $AnsweredAndSkippedPerson[$queId]['answered'];
        $skipped = ($AnsweredAndSkippedPerson[$queId] == null) ? (int) $total_submitted_que : (int) $AnsweredAndSkippedPerson[$queId]['skipped'];
        if (in_array($qType, $choiceQType)) {
            $multi_data[] = array('Task', 'Percentage', array('role' => 'style'));
            $queSubArrayCount[$queId] = getAnswerSubmissionCountExportReport($queId, $survey_id, $survey_type, $GF_QueLogic_Passed_Submissions);
            $q1 = "select bc_survey_answers.id,bc_survey_answers.answer_name,
                      bc_survey_answers.answer_sequence,bc_survey_answers.score_weight,
                      bc_survey_answers.radio_image
                      from bc_survey_answers 
                   left join  bc_survey_answers_bc_survey_questions_c 
                   on bc_survey_answers_bc_survey_questions_c.bc_survey_answers_bc_survey_questionsbc_survey_answers_idb = bc_survey_answers.id
                   and bc_survey_answers.deleted = 0 
                   and bc_survey_answers_bc_survey_questions_c.deleted = 0
                   where bc_survey_answers_bc_survey_questions_c.bc_survey_answers_bc_survey_questionsbc_survey_questions_ida = '{$queId}'";
            $runQ1 = $db->query($q1);
            $totalDetractorsSubmission = array();
            $totalPassivesSubmission = array();
            $totalPromotersSubmission = array();
            $totalNPSSubmittionCount = array_sum($queSubArrayCount[$queId]);
            $divisionVal = ($totalNPSSubmittionCount == 0) ? 1 : $totalNPSSubmittionCount;
            $individual_question_score = array();
            while ($ansObj = $db->fetchByAssoc($runQ1)) {
                $ansID = $ansObj['id'];
                $ansNameVal = $ansObj['answer_name'];
                $ansSeq = $ansObj['answer_sequence'];
                $score_weight = $ansObj['score_weight'];
                $ansCount = ($queSubArrayCount[$queId][$ansID] == null) ? 0 : (int) $queSubArrayCount[$queId][$ansID];
                if ($qType == 'netpromoterscore') {
                    $ansNameVal = (int) $ansNameVal;
                    if ($ansNameVal >= 0 && $ansNameVal <= 6) {
                        $totalDetractorsSubmission[] = $ansCount;
//random color display for chart
                        if ($ansNameVal == 6) {
                            $totalDetSubAns = array_sum($totalDetractorsSubmission);
                            $detractorsPercent = ( $totalDetSubAns / $divisionVal * 100);
                            $ansName = 'Detractors (0-6)';
                            $percent = ($totalNPSSubmittionCount > 0) ? number_format($detractorsPercent, 2) : 0;
                            $random_colorNumber = array_rand($chartColor);
                            $random_color = $chartColor[$random_colorNumber];
                            $multi_data[] = array($ansName, (float) $percent, $random_color);
                            $tableDataArray[$queId][$ansName]['column'] = $ansName;
                            $tableDataArray[$queId][$ansName]['ansSeq'] = $ansSeq;
                            $tableDataArray[$queId][$ansName]['percent'] = $percent . '%';
                            $tableDataArray[$queId][$ansName]['Count'] = $totalDetSubAns;
                            $tableDataArray['columnStatsCount'][$queId][$ansName] = 1;
                            if ($totalDetSubAns > 0) {
                                $statsSubmittedAnsSeqNumArray[$qType][$queId][$ansName] = 1;
                                $statsSubmittedAnsCountArray[$qType][$queId][$ansName] = $totalDetSubAns;
                            }
                        }
                    } else if ($ansNameVal > 6 && $ansNameVal <= 8) {
                        $totalPassivesSubmission[] = $ansCount;
//random color display for chart
                        if ($ansNameVal == 8) {
                            $totalPasSubAns = array_sum($totalPassivesSubmission);
                            $passivesPercent = ($totalPasSubAns / $divisionVal * 100);
                            $ansName = 'Passives (7-8)';
                            $percent = ($totalNPSSubmittionCount > 0) ? number_format($passivesPercent, 2) : 0;
                            $random_colorNumber = array_rand($chartColor);
                            $random_color = $chartColor[$random_colorNumber];
                            $multi_data[] = array($ansName, (float) $percent, $random_color);
                            $tableDataArray[$queId][$ansName]['column'] = $ansName;
                            $tableDataArray[$queId][$ansName]['ansSeq'] = $ansSeq;
                            $tableDataArray[$queId][$ansName]['percent'] = $percent . '%';
                            $tableDataArray[$queId][$ansName]['Count'] = $totalPasSubAns;
                            $tableDataArray['columnStatsCount'][$queId][$ansName] = 2;
                            if ($totalPasSubAns > 0) {
                                $statsSubmittedAnsSeqNumArray[$qType][$queId][$ansName] = 2;
                                $statsSubmittedAnsCountArray[$qType][$queId][$ansName] = $totalPasSubAns;
                            }
                        }
                    } else if ($ansNameVal > 8 && $ansNameVal <= 10) {
                        $totalPromotersSubmission[] = $ansCount;
//random color display for chart
                        if ($ansNameVal == 10) {
                            $totalProSubAns = array_sum($totalPromotersSubmission);
                            $promoPercent = ($totalProSubAns / $divisionVal * 100);
                            $ansName = 'Promoters (9-10)';
                            $percent = ($totalNPSSubmittionCount > 0) ? number_format($promoPercent, 2) : 0;
                            $random_colorNumber = array_rand($chartColor);
                            $random_color = $chartColor[$random_colorNumber];
                            $multi_data[] = array($ansName, (float) $percent, $random_color);
                            $tableDataArray[$queId][$ansName]['column'] = $ansName;
                            $tableDataArray[$queId][$ansName]['ansSeq'] = $ansSeq;
                            $tableDataArray[$queId][$ansName]['percent'] = $percent . '%';
                            $tableDataArray[$queId][$ansName]['Count'] = $totalProSubAns;
                            $tableDataArray['columnStatsCount'][$queId][$ansName] = 3;

                            if ($totalProSubAns > 0) {
                                $statsSubmittedAnsSeqNumArray[$qType][$queId][$ansName] = 3;
                                $statsSubmittedAnsCountArray[$qType][$queId][$ansName] = $totalProSubAns;
                            }
                        }
                    }
                } else {
                    $percent = number_format(($ansCount * 100) / ((empty($answered) || $answered == 0 || $answered == '0') ? 1 : $answered), 2);
                    $random_colorNumber = array_rand($chartColor);
                    $random_color = $chartColor[$random_colorNumber];
                    $multi_data[] = array($ansNameVal, (float) $percent, $random_color);
                    $tableDataArray[$queId][$ansNameVal]['weight'] = $score_weight;
                    $tableDataArray[$queId][$ansNameVal]['column'] = $ansNameVal;
                    $tableDataArray[$queId][$ansNameVal]['ansSeq'] = $ansSeq;
                    $tableDataArray[$queId][$ansNameVal]['percent'] = $percent . '%';
                    $tableDataArray[$queId][$ansNameVal]['Count'] = $ansCount;
                    if ($is_image_option) {
                        $tableDataArray[$queId][$ansNameVal]['radio_image'] = $ansObj['radio_image'];
                    }
                    $tableDataArray['columnStatsCount'][$queId][$ansNameVal] = $ansSeq;
                    if ($ansCount > 0) {
                        $statsSubmittedAnsSeqNumArray[$qType][$queId][$ansNameVal] = $ansSeq;
                        $statsSubmittedAnsCountArray[$qType][$queId][$ansNameVal] = $ansCount;
                    }
                    if ($ansCount > 0) {
                        $individual_question_score[] = (float) $score_weight * $ansCount;
                    }
                }
            }
            $total_score = array_sum($individual_question_score);
            $total_submitted_queVal = ($total_submitted_queScore == 0) ? 1 : $total_submitted_queScore;
            $average_score = number_format((float) $total_score / $total_submitted_queVal, 2, '.', '');
            if (!empty($statsSubmittedAnsSeqNumArray)) {
                ksort($statsSubmittedAnsSeqNumArray[$qType][$queId]);
            }
            if (!empty($statsSubmittedAnsCountArray)) {
                ksort($statsSubmittedAnsCountArray[$qType][$queId]);
            }
            $statsDataArra = statsQuestionReportData($statsSubmittedAnsSeqNumArray, $statsSubmittedAnsCountArray);
            $tableStrucutureDataArray['statsDataArra'] = $statsDataArra;
            $tableStrucutureDataArray['quetitle'] = $qTitle;
            $tableStrucutureDataArray['qType'] = $qType;
            $tableStrucutureDataArray['enable_scoring'] = $enable_scoring;
            $tableStrucutureDataArray['qSeq'] = $question_sequence;
            $tableStrucutureDataArray['tableData'] = $tableDataArray;
            $tableStrucutureDataArray['answered'] = $answered;
            $tableStrucutureDataArray['skipped'] = $skipped;
            $tableStrucutureDataArray['average_score'] = $average_score;
            $tableStrucutureDataArray['base_score'] = $base_score;
            $returnChartDataArray[$queId] = $multi_data;
            $returnChartDataArray[$queId]['qType'] = $qType;
            $returnChartDataArray[$queId]['qSeq'] = $question_sequence;
            $returnChartDataArray[$queId]['tableStrucutureDataArray'] = $tableStrucutureDataArray;
        } else if (in_array($qType, $otherChoiceQType)) {
            $multi_data[] = array('Task', 'Percentage', array('role' => 'style'));
            $queSubArrayCount[$queId] = getAnswerSubmissionCountExportReport($queId, $survey_id, $survey_type, $GF_QueLogic_Passed_Submissions);
            if ($qType == 'rating') {
                if (!empty($data['maxsize'])) {
                    $starCount = $data['maxsize'];
                } else {
                    $starCount = 5;
                }
                for ($i = 1; $i <= $starCount; $i++) {
                    $ansCountVal = (isset($queSubArrayCount[$queId][$i])) ? $queSubArrayCount[$queId][$i] : 0;
                    $percent = number_format(($ansCountVal * 100) / ((empty($answered) || $answered == 0 || $answered == '0') ? 1 : $answered), 2);
                    $random_colorNumber = array_rand($chartColor);
                    $random_color = $chartColor[$random_colorNumber];
                    $multi_data[] = array((string) $i, (float) $percent, $random_color);
                    $tableDataArray[$queId][$i]['column'] = $i;
                    $tableDataArray[$queId][$i]['percent'] = $percent . '%';
                    $tableDataArray[$queId][$i]['Count'] = $ansCountVal;
                    $tableDataArray['columnStatsCount'][$queId][$i] = $i;
                    if ($ansCountVal > 0) {
                        $statsSubmittedAnsSeqNumArray[$qType][$queId][$i] = $i;
                        $statsSubmittedAnsCountArray[$qType][$queId][$i] = $ansCountVal;
                    }
                }
            } else {
                ksort($queSubArrayCount[$queId]);
                foreach ($queSubArrayCount[$queId] as $ansVal => $ansSubCountVal) {
                    $percent = number_format(($ansSubCountVal * 100) / ((empty($answered) || $answered == 0 || $answered == '0') ? 1 : $answered), 2);
                    $random_colorNumber = array_rand($chartColor);
                    $random_color = $chartColor[$random_colorNumber];
                    $multi_data[] = array((string) $ansVal, (float) $percent, $random_color);
                    $tableDataArray[$queId][$ansVal]['column'] = $ansVal;
                    $tableDataArray[$queId][$ansVal]['percent'] = $percent . '%';
                    $tableDataArray[$queId][$ansVal]['Count'] = $ansSubCountVal;
                    $tableDataArray['columnStatsCount'][$queId][$ansVal] = $ansVal + 1;
                    if ($ansSubCountVal > 0) {
                        $statsSubmittedAnsSeqNumArray[$qType][$queId][$ansVal] = $ansVal + 1;
                        $statsSubmittedAnsCountArray[$qType][$queId][$ansVal] = $ansSubCountVal;
                    }
                }
            }
            if (!empty($statsSubmittedAnsSeqNumArray)) {
                ksort($statsSubmittedAnsSeqNumArray[$qType][$queId]);
            }
            if (!empty($statsSubmittedAnsCountArray)) {
                ksort($statsSubmittedAnsCountArray[$qType][$queId]);
            }
            $statsDataArra = statsQuestionReportData($statsSubmittedAnsSeqNumArray, $statsSubmittedAnsCountArray);
            $tableStrucutureDataArray['statsDataArra'] = $statsDataArra;
            $tableStrucutureDataArray['quetitle'] = $qTitle;
            $tableStrucutureDataArray['qType'] = $qType;
            $tableStrucutureDataArray['enable_scoring'] = $enable_scoring;
            $tableStrucutureDataArray['qSeq'] = $question_sequence;
            $tableStrucutureDataArray['tableData'] = $tableDataArray;
            $tableStrucutureDataArray['answered'] = $answered;
            $tableStrucutureDataArray['skipped'] = $skipped;
            $tableStrucutureDataArray['average_score'] = $average_score;
            $tableStrucutureDataArray['base_score'] = $base_score;
            $returnChartDataArray[$queId] = $multi_data;
            $returnChartDataArray[$queId]['qType'] = $qType;
            $returnChartDataArray[$queId]['qSeq'] = $question_sequence;
            $returnChartDataArray[$queId]['tableStrucutureDataArray'] = $tableStrucutureDataArray;
        } else if (in_array($qType, $matrixChoiceQType)) {
            $multi_data[] = array('Rows');
            $oQuestion = BeanFactory::getBean('bc_survey_questions', $queId);
            $matrix_rows = !empty($oQuestion->matrix_row) ? json_decode(base64_decode($oQuestion->matrix_row), true) : '';
            $matrix_cols = !empty($oQuestion->matrix_col) ? json_decode(base64_decode($oQuestion->matrix_col), true) : '';
            $queSubArrayCount[$queId] = getAnswerSubmissionCountExportReport($queId, $survey_id, $survey_type, $GF_QueLogic_Passed_Submissions);
            $matrixRowData = $queSubArrayCount[$queId]['matrix'][$queId];
            $row_count = count($matrix_rows);
            $col_count = count($matrix_cols);
            for ($rowNum = 1; $rowNum <= $row_count; $rowNum++) {
// increment row counter
                $multi_data[$rowNum] = array($matrix_rows[$rowNum]);
                $rowSum = array_sum($matrixRowData[$rowNum]);
                for ($colNum = 1; $colNum <= $col_count + 1; $colNum++) {
// increment  column counter
                    if (!empty($matrix_cols[$colNum])) {
                        $multi_data[0][$colNum] = $matrix_cols[$colNum];
                        $random_colorNumber = array_rand($chartColor);
                        $chartColorname = $chartColor[$random_colorNumber];
                        $matrix_chart_colors[] = $chartColorname;
                        $ansSubCountVal = (empty($matrixRowData[$rowNum][$colNum])) ? (int) 0 : $matrixRowData[$rowNum][$colNum];
                        $percent = number_format(($ansSubCountVal * 100) / ((empty($rowSum) || $rowSum == 0 || $rowSum == '0') ? 1 : $rowSum), 2);
//updating column count to array rows
                        array_push($multi_data[$rowNum], (float) $percent);
                        $tableDataArray[$matrix_rows[$rowNum]][$matrix_cols[$colNum]] = $ansSubCountVal . ' (' . $percent . '%)';
                        $tableDataArray['columnStatsCount'][$matrix_cols[$colNum]] = $colNum;
                    }
                    if ($matrixRowData[$rowNum][$colNum] > 0) {
                        foreach ($matrixRowData as $rowSeq => $colSeqSubData) {
                            foreach ($colSeqSubData as $colSeq => $colSubCountDat) {
                                $statsSubmittedAnsSeqNumArray[$qType][$queId][$matrix_rows[$rowSeq]][$matrix_cols[$colSeq]] = $colSeq;
                                $statsSubmittedAnsCountArray[$qType][$queId][$matrix_rows[$rowSeq]][$matrix_cols[$colSeq]] = $colSubCountDat;
                            }
                        }
                    }
                }
                $tableDataArray[$matrix_rows[$rowNum]]['Count'] = $rowSum;
            }
            if (!empty($statsSubmittedAnsSeqNumArray)) {
                ksort($statsSubmittedAnsSeqNumArray[$qType][$queId]);
            }
            if (!empty($statsSubmittedAnsCountArray)) {
                ksort($statsSubmittedAnsCountArray[$qType][$queId]);
            }
            $statsDataArra = statsQuestionReportData($statsSubmittedAnsSeqNumArray, $statsSubmittedAnsCountArray);
            $tableStrucutureDataArray['statsDataArra'] = $statsDataArra;
            $tableStrucutureDataArray['quetitle'] = $qTitle;
            $tableStrucutureDataArray['qType'] = $qType;
            $tableStrucutureDataArray['enable_scoring'] = $enable_scoring;
            $tableStrucutureDataArray['qSeq'] = $question_sequence;
            $tableStrucutureDataArray['tableData'] = $tableDataArray;
            $tableStrucutureDataArray['answered'] = $answered;
            $tableStrucutureDataArray['skipped'] = $skipped;
            $returnChartDataArray[$queId] = $multi_data;
            $returnChartDataArray[$queId]['qType'] = $qType;
            $returnChartDataArray[$queId]['qSeq'] = $question_sequence;
            $returnChartDataArray[$queId]['matrixColors'] = $matrix_chart_colors;
            $returnChartDataArray[$queId]['tableStrucutureDataArray'] = $tableStrucutureDataArray;
        } else if (in_array($qType, $textType)) { // govind
            $textQ = " select submit_answer_id as text
                       from bc_survey_submit_answer_calculation 
                       left join bc_survey_submission on bc_survey_submission.id = bc_survey_submit_answer_calculation.submission_id
                       and bc_survey_submission.deleted = 0
                       where question_id = '{$queId}' 
                       and submission_id in ('{$submissionIds}') order by bc_survey_submission.submission_date desc";
            $runtextQ = $db->query($textQ);
            if ($qType == 'contact-information') {
                while ($textDataArr = $db->fetchByAssoc($runtextQ)) {
                    $contactSubDetails = html_entity_decode($textDataArr['text'], ENT_QUOTES);
                    if ($db->dbType == 'mssql') {
                        $tableDataArray[] = json_decode(stripcslashes($contactSubDetails), true);
                    } else {
                    $tableDataArray[] = json_decode($contactSubDetails, true);
                }
                }
            } else {
                while ($textDataArr = $db->fetchByAssoc($runtextQ)) {
                    $tableDataArray[] = $textDataArr['text'];
                }
            }
            $tableStrucutureDataArray['quetitle'] = $qTitle;
            $tableStrucutureDataArray['qType'] = $qType;
            $tableStrucutureDataArray['qSeq'] = $question_sequence;
            $tableStrucutureDataArray['tableData'] = $tableDataArray;
            $tableStrucutureDataArray['answered'] = $answered;
            $tableStrucutureDataArray['skipped'] = $skipped;
            $returnChartDataArray[$queId]['tableStrucutureDataArray'] = $tableStrucutureDataArray;
            $returnChartDataArray[$queId]['qType'] = $qType;
            $returnChartDataArray[$queId]['qSeq'] = $question_sequence;
        }
    }
    return $returnChartDataArray;
}

function statsQuestionReportData($statsSubmittedAnsSeqNumArray, $statsSubmittedAnsCountArray) {
    $statsDataArray = array();

    foreach ($statsSubmittedAnsSeqNumArray as $qType => $ansDataArray) {
        foreach ($ansDataArray as $qID => $ansData) {
            $fromVal = '--';
            $toVal = '--';
            $lfreqCount = '--';
            $lfreqVal = '--';
            $mfreqCount = '--';
            $mfreqVal = '--';
            $lestArr = array();
            $calDataArray = array();
            if ($qType == 'matrix') {
                foreach ($ansData as $rowLbl => $rowSubData) {
                    $fromVal = '--';
                    $toVal = '--';
                    $lfreqCount = '--';
                    $lfreqVal = '--';
                    $mfreqCount = '--';
                    $mfreqVal = '--';
                    $lestArr = array();
                    $calDataArray = array();
                    if (count($rowSubData) > 1) {
                        $fromVal = array_search(min($rowSubData), $rowSubData);
                        $toVal = array_search(max($rowSubData), $rowSubData);
                    }
                    if (count(array_unique($statsSubmittedAnsCountArray[$qType][$qID][$rowLbl])) == 1) {
                        $mCountAr = array_unique(array_values($statsSubmittedAnsCountArray[$qType][$qID][$rowLbl]));
                        $mfreqVal = implode(',', array_keys($statsSubmittedAnsCountArray[$qType][$qID][$rowLbl]));
                        $mfreqCount = $mCountAr[0];
                    } else {
                        foreach ($statsSubmittedAnsCountArray[$qType][$qID][$rowLbl] as $opt => $subCount) {
                            $lestArr[$subCount][] = $opt;
                        }
                        $keys = array_keys($lestArr);
                        $arrMinKey = min($keys);
                        $arrMaxKey = max($keys);
                        $lfreqCount = $arrMinKey;
                        $lfreqVal = implode(',', $lestArr[$arrMinKey]);
                        $mfreqCount = $arrMaxKey;
                        $mfreqVal = implode(',', $lestArr[$arrMaxKey]);
                    }
                    foreach ($statsSubmittedAnsCountArray[$qType][$qID][$rowLbl] as $opt => $subCount) {
                        if (!is_array($subCount)) {
                            for ($i = 1; $i <= $subCount; $i++) {
                                $calDataArray[] = $rowSubData[$opt];
                            }
                        }
                    }
                    $calculationData = standard_deviation($calDataArray);
                    $statsDataArray[$qID][$rowLbl]['range']['from'] = $fromVal;
                    $statsDataArray[$qID][$rowLbl]['range']['to'] = $toVal;
                    $statsDataArray[$qID][$rowLbl]['leastFreq']['lfreqCount'] = $lfreqCount;
                    $statsDataArray[$qID][$rowLbl]['leastFreq']['lfreqVal'] = $lfreqVal;
                    $statsDataArray[$qID][$rowLbl]['mostFreq']['mfreqCount'] = $mfreqCount;
                    $statsDataArray[$qID][$rowLbl]['mostFreq']['mfreqVal'] = $mfreqVal;
                    $statsDataArray[$qID][$rowLbl]['mean'] = $calculationData['Mean'];
                    $statsDataArray[$qID][$rowLbl]['median'] = $calculationData['Median'];
                    $statsDataArray[$qID][$rowLbl]['variance'] = $calculationData['Variance'];
                    $statsDataArray[$qID][$rowLbl]['sd'] = $calculationData['SD'];
                }
            } else {
                if (count($ansData) > 1) {
                    $fromVal = array_search(min($ansData), $ansData);
                    $toVal = array_search(max($ansData), $ansData);
                }
                if (count(array_unique($statsSubmittedAnsCountArray[$qType][$qID])) == 1) {
                    $mCountAr = array_unique(array_values($statsSubmittedAnsCountArray[$qType][$qID]));
                    $mfreqVal = implode(',', array_keys($statsSubmittedAnsCountArray[$qType][$qID]));
                    $mfreqCount = $mCountAr[0];
                } else {
                    foreach ($statsSubmittedAnsCountArray[$qType][$qID] as $opt => $subCount) {
                        $lestArr[$subCount][] = $opt;
                    }
                    $keys = array_keys($lestArr);
                    $arrMinKey = min($keys);
                    $arrMaxKey = max($keys);
                    $lfreqCount = $arrMinKey;
                    $lfreqVal = implode(',', $lestArr[$arrMinKey]);
                    $mfreqCount = $arrMaxKey;
                    $mfreqVal = implode(',', $lestArr[$arrMaxKey]);
                }
                foreach ($statsSubmittedAnsCountArray[$qType][$qID] as $opt => $subCount) {
                    if (!is_array($subCount)) {
                        for ($i = 1; $i <= $subCount; $i++) {
                            $calDataArray[] = $ansData[$opt];
                        }
                    }
                }
                $calculationData = standard_deviation($calDataArray);
                $statsDataArray[$qID]['range']['from'] = $fromVal;
                $statsDataArray[$qID]['range']['to'] = $toVal;
                $statsDataArray[$qID]['leastFreq']['lfreqCount'] = $lfreqCount;
                $statsDataArray[$qID]['leastFreq']['lfreqVal'] = $lfreqVal;
                $statsDataArray[$qID]['mostFreq']['mfreqCount'] = $mfreqCount;
                $statsDataArray[$qID]['mostFreq']['mfreqVal'] = $mfreqVal;
                $statsDataArray[$qID]['mean'] = $calculationData['Mean'];
                $statsDataArray[$qID]['median'] = $calculationData['Median'];
                $statsDataArray[$qID]['variance'] = $calculationData['Variance'];
                $statsDataArray[$qID]['sd'] = $calculationData['SD'];
            }
        }
    }
    return $statsDataArray;
}

function getExportReportData($type = '', $survey_id = '', $exportReport = '', $exportBy = '', $exportAs = '', $status_type = '', $selectedRange = array(), $GF_QueLogic_Passed_Submissions = array()) {
    global $db, $app_list_strings;
    require_once('include/SugarQuery/SugarQuery.php');
    if ($type == 'status') {
        if ($exportReport == 'normal') {
            $query = new SugarQuery();
            $query->from(BeanFactory::getBean('bc_survey_submission'));
            $query->join('bc_survey_submission_bc_survey', array('alias' => 'related_survey'));
            $query->select->fieldRaw("related_survey.id", "survey_id");
            $query->select(array("status", "id", "email_opened", "survey_send", "related_survey.name", "submission_type", "target_parent_id", "target_parent_type"));
            $query->where()->equals('related_survey.id', $survey_id);
            if ($status_type == 'openended') {
                $query->where()->equals('submission_type', 'Open Ended');
            } else if ($status_type == 'email') {
                $query->where()->equals('submission_type', 'Email');
            }
            if (!empty($GF_QueLogic_Passed_Submissions)) {
                $query->where()->in('bc_survey_submission.id', $GF_QueLogic_Passed_Submissions);
            }
            $scDataQryRes = $query->execute();
            $subType = array(
                'openended' => 'Open Ended',
                'email' => 'Email',
                'combined' => 'Combined'
            );

            $email_not_opened = 0;
            $pending = 0;
            $submitted = 0;
            foreach ($scDataQryRes as $status_row) {
                if ($status_row['status'] == 'Pending' && $status_row['email_opened'] == 0) {
                    $email_not_opened++;
                } elseif ($status_row['status'] == 'Pending' && $status_row['email_opened'] == 1) {
                    $pending++;
                } elseif ($status_row['status'] == 'Submitted') {
                    $submitted++;
                }
                $survey['Survey'] = htmlspecialchars_decode($status_row['name'], ENT_QUOTES);
            }
            if (empty($status_row['name'])) {
                $q = "select name from bc_survey where id = '{$survey_id}'";
                $runQ = $db->query($q);
                $sName = $db->fetchByAssoc($runQ);
                $surveyName = $sName['name'];
                $survey['Survey'] = $surveyName;
            }
            $survey['Submission Type'] = $subType[$status_type];
            $survey['Pending'] = $pending;
            $survey['Submitted'] = $submitted;
            $survey['NotViewed'] = $email_not_opened;

            return $survey;
        } else {
            $subType = array(
                'openended' => 'Open Ended',
                'email' => 'Email',
                'combined' => 'Combined'
            );
            $trendData = array();
            $trendDataReport = array();
            $q = "select name from bc_survey where id = '{$survey_id}'";
            $runQ = $db->query($q);
            $sName = $db->fetchByAssoc($runQ);
            $surveyName = $sName['name'];
            $trendsStatusReportDataArray = getTrendWiseSubmissionData($survey_id, $status_type, $GF_QueLogic_Passed_Submissions);
            $range = ($selectedRange['range'] == 'default') ? $trendsStatusReportDataArray['defaultLoadVal'] : $selectedRange['range'];
            if ($exportAs == 'pdf') {
                $trendData = $trendsStatusReportDataArray[$range];
            } else {
                $trendArraKeys = array_keys($trendsStatusReportDataArray[$range]);
                $trendArraVals = array_column($trendsStatusReportDataArray[$range], 'count');
                $trendArraPrec = array_column($trendsStatusReportDataArray[$range], 'percent');
                foreach($trendArraVals as $k => $vCount){
                    $trendArraVals[$k] = $vCount.' ('.$trendArraPrec[$k].'%)';
                }
                $trendData['Survey'] = $surveyName;
                $trendData['Submission Type'] = $subType[$status_type];
                $trendDataReport = array_combine($trendArraKeys, $trendArraVals);
                $trendData = $trendData + $trendDataReport;
            }
            return $trendData;
        }
    } else {
        if ($exportReport == 'normal') {
            $query = new SugarQuery();
            $query->from(BeanFactory::getBean('bc_survey_submission'));
            $query->join('bc_survey_submission_bc_survey', array('alias' => 'bc_survey'));

// select fields
            $query->select->fieldRaw("bc_survey_submission.id", "submission_id");
            $query->select->fieldRaw("schedule_on", "send_date");
            $query->select->fieldRaw("submission_date", "receive_date");
            $query->select->fieldRaw("bc_survey_submission.date_modified", "date_modified");
            $query->select(array("id", "target_parent_type", "target_parent_id", "status", "email_opened", "customer_name", "send_date", "submission_type", "change_request", "consent_accepted"));

            $query->where()->contains('bc_survey.id', "{$survey_id}");
            if ($status_type == 'openended') {
                $query->where()->equals('submission_type', 'Open Ended');
            } else if ($status_type == 'email') {
                $query->where()->equals('submission_type', 'Email');
            }
            $query->where()->equals('status', "Submitted");
            if (!empty($GF_QueLogic_Passed_Submissions)) {
                $query->where()->in('bc_survey_submission.id', $GF_QueLogic_Passed_Submissions);
            }
            $query->orderBy('bc_survey_submission.submission_date', 'DESC');

            $result = $query->execute();

            $module_types = array();
            foreach ($result as $row) {
// check related survey
                if ($row['receive_date'] != "N/A") {
                    $receive_date = TimeDate::getInstance()->to_display_date_time($row['receive_date']);
                } else {
                    $receive_date = $row['receive_date'];
                }
                if (empty($row['target_parent_id'])) {
                    $row['target_parent_id'] = $row['customer_name'];
                }
                $module_types[$row['id']] = array(
                    'customer_name' => $row['customer_name'],
                    'submission_id' => $row['id'],
                    'submission_type' => $row['submission_type'],
                    'send_date' => TimeDate::getInstance()->to_display_date_time($row['send_date']),
                    'module_id' => $row['target_parent_id'],
                    'receive_date' => $receive_date
                );
            }

            return $module_types;
        } else {
            $q = "select name from bc_survey where id = '{$survey_id}'";
            $runQ = $db->query($q);
            $sName = $db->fetchByAssoc($runQ);
            $surveyName = $sName['name'];
            $trendsQReportDataArray = getTrendQuestionWiseSubmissionData($survey_id, $status_type, $GF_QueLogic_Passed_Submissions);
            $returnExportData = array();
            $trendDataReport = array();
            $i = 0;
            foreach ($trendsQReportDataArray as $qID => $trendReportData) {
                $qu = "select name from bc_survey_questions where id= '{$qID}'";
                $r = $db->query($qu);
                $d = $db->fetchByAssoc($r);
                $qName = $d['name'];
                $subType = array(
                    'openended' => 'Open Ended',
                    'email' => 'Email',
                    'combined' => 'Combined'
                );
                $range = ($selectedRange['range'] == 'default') ? $trendReportData['defaultLoadVal'] : $selectedRange['range'];
                $trendArraKeys = array_keys($trendReportData['trendQuestiontableData'][$range]);
                $trendArraVals = array_column($trendReportData['trendQuestiontableData'][$range], 'count');
                $trendArraPrec = array_column($trendReportData['trendQuestiontableData'][$range], 'percent');
                foreach($trendArraVals as $k => $vCount){
                    $trendArraVals[$k] = $vCount.' ('.$trendArraPrec[$k].'%)';
                }
                $returnExportData[$i]['Question'] = $qName;
                $returnExportData[$i]['Submission Type'] = $subType[$status_type];
                $trendDataReport = array_combine($trendArraKeys, $trendArraVals);
                $returnExportData[$i] = $returnExportData[$i] + $trendDataReport;
                $i++;
            }
            return $returnExportData;
        }
    }
}

function uploadExportReportImages($base_64imgData) {
    require_once('include/upload_file.php');
    $UploadStream = new UploadStream();
    $returnData = array();
    $ID = create_guid();
    $image_data = explode(',', $base_64imgData);
    $ext = explode('data:image/', $image_data[0]);
    $ext_arr = explode(';base64', $ext[1]);
    $final_ext = '.' . $ext_arr[0];
    $UploadStream->stream_open('123456789' . $ID . $final_ext, "wb"); // Fix :: added dummy content bcz it get extracted letter in internal process
    $UploadStream->stream_write(base64_decode($image_data[1]));
    $UploadStream->stream_close();
    $returnData['ID'] = $ID;
    $returnData['final_ext'] = $final_ext;
    return $returnData;
}

function exportStatusReportDataAsPDF($report_type = '', $exportReport = '', $statusPieImgData = '', $statusLnImgData = '', $surveyName = '', $finalExportData = array()) {
    $removebaleFile = array();
    if ($report_type == 'status') {
        $pdfHtml = '';
        if ($exportReport == 'normal') {
            $returnDataPie = uploadExportReportImages($statusPieImgData);
            $returnDataLn = uploadExportReportImages($statusLnImgData);
            $pieID = $returnDataPie['ID'];
            $pie_final_ext = $returnDataPie['final_ext'];
            $lnID = $returnDataLn['ID'];
            $ln_final_ext = $returnDataLn['final_ext'];
            $path_pie = "upload/$pieID" . $pie_final_ext;
            $path_ln = "upload/$lnID" . $ln_final_ext;
            $removebaleFile[] = $path_pie;
            $removebaleFile[] = $path_ln;
            if (SugarAutoLoader::fileExists($path_pie) && SugarAutoLoader::fileExists($path_ln)) {
                $pdfHtml .= '<div class="report_header"><span style="text-align:center;"><b>Status Report for ' . $surveyName . '</b></span></div>';
                $pdfHtml .= "<div id='status_section'>";
                $pdfHtml .= "<div class='report_display' id='piechart_3d_combined'>";
                $pdfHtml .= '<img src="' . trim($path_pie) . '" height="250px" width="500px">';
                $pdfHtml .= "</div>";
                $pdfHtml .= "<div id='line_chart_combined' class='report_display'>";
                $pdfHtml .= '<img src="' . trim($path_ln) . '" height="250px" width="500px">';
                $pdfHtml .= "</div>";
                $pdfHtml .= "</div>";
            }
        } else {
            $returnDataln = uploadExportReportImages($statusLnImgData);
            $lnID = $returnDataln['ID'];
            $ln_final_ext = $returnDataln['final_ext'];
            $path_ln = "upload/$lnID" . $ln_final_ext;
            $removebaleFile[] = $path_ln;
            $pdfHtml .= '<div id="trend_status_section" style="">';
            $pdfHtml .= ' <table cellspacing="0" cellpadding="1" border="0" width="100%" align="center">
		<tr>
			<td><h3>' . $surveyName . '</h3></td>
		</tr>';
            if($exportReport == 'trend'){
                $pdfHtml .= '<tr><h4>Trend Report</h4></td>
		</tr>';
            }
	$pdfHtml .= '</table>
                                <div class="trend_report_display" id="trend_line_chart_by_day_combined" style="width:100%;">
                                    <img src="' . trim($path_ln) . '" height="250px" width="500px">
                                </div>
                                <div class="trend_report_display trend-tbl-report" id="trend_tbl_chart" style="">
                                   <div class="trend-tbl-class1" style="border: 1px solid #000;padding-top: 37px;background: #efefef;margin-top: 15px;width: 100%;border-bottom: 1px solid #e9e9e9;">
                                      <div class="trend-tbl-class2">
                                         <table align="left" id="multi_table" class="model-tbl table table-striped table-bordered table-condensed" style="width:100%" border="1">
                                            <thead>
                                               <tr class="thead">
                                                  <th>
                                                     <b>Date Range</b>
                                                  </th>
                                                  <th>
                                                     <b>Response Percent</b>
                                                  </th>
                                                  <th>
                                                     <b>Response Count</b>
                                                  </th>
                                               </tr>
                                            </thead>
                                            <tbody>';
            foreach ($finalExportData as $key => $tData) {
                $pdfHtml .= '<tr>
                                                    <td>' . $tData['value'] . '</td>
                                                    <td>' . $tData['percent'] . '%</td>
                                                    <td>' . $tData['count'] . '</td>
                                                 </tr>';
            }
            $pdfHtml .= '</tbody>
                                         </table>
                                      </div>
                                   </div>
                                </div>
                             </div>';
        }
        generateExportReportInPdf($surveyName, $pdfHtml, $removebaleFile);
    }
}

function exportQuestionTrendReportDataAsPDF($questionPDFData = array(), $survey_id = '', $survey_type = '', $GF_QueLogic_Passed_SubmissionsArr = array(), $selectedRangeVal = array(), $surveyName = '', $qID = '', $fromIndividualQuestion = false,$exportAS = '') {
    global $db;
    $removebaleFile = array();
    $GF_QueLogic_Passed_Submissions = $GF_QueLogic_Passed_SubmissionsArr['accesible_submissions'];
    $total_submitted_que = $GF_QueLogic_Passed_SubmissionsArr['total_send_survey'];
    $retunrChartData = getQuestionWiseTrendExportReportData($survey_id, $survey_type, $GF_QueLogic_Passed_Submissions, $selectedRangeVal, $qID, $fromIndividualQuestion);
    $AnsweredAndSkippedPerson = getAnswerSubmissionAnsweredAndSkipped($survey_id, $survey_type, $total_submitted_que, '', $GF_QueLogic_Passed_Submissions);
    $rowDataArray = array();
    $rowDataArray['surveyTitle'] = $surveyName;
    $rowDataArray['totalResponse'] = $total_submitted_que;
    $rowDataArray['trend'] = 'trend' ;
    $choiceQType = array('check-box', 'radio-button', 'dropdownlist', 'multiselectlist', 'boolean', 'netpromoterscore', 'emojis', 'scale', 'rating', 'matrix');
    $pdfHtml = '';
    $pdfHtml .= getCommonHeaderHtmlStructure($rowDataArray);
    $question_sequence = 1;
    foreach ($retunrChartData as $qID => $tableStructureDataArray) {
        $q = "SELECT
                bc_survey_questions.name,
                question_type,
                question_sequence,
                bc_survey_pages.page_sequence
              FROM
                bc_survey_questions
              LEFT JOIN
                bc_survey_bc_survey_questions_c ON bc_survey_bc_survey_questions_c.bc_survey_bc_survey_questionsbc_survey_questions_idb = bc_survey_questions.id AND bc_survey_questions.deleted = 0 AND bc_survey_bc_survey_questions_c.deleted = 0
              LEFT JOIN
                bc_survey_pages_bc_survey_questions_c ON bc_survey_pages_bc_survey_questions_c.bc_survey_pages_bc_survey_questionsbc_survey_questions_idb = bc_survey_questions.id AND bc_survey_pages_bc_survey_questions_c.deleted = 0
              LEFT JOIN
                bc_survey_pages ON bc_survey_pages.id = bc_survey_pages_bc_survey_questions_c.bc_survey_pages_bc_survey_questionsbc_survey_pages_ida AND bc_survey_pages.deleted = 0
              WHERE
                bc_survey_bc_survey_questions_c.bc_survey_bc_survey_questionsbc_survey_ida = '{$survey_id}' and bc_survey_questions.id = '{$qID}'
              ORDER BY
                bc_survey_pages.page_sequence,
                bc_survey_questions.question_sequence ASC";
        $runQ = $db->query($q);
        $qDataArr = $db->fetchByAssoc($runQ);
        $quetitle = $qDataArr['name'];
        $question_type = $qDataArr['question_type'];
        if (in_array($question_type, $choiceQType)) {
            $chartImg = $questionPDFData[$qID]['chartImg'];
            $rowDataArray['quetitle'] = $quetitle;
            $rowDataArray['qSeq'] = $question_sequence;
            $rowDataArray['answeredCount'] = $AnsweredAndSkippedPerson[$qID]['answered'];
            $rowDataArray['skippedCount'] = $AnsweredAndSkippedPerson[$qID]['skipped'];
            $rowDataArray['trendDataArra'] = $tableStructureDataArray['trendQuestionTableData'];
            $rowDataArray['fromIndividualQuestion'] = $fromIndividualQuestion;
            $rowDataArray['exportAS'] = $exportAS;
            if ($fromIndividualQuestion && $exportAS == 'image') {
                $rowDataArray['path_Img'] = $chartImg;
            } else {
                $returnDataPie = uploadExportReportImages($chartImg);
                $pieID = $returnDataPie['ID'];
                $pie_final_ext = $returnDataPie['final_ext'];
                $path_pie = "upload/$pieID" . $pie_final_ext;
                if (SugarAutoLoader::fileExists($path_pie)) {
                    $removebaleFile[] = $path_pie;
                    $rowDataArray['path_Img'] = $path_pie;
                }
            }

            $pdfHtml .= getTrendTableHtmlStructure($rowDataArray);
            $question_sequence++;
        }
    }
    if ($fromIndividualQuestion) {
        return $pdfHtml;
    } else {
        generateExportReportInPdf($surveyName, $pdfHtml, $removebaleFile);
    }
}

function exportQuestionNormalReportDataAsPDF($questionPDFData = array(), $survey_id = '', $survey_type = '', $GF_QueLogic_Passed_SubmissionsArr = array(), $surveyName = '', $qID = '', $fromIndividualQuestion = false, $exportAS = '') {
    $removebaleFile = array();
    $GF_QueLogic_Passed_Submissions = $GF_QueLogic_Passed_SubmissionsArr['accesible_submissions'];
    $total_submitted_que = $GF_QueLogic_Passed_SubmissionsArr['total_send_survey'];
    $pdfHtml = '';
    $rowDataArray = array();
    $choiceQType = array('check-box', 'radio-button', 'dropdownlist', 'multiselectlist', 'boolean', 'netpromoterscore', 'emojis', 'scale', 'rating');
    $textType = array('textbox', 'commentbox', 'date-time', 'contact-information');
    $matrixChoiceQType = array('matrix');
    $tableStructureDataMainArray = getQuestionWiseExportReportData($survey_id, $survey_type, $total_submitted_que, $GF_QueLogic_Passed_Submissions, $qID, $fromIndividualQuestion);
    $rowDataArray['surveyTitle'] = $surveyName;
    $rowDataArray['totalResponse'] = $total_submitted_que;
    $rowDataArray['showEndBR'] = true;
    $rowDataArray['exportAS'] = $exportAS;
    $pdfHtml .= getCommonHeaderHtmlStructure($rowDataArray);
    $question_sequence = 1;
    $length = count($tableStructureDataMainArray);
    foreach ($tableStructureDataMainArray as $qID => $tableStructureDataArray) {
        if ($length == $question_sequence) {
            $rowDataArray['showEndBR'] = false;
        }
        $chartImg = $questionPDFData[$qID]['chartImg'];
        $statsEnable = ($questionPDFData[$qID]['stats'] == 'show') ? true : false;
        if (in_array($tableStructureDataArray['tableStrucutureDataArray']['qType'], $matrixChoiceQType)) {
            $rowDataArray['statsColCount'] = $tableStructureDataArray['tableStrucutureDataArray']['tableData']['columnStatsCount'];
            unset($tableStructureDataArray['tableStrucutureDataArray']['tableData']['columnStatsCount']);
            $rowDataArray['quetitle'] = $tableStructureDataArray['tableStrucutureDataArray']['quetitle'];
            $rowDataArray['answeredCount'] = $tableStructureDataArray['tableStrucutureDataArray']['answered'];
            $rowDataArray['skippedCount'] = $tableStructureDataArray['tableStrucutureDataArray']['skipped'];
            $rowDataArray['matrixDataArra'] = $tableStructureDataArray['tableStrucutureDataArray']['tableData'];
            $rowDataArray['qSeq'] = $question_sequence;
            $rowDataArray['enable_scoring'] = $tableStructureDataArray['tableStrucutureDataArray']['enable_scoring'];
            $rowDataArray['statsDataArra'] = $tableStructureDataArray['tableStrucutureDataArray']['statsDataArra'][$qID];
            $rowDataArray['statsEnable'] = $statsEnable;
            $rowDataArray['fromIndividualQuestion'] = $fromIndividualQuestion;
            if ($fromIndividualQuestion && $exportAS == 'image') {
                $rowDataArray['path_Img'] = $chartImg;
            } else {
                $returnDataPie = uploadExportReportImages($chartImg);
                $pieID = $returnDataPie['ID'];
                $pie_final_ext = $returnDataPie['final_ext'];
                $path_pie = "upload/$pieID" . $pie_final_ext;
                if (SugarAutoLoader::fileExists($path_pie)) {
                    $removebaleFile[] = $path_pie;
                    $rowDataArray['path_Img'] = $path_pie;
                }
            }
            $pdfHtml .= getMatrixHtmlStructure($rowDataArray);
        } else if (in_array($tableStructureDataArray['tableStrucutureDataArray']['qType'], $choiceQType)) {
            $rowDataArray['statsColCount'] = $tableStructureDataArray['tableStrucutureDataArray']['tableData']['columnStatsCount'][$qID];
            unset($tableStructureDataArray['tableStrucutureDataArray']['tableData']['columnStatsCount'][$qID]);
            $rowDataArray['quetitle'] = $tableStructureDataArray['tableStrucutureDataArray']['quetitle'];
            $rowDataArray['answeredCount'] = $tableStructureDataArray['tableStrucutureDataArray']['answered'];
            $rowDataArray['skippedCount'] = $tableStructureDataArray['tableStrucutureDataArray']['skipped'];
            $rowDataArray['choiceDataArra'] = $tableStructureDataArray['tableStrucutureDataArray']['tableData'][$qID];
            $rowDataArray['qSeq'] = $question_sequence;
            $rowDataArray['base_score'] = $tableStructureDataArray['tableStrucutureDataArray']['base_score'];
            $rowDataArray['average_score'] = $tableStructureDataArray['tableStrucutureDataArray']['average_score'];
            $rowDataArray['enable_scoring'] = $tableStructureDataArray['tableStrucutureDataArray']['enable_scoring'];
            $rowDataArray['statsDataArra'] = $tableStructureDataArray['tableStrucutureDataArray']['statsDataArra'][$qID];
            $rowDataArray['qType'] = $tableStructureDataArray['tableStrucutureDataArray']['qType'];
            $rowDataArray['statsEnable'] = $statsEnable;
            $rowDataArray['fromIndividualQuestion'] = $fromIndividualQuestion;
            if ($fromIndividualQuestion && $exportAS == 'image') {
                $rowDataArray['path_Img'] = $chartImg;
            } else {
                $returnDataPie = uploadExportReportImages($chartImg);
                $pieID = $returnDataPie['ID'];
                $pie_final_ext = $returnDataPie['final_ext'];
                $path_pie = "upload/$pieID" . $pie_final_ext;
                if (SugarAutoLoader::fileExists($path_pie)) {
                    $removebaleFile[] = $path_pie;
                    $rowDataArray['path_Img'] = $path_pie;
                }
            }
            $pdfHtml .= getChoiceTypeHtmlStructure($rowDataArray);
        } else if (in_array($tableStructureDataArray['tableStrucutureDataArray']['qType'], $textType)) {
            $rowDataArray['quetitle'] = $tableStructureDataArray['tableStrucutureDataArray']['quetitle'];
            $rowDataArray['answeredCount'] = $tableStructureDataArray['tableStrucutureDataArray']['answered'];
            $rowDataArray['skippedCount'] = $tableStructureDataArray['tableStrucutureDataArray']['skipped'];
            $rowDataArray['nonchoiceDataArra'] = $tableStructureDataArray['tableStrucutureDataArray']['tableData'];
            $rowDataArray['qSeq'] = $question_sequence;
            $rowDataArray['fromIndividualQuestion'] = $fromIndividualQuestion;
            $rowDataArray['qType'] = $tableStructureDataArray['tableStrucutureDataArray']['qType'];
            $pdfHtml .= getNonChoiceTypeHtmlStructure($rowDataArray);
        }
        $question_sequence++;
    }
    //  echo $pdfHtml;
    // exit;
    if ($fromIndividualQuestion) {
        return $pdfHtml;
    } else {
        generateExportReportInPdf($surveyName, $pdfHtml, $removebaleFile);
    }
}

function generateExportReportInPdf($surveyName, $pdfHtml, $removebaleFile = array()) {
    require_once 'vendor/tcpdf/tcpdf.php';
    require_once 'vendor/tcpdf/config/lang/eng.php';
    require_once('include/upload_file.php');
    $UploadStream = new UploadStream();

// create new PDF document
    $pdf = new TCPDF('p', 'mm', 'A4', true, 'UTF-8', false);

// set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->setLanguageArray($l);

    $pdf->SetFont('helvetica', '', 11);
    $pdf->AddPage();
    $pdf->SetTitle($surveyName);
    $pdf->writeHTML($pdfHtml, true, false, false, false, '');
    ob_clean();
    trim($surveyName);
    $pdf->Output($surveyName . '.pdf', 'D');
    foreach($removebaleFile as $file){
        $UploadStream->unlink($file);
    }
}

function getAllQuestionExportData($report_type = '', $survey_id, $exportReport = '', $exportBy = '', $exportAs = '', $statustype = '', $selectedRange = array(), $returnData = array()) {
    $submtData = array();
    if ($report_type == 'status' && $exportReport == 'normal') {
        $GF_QueLogic_Passed_Submissions = $returnData['accesible_submissionsAll'];
    } else {
    $GF_QueLogic_Passed_Submissions = $returnData['accesible_submissions'];
    }

    $total_submitted = $returnData['total_send_survey'];
    if ($report_type == 'question' && $exportAs == 'pdf' && $exportReport == 'normal') {
        $submtData = getQuestionWiseExportReportData($survey_id, $statustype, $total_submitted, $GF_QueLogic_Passed_Submissions,'',false);
    } else {
        $submtData = getExportReportData($report_type, $survey_id, $exportReport, $exportBy, $exportAs, $statustype, $selectedRange, $GF_QueLogic_Passed_Submissions);
        if ($report_type == 'question' && $exportReport == 'normal') {
            $submitDataArry = array();
            $submitted_question_obj = new bc_survey_submit_question();
// To Improve Performance While Exporting report from Survey Report.
// By Biztech. 
            foreach ($submtData as $sbmtId => $sbmtData) {
                $submitDataArry = $submitted_question_obj->custom_retrieve_by_string_fields(array('survey_ID' => $survey_id, 'submission_id' => $sbmtId));

                $submtData[$sbmtId]['Response'] = $submitDataArry;
                unset($submtData[$sbmtId]['module_id']);
                unset($submtData[$sbmtId]['submission_id']);
            }
        }
    }
    return $submtData;
}

function getUserAccessibleRecordsData($survey_id = '', $status_type, $gf_filter_by, $global_filter = array(), $GF_saved_question_logic = array()) {
    require_once 'custom/include/utilsfunction.php';
    require_once('include/SugarQuery/SugarQuery.php');
    $returnData = array();
    $query = new SugarQuery();
    $query->from(BeanFactory::getBean('bc_survey_submission'));
    $query->join('bc_survey_submission_bc_survey', array('alias' => 'bc_survey'));
// select fields
//$query->select->fieldRaw("COUNT(bc_survey_submission.id)", "total_send_survey");
    $query->select->fieldRaw("target_parent_id", "target_parent_id");
    $query->select->fieldRaw("target_parent_type", "target_parent_type");
    $query->select->fieldRaw("status", "status");
    $query->select->fieldRaw("submission_date", "submission_date");
    $query->select->fieldRaw("bc_survey_submission.id", "submission_id");
// where condition
    if (isset($status_type) && $status_type == 'email') {
        $query->where()->equals('bc_survey_submission.submission_type', 'Email');
    } else if (isset($status_type) && $status_type == 'openended') {
        $query->where()->equals('bc_survey_submission.submission_type', 'Open Ended');
    } else {
        
    }
    $query->where()->equals('bc_survey.id', $survey_id);
    $result_total_send_survey = $query->execute();

// Role Compatibility :: START
    $total_send_survey = 0;
    $accesible_submissions = array();
    $accesible_submissionsAll = array();
    $GF_QueLogic_Passed_Submissions = array();
    foreach ($result_total_send_survey as $totalSend) {
        if ($totalSend['status'] == 'Submitted') {
// Global filter :: START
            $totalSend['submission_date'] = explode(' ', $totalSend['submission_date'])[0];
            $istrue = false;
            if (!empty($global_filter['gf_start_date']) && empty($global_filter['gf_end_date']) && $totalSend['submission_date'] >= $global_filter['gf_start_date']) {
                $istrue = true;
            } else if (!empty($global_filter['gf_end_date']) && empty($global_filter['gf_start_date']) && $totalSend['submission_date'] <= $global_filter['gf_end_date']) {
                $istrue = true;
            } else if (!empty($global_filter['gf_start_date']) && !empty($global_filter['gf_end_date']) && $totalSend['submission_date'] >= $global_filter['gf_start_date'] && $totalSend['submission_date'] <= $global_filter['gf_end_date']) {
                $istrue = true;
            } else if (empty($global_filter['gf_start_date']) && empty($global_filter['gf_end_date'])) {
                $istrue = true;
            }

// check global filter by question logic
            if ($istrue) {
                $isEmptyGF_saved_question_logic = true;
                $resultAll_GF_QueLogic_status = array();
                foreach ($GF_saved_question_logic as $k => $global_logic_data) {
                    if ($global_logic_data->que_id != "0") {
                        $GF_QueLogic_status = getGlobalFilterByQuestionLogicSubmissions($survey_id, $totalSend['submission_id'], $global_logic_data);
                        if ($global_filter['GF_match_case'] == 'OR') {
                            if ($GF_QueLogic_status == true) {
                                $GF_QueLogic_Passed_Submissions[] = $totalSend['submission_id'];
                            }
                        }
                        $resultAll_GF_QueLogic_status[] = $GF_QueLogic_status;
                    }
                    $isEmptyGF_saved_question_logic = false;
                }
                if (!in_array(false, $resultAll_GF_QueLogic_status)) {
                    $GF_QueLogic_Passed_Submissions[] = $totalSend['submission_id'];
                }
                if ($isEmptyGF_saved_question_logic) {
                    $gf_filter_by = '';
                    $global_filter['gf_filter_by'] = '';
                }
            }
            if ($istrue && (($gf_filter_by == 'by_question_logic' && in_array($totalSend['submission_id'], $GF_QueLogic_Passed_Submissions)) || $gf_filter_by == 'by_date' || empty($gf_filter_by))) {
                $oAclFocus = array();
                $isAccessible = true;
                if (!empty($totalSend['target_parent_id'])) {
                    $oAclFocus = BeanFactory::getBean($totalSend['target_parent_type'], $totalSend['target_parent_id']);
                } else { //  web link submission then no role compatibility checking
                    if (in_array($totalSend['submission_id'], $GF_QueLogic_Passed_Submissions)) {
                        $accesible_submissions[] = $totalSend["submission_id"];
                        $accesible_submissionsAll[] = $totalSend["submission_id"];
                    } else {
                        $isAccessible = false;
                    }
                }

                if (!empty($oAclFocus)) {
                    if (!empty($oAclFocus->id)) {
                        $isAccessible = true;
                        $accesible_submissions[] = $totalSend["submission_id"];
                    $accesible_submissionsAll[] = $totalSend["submission_id"];
                    } else {
                        $isAccessible = false;
                    }
                }
                if ($isAccessible) {
                    $total_send_survey = $total_send_survey + 1; // total send out survey
                }
            }
        }
        if ($totalSend['status'] != 'Submitted' || $isAccessible) {
            $oAclFocus = array();
            if ($isAccessible) {
                $accesible_submissionsAll[] = $totalSend["submission_id"];
            } else {
                if (!empty($totalSend['target_parent_id'])) {
                    $oAclFocus = BeanFactory::getBean($totalSend['target_parent_type'], $totalSend['target_parent_id']);
                } else { //  web link submission then no role compatibility checking
                    $accesible_submissionsAll[] = $totalSend["submission_id"];
                }
                if (!empty($oAclFocus)) {
                    if (!empty($oAclFocus->id)) {
                        $accesible_submissionsAll[] = $totalSend["submission_id"];
                    }
                }
            }
        }
    }
    $returnData['accesible_submissions'] = $accesible_submissions;
    $returnData['accesible_submissionsAll'] = $accesible_submissionsAll;
    $returnData['total_send_survey'] = $total_send_survey;
    return $returnData;
}

function getAnswerSubmissionCountExportReport($que_id, $surveyID = '', $status_type = '', $GF_QueLogic_Passed_Submissions = array()) {
    global $db;
    $submissionTypeArray = array();
    switch ($status_type) {
        case 'openended':
            $submissionTypeArray = array('Open Ended');
            break;
        case 'email':
            $submissionTypeArray = array('Email');
            break;
        case 'combined':
            $submissionTypeArray = array('Email', 'Open Ended');
            break;
    }
    $submissionTypeImplodeVal = implode("','", $submissionTypeArray);
    $submissionIds = implode("','", $GF_QueLogic_Passed_Submissions);
    $selectEachAnswerSubCount = "SELECT 
                                bc_survey_submit_answer_calculation.survey_receiver_id AS recId,
                                bc_survey_submit_answer_calculation.question_id AS queId,
                                bc_survey_submit_answer_calculation.submit_answer_id AS ansSubmitCount,
                                bc_survey_submit_answer_calculation.answer_type AS ans_type,
                                bc_survey_submit_answer_calculation.submission_id AS sub_id,
                                bc_survey_submission.submission_date
                            FROM
                                bc_survey_submit_answer_calculation
                                left join bc_survey_submission on bc_survey_submission.id = bc_survey_submit_answer_calculation.submission_id
                                and bc_survey_submission.deleted = 0
                            WHERE
                                bc_survey_submit_answer_calculation.sent_survey_id = '{$surveyID}'
                                and bc_survey_submission.submission_type in ('{$submissionTypeImplodeVal}')
                                    and bc_survey_submit_answer_calculation.submit_answer_id != ''
                                    and bc_survey_submit_answer_calculation.question_id = '{$que_id}'
                                and bc_survey_submission.id in ('{$submissionIds}')
    ";
    $runQuery = $db->query($selectEachAnswerSubCount);
    $submit_answer_Array = array();
    $is_matrix = false;
    $matri_all_count_array = array();
    $countEachAns = array();
    $scale_answer_Array = array();
    $scale_Count = array();
    while ($resultCountData = $db->fetchByAssoc($runQuery)) {
        if (($status_type == 'openended' && str_split($resultCountData['recId'], 8)[0] == 'Web Link') || ($status_type == 'email' && str_split($resultCountData['recId'], 8)[0] != 'Web Link') || ($status_type == 'combined' || $status_type == '')) {
            $explodeData = explode(',', $resultCountData['ansSubmitCount']);
            if ($resultCountData['ans_type'] == 'matrix') {
                $qid = $resultCountData['queId'];
                $is_matrix = true;
                if (is_array($explodeData)) {
                    foreach ($explodeData as $ansID) {
                        if (!empty($ansID)) {
                            $matrix = explode('_', $ansID);

                            $count = (isset($matri_all_count_array[$qid][$matrix[0]][$matrix[1]])) ? $matri_all_count_array[$qid][$matrix[0]][$matrix[1]] : 0;
                            $count++;
                            $matri_all_count_array[$qid][$matrix[0]][$matrix[1]] = $count;
                        }
                    }
                    $countEachAns['matrix'] = $matri_all_count_array;
                }
            }

            if ($resultCountData['ans_type'] == 'scale') {
                foreach ($explodeData as $k => $data) {
                    if ($data != '') {
                        $scale_answer_Array[] = $data;
                    }
                }
                $scale_Count = array_count_values($scale_answer_Array);
            }
            if ($resultCountData['ans_type'] != 'scale') {
                if (is_array($explodeData)) {
                    $submit_answer_Array = array_merge($submit_answer_Array, $explodeData);
                } else {
                    $submit_answer_Array[] = $explodeData;
                }
            }
        }
    }
    $GLOBALS['log']->fatal('This is the result : $countEachAns for scale', print_r($countEachAns, 1));
    $countEachAnsData = array();
    $countEachAnsData = array_count_values($submit_answer_Array);
    $countEachAnsData = $countEachAnsData + $countEachAns + $scale_Count;
    return $countEachAnsData;
}
/*
 * Save_bc_submission_history_individual :: Saves submitted answer with submission detail in History table
 */
function Save_bc_submission_history_individual($submit_details) {
    global $db;
    $id = create_guid();
    $date_entered = $submit_details['date_entered'];
    $submission_id = $submit_details['submission_id'];
    $survey_id = $submit_details['survey_id'];
    $question_id = $submit_details['question_id'];
    $question_type = $submit_details['question_type'];
    $submitted_answer = $submit_details['submitted_answer'];
    $submission_date = $submit_details['submission_date'];
    $resubmit_count = $submit_details['resubmit_count'];

    // check whether submitted answer is empty or not
   // if (!empty($submitted_answer)) {

        // check whether duplicate entry or not
        $selQry = "SELECT id FROM bc_submission_history_individual WHERE submission_id='$submission_id' AND question_id='$question_id' AND submission_date = '$submission_date' ";
        $resultSel = $db->query($selQry);
        
        // If not a duplicate entry then create new one record in History Table
        if ($resultSel->num_rows == 0) {
        $submitted_answer = addslashes($submitted_answer);
        if ($db->dbType == "mssql") {
            $insQry = "INSERT into bc_submission_history_individual 
            (id,date_entered,submission_id,survey_id,question_id,question_type,submitted_answer,submission_date,resubmit_count) 
            VALUES ('{$id}',
                '{$date_entered}',
                '{$submission_id}',
                '{$survey_id}',
                '{$question_id}',
                '{$question_type}',
                '{$submitted_answer}',
                '{$submission_date}',
                '{$resubmit_count}'
            )
            ";
        } else {
        $insQry = 'INSERT into bc_submission_history_individual 
            (id,date_entered,submission_id,survey_id,question_id,question_type,submitted_answer,submission_date,resubmit_count) 
            VALUES ("' . $id . '",
                "' . $date_entered . '",
                "' . $submission_id . '",
                "' . $survey_id . '",
                "' . $question_id . '",
                "' . $question_type . '",
                "' . $submitted_answer . '",
                "' . $submission_date . '",
                "' . $resubmit_count . '"
            )
            ';
        }
            $db->query($insQry);
            return true;
        }
   // }
    return false;
}
