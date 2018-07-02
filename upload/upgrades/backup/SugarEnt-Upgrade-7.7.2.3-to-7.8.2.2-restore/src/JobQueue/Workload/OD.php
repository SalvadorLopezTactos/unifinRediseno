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
 * Class OD
 * @package JobQueue
 */
class OD extends Workload
{
    /**
     * Form a route using the instance key.
     * {@inheritdoc}
     */
    public function setRoute($handlerName)
    {
        $this->route = $handlerName . ':' . $this->getInstanceUnique();
    }

    /**
     * Add the instance key as a parameter.
     * {@inheritdoc}
     */
    public function initAttributes($data)
    {
        $this->attributes = $data;
        $this->attributes['instanceKey'] = $this->getInstanceUnique();
    }

    /**
     * {@inheritdoc}
     */
    public function getHandlerName()
    {
        return str_replace(':' . $this->getInstanceUnique(), '', $this->route);
    }

    /**
     * Return instance specific part.
     *
     * @return string
     */
    protected function getInstanceUnique()
    {
        return \SugarConfig::getInstance()->get('unique_key');
    }
}
