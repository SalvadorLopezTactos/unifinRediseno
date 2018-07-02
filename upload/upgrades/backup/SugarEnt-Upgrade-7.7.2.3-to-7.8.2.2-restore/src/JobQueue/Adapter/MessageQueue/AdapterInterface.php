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

namespace Sugarcrm\Sugarcrm\JobQueue\Adapter\MessageQueue;

/**
 * Interface AdapterInterface
 * @package JobQueue
 */
interface AdapterInterface
{
    /**
     * Add a job with a certain Workload to a queue.
     * @param string $route
     * @param string $data
     */
    public function addJob($route, $data);

    /**
     * Bind the queue to a route for listening.
     * @param string $route
     */
    public function bind($route);

    /**
     * Unbind the queue from a route.
     * @param string $route
     */
    public function unbind($route);

    /**
     * Get a job with a certain Workload, based on the message envelope, specific to queue realization.
     * @param mixed $message
     * @return string
     */
    public function getJob($message);

    /**
     * Returns a message envelope, specific to queue realization. In case of an empty queue returns null.
     * For custom implementation important to lock selected message till its resolving.
     * @return null|mixed
     */
    public function getMessage();

    /**
     * Remove a job from a queue.
     * @param mixed $message Message envelope, specific to queue realization
     */
    public function resolve($message);
}
