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

use Sugarcrm\Sugarcrm\JobQueue\Workload\WorkloadInterface;

/**
 * Class ObserverInterface
 * @package JobQueue
 */
interface ObserverInterface
{
    /**
     * React on adding a task to job server.
     *
     * @param WorkloadInterface $workload
     */
    public function onAdd(WorkloadInterface $workload);

    /**
     * React on running a task.
     *
     * @param WorkloadInterface $workload
     */
    public function onRun(WorkloadInterface $workload);

    /**
     * React on resolving a task.
     *
     * @param WorkloadInterface $workload
     * @param string $resolution SchedulersJob resolution.
     */
    public function onResolve(WorkloadInterface $workload, $resolution);
}
