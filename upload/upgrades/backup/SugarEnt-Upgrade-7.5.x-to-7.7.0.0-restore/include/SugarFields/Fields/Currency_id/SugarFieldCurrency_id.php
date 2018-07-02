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

require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');

class SugarFieldCurrency_id extends SugarFieldBase
{
    /**
     * Formats a field for the Sugar API
     *
     * @see SugarFieldBase::apiFormatField
     */
    public function apiFormatField(&$data, $bean, $args, $fieldName, $properties)
    {
        if (!empty($bean->$fieldName)) {
            $data[$fieldName] = $bean->$fieldName;
        } else {
            $data[$fieldName] = "-99";
        }
    }
}
