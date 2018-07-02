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

namespace Sugarcrm\Sugarcrm\JobQueue\Observer;

use Sugarcrm\Sugarcrm\JobQueue\Exception\UnexpectedResolutionException;
use Sugarcrm\Sugarcrm\JobQueue\Helper\Child;
use Sugarcrm\Sugarcrm\JobQueue\Helper\Producer as ParentHelper;
use Sugarcrm\Sugarcrm\JobQueue\Workload\WorkloadInterface;

/**
 * Class State
 * @package JobQueue
 */
class State implements ObserverInterface
{
    /**
     * Stub.
     * {@inheritdoc}
     */
    public function onAdd(WorkloadInterface $workload)
    {
    }

    /**
     * Check job status and parent job actuality.
     *
     * {@inheritdoc}
     * @throws UnexpectedResolutionException
     */
    public function onRun(WorkloadInterface $workload)
    {
        $job = \BeanFactory::getBean('SchedulersJobs', $workload->getAttribute('dbId'));
        if (!$job->id) {
            \LoggerManager::getLogger()->info('Cannot get bean by dbId.');
            return;
        }

        if (
            $job->resolution == \SchedulersJob::JOB_CANCELLED ||
            $job->resolution == \SchedulersJob::JOB_PARTIAL
        ) {
            throw new UnexpectedResolutionException($job->resolution, "The job '{$job->id}' has been stopped.");
        }

        if ($job->job_group) {
            $childHandler = new Child($job);
            if (!$childHandler->isParentActual()) {
                throw new UnexpectedResolutionException(
                    \SchedulersJob::JOB_CANCELLED,
                    "The parent job for the {$job->id}' task is already done."
                );
            };
        }
    }

    /**
     * Resolve parent and child tasks.
     * {@inheritdoc}
     */
    public function onResolve(WorkloadInterface $workload, $resolution)
    {
        $job = \BeanFactory::getBean('SchedulersJobs', $workload->getAttribute('dbId'));
        if (!$job->id) {
            \LoggerManager::getLogger()->info('Cannot get bean by dbId.');
            return;
        }
        if ($job->job_group) {
            $parentHandler = new ParentHelper(\BeanFactory::getBean('SchedulersJobs', $job->job_group));
            $parentHandler->resolve();
        } else {
            $parentHandler = new ParentHelper($job);
            if ($resolution == \SchedulersJob::JOB_CANCELLED || $resolution == \SchedulersJob::JOB_FAILURE) {
                $parentHandler->resolveChildren($resolution);
            }
            $parentHandler->resolve();
        }
    }
}
