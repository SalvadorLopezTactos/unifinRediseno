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

use Sugarcrm\Sugarcrm\JobQueue\Helper\Resolution;
use Sugarcrm\Sugarcrm\JobQueue\Workload\WorkloadInterface;

/**
 * Class Reflection
 * @package JobQueue
 */
class Reflection implements ObserverInterface
{
    /**
     * @var Resolution
     */
    protected $resolutionHelper;

    /**
     * Setup resolution helper.
     */
    public function __construct()
    {
        $this->resolutionHelper = new Resolution();
    }

    /**
     * Create an SchedulersJobs record to follow job executing process via module interface.
     * Add the 'JobId' attribute to workload.
     * Setup $bean->job_group if the passed workload already has context 'dbId'.
     * {@inheritdoc}
     */
    public function onAdd(WorkloadInterface $workload)
    {
        $job = \BeanFactory::newBean('SchedulersJobs');

        $job->interface = true;
        $job->name = $workload->getHandlerName();
        $job->target = $workload->getRoute();
        $job->data = serialize($workload->getData());

        $this->resolutionHelper->setResolution($job, \SchedulersJob::JOB_PENDING);

        $context = $workload->getAttribute('context');
        $job->job_group = !empty($context['dbId']) ? $context['dbId'] : null;

        $module = $workload->getAttribute('module');
        if (!$module) {
            $job->module = !empty($context['module']) ? $context['module'] : 'SchedulersJobs';
        } else {
            $job->module = $module;
        }

        $job->fallible = $workload->getAttribute('fallible');
        $job->rerun = $workload->getAttribute('rerun');

        $job->assigned_user_id = $GLOBALS['current_user']->id;

        $job->save();
        $workload->setAttribute('dbId', $job->id);
    }

    /**
     * Mark following record as running.
     * {@inheritdoc}
     */
    public function onRun(WorkloadInterface $workload)
    {
        $job = \BeanFactory::getBean('SchedulersJobs', $workload->getAttribute('dbId'));
        if (!$job->id) {
            \LoggerManager::getLogger()->info('Cannot get bean by dbId.');
            return;
        }
        $this->resolutionHelper->setResolution($job, \SchedulersJob::JOB_RUNNING);
    }

    /**
     * Resolve created in onAdd db record.
     * {@inheritdoc}
     */
    public function onResolve(WorkloadInterface $workload, $resolution)
    {
        $job = \BeanFactory::getBean('SchedulersJobs', $workload->getAttribute('dbId'));
        if (!$job->id) {
            \LoggerManager::getLogger()->info('Cannot get bean by dbId.');
            return;
        }
        \LoggerManager::getLogger()->info("Resolving job {$job->id} as {$resolution}.");

        $job->execute_time = \TimeDate::getInstance()->nowDb();
        $job->save();
        $this->resolutionHelper->setResolution($job, $resolution);
    }
}
