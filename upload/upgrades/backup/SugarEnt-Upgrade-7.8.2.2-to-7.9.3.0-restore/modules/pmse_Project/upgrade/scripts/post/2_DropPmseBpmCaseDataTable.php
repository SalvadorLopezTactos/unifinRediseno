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

class SugarUpgradeDropPmseBpmCaseDataTable extends UpgradeScript
{
    public $order = 2200;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        // only run this when coming from a 7.6.x or 7.7.x upgrade
        if (!(version_compare($this->from_version, '7.6.0', ">=")
            && version_compare($this->from_version, '7.8.0.0RC1', "<"))
        ) {
            return;
        }

        $this->log('Droping `pmse_bpm_case_data` table...');
        if ($this->db->dropTableName('pmse_bpm_case_data')) {
            $this->log('The table was dropped');
        } else {
            $this->log('Failed to drop the table');
        }
    }
}
