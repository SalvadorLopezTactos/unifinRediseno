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

namespace Sugarcrm\Sugarcrm\Security\InputValidation;

class Serialized
{
    /**
     * Checks whether the $value contains object or class references
     * @param string $value Serialized value of any type
     * @return boolean
     */
    public static function hasObjectRefs($value)
    {
        preg_match('/[oc]:\d+:/i', $value, $matches);
        return count($matches) > 0;
    }

    /**
     * Performs unserialization. Accepts all types except Objects
     *
     * @param string $value Serialized value of any type except Object
     * @return mixed False if Object, converted value for other cases
     */
    public static function unserialize($value)
    {
        if (self::hasObjectRefs($value)) {
            \LoggerManager::getLogger()->warning('Objects unserialization is not allowed');
            return false;
        }

        return unserialize($value);
    }
}
