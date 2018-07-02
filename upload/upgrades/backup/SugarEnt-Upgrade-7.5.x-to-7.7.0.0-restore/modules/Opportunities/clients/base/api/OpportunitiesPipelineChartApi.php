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

class OpportunitiesPipelineChartApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'pipeline' => array(
                'reqType' => 'GET',
                'path' => array('Opportunities', 'chart', 'pipeline'),
                'pathVars' => array('module', '', ''),
                'method' => 'pipeline',
                'shortHelp' => 'Get the current opportunity pipeline data for the current timeperiod',
                'longHelp' => 'modules/Opportunities/clients/base/api/help/OpportunitiesPipelineChartApi.html',
            ),
            'pipelineWithTimeperiod' => array(
                'reqType' => 'GET',
                'path' => array('Opportunities', 'chart', 'pipeline', '?'),
                'pathVars' => array('module', '', '', 'timeperiod_id'),
                'method' => 'pipeline',
                'shortHelp' => 'Get the current opportunity pipeline data for a specific timeperiod',
                'longHelp' => 'modules/Opportunities/clients/base/api/help/OpportunitiesPipelineChartApi.html',
            ),
            'pipelineWithTimeperiodAndTeam' => array(
                'reqType' => 'GET',
                'path' => array('Opportunities', 'chart', 'pipeline', '?', '?'),
                'pathVars' => array('module', '', '', 'timeperiod_id', 'type'),
                'method' => 'pipeline',
                'shortHelp' => 'Get the current opportunity pipeline data for the current timeperiod',
                'longHelp' => 'modules/Opportunities/clients/base/api/help/OpportunitiesPipelineChartApi.html',
            ),
        );
    }

    public function pipeline(ServiceBase $api, $args)
    {

        // Check for permissions on both Revenue line times and accounts.
        /* @var $seed Opportunity */
        $seed = BeanFactory::newBean($args['module']);
        if (!$seed->ACLAccess('view')) {
            throw new SugarApiExceptionNotAuthorized();
        }

        // we have no timeperiod defined, so lets just pull the current one
        if (empty($args['timeperiod_id'])) {
            $args['timeperiod_id'] = TimePeriod::getCurrentId();
        }

        // validate timeperiod_id
        // fix up the timeperiod filter
        /* @var $tp TimePeriod */
        // we use retrieveBean so it will return NULL and not an empty bean if the $args['timeperiod_id'] is invalid
        $tp = BeanFactory::retrieveBean('TimePeriods', $args['timeperiod_id']);
        if (is_null($tp) || empty($tp->id)) {
            throw new SugarApiExceptionInvalidParameter('Provided TimePeriod is invalid');
        }

        // check the type param
        if (!isset($args['type']) || ($args['type'] != 'user' && $args['type'] != 'group')) {
            $args['type'] = 'user';
        }

        // pull the forecast settings
        /* @var $admin Administration */
        $admin = BeanFactory::getBean('Administration');
        $settings = $admin->getConfigForModule('Forecasts', $api->platform);

        // get sales_stages to ignore
        $ignore_stages = array_merge($settings['sales_stage_won'], $settings['sales_stage_lost']);

        // build out the query
        $sq = new SugarQuery();
        $sq->select(array('id', 'sales_stage', 'amount', 'base_rate'));
        $sq->from($seed)
            ->where()
            ->gte('date_closed_timestamp', $tp->start_date_timestamp)
            ->lte('date_closed_timestamp', $tp->end_date_timestamp);

        $sq->orderBy('probability', 'DESC');

        // determine the type we need to fetch
        if ($args['type'] == 'user') {
            // we are only looking at our pipeline
            $sq->where()->equals('assigned_user_id', $api->user->id);
        } else {
            // we need to fetch ours + everyone under us (the whole tree)
            // get the reporting users
            $users = $this->getReportingUsers($api->user->id);
            // add current_user to the users_list
            array_unshift($users, $api->user->id);
            $sq->where()->in('assigned_user_id', array_values($users));
        }

        // run the query
        $rows = $sq->execute();
        // data storage
        $data = array();
        // keep track of the total for later user
        $total = '0';
        foreach ($rows as $row) {
            // if the sales stage is one we need to ignore, the just continue to the next record
            if (in_array($row['sales_stage'], $ignore_stages)) {
                continue;
            }

            // if we have not seen this sales stage before, set the value to zero (0)
            if (!isset($data[$row['sales_stage']])) {
                $data[$row['sales_stage']] = array('count' => 0, 'total' => '0');
            }

            // if customers have made amount not required, it saves to the DB as NULL
            // make sure we set it to 0 for the math ahead
            if (empty($row['amount'])) {
                $row['amount'] = 0;
            }

            // convert to the base currency
            $base_amount = SugarCurrency::convertWithRate($row['amount'], $row['base_rate']);

            // add the new value into what was already there
            $data[$row['sales_stage']]['total'] = SugarMath::init($data[$row['sales_stage']]['total'], 0)->add(
                $base_amount
            )->result();
            $data[$row['sales_stage']]['count']++;

            // add to the total
            $total = SugarMath::init($total, 0)->add($base_amount)->result();
        }

        // get the default currency
        /* @var $currency Currency */
        $currency = SugarCurrency::getBaseCurrency();

        // setup for return format
        $return_data = array();
        $series = 0;
        $previous_value = '0';
        foreach ($data as $key => $item) {
            $value = $item['total'];
            // set up each return key
            $return_data[] = array(
                'key' => $key,          // the label/sales stage
                'count' => $item['count'],
                'values' => array(      // the values used in the grid
                    array(
                        'series' => $series++,
                        'label' => SugarCurrency::formatAmount($value, $currency->id, 0),
                        // sending value by itself as 'y' gets manipulated by scale on the frontend
                        // this way we maintain the actual value's integrity
                        'value' => intval($value),
                        'x' => 0,
                        'y' => intval($value),                  // this needs to be an integer
                        'y0' => intval($previous_value)         // this needs to be an integer
                    )
                )
            );
            // save the previous value for use in the next item in the series
            $previous_value = SugarMath::init($previous_value, 0)->add($value)->result();
        }

        // actually return the formatted data
        $mod_strings = return_module_language($GLOBALS['current_language'], 'Opportunities');

        return array(
            'properties' => array(
                'title' => $mod_strings['LBL_PIPELINE_TOTAL_IS'] . SugarCurrency::formatAmount($total, $currency->id),
                'total' => $total,
                'scale' => 1000,
                'units' => $currency->symbol
            ),
            'data' => $return_data
        );
    }

    /**
     * Recursive Method to Retrieve the full tree of reportees for your team.
     *
     * @param string $user_id       User to check for reportees on
     * @return array
     */
    protected function getReportingUsers($user_id)
    {
        $final_users = array();
        $reporting_users = User::getReporteesWithLeafCount($user_id);

        foreach($reporting_users as $user => $reportees) {
            $final_users[] = $user;
            // if the user comes back with zero (0) for the count, don't try as they don't have any reportees
            if($reportees > 0) {
                $final_users = array_merge($final_users, $this->getReportingUsers($user));
            }
        }

        return $final_users;
    }
}
