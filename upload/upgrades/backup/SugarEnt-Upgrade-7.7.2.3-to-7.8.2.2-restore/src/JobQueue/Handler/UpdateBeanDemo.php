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

class UpdateBeanDemo implements RunnableInterface
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
     * @var array ['fieldName' => 'value', ...]
     */
    protected $data;

    /**
     * @param string $module
     * @param string $id
     * @param array $data ['fieldName' => 'value', ...]
     * @throws LogicException
     */
    public function __construct($module, $id, array $data)
    {
        $this->bean = \BeanFactory::getBean($module, $id);
        if (empty($this->bean->id)) {
            throw new LogicException('Cannot find a record by id.');
        }
        $this->module = $module;
        $this->id = $id;
        $this->data = $data;
    }

    /**
     * Update a single record.
     * {@inheritdoc}
     * @throws RuntimeException
     */
    public function run()
    {
        if (!$this->bean->aclAccess('edit')) {
            throw new RuntimeException('Has no access to edit.');
        }
        foreach ($this->data as $fName => $value) {
            $this->bean->$fName = $value;
        }
        $this->bean->save();

        return \SchedulersJob::JOB_SUCCESS;
    }
}
