<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

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

require_once 'modules/pmse_Inbox/engine/PMSEHandlers/PMSEBeanHandler.php';
require_once 'include/workflow/alert_utils.php';
require_once 'modules/pmse_Inbox/engine/PMSERelatedModule.php';

class PMSEEmailHandler
{

    /**
     *
     * @var PMSEBeanHandler
     */
    private $beanUtils;

    /**
     *
     * @var Administration
     */
    private $admin;

    /**
     *
     * @var type
     */
    private $locale;

    /**
     *
     * @var PMSELogger
     */
    private $logger;

    /**
     * @var PMSERelatedModule
     */
    private $pmseRelatedModule;

    /**
     * @global beanList
     */
    protected $beanList;

    /**
     *
     * @global type $locale
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        global $locale, $beanList;
        $this->beanList = $beanList;
        $this->locale = $locale;
        $this->beanUtils = new PMSEBeanHandler();
        $this->logger = PMSELogger::getInstance();
        $this->admin = new Administration();
        $this->pmseRelatedModule = new PMSERelatedModule();
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getBeanUtils()
    {
        return $this->beanUtils;
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     *
     * @param Administration $admin
     */
    public function setAdmin(Administration $admin)
    {
        $this->admin = $admin;
    }

    /**
     *
     * @param type $beanUtils
     * @codeCoverageIgnore
     */
    public function setBeanUtils($beanUtils)
    {
        $this->beanUtils = $beanUtils;
    }

    /**
     *
     * @param type $locale
     * @codeCoverageIgnore
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     *
     * @param type $logger
     * @codeCoverageIgnore
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     *
     * @param type $param
     * @return \SugarPHPMailer
     * @codeCoverageIgnore
     */
    public function retrieveSugarPHPMailer()
    {
        return new SugarPHPMailer();
    }

    /**
     *
     * @param type $module
     * @param type $beanId
     * @return type
     * @codeCoverageIgnore
     */
    public function retrieveBean($module, $beanId = null)
    {
        return BeanFactory::getBean($module, $beanId);
    }

    /**
     * Get the email data stored in a json string and also processes and parses the variable data.
     * @param type $bean
     * @param type $json
     * @param type $flowData
     * @return \StdClass
     */
    public function processEmailsFromJson($bean, $json, $flowData)
    {
        $addresses = json_decode($json);
        $result = new StdClass();
        if (isset($addresses->to) && is_array($addresses->to)) {
            $result->to = $this->processEmailsAndExpand($bean, $addresses->to, $flowData);
        }
        if (isset($addresses->cc) && is_array($addresses->cc)) {
            $result->cc = $this->processEmailsAndExpand($bean, $addresses->cc, $flowData);
        }
        if (isset($addresses->bcc) && is_array($addresses->bcc)) {
            $result->bcc = $this->processEmailsAndExpand($bean, $addresses->bcc, $flowData);
        }
        return $result;
    }

    /**
     * Process the email and also obtains the bean data that needs to be inserted in the email object,
     * replacing the variables instances with the actual value.
     * @param type $bean
     * @param type $to
     * @param type $flowData
     * @return \StdClass
     * @codeCoverageIgnore
     */
    public function processEmailsAndExpand($bean, $to, $flowData)
    {
        $res = array();

        $moduleName = $flowData['cas_sugar_module'];
        $object_id = $flowData['cas_sugar_object_id'];

        foreach ($to as $entry) {
            switch (strtoupper($entry->type)) {
                case 'USER':
                    $res = array_merge(
                        $res, $this->processUserEmails($bean, $entry, $flowData)
                    );
                    break;
                case 'TEAM':
                    $res = array_merge(
                        $res, $this->processTeamEmails($bean, $entry, $flowData)
                    );
                    break;
                case 'ROLE':
                    $res = array_merge(
                        $res, $this->processRoleEmails($bean, $entry, $flowData)
                    );
                    break;
                case 'RECIPIENT':
                    $res = array_merge(
                        $res, $this->processRecipientEmails($bean, $entry, $flowData)
                    );
                    break;
                case 'EMAIL':
                    $res = array_merge(
                        $res, $this->processDirectEmails($bean, $entry, $flowData)
                    );
                    break;
            }
        }
        
        return $res;
    }

