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
 * Class Sugar
 * @package JobQueue
 */
class Sugar implements AdapterInterface
{
    /**
     * @var \DBManager
     */
    protected $db;

    /**
     * @var array $routes
     */
    protected $routes = array();

    /**
     * Initialize db instance.
     */
    public function __construct()
    {
        $this->db = \DBManagerFactory::getInstance();
    }

    /**
     * Add a job to Sugar jobs database table.
     * {@inheritdoc}
     */
    public function addJob($route, $data)
    {
        $job = \BeanFactory::newBean('SchedulersJobs');
        $job->interface = false;
        $job->target = $route;
        $job->data = $data;
        $job->status = \SchedulersJob::JOB_STATUS_QUEUED;
        $job->save();
    }

    /**
     * {@inheritdoc}
     */
    public function bind($route)
    {
        $this->routes[] = $route;
    }

    /**
     * {@inheritdoc}
     */
    public function unbind($route)
    {
        $key = array_search($route, $this->routes);
        if ($key) {
            unset($this->routes[$key]);
        }
    }

    /**
     * Get a job from Sugar database table based on the id sent in the $message param.
     * {@inheritdoc}
     */
    public function getJob($message)
    {
        $bean = \BeanFactory::getBean('SchedulersJobs', $message);
        return $bean->data;
    }

    /**
     * Get message that contains job's record id and maybe some other useful info.
     * {@inheritdoc}
     */
    public function getMessage()
    {
        $job = \BeanFactory::getBean('SchedulersJobs');
        $queued = \SchedulersJob::JOB_STATUS_QUEUED;
        $running = \SchedulersJob::JOB_STATUS_RUNNING;
        $id = null;

        $attempts = 5;
        while ($attempts-- && $this->routes) {
            $query = "SELECT id FROM {$job->table_name} " .
                "WHERE execute_time <= {$this->db->now()} " .
                "AND target IN('" . implode("', '", $this->db->arrayQuote($this->routes)) . "') " .
                "AND status = {$this->db->quoted($queued)} AND interface = 0 AND deleted = 0 " .
                "ORDER BY execute_time ASC";

            $id = $this->db->getOne($query);

            if (!$id) {
                return null;
            }
            // Using direct query here to be able to fetch affected count
            // if count is 0 this means somebody changed the job status and we have to try again.
            $res = $this->db->query(
                "UPDATE {$job->table_name} " .
                "SET execute_time={$this->db->now()}, status = {$this->db->quoted($queued)}, " .
                "date_modified={$this->db->now()} " .
                "WHERE id='{$id}'"
            );

            if ($this->db->getAffectedRowCount($res) > 0) {
                break;
            }
        }

        return $id;
    }

    /**
     * Set an appropriate resolution and status to a job record in the database, depending on resolution.
     * {@inheritdoc}
     */
    public function resolve($message)
    {
        $job = \BeanFactory::getBean('SchedulersJobs', $message);
        $job->mark_deleted($job->id);
    }
}
