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

class SugarUpgradeRevenueLineItemSyncToForecastWorksheet extends UpgradeScript
{
    public $order = 2190;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        $this->log('Updating Revenue Line Item Rows in Forecast Worksheet');

        $fields = array(
            'name',
            'account_id',
            'account_name',
            'likely_case',
            'best_case',
            'base_rate',
            'worst_case',
            'currency_id',
            'date_closed',
            'date_closed_timestamp',
            'probability',
            'commit_stage',
            'sales_stage',
            'assigned_user_id',
            'created_by',
            'date_entered',
            'deleted',
            'team_id',
            'team_set_id',
            'opportunity_id',
            'opportunity_name',
            'description',
            'next_step',
            'lead_source',
            'product_type',
            'campaign_id',
            'campaign_name',
            'product_template_id',
            'product_template_name',
            'category_id',
            'category_name',
            'list_price',
            'cost_price',
            'discount_price',
            'discount_amount',
            'quantity',
            'total_amount'
        );

        $sqlSet = "%s=(SELECT %s from revenue_line_items r WHERE r.id = fw.parent_id and fw.parent_type = 'RevenueLineItems')";

        $sqlSetArray = array();

        foreach ($fields as $field) {
            $key = $field;
            if (is_array($field)) {
                $key = array_shift(array_keys($field));
                $field = array_shift($field);
            }

            switch ($field) {
                case 'account_name':
                    $sqlSetArray[] = sprintf(
                        "%s = (SELECT DISTINCT a.name FROM accounts a INNER JOIN revenue_line_items r on
                            r.account_id = a.id WHERE r.id = fw.parent_id and fw.parent_type = 'RevenueLineItems')",
                        $field
                    );
                    break;
                case 'opportunity_name':
                    $sqlSetArray[] = sprintf(
                        "%s = (SELECT DISTINCT o.name FROM opportunities o INNER JOIN revenue_line_items r on
                            r.opportunity_id = o.id WHERE r.id = fw.parent_id and fw.parent_type = 'RevenueLineItems')",
                        $field
                    );
                    break;
                case 'campaign_name':
                    $sqlSetArray[] = sprintf(
                        "%s = (SELECT DISTINCT c.name FROM campaigns c INNER JOIN revenue_line_items r on
                            r.campaign_id = c.id WHERE r.id = fw.parent_id and fw.parent_type = 'RevenueLineItems')",
                        $field
                    );
                    break;
                case 'product_template_name':
                    $sqlSetArray[] = sprintf(
                        "%s = (SELECT DISTINCT p.name FROM product_templates p INNER JOIN revenue_line_items r on
                            r.product_template_id = p.id WHERE r.id = fw.parent_id and fw.parent_type = 'RevenueLineItems')",
                        $field
                    );
                    break;
                case 'category_name':
                    $sqlSetArray[] = sprintf(
                        "%s = (SELECT DISTINCT c.name FROM product_categories c INNER JOIN revenue_line_items r on
                            r.category_id = c.id WHERE r.id = fw.parent_id and fw.parent_type = 'RevenueLineItems')",
                        $field
                    );
                    break;
                default;
                    $sqlSetArray[] = sprintf($sqlSet, $key, $field);
                    break;
            }
        }

        $sql = "update forecast_worksheets as fw SET " . join(",", $sqlSetArray) . "
          where exists (SELECT * from revenue_line_items r WHERE r.id = fw.parent_id and fw.parent_type = 'RevenueLineItems')";

        $r = $this->db->query($sql);

        $this->log('SQL Ran, Updated ' . $this->db->getAffectedRowCount($r) . ' Rows');
    }
}
