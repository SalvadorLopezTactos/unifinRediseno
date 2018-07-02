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

namespace Sugarcrm\Sugarcrm\JobQueue\Helper;

/**
 * Class Resolution
 * @package JobQueue
 */
class Resolution
{
    /**
     * Check if it's possible to change resolution for passed job.
     * Backlog: Pause - queued and running parent. Resume - partial.
     * Cancel - queued, partial(paused) and running parent.
     *
     * @param string $from
     * @param string $to Resolution.
     * @return bool False if resolution cannot be changed.
     */
    public function checkDependencies($from, $to)
    {
        if (!$from || $from == $to) {
            return true;
        }
        switch ($to) {
            case \SchedulersJob::JOB_CANCELLED:
                if (
                    $from == \SchedulersJob::JOB_PENDING ||
                    $from == \SchedulersJob::JOB_PARTIAL ||
                    $from == \SchedulersJob::JOB_RUNNING
                ) {
                    return true;
                }
                break;
            case \SchedulersJob::JOB_PARTIAL:
                if ($from == \SchedulersJob::JOB_PENDING) {
                    return true;
                }
                break;
            case \SchedulersJob::JOB_PENDING:
                if ($from == \SchedulersJob::JOB_RUNNING) {
                    return false;
                }
                // Resume.
                if ($from == \SchedulersJob::JOB_PARTIAL) {
                    return true;
                }
                break;
            case \SchedulersJob::JOB_RUNNING:
                if (
                    $from == \SchedulersJob::JOB_PENDING ||
                    $from == \SchedulersJob::JOB_PARTIAL
                ) {
                    return true;
                }
                break;
            case \SchedulersJob::JOB_FAILURE:
                return true;
                break;
            case \SchedulersJob::JOB_SUCCESS:
                if ($from == \SchedulersJob::JOB_RUNNING) {
                    return true;
                }
                break;
        }
        return false;
    }

    /**
     * Return a proper status by resolution.
     *
     * @param string $resolution SchedulersJobs resolution.
     * @return string Status.
     */
    public function getStatus($resolution)
    {
        switch ($resolution) {
            case \SchedulersJob::JOB_PENDING:
            case \SchedulersJob::JOB_PARTIAL:
                return \SchedulersJob::JOB_STATUS_QUEUED;
                break;
            case \SchedulersJob::JOB_RUNNING:
                return \SchedulersJob::JOB_STATUS_RUNNING;
                break;
            default:
                return \SchedulersJob::JOB_STATUS_DONE;
                break;
        }
    }

    /**
     * Modifies a job with a particular status according to passed resolution.
     * Triggers save.
     *
     * @param \SchedulersJob $job
     * @param string $resolution
     * @return boolean False if resolution cannot be changed.
     */
    public function setResolution(\SchedulersJob $job, $resolution)
    {
        if (!$this->checkDependencies($job->resolution, $resolution)) {
            return false;
        }
        $status = $this->getStatus($resolution);
        if ($status == \SchedulersJob::JOB_RUNNING) {
            $job->percent_complete = 0;
        }
        $job->status = $status;
        $job->resolution = $resolution;
        return $job->save();
    }
}
