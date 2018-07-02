<?php
 if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
/**
 * Fix ext4 in enum fields which can be messed up old versions thus causing notices
 */
class SugarUpgradeFixEnumFields extends UpgradeScript
{
    public $order = 2050;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        if(version_compare($this->from_version, '7.2', '>=')) {
            return;
        }
        $this->log('Checking for broken enum fields');
        $drop_ids = array();
    	$res = $this->db->query("SELECT * FROM fields_meta_data WHERE type='enum' AND deleted=0 AND ext4 IS NOT NULL AND ext4 != '' AND ext4 != 's:0:\"\";'");
        while($row = $this->db->fetchByAssoc($res, false)) {
            if(empty($row['ext4'])) {
                // shouldn't happen but just in case
                continue;
            }
            $this->log("Dependent enum found with ext4: id {$row['id']} ext4 {$row['ext4']}");
            $drop_ids[] = $this->db->quoted($row['id']);
        }
        if(!empty($drop_ids)) {
            $this->db->query("UPDATE fields_meta_data SET ext4 = '' WHERE id IN (".join(",", $drop_ids).")");
        }
    }
}