    public function processUserEmails($bean, $entry, $flowData)
    {
        $res = array();
        $users = array();

        if (!isset($this->beanList[$entry->module])) {
            $bean = $this->pmseRelatedModule->getRelatedModule($bean, $entry->module);
        }
        switch ($entry->value) {
            case 'last_modifier':
                $users[] = $this->getLastModifier($bean);
                break;
            case 'record_creator':
                $users[] = $this->getRecordCreator($bean);
                break;
            case 'is_assignee':
                $users[] = $this->getCurrentAssignee($bean);
                break;
        }        
        foreach ($users as $user) {
            $res = array_merge($res, $this->getUserEmails($user, $entry));
        }
        return $res;
    }
    
    public function getCurrentAssignee($bean)
    {
        $userBean = $this->retrieveBean("Users", $bean->assigned_user_id);
        return $userBean;
    }
    
    public function getRecordCreator($bean)
    {
        $userBean = $this->retrieveBean("Users", $bean->created_by);
        return $userBean;
    }
    
    public function getLastModifier($bean)
    {
        $userBean = $this->retrieveBean("Users", $bean->modified_user_id);
        return $userBean;
    }

    public function getUserEmails($userBean, $entry)
    {
        $res = array();
        $user = $userBean;
        if ($entry->user === 'manager_of') {
            $user = $this->getSupervisor($userBean);
        }
        
        if (isset($user->full_name) && isset($user->email1)) {
            $item = new StdClass();
            $item->name = $user->full_name;
            $item->address = $user->email1;
            $res[] = $item;
        }
        return $res;
    }
    
    public function getSupervisor($user)
    {
        if (isset($user->reports_to_id) && $user->reports_to_id != '') {
            $supervisor = $this->retrieveBean("Users", $user->reports_to_id);
            if (
                isset($supervisor->full_name) && 
                !empty($supervisor->full_name) && 
                isset($supervisor->email1) && 
                !empty($supervisor->email1)
            ) {
                return $supervisor;
            } else {
                return '';
            }
        }
    }
    
    public function processTeamEmails($bean, $entry, $flowData)
    {
        $res = array();
        $team = $this->retrieveBean('Teams',$entry->value); //$beanFactory->getBean('Teams');
        //$response = $team->getById();
        $members = $team->get_team_members();
        foreach ($members as $user) {
            $userBean = $this->retrieveBean("Users", $user->id);
            if (isset($userBean->full_name) && isset($userBean->email1)) {
                $item = new stdClass();
                $item->name = $userBean->full_name;
                $item->address = $userBean->email1;
                $res[] = $item;
            }
        }
        return $res;
    }

    public function processRoleEmails($bean, $entry, $flowData)
    {
        $res = array();
        $role = $this->retrieveBean('ACLRoles', $entry->value);
        $userList = $role->get_linked_beans('users','User');
        foreach ($userList as $user) {
            if (isset($user->full_name) && isset($user->email1)) {
                $item = new stdClass();
                $item->name = $user->full_name;
                $item->address = $user->email1;
                $res[] = $item;
            }
        }
        return $res;
    }

    public function processRecipientEmails($bean, $entry, $flowData)
    {
        $res = array();
        $field = $entry->value;
        $module = $entry->module;

        if (!isset($this->beanList[$module])) {
            $bean = $this->pmseRelatedModule->getRelatedModule($bean, $module);
        }
        if (!empty($bean) && is_object($bean)) {
            $value = $bean->$field;
        } else {
            $value = '';
        }

        $item = new stdClass();
        $item->name = $value;
        $item->address = $value;
        $res[] = $item;
        return $res;
    }

    public function processDirectEmails($bean, $entry, $flowData)
    {
        $res = array();
        $item = new stdClass();
        $item->name = $entry->value;
        $item->address = $entry->value;
        $res[] = $item;
        return $res;
    }
    
    /**
     * filling the mail object with all the administrative settings and configurations
     * @global type $sugar_version
     * @global type $sugar_config
     * @global type $app_list_strings
     * @global type $current_user
     * @param type $mailObject
     */
    public function setupMailObject($mailObject)
    {
        $this->admin->retrieveSettings();
        if ($this->admin->settings['mail_sendtype'] == "SMTP") {
            $mailObject->Mailer = "smtp";
            $mailObject->Host = $this->admin->settings['mail_smtpserver'];
            $mailObject->Port = $this->admin->settings['mail_smtpport'];
            $mailObject->SMTPSecure = '';
            if ($this->admin->settings['mail_smtpssl'] == 1) {
                $mailObject->SMTPSecure = 'ssl';
            }
            if ($this->admin->settings['mail_smtpssl'] == 2) {
                $mailObject->SMTPSecure = 'tls';
            }
            if ($this->admin->settings['mail_smtpauth_req']) {
                $mailObject->SMTPAuth = true;
                $mailObject->Username = $this->admin->settings['mail_smtpuser'];
                $mailObject->Password = $this->admin->settings['mail_smtppass'];
            }
        } else {
            $mailObject->Mailer = 'sendmail';
        }
        $mailObject->From = $this->admin->settings['notify_fromaddress'];
        $mailObject->FromName = (empty($this->admin->settings['notify_fromname'])) ? "" : $this->admin->settings['notify_fromname'];
    }

