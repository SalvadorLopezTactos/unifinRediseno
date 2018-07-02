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

/**
 * Relationship between ACL Roles and Users which maintains ACL Role Sets
 */
class KBUsefulnessRelationship extends M2MRelationship
{
    /**
     * @inheritDoc
     */
    protected function getRoleWhere($table = null, $ignore_role_filter = false, $ignore_primary_flag = false)
    {
        if (empty($table)) {
            $table = $this->getRelationshipTable();
        }

        if (!empty($this->primaryOnly)) {
            return " AND {$table}.{$this->def['primary_flag_column']} = 1";
        }
        return parent::getRoleWhere($table, $ignore_role_filter, $ignore_primary_flag);
    }
}
