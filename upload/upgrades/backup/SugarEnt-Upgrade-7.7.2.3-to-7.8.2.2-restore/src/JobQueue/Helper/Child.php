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

use Sugarcrm\Sugarcrm\JobQueue\Exception\LogicException;

/**
 * Class Child
 * @package JobQueue
 */
class Child
{
    /**
     * @var \SchedulersJob
     */
    protected $bean;

    /**
     * @param \SchedulersJob $bean
     * @throws LogicException If the job isn't a child.
     */
    public function __construct(\SchedulersJob $bean)
    {
        if (!$bean->job_group) {
            throw new LogicException('The job isn\'t a child.');
        }
        $this->bean = $bean;
    }

    /**
     * Check if the parent task is still actual.
     *
     * @return bool
     */
    public function isParentActual()
    {
        $parentBean = \BeanFactory::getBean('SchedulersJobs', $this->bean->job_group);
        return $parentBean->status != \SchedulersJob::JOB_STATUS_DONE;
    }

    /**
     * Return parent bean.
     *
     * @return \SchedulersJob
     */
    public function getParentJob()
    {
        return \BeanFactory::getBean('SchedulersJobs', $this->bean->job_group);
    }
}