    /**
     * Send the email based in an email template and with the email data parsed.
     * @param type $moduleName
     * @param type $beanId
     * @param type $addresses
     * @param type $templateId
     * @return type
     */
    public function sendTemplateEmail($moduleName, $beanId, $addresses, $templateId)
    {
        $msgError = '';
        $bean = $this->retrieveBean($moduleName, $beanId);

        $mailObject = $this->retrieveSugarPHPMailer();
        $this->setupMailObject($mailObject);

        $OBCharset = $this->locale->getPrecedentPreference('default_email_charset');

        if (isset($addresses->to)) {
            foreach ($addresses->to as $key => $email) {
                $mailObject->AddAddress($email->address, $this->locale->translateCharsetMIME(trim($email->name), 'UTF-8', $OBCharset));
            }
        } else {
            $msgError = 'addresses field \'TO\' is not defined';
        }

        if (isset($addresses->cc)) {
            foreach ($addresses->cc as $key => $email) {
                $mailObject->AddCC($email->address, $this->locale->translateCharsetMIME(trim($email->name), 'UTF-8', $OBCharset));
            }
        } else {
            $this->logger->info('addresses field \'CC\' is not defined');
        }

        if (isset($addresses->bcc)) {
            foreach ($addresses->bcc as $key => $email) {
                $mailObject->AddBCC($email->address, $this->locale->translateCharsetMIME(trim($email->name), 'UTF-8', $OBCharset));
            }
        } else {
            $this->logger->info('addresses field \'BCC\' is not defined');
        }

        //    $email = trim($this->mergeBeanInTemplate($bean, $addressArray['to'][0][1], false));
        $templateObject = $this->retrieveBean('pmse_Emails_Templates');
        $templateObject->disable_row_level_security = true;

        if (isset($templateId) && $templateId != "") {
            $templateObject->retrieve($templateId);
        } else {
            $msgError = 'template_id is not defined';
        }

        if (isset($templateObject->from_name) && $templateObject->from_name != '') {
            $mailObject->FromName = $templateObject->from_name;
        }

        if (isset($templateObject->from_address) && $templateObject->from_address != '') {
            $mailObject->From = $templateObject->from_address;
        }

        if (isset($templateObject->body) && empty($templateObject->body)) {
            $templateObject->body = strip_tags(from_html($templateObject->body_html));
        } else {
            $this->logger->warning('template body is not defined');
        }

        if (isset($templateObject->body) && isset($templateObject->body_html)) {
            if (!empty($templateObject->body_html)) {
                $mailObject->IsHTML(true);
                $mailObject->Body = from_html($this->beanUtils->mergeBeanInTemplate($bean, $templateObject->body_html));
                $mailObject->AltBody = from_html($this->beanUtils->mergeBeanInTemplate($bean, $templateObject->body));
            } else {
                $mailObject->AltBody = from_html($this->beanUtils->mergeBeanInTemplate($bean, $templateObject->body));
            }
        } else {
            $this->logger->warning('template body_html is not defined');
        }

        if (isset($templateObject->subject)) {
            $mailObject->Subject = from_html($this->beanUtils->mergeBeanInTemplate($bean, $templateObject->subject));
        } else {
            $this->logger->warning('template subject is not defined');
        }

        $mailObject->prepForOutbound();
        $result = $mailObject->Send();

        //if (isset($mailObject->ErrorInfo)) {
        //$this->bpmLog('ERROR', "mail error: " . $mailObject->ErrorInfo);
        //}
        return array('result' => $result, 'ErrorMessage' => $msgError, 'ErrorInfo' => $mailObject->ErrorInfo);
    }

