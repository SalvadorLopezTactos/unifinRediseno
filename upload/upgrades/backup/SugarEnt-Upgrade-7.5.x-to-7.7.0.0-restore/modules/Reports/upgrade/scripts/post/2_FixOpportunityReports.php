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


class SugarUpgradeFixOpportunityReports extends UpgradeScript
{
    public $order = 2200;
    public $type = self::UPGRADE_DB;

    protected $rli_table_name = 'Opportunities:revenuelineitems';
    protected $rli_table_def = array(
        'name' => 'Opportunities  >  Revenue Line Items',
        'parent' => 'self',
        'link_def' => array(
            'name' => 'revenuelineitems',
            'relationship_name' => 'opportunities_revenuelineitems',
            'bean_is_lhs' => true,
            'link_type' => 'many',
            'label' => 'Revenue Line Items',
            'module' => 'RevenueLineItems',
            'table_key' => 'Opportunities:revenuelineitems',
        ),
        'module' => 'RevenueLineItems',
        'label' => 'Revenue Line Items',
    );

    public function run()
    {
        if (version_compare($this->from_version, '7.2.2', '<')) {
            // lets find all the reports for the opps module that contain sales_stage

            $sql = "select id, content from saved_reports where module = 'Opportunities' and deleted = 0
                and content like '%\"name\":\"sales_stage\"%';";

            $results = $this->db->query($sql);

            $this->log('Found ' . $this->db->getAffectedRowCount($results) . ' Reports That Need Updating');

            $fixedReports = array();

            // since we are dealing with json data, don't have fetchByAssoc encode the data
            while ($row = $this->db->fetchByAssoc($results, false)) {
                // reset the name, just in case.
                $this->rli_table_name = 'Opportunities:revenuelineitems';
                $report = json_decode($row['content'], true);

                // if links_defs is there, we should set that as well
                if (isset($report['links_def'])) {
                    $report['links_def'][] = 'revenuelineitems';
                    // if we are setting the links_defs, the rli_table_name needs to be changed
                    $this->rli_table_name = 'revenuelineitems';
                } elseif (isset($report['full_table_list'])) {
                    $report['full_table_list'][$this->rli_table_name] = $this->rli_table_def;
                } else {
                    // if we don't have a links_def or the full_table_list, we should just bail out now.
                    $this->log("Didn't find links_def or full_table_list for Report: " . $row['name'] . '; Will Not Upgrade Report Metadata');
                    continue;
                }

                // lets loop though all the display_columns and find anyone that is sales_stage
                foreach (array('group_defs', 'display_columns', 'summary_columns') as $type) {
                    foreach ($report[$type] as $key => $column) {
                        if ($column['name'] == 'sales_stage' && $column['table_key'] == 'self') {
                            $report[$type][$key]['table_key'] = $this->rli_table_name;
                        }
                    }
                }

                // now lets fix all the filters.
                foreach ($report['filters_def'] as $name => $filter) {

                    $returnSingleFilter = false;
                    if (isset($filter['name']) && isset($filter['table_key'])) {
                        $returnSingleFilter = true;
                        $filter = array($filter);
                    }

                    $filter = $this->fixFilters($filter);
                    if ($returnSingleFilter) {
                        $filter = array_shift($filter);
                    }

                    $report['filters_def'][$name] = $filter;
                }

                $json_def = json_encode($report, JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT);

                $fixedReports[] = $json_def;

                $sql = 'UPDATE saved_reports
                    SET content = ' . $this->db->quoted($json_def) . '
                    where id = ' . $this->db->quoted($row['id'])  . ';';

                $this->db->query($sql);
            }


            // clear out any js cache, as the reports will screw up if they are not cleared
            require_once("modules/Administration/QuickRepairAndRebuild.php");
            $rac = new RepairAndClear('', '', false, false);
            $rac->clearJsFiles();

            return $fixedReports;
        }

        return false;
    }

    protected function fixFilters($filter)
    {
        foreach ($filter as $name => $f) {
            if ($name === 'operator') {
                continue;
            }

            // if the operator is set, then we have a group by, and we need to process all those queries
            if (isset($f['operator'])) {
                $filter[$name] = $this->fixFilters($f);
            } elseif ($f['name'] === 'sales_stage' && $f['table_key'] !== $this->rli_table_name) {
                $filter[$name]['table_key'] = $this->rli_table_name;
            }
        }
        return $filter;
    }
}
