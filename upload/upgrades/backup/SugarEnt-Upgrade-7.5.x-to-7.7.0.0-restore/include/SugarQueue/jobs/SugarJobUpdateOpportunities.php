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

require_once('modules/SchedulersJobs/SchedulersJob.php');

/**
 * SugarJobUpdateOpportunities.php
 *
 * Class to run a job which should upgrade every old opp with commit stage, date_closed_timestamp,
 * best/worst cases and related product
 */
class SugarJobUpdateOpportunities implements RunnableSchedulerJob {

    /**
     * @var SchedulersJob
     */
    protected $job;

    /**
     * @param SchedulersJob $job
     */
    public function setJob(SchedulersJob $job)
    {
        $this->job = $job;
    }

    /**
     * @param $data
     * @return bool
     */
    public function run($data)
    {
        $this->job->runnable_ran = true;
        $this->job->runnable_data = $data;

        $keys = json_decode(html_entity_decode($data), true);

        foreach ($keys as $key) {
            /* @var $opp Opportunity */
            $opp = BeanFactory::getBean('Opportunities');
            $opp->retrieve($key);
            $opp->save(false);
        }

        $this->job->succeedJob();
        return true;
    }
}
