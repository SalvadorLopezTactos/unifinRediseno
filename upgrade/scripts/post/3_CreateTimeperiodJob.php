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
 * Create a job for updating time periods
 */
class SugarUpgradeCreateTimeperiodJob extends UpgradeScript
{
    public $order = 3000;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        if (!version_compare($this->from_version, '6.7.0', '<'))
        {
            // only for upgrades from below 6.7
            return;
        }
        // add class::SugarJobCreateNextTimePeriod job if not there
        $job = new Scheduler();
        $job->retrieve_by_string_fields(array("job" => 'class::SugarJobCreateNextTimePeriod'));
        if(empty($job->id)) {
                $job->name               = translate('LBL_OOTB_CREATE_NEXT_TIMEPERIOD', 'Schedulers');
                $job->job                = 'class::SugarJobCreateNextTimePeriod';
                $job->date_time_start    = '2013-01-01 00:00:01';
                $job->date_time_end      = '2030-12-31 23:59:59';
                $job->job_interval       = '0::23::*::*::*';
                $job->status             = 'Active';
                $job->created_by         = '1';
                $job->modified_user_id   = '1';
                $job->catch_up           = '0';
                $job->save();
        }
    }
}
