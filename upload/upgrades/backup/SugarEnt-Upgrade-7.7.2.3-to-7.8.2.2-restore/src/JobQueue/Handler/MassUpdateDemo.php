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

namespace Sugarcrm\Sugarcrm\JobQueue\Handler;

use Sugarcrm\Sugarcrm\JobQueue\Client\ClientInterface;
use Sugarcrm\Sugarcrm\JobQueue\Exception\LogicException;

class MassUpdateDemo implements RunnableInterface, SubtaskCapableInterface
{
    /**
     * Fail the task if a single child ends as failed.
     */
    const FALLIBLE = true;

    /**
     * Ability to rerun the task.
     */
    const RERUN = true;

    /**
     * @var ClientInterface To create related jobs.
     */
    protected $client;

    /**
     * @var array $allowedActions Allowed values for $data['action'] param.
     */
    protected $allowedActions = array('save', 'delete', 'addToProspectList');

    /**
     * @var string $action Action name.
     */
    protected $action;

    /**
     * @var string $module Module name.
     */
    protected $module;

    /**
     * @var array $uid Of ids.
     */
    protected $uid;

    /**
     * @var array $data For update.
     */
    protected $data;

    /**
     * @param string $action
     * @param string $module
     * @param array $uid
     * @param array $data
     * @throws LogicException
     */
    public function __construct($action, $module, array $uid, array $data = array())
    {
        if (!in_array($action, $this->allowedActions)) {
            throw new LogicException('Unsupported action.');
        }
        if (empty($uid)) {
            throw new LogicException('Nothing to update.');
        }
        $this->action = $action;
        $this->module = $module;
        $this->uid = $uid;
        $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        foreach ($this->uid as $beanId) {
            if ($this->action == 'delete') {
                // Or a new instance for independent tasks.
                $this->client->deleteBeanDemo($this->module, $beanId);
            } elseif ($this->action == 'save') {
                $this->client->updateBeanDemo($this->module, $beanId, $this->data);
            }
        }
        return \SchedulersJob::JOB_RUNNING;
    }
}
