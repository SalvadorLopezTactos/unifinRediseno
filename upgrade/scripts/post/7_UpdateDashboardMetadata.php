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

class SugarUpgradeUpdateDashboardMetadata extends UpgradeScript
{
    public $order = 7490;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        $deletedDashlets = array(
            '7.8.0.0' => array(
                'news',
            ),
        );

        $this->updateMetaForDeletedDashboards($deletedDashlets);
    }

    public function updateMetaForDeletedDashboards($deletedDashlets)
    {
        $left = "metadata LIKE '%\"type\":\"";
        $right = "\"%'";

        foreach ($deletedDashlets as $version => $dashlets) {
            if (empty($dashlets)) {
                continue;
            }

            if (version_compare($this->from_version, $version, '<')) {
                $sql = 'SELECT id, metadata FROM dashboards WHERE ';
                $sql.= $left . implode($right . ' OR ' . $left, $dashlets) . $right;

                $rows = $this->db->query($sql);

                foreach ($rows as $row) {
                    $id = $this->db->quoted($row['id']);
                    $metadata = json_decode($row['metadata']);
                    $dirty = false;

                    // Loop through the dashboard, drilling down to the dashlet level.
                    foreach ($metadata->components as $component_key => $component) {
                        foreach ($component->rows as $row_key => $row) {
                            foreach ($row as $item_key => $item) {
                                if (isset($item->view->type) && in_array($item->view->type, $dashlets)) {
                                    // Dashlet is deleted, remove it from the metadata.
                                    unset($metadata->components[$component_key]->rows[$row_key][$item_key]);
                                }
                            }

                            // Check if the current row is now empty.
                            if (count($metadata->components[$component_key]->rows[$row_key]) == 0) {
                                // This row is now empty, remove it and mark the metadata as dirty.
                                unset($metadata->components[$component_key]->rows[$row_key]);
                                $dirty = true;
                            }
                        }
                    }

                    if ($dirty) {
                        // Loop through the rows re-assigning sequential array keys for dashboard display.
                        foreach ($metadata->components as $key => $value) {
                            $metadata->components[$key]->rows = array_values($metadata->components[$key]->rows);
                        }
                    }

                    $metadata = $this->db->quoted(json_encode($metadata));
                    $this->db->query("UPDATE dashboards SET metadata = $metadata WHERE id = $id");
                }
            }
        }
    }
}
