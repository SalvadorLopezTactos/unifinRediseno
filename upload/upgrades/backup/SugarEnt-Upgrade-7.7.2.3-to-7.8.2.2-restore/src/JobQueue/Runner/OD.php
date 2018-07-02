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

namespace Sugarcrm\Sugarcrm\JobQueue\Runner;

use Sugarcrm\Sugarcrm\JobQueue\LockStrategy\LockStrategyInterface;
use Sugarcrm\Sugarcrm\JobQueue\Worker\WorkerInterface;

/**
 * Class OD
 * @package JobQueue
 */
class OD extends Standard
{
    /**
     * Special functionality for on-demand mode that uses legacy config variables.
     *
     * @param WorkerInterface $worker
     * @param LockStrategyInterface $lock
     */
    public function __construct(WorkerInterface $worker, LockStrategyInterface $lock)
    {
        $this->maxRuntime = \SugarConfig::getInstance()->get('cron.max_cron_runtime', $this->maxRuntime);
        parent::__construct($worker, $lock);
    }

    /**
     * Handle no jobs case.
     * Stop the server.
     */
    protected function noJobsHandler()
    {
        $this->stopWork = true;
    }

    /**
     * Do not release lock.
     * {@inheritdoc}
     */
    public function run()
    {
        $this->startWorker();
    }

    /**
     * Stub.
     * {@inheritdoc}
     */
    public function acquireLock()
    {
    }
}
