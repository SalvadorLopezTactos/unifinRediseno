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
 * Class WorkloadInterface
 * @package JobQueue
 */
interface WorkloadInterface
{
    /**
     * Required data.
     *
     * @param mixed $data
     */
    public function setData($data);

    /**
     * @return mixed
     */
    public function getData();

    /**
     * @param string $handlerName
     */
    public function setRoute($handlerName);

    /**
     * @return string
     */
    public function getRoute();

    /**
     * Set an attribute key.
     *
     * @param string $key
     * @param mixed $value
     */
    public function setAttribute($key, $value);

    /**
     * Get an attribute by key.
     *
     * @param $key
     * @return mixed
     */
    public function getAttribute($key);

    /**
     * Get attributes.
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Return a handler name matched to the route.
     *
     * @return string
     */
    public function getHandlerName();
}
