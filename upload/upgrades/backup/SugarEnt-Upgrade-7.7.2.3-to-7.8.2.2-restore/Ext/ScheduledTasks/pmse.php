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

if (empty($job_strings)) {
    $job_strings = array();
}

array_push($job_strings, 'PMSEEngineCron');

if (!function_exists("PMSEEngineCron")) {
    function PMSEEngineCron()
    {
        require_once("modules/pmse_Inbox/engine/PMSEHandlers/PMSEHookHandler.php");

//      Calls and Meetings modules uses this session variable on save function,
//      in order to do not send notification email to the owner. (within Process Author cron)
        $_SESSION['process_author_cron'] = true;
        $hookHandler = new PMSEHookHandler();
        $hookHandler->executeCron();
        unset($_SESSION['process_author_cron']);

        return true;
    }
}

if (!function_exists("PMSEJobRun")) {
    function PMSEJobRun($job)
    {
        require_once 'modules/pmse_Inbox/engine/PMSEFlowRouter.php';
        require_once 'modules/pmse_Inbox/engine/PMSEHandlers/PMSECaseFlowHandler.php';

        if (!empty($job->data)) {
            $flowData = (array)json_decode($job->data);
            $externalAction = 'RESUME_EXECUTION';
            $jobQueueHandler = new PMSEJobQueueHandler();

            $jobQueueHandler->executeRequest($flowData, false, null, $externalAction);
        }

        return true;
    }
}

