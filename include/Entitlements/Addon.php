<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

namespace Sugarcrm\Sugarcrm\Entitlements;

// This section of code is a portion of the code referred
// to as Critical Control Software under the End User
// License Agreement.  Neither the Company nor the Users
// may modify any portion of the Critical Control Software.
use Sugarcrm\Sugarcrm\inc\Entitlements\Exception\SubscriptionException;

/**
 * Class Addon
 *
 * addon part of Sugar subscription
 */
class Addon
{
    /**
     * data
     * @var array
     */
    protected $data = [];

    public function __construct(string $id, array $data)
    {
        $this->parse($id, $data);
    }

    /**
     * parse the Addon section
     * @param string $id
     * @param array $data
     * @throws \Exception
     */
    protected function parse(string $id, array $data)
    {
        if (empty($id)) {
            throw new SubscriptionException('No subscription Id in json data');
        }

        $this->data['id'] = $id;
        if (empty($data)) {
            return;
        }

        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }
    }

    /**
     * access method
     * @param string $name
     * @return mixed|null
     */
    public function __get(string $name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
        return null;
    }
}
//END REQUIRED CODE DO NOT MODIFY
