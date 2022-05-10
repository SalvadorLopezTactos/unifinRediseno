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

class SugarUpgradeOpportunityCreateRLI extends UpgradeScript
{
    public $order = 2115;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        // are we coming from anything before 7.0?
        if (!version_compare($this->from_version, '7.0', '<')) {
            return;
        }

        // we need to ignore CE
        if (!$this->fromFlavor('pro')) {
            return;
        }

        $this->log("Creating missing RLIs for orphaned Opportunities");
        $sql = "SELECT '' as id, 
                       o.id as opportunity_id, 
                       o.name,
                       o.amount as discount_price,
                       o.worst_case, 
                       o.amount, 
                       o.best_case, 
                       o.amount as cost_price, 
                       1 as quantity, 
                       o.currency_id, 
                       o.amount/o.amount_usdollar as base_rate,
                       o.probability, 
                       o.date_closed, 
                       o.date_closed_timestamp, 
                       o.assigned_user_id, 
                       ac.account_id, 
                       o.commit_stage, 
                       o.sales_stage, 
                       o.deleted, 
                       o.date_entered, 
                       o.date_modified, 
                       o.modified_user_id, 
                       o.created_by, 
                       o.team_id, 
                       o.team_set_id 
                FROM opportunities as o 
                LEFT JOIN accounts_opportunities as ac 
                ON ac.opportunity_id = o.id 
                LEFT JOIN revenue_line_items rli 
                ON o.id = rli.opportunity_id 
                WHERE rli.id IS NULL";

        $this->log('Running SQL: ' . $sql);
        $r = $this->db->query($sql);
        $this->insertRows($r);

        $this->log("Done creating missing RLIs for orphaned Opportunities");
    }

    /**
     * Process all the results and insert them back into the db
     *
     * @param resource $results
     */
    protected function insertRows($results)
    {
        $insertSQL = "INSERT INTO revenue_line_items 
                (id, 
                 opportunity_id, 
                 name,
                 discount_price,
                 worst_case, 
                 likely_case, 
                 best_case, 
                 cost_price, 
                 quantity, 
                 currency_id, 
                 base_rate, 
                 probability, 
                 date_closed, 
                 date_closed_timestamp, 
                 assigned_user_id, 
                 account_id, 
                 commit_stage, 
                 sales_stage, 
                 deleted, 
                 date_entered, 
                 date_modified, 
                 modified_user_id, 
                 created_by, 
                 team_id, 
                 team_set_id) VALUES";

        /* @var $rli RevenueLineItem */
        $rli = BeanFactory::getBean('RevenueLineItems');

        while ($row = $this->db->fetchByAssoc($results)) {
            $row['id'] = create_guid();
            foreach ($row as $key => $value) {
                $row[$key] = $this->db->massageValue($value, $rli->getFieldDefinition($key));
            }

            $this->db->query($insertSQL . ' (' . join(',', $row) . ');');
        };
    }
}
