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

namespace Sugarcrm\Sugarcrm\JobQueue\Workload;

/**
 * Class Workload
 * @package JobQueue
 */
class Workload implements WorkloadInterface
{
    /**
     * @var string route To find worker that handle this job.
     */
    protected $route;

    /**
     * @var mixed data Data of job to send in JQ.
     */
    protected $data;

    /**
     * @var array attributes Extra data.
     */
    protected $attributes = array();

    /**
     * @param $route
     * @param $data
     * @param $attributes
     */
    public function __construct($route, $data, array $attributes = array())
    {
        $this->setRoute($route);
        $this->setData($data);
        $this->initAttributes($attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function getRoute()
    {
        return $this->route;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttribute($key)
    {
        return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function setRoute($handlerName)
    {
        $this->route = $handlerName;
    }

    /**
     * {@inheritdoc}
     */
    protected function initAttributes($data)
    {
        $this->attributes = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getHandlerName()
    {
        return $this->route;
    }
}
