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
 * Update entry in systems table
 */
class SugarUpgradeSetSystemID extends UpgradeScript
{
    public $order = 4000;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        if(!($this->from_flavor == 'ce' && $this->toFlavor('pro'))) return;
        $system = new System();
        $system->system_key = $this->config['unique_key'];
        $system->user_id = '1';
        $system->last_connect_date = TimeDate::getInstance()->nowDb();
        $system_id = $system->retrieveNextKey(false, true);
        $this->db->query( "INSERT INTO config (category, name, value) VALUES ( 'system', 'system_id', '" . $system_id . "')" );
    }
}
