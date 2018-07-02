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
class SugarFieldName extends SugarFieldBase
{
    public function fixForFilter(&$value, $fieldName, SugarBean $bean, SugarQuery $q, SugarQuery_Builder_Where $where, $op)
    {
        //check to see if this name type field has a 'fields' array defined
        if (!empty($bean->field_defs[$fieldName]) && !empty($bean->field_defs[$fieldName]['fields'])) {
            //iterate through array to create search with concatenated fields
            $expr = $bean->db->concat($bean->table_name, $bean->field_defs[$fieldName]['fields']);
            $expr .= " LIKE '{$value}%'";
            $where->addRaw($expr);
            //return false so no further processing is done on this field
            return false;
        }
        return true;
    }
}
