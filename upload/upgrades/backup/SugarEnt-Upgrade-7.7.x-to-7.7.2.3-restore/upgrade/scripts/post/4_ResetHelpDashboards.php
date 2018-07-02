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

class SugarUpgradeResetHelpDashboards extends UpgradeScript
{
    public $order = 4000;
    public $type = self::UPGRADE_DB;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (version_compare($this->from_version, '7.2.2', '<')) {
            $this->resetHelpDashboards();
        }
    }

    /**
     * Update help dashboard metadata adding the new Learning Resources dashlet
     *
     * @private
     */
    private function resetHelpDashboards()
    {
        $helpMetadata = $this->db->quoted(
            '{"components":[{"rows":[[{"view":{"type":"help-dashlet","label":'
            . '"LBL_DEFAULT_HELP_DASHLET_TITLE"},"width":12},{"view":{"type":"learning-resources","label":'
            . '"LBL_LEARNING_RESOURCES_NAME"},"width":12}]],"width":12}]}'
        );
        $this->db->query(
            "UPDATE dashboards
                SET metadata = $helpMetadata
                WHERE dashboard_type = 'help-dashboard'"
        );
    }
}
