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

namespace Sugarcrm\Sugarcrm\JobQueue\Client;

use Sugarcrm\Sugarcrm\JobQueue\Observer\State;
use Sugarcrm\Sugarcrm\JobQueue\Workload\WorkloadInterface;

/**
 * Class Immediate
 * @package JobQueue
 */
class Immediate implements ClientInterface
{
    /**
     * @var callable
     */
    protected $function;

    /**
     * Initialize object and set up handler function (normally it is Manager's proxyHandler).
     * ToDo: Add type-hint 'callable' when we finally leave 5.3.
     * @param callable $function
     */
    public function __construct($function)
    {
        $this->function = $function;
    }

    /**
     * Adds a job and immediately runs it.
     * {@inheritdoc}
     */
    public function addJob(WorkloadInterface $workload)
    {
        $stateObserver = new State();
        $stateObserver->onResolve($workload, call_user_func($this->function, $workload));
    }
}