    /**
     * Checks if the primary email address exists
     * @param type $field
     * @param type $bean
     * @param type $historyData
     * @return boolean
     */
    public function doesPrimaryEmailExists($field, $bean, $historyData)
    {
        if ($field->field == 'email_addresses_primary') {
            $preEmail = $bean->emailAddress->getPrimaryAddress('', $bean->id, $bean->module_dir);
            if (empty($preEmail)) {
                //is a new record, it hasn't any email in DB yet
                $emailKey = $this->getPrimaryEmailKeyFromREQUEST($bean);
                $historyData->savePredata($field->field, $_REQUEST[$emailKey]);
                $_REQUEST[$emailKey] = $field->value;
            } else {
                //the record exist in db
                $historyData->savePredata($field->field, $preEmail);
                $this->updateEmails($bean, $field->value);
            }
            return true;
        }
        return false;
    }

    /**
     * Get the primary Key from a request in order to obtain the email id
     * @param type $bean
     * @return type
     */
    public function getPrimaryEmailKeyFromREQUEST($bean)
    {
        $module = $bean->module_dir;
        $widgetCount = 0;
        $moduleItem = '0';

        $widget_id = '';
        foreach ($_REQUEST as $key => $value) {
            if (strpos($key, 'emailAddress') !== false) {
                break;
            }
            $widget_id = $_REQUEST[$module . '_email_widget_id'];
        }

        while (isset($_REQUEST[$module . $widget_id . "emailAddress" . $widgetCount])) {
            if (empty($_REQUEST[$module . $widget_id . "emailAddress" . $widgetCount])) {
                $widgetCount++;
                continue;
            }

            $primaryValue = false;

            $eId = $module . $widget_id;
            if (isset($_REQUEST[$eId . 'emailAddressPrimaryFlag'])) {
                $primaryValue = $_REQUEST[$eId . 'emailAddressPrimaryFlag'];
            } elseif (isset($_REQUEST[$module . 'emailAddressPrimaryFlag'])) {
                $primaryValue = $_REQUEST[$module . 'emailAddressPrimaryFlag'];
            }

            if ($primaryValue) {
                return $eId . 'emailAddress' . $widgetCount;
            }
            $widgetCount++;
        }
        $_REQUEST[$bean->module_dir . '_email_widget_id'] = 0;
        $_REQUEST['emailAddressWidget'] = 1;
        $_REQUEST['useEmailWidget'] = true;
        $emailId = $bean->module_dir . $moduleItem . 'emailAddress';
        $_REQUEST[$emailId . 'PrimaryFlag'] = $emailId . $moduleItem;
        $_REQUEST[$emailId . 'VerifiedFlag' . $moduleItem] = true;
        //$_REQUEST[$emailId . 'VerifiedValue' . $moduleItem] = $myemail;

        return $emailId . $moduleItem;
    }

    /**
     * Update the email data in the REQUEST global object
     * @param type $bean
     * @param type $newEmailAddress
     */
    public function updateEmails($bean, $newEmailAddress)
    {
        //Note.- in the future will be an 'array' of change fields emails
        $moduleItem = '0';
        $addresses = $bean->emailAddress->getAddressesByGUID($bean->id, $bean->module_dir);
        if (sizeof($addresses) > 0) {
            $_REQUEST[$bean->module_dir . '_email_widget_id'] = 0;
            $_REQUEST['emailAddressWidget'] = 1;
            $_REQUEST['useEmailWidget'] = true;
        }
        foreach ($addresses as $item => $data) {
            if (!isset($data['email_address_id']) || !isset($data['primary_address'])) {
                $this->logger->error(' The Email address Id or the primary address flag does not exist in DB');
                continue;
            }
            $emailAddressId = $data['email_address_id'];
            $emailId = $bean->module_dir . $moduleItem . 'emailAddress';
            if (!empty($emailAddressId) && $data['primary_address'] == 1) {
                $_REQUEST[$emailId . 'PrimaryFlag'] = $emailId . $item;
                $_REQUEST[$emailId . $item] = $newEmailAddress;
            } else {
                $_REQUEST[$emailId . $item] = $data['email_address'];
            }
            $_REQUEST[$emailId . 'Id' . $item] = $emailAddressId;
            $_REQUEST[$emailId . 'VerifiedFlag' . $item] = true;
            $_REQUEST[$emailId . 'VerifiedValue' . $item] = $data['email_address'];
            //$upd_query = "UPDATE email_addresses SET email_address='" . $emailAddress . "', email_address_caps='" . mb_strtoupper($emailAddress) . "', date_modified=" . $db->now() . " WHERE id='" . $row['email_address_id'] . "'";
            //$upd_res = $db->Query($upd_query);
            //$this->bpmLog('INFO',  $upd_query . ' result :  ' . print_r($upd_res,true));
        }
    }

}
