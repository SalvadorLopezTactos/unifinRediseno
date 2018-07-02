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

require_once('modules/Forecasts/AbstractForecastHooks.php');
class OpportunityHooks extends AbstractForecastHooks
{

    /**
     * This is a general hook that takes the Opportunity and saves it to the forecast worksheet record.
     *
     * @param Opportunity $bean The bean we are working with
     * @param string $event Which event was fired
     * @param array $args Any additional Arguments
     * @return bool
     */
    public static function saveWorksheet(Opportunity $bean, $event, $args)
    {
        if (static::isForecastSetup()) {
            /* @var $worksheet ForecastWorksheet */
            $worksheet = BeanFactory::getBean('ForecastWorksheets');
            $worksheet->saveRelatedOpportunity($bean);
            return true;
        }

        return false;
    }

    /**
     * Mark all related RLI's on a given opportunity to be deleted
     *
     * @param Opportunity $bean
     * @param $event
     * @param $args
     */
    public static function deleteOpportunityRevenueLineItems(Opportunity $bean, $event, $args)
    {
        if (static::isForecastSetup()) {
            $rlis = $bean->get_linked_beans('revenuelineitems', 'RevenueLineItems');
            foreach ($rlis as $rli) {
                $rli->mark_deleted($rli->id);
            }
        }
    }

    /**
     * Set the Sales Status based on the associated RLI's sales_stage
     *
     * @param Opportunity $bean
     * @param string $event
     * @param array $args
     */
    public static function setSalesStatus(Opportunity $bean, $event, $args)
    {
        if ($bean->ACLFieldAccess('sales_status', 'write')) {
            // we have a new bean so set the value to new and dump out
            if (empty($bean->fetched_row)) {
                $bean->sales_status = Opportunity::STATUS_NEW;
                return;
            }

            // Load forecast config so we have the sales_stage data.
            static::loadForecastSettings();

            // we don't have a new row, so figure out what we need to set it to
            $closed_won = static::$settings['sales_stage_won'];
            $closed_lost = static::$settings['sales_stage_lost'];

            $won_rlis = count(
                $bean->get_linked_beans(
                    'revenuelineitems',
                    'RevenueLineItems',
                    array(),
                    0,
                    -1,
                    0,
                    "sales_stage in ('" . join("', '", $closed_won) . "')"
                )
            );

            $lost_rlis = count(
                $bean->get_linked_beans(
                    'revenuelineitems',
                    'RevenueLineItems',
                    array(),
                    0,
                    -1,
                    0,
                    "sales_stage in ('" . join("', '", $closed_lost) . "')"
                )
            );

            $total_rlis = count($bean->get_linked_beans('revenuelineitems', 'RevenueLineItems'));

            if ($total_rlis > ($won_rlis + $lost_rlis) || $total_rlis === 0) {
                // still in progress
                $bean->sales_status = Opportunity::STATUS_IN_PROGRESS;
            } else {
                // they are equal so if the total lost == total rlis then it's closed lost,
                // otherwise it's always closed won
                if ($lost_rlis == $total_rlis) {
                    $bean->sales_status = Opportunity::STATUS_CLOSED_LOST;
                } else {
                    $bean->sales_status = Opportunity::STATUS_CLOSED_WON;
                }
            }
        }
    }

    /**
     * This handles the maintaining of the hidden RevenueLineItem when we are forecasting by Opportunities
     *
     * @param Opportunity $opp          The Opportunity Bean
     * @param string $event             What event is being handled
     * @param array $args               Any additional arguments passed in
     * @return boolean
     */
    public static function processHiddenRevenueLineItem(Opportunity $opp, $event, $args = array())
    {
        // if this is not after save, then ignore it
        if ($event != 'after_save') {
            return false;
        }

        // make sure forecasts is setup and we are forecasting by Opportunities
        if (static::isForecastSetup() && static::$settings['forecast_by'] == 'Opportunities') {
            //We create a related product entry for any new opportunity so that we may forecast on products
            // create an empty product module
            /* @var $rli RevenueLineItem */
            $rli = BeanFactory::getBean('RevenueLineItems');
            $rli->retrieve_by_string_fields(array('opportunity_id' => $opp->id));

            $rli->name = $opp->name;
            $rli->best_case = $opp->best_case;
            $rli->likely_case = $opp->amount;
            $rli->worst_case = $opp->worst_case;
            $rli->cost_price = $opp->amount;
            $rli->quantity = 1;
            $rli->currency_id = $opp->currency_id;
            $rli->base_rate = $opp->base_rate;
            $rli->probability = $opp->probability;
            $rli->date_closed = $opp->date_closed;
            $rli->date_closed_timestamp = $opp->date_closed_timestamp;
            $rli->assigned_user_id = $opp->assigned_user_id;
            $rli->opportunity_id = $opp->id;
            $rli->account_id = $opp->account_id;
            $rli->commit_stage = $opp->commit_stage;
            $rli->sales_stage = $opp->sales_stage;
            $rli->deleted = $opp->deleted;
            $rli->save();

            return true;
        }

        return false;
    }
}
