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
 * Class Producer
 * @package JobQueue
 */
class Producer
{
    /**
     * @var \DBManager
     */
    protected $db;

    /**
     * @var \SchedulersJob
     */
    protected $bean;

    /**
     * @var Resolution
     */
    protected $resolutionHelper;

    /**
     * @param \SchedulersJob $bean
     */
    public function __construct(\SchedulersJob $bean)
    {
        $this->bean = $bean;
        $this->db = \DBManagerFactory::getInstance();
        $this->resolutionHelper = new Resolution();
    }

    /**
     * Resolving the parent job according to subtasks' statuses.
     */
    public function resolve()
    {
        if (!$this->hasChildren(array()) || $this->bean->status == \SchedulersJob::JOB_STATUS_DONE) {
            return;
        }

        if ($this->bean->fallible && $this->hasChildren(array(\SchedulersJob::JOB_FAILURE))) {
            $this->resolutionHelper->setResolution($this->bean, \SchedulersJob::JOB_FAILURE);
            return;
        }

        $this->updateProgress();

        if (!$this->hasChildren(array(\SchedulersJob::JOB_PARTIAL)) && $this->isAllChildrenDone()) {
            $this->resolutionHelper->setResolution($this->bean, \SchedulersJob::JOB_SUCCESS);
            return;
        }
    }

    /**
     * If parent task has been resolved, resolve children tasks if they exist.
     * Affects queued and partial statuses.
     *
     * @param string $resolution Used for resolving subtasks.
     */
    public function resolveChildren($resolution)
    {
        foreach ($this->getChildren(array(\SchedulersJob::JOB_PENDING, \SchedulersJob::JOB_PARTIAL)) as $record) {
            $bean = \BeanFactory::getBean('SchedulersJobs', $record['id']);
            $this->resolutionHelper->setResolution($bean, $resolution);
        }
    }

    /**
     * Delete all subtasks.
     */
    public function deleteChildren()
    {
        $this->db->query(
            "DELETE FROM {$this->bean->table_name} WHERE job_group = {$this->db->quoted($this->bean->id)}"
        );
    }

    /**
     * Return subtasks by resolutions.
     *
     * @param array $resolutions
     * @return array [[id], [id] ...].
     */
    public function getChildren(array $resolutions)
    {
        $sq = new \SugarQuery();
        $sq->select(array('id'));
        $sq->from(\BeanFactory::getBean('SchedulersJobs'));
        $sq->where()
            ->equals('job_group', $this->bean->id)
            ->in('resolution', $resolutions);
        $result = $sq->execute();

        return $result;
    }

    /**
     * Check availability of subtasks by resolutions.
     *
     * @param array $resolutions
     * @return bool
     */
    public function hasChildren(array $resolutions)
    {
        $sq = new \SugarQuery();
        $sq->select()->setCountQuery();
        $sq->from(\BeanFactory::getBean('SchedulersJobs'));
        $sq->where()->equals('job_group', $this->bean->id);
        if ($resolutions) {
            $sq->where()->in('resolution', $resolutions);
        }
        $result = $sq->execute();

        return (bool)$result[0]['record_count'];
    }

    /**
     * Check if the current job has queued subtasks.
     *
     * @return bool
     */
    public function isAllChildrenDone()
    {
        $sq = new \SugarQuery();
        $sq->select()->setCountQuery();
        $sq->from(\BeanFactory::getBean('SchedulersJobs'));
        $sq->where()
            ->equals('job_group', $this->bean->id)
            ->notEquals('status', \SchedulersJob::JOB_STATUS_DONE);
        $result = $sq->execute();

        return !(bool)$result[0]['record_count'];
    }

    /**
     * Update job progress.
     */
    protected function updateProgress()
    {
        $sql = "SELECT COUNT(self.status) * 100 / COUNT(0) AS percentage
                FROM job_queue
                LEFT JOIN job_queue AS self
                  ON job_queue.id = self.id
                  AND self.status = {$this->db->quoted(\SchedulersJob::JOB_STATUS_DONE)}
                  AND self.job_group = {$this->db->quoted($this->bean->id)}
                WHERE job_queue.job_group = {$this->db->quoted($this->bean->id)}
                GROUP BY job_queue.job_group";
        $res = $this->db->fetchOne($sql);

        $this->bean->percent_complete = (int)$res['percentage'];
        $this->bean->save();
    }
}
