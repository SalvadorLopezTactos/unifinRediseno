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

use Doctrine\DBAL\Connection;

/**
 * Adds Commit Stage field to Opps in RLI mode
 * then re-saves Opps to populate commit_stage and closed_won_revenue_line_items
 */
class SugarUpgradeOpportunityAddCommitStageFieldData extends UpgradeScript
{
    public $order = 7030;
    public $type = self::UPGRADE_CUSTOM;

    public $oppBean;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->toFlavor('ent') &&
            version_compare($this->from_version, '11.3.0', '<') &&
            Opportunity::usingRevenueLineItems() &&
            Forecast::isSetup()
        ) {
            $oppsWithRLIConverter = new OpportunityWithRevenueLineItem();

            // update new fields vardefs
            $oppsWithRLIConverter->processFields();
            // add commit_stage field to layouts
            $oppsWithRLIConverter->fixForecastFields();

            // Update the commit_stage and closed_won_revenue_line_items fields for relevant Opps
            $this->oppBean = BeanFactory::newBean('Opportunities');
            $this->fixCommitStageField();
            $this->fixClosedWonRLIsField();
        }
    }

    /**
     * Fixes commit_stage field
     */
    protected function fixCommitStageField()
    {
        $forecastKeys = array_reverse($this->oppBean->getSortedForecastRangeKeys());
        foreach ($forecastKeys as $forecastKey) {
            $this->updateOppsForCommitStage($forecastKey);
        }
    }

    /**
     * Fixes closed_won_revenue_line_items field
     */
    protected function fixClosedWonRLIsField()
    {
        $closedWonStages = $this->oppBean->getRliClosedWonStages();
        $quotedClosedWonStages = [];
        foreach ($closedWonStages as $closedWonStage) {
            $quotedClosedWonStages[] = $this->db->quoted($closedWonStage);
        }

        $subquery = $this->db->getConnection()->createQueryBuilder();
        $subquery->select(['count(id)'])
            ->from('revenue_line_items')
            ->where($subquery->expr()->eq('opportunity_id', 'opportunities.id'))
            ->andWhere($subquery->expr()->in('sales_stage', $quotedClosedWonStages));

        $query = $this->db->getConnection()->createQueryBuilder();
        $query->update('opportunities')
            ->set('closed_won_revenue_line_items', '(' . $subquery->getSQL() . ')');

        $query->execute();
    }

    /**
     * Updates the commit_stage for all Opps that have RLIs with the given commit_stage
     * @param $oppIds
     * @param $commitStage
     * @throws \Doctrine\DBAL\Exception
     */
    private function updateOppsForCommitStage($commitStage)
    {
        $subquery = $this->db->getConnection()->createQueryBuilder()
            ->select('opportunity_id')
            ->distinct()
            ->from('revenue_line_items');
        $subquery->where($subquery->expr()->eq('commit_stage', $this->db->quoted($commitStage)));

        $query = $this->db->getConnection()->createQueryBuilder();
        $query->update('opportunities')
            ->set('commit_stage', $this->db->quoted($commitStage))
            ->where('id IN (' . $subquery->getSQL() . ')');
        $query->execute();
    }
}
