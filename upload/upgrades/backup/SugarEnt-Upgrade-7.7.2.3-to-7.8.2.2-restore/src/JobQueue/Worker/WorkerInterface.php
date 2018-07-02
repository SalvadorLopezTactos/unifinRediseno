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

namespace Sugarcrm\Sugarcrm\JobQueue\Worker;

/**
 * Interface WorkerInterface
 * @package JobQueue
 */
interface WorkerInterface
{
    // Gearman codes http://php.net/manual/en/gearman.constants.php
    const RETURN_CODE_SUCCESS = 0;
    const RETURN_CODE_IO_WAIT = 1;
    const RETURN_CODE_NO_ACTIVE_FDS = 7;
    const RETURN_CODE_NO_REGISTERED_FUNCTIONS = 34;
    const RETURN_CODE_NO_JOBS = 35;
    const RETURN_CODE_TIMEOUT = 47;

    /**
     * Get last worker return code.
     *
     * @return int Return code constants.
     */
    public function returnCode();

    /**
     * Bind route with function that handles it.
     *
     * @param string $route Workload's route.
     * @param callable $function Function that handles this route.
     * ToDo: Add type-hint 'callable' to $function when we finally leave 5.3.
     */
    public function registerHandler($route, $function);

    /**
     * Unregister a function name with the job servers.
     *
     * @param string $route Workload's route.
     */
    public function unregisterHandler($route);

    /**
     * Wait for and perform jobs.
     *
     * @return boolean
     */
    public function work();

    /**
     * Wait for activity from one of the job servers.
     * We need this method for compatibility with Gearman.
     * For other implementations should return true;
     *
     * @return boolean
     */
    public function wait();
}
