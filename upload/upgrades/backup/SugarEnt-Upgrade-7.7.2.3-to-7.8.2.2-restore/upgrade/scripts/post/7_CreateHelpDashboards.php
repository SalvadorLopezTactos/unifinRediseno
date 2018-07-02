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

class SugarUpgradeCreateHelpDashboards extends UpgradeScript
{
    public $order = 7500;
    public $type = self::UPGRADE_DB;

    public function run()
    {

        if (version_compare($this->from_version, '7.2', '<')) {
            $sql = "SELECT d.dashboard_module,
                           d.view_name,
                           d.assigned_user_id,
                           (SELECT d1.dashboard_type
                            FROM   dashboards d1
                            WHERE  d1.dashboard_module = d.dashboard_module
                               AND d1.view_name = d.view_name
                               AND d1.assigned_user_id = d.assigned_user_id
                               AND d1.dashboard_type = 'help-dashboard') has_help_dashboard
                    FROM   dashboards d
                    GROUP  BY d.assigned_user_id,
                              d.dashboard_module,
                              d.view_name";

            $results = $this->db->query($sql);


            // get the view defs from the help-dashboard.php file if it exists
            $viewdefs = array();
            if (SugarAutoLoader::load('clients/base/layouts/help-dashboard/help-dashboard.php') &&
                isset($viewdefs['base']['layout']['help-dashboard']['metadata'])) {
                $helpDashboardMeta = json_encode($viewdefs['base']['layout']['help-dashboard']['metadata']);
            } else {
                $helpDashboardMeta = '{"components":[{"rows":[[{"view":{"type":"help-dashlet","label":"LBL_DEFAULT_HELP_DASHLET_TITLE"},"width":12}]],"width":12}]}';
            }

            while ($row = $this->db->fetchByAssoc($results)) {
                if (!empty($row['has_help_dashboard'])) {
                    continue;
                }

                $sqlInsert = "INSERT INTO dashboards (id, name, date_entered, date_modified, modified_user_id, created_by,
                    description, deleted, assigned_user_id, dashboard_module, view_name, metadata, dashboard_type)
                  VALUES
                    ('" . create_guid() . "', 'LBL_DEFAULT_HELP_DASHLET_TITLE',
                        '" . $GLOBALS['timedate']->nowDb() . "', '" . $GLOBALS['timedate']->nowDb() . "',
                        '" . $row['assigned_user_id'] . "', '" . $row['assigned_user_id'] . "', NULL, 0,
                        '" . $row['assigned_user_id'] . "', '" . $row['dashboard_module'] . "', '" . $row['view_name'] . "',
                        '" . $helpDashboardMeta . "', 'help-dashboard')";

                $this->db->query($sqlInsert);

            }
        }
    }
}
