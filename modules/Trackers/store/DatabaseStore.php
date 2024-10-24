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
/*********************************************************************************
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/


/**
 * Database
 * This is an implementation of the Store interface where the storage uses
 * the configured database instance as defined in DBManagerFactory::getInstance() method
 *
 */
class DatabaseStore implements Store
{
    /** {@inheritDoc} */
    public function flush($monitor)
    {
        $values = $monitor->toArray();
        $values = array_filter($values);

        if (safeCount($values) < 1) {
            return;
        }

        $dictionary = [];
        require $monitor->metricsFile;

        DBManagerFactory::getInstance()->insertParams(
            $monitor->table_name,
            $dictionary[$monitor->name]['fields'],
            $values
        );
    }
}
