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
class SugarUpgradeRecalcQuote extends UpgradeScript
{
    public $order = 9000;
    public $type = self::UPGRADE_CUSTOM;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (version_compare($this->from_version, '7.9.0.0', '<')) {
            $this->updateQuotes();
        }
    }

    /**
     * runs SQL to recalculate added sugarlogic on existing and new fields
     */
    public function updateQuotes()
    {
        $conn = $this->getDBConnection();
        /**
         * this sql actually works on all our supported dbs, so instead of splitting the table creation/deletion
         * into separate driver calls, I'm doing it all in one shot here.
         **/
        $sql1 = 'create TABLE tmp_pbupgrade
                (
                  id varchar(36) not null primary key,
                  taxable_subtotal decimal(26,6)
                )';
        $conn->executeQuery($sql1);

        $sql2 = 'insert into tmp_pbupgrade
                select pb.id, coalesce(sum(p.total_amount),0) taxable_subtotal from product_bundles pb
                inner join product_bundle_product pbp
                    on pbp.bundle_id = pb.id
                inner join products p
                    on p.id = pbp.product_id
                    and p.tax_class = \'Taxable\'
                    and p.deleted = 0
                where pb.deleted = 0
                group by pb.id';
        $conn->executeQuery($sql2);

        $sql3 = 'update product_bundles
                  set product_bundles.taxable_subtotal = (
                      select taxable_subtotal
                        from tmp_pbupgrade tpb
                        where tpb.id = product_bundles.id
                  )';
        $conn->executeQuery($sql3);

        $sql4 = 'drop table tmp_pbupgrade';
        $conn->executeQuery($sql4);

        $sql5 = 'create table tmp_quoteupgrade
                (
                    id varchar(36) not null primary key,
                    taxrate_value decimal(26,6),
                    deal_tot_discount_percentage decimal(26,6),
                    taxable_subtotal decimal(26,6),
                    tax decimal(26,6),
                    tax_usdollar decimal(26,6),
                    total decimal(26,6),
                    total_usdollar decimal(26,6)
                )';
        $conn->executeQuery($sql5);

        $sql6 = 'insert into tmp_quoteupgrade
                select
                    q.id,
                    max(coalesce(t.value, 0)) as taxrate_value,
                  max(case when q.subtotal_usdollar = 0 then 0 else ((q.deal_tot_usdollar / q.subtotal_usdollar) * 100) end) as deal_tot_discount_percentage,
                    coalesce(sum(pb.taxable_subtotal), 0) as taxable_subtotal,
                    (coalesce(sum(pb.taxable_subtotal), 0) * max(coalesce(t.value, 0)/100)) as tax,
                    ((coalesce(sum(pb.taxable_subtotal), 0) * (coalesce(max(t.value), 0)/100))/max(q.base_rate)) as tax_usdollar,
                    ((coalesce(sum(pb.taxable_subtotal), 0) * (coalesce(max(t.value), 0)/100)) + max(q.shipping) + sum(pb.new_sub)) as total,
                    max(q.total/q.base_rate) as total_usdollar
                from quotes q
                inner join product_bundle_quote pbq
                    on pbq.quote_id = q.id
                inner join product_bundles pb
                    on pb.id = pbq.bundle_id
                    and pb.deleted = 0
                left join taxrates t
                    on t.id = q.taxrate_id
                where q.deleted = 0
                group by q.id';
        $conn->executeQuery($sql6);

        $sql7 = 'update quotes
                  set quotes.deal_tot_discount_percentage = (
                      select tqu.deal_tot_discount_percentage from tmp_quoteupgrade tqu
                      where quotes.id = tqu.id
                  ),
                    quotes.taxable_subtotal = (
                        select tqu.taxable_subtotal from tmp_quoteupgrade tqu
                        where quotes.id = tqu.id
                    ),
                    quotes.tax = (
                        select tqu.tax from tmp_quoteupgrade tqu
                        where quotes.id = tqu.id
                    ),
                    quotes.tax_usdollar = (
                        select tqu.tax_usdollar from tmp_quoteupgrade tqu
                        where quotes.id = tqu.id
                    ),
                    quotes.total = (
                        select tqu.total from tmp_quoteupgrade tqu
                        where quotes.id = tqu.id
                    ),
                    quotes.total_usdollar = (
                        select tqu.total_usdollar from tmp_quoteupgrade tqu
                        where quotes.id = tqu.id
                    ),
                    quotes.taxrate_value = (
                        select tqu.taxrate_value from tmp_quoteupgrade tqu
                        where quotes.id = tqu.id
                    )';
        $conn->executeQuery($sql7);

        $sql8 = 'drop table tmp_quoteupgrade';
        $conn->executeQuery($sql8);
    }

    /**
     * Gets the DB connection for the query
     * @return \Sugarcrm\Sugarcrm\Dbal\Connection
     */
    protected function getDBConnection()
    {
        $db = DBManagerFactory::getInstance();
        return $db->getConnection();
    }
}
