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

use Sugarcrm\Sugarcrm\JobQueue\Exception\LogicException;
use Sugarcrm\Sugarcrm\JobQueue\Exception\RuntimeException;

class DeleteBeanDemo implements RunnableInterface
{
    /**
     * @var \SugarBean
     */
    protected $bean;

    /**
     * @var string $module Module name.
     */
    protected $module;

    /**
     * @var string $id Bean id.
     */
    protected $id;

    /**
     * @param string $module
     * @param string $id
     * @throws LogicException
     */
    public function __construct($module, $id)
    {
        $this->bean = \BeanFactory::getBean($module, $id);
        if (empty($this->bean->id)) {
            throw new LogicException('Cannot find a record by id.');
        }
        $this->module = $module;
        $this->id = $id;
    }

    /**
     * Delete a single record.
     * {@inheritdoc}
     * @throws RuntimeException
     */
    public function run()
    {
        if (!$this->bean->aclAccess('delete')) {
            throw new RuntimeException('Has no access to delete.');
        }

        $this->bean->mark_deleted($this->id);

        return \SchedulersJob::JOB_SUCCESS;
    }
}
