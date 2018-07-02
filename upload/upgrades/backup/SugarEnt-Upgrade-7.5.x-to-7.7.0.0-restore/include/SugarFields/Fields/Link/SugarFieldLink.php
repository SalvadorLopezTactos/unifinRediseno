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
require_once('include/SugarSmarty/plugins/function.sugar_replace_vars.php');

class SugarFieldLink extends SugarFieldBase {
    public function apiFormatField(&$data, $bean, $args, $fieldName, $properties) {
    	// this is only for generated links
    	if(isset($bean->field_defs[$fieldName]['gen']) && isTruthy($bean->field_defs[$fieldName]['gen'])) {
            $subject = $bean->field_defs[$fieldName]['default'];
            if (!empty($subject)) {
                $data[$fieldName] = replace_sugar_vars($subject, $bean->toArray(), true);
            } else {
                $data[$fieldName] = "";
            }
	    } else {
            parent::apiFormatField($data, $bean, $args, $fieldName, $properties);
        }
    }
}
