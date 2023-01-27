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
 * Apply changes to the `team_sets_modules` table
 */
class SugarUpgradeUpdateTeamSetModules extends UpgradeScript
{
    public $order = 1100;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        if (version_compare($this->from_version, '9.3', '>=')) {
            return;
        }

        if ($this->db instanceof MysqliManager || $this->db instanceof IBMDB2Manager) {
            $conn = $this->db->getConnection();
            $conn->executeQuery('CREATE TABLE team_sets_modules_new LIKE team_sets_modules');
            $conn->executeQuery(
                'INSERT INTO team_sets_modules_new '
                . 'SELECT * FROM team_sets_modules WHERE team_set_id IS NOT NULL AND module_table_name IS NOT NULL'
            );
            $conn->executeQuery('RENAME TABLE team_sets_modules TO team_sets_modules_old');
            $conn->executeQuery('RENAME TABLE team_sets_modules_new TO team_sets_modules');
            $this->db->dropTableName('team_sets_modules_old');
        } else {
            $this->db->getConnection()->executeQuery(
                'DELETE FROM team_sets_modules WHERE team_set_id IS NULL OR module_table_name IS NULL'
            );
        }

        global $dictionary;

        // enforce NOT NULL on the key columns which cannot be done via DBManager::repairTable()
        foreach (['team_set_id', 'module_table_name'] as $field) {
            $this->db->alterColumn('team_sets_modules', $dictionary['TeamSetModule']['fields'][$field]);
        }
    }
}
