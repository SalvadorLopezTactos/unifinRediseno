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

require_once('include/api/SugarApi.php');
require_once('include/SugarQuery/SugarQuery.php');

class ReportsDashletsApi extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            'getSavedReports' => array(
                'reqType' => 'GET',
                'path' => array('Reports', 'saved_reports'),
                'pathVars' => array('', ''),
                'method' => 'getSavedReports',
                'shortHelp' => 'Returns items from the saved_reports table based on a few criteria',
                'longHelp' => 'modules/Reports/clients/base/api/help/ReportsDashletApiGetSavedReports.html',
            ),
            'getSavedReportChartById' => array(
                'reqType' => 'POST',
                'path' => array('Reports', 'chart', '?'),
                'pathVars' => array('', '', 'reportId'),
                'method' => 'getSavedReportChartById',
                'shortHelp' => 'Updates a ForecastWorksheet model',
                'longHelp' => 'modules/Reports/clients/base/api/help/ReportsDashletApiGetSavedReportById.html',
            )
        );
    }

    /**
     * Retrieves all saved reports that meet args-driven criteria
     *
     * @param $api ServiceBase The API class of the request
     * @param $args array The arguments array passed in from the API
     * @return array
     */
    public function getSavedReports($api, $args)
    {
        // Make sure the user isn't seeing reports they don't have access to
        require_once('modules/Reports/SavedReport.php');
        $modules = array_keys(getACLDisAllowedModules());
        $fieldList = array('id', 'name', 'module', 'report_type', 'content', 'chart_type', 'assigned_user_id');

        $sq = new SugarQuery();
        $sq->from(BeanFactory::getBean('Reports'));
        $sq->select($fieldList);
        $sq->orderBy('name', 'asc');

        // if there were restricted modules, add those to the query
        if(count($modules)) {
            $sq->where()->notIn('module', $modules);
        }

        if(isset($args['has_charts']) && $args['has_charts'] == 'true') {
            $sq->where()->notEquals('chart_type', 'none');
        }

        $result = $sq->execute();
        // check acls
        foreach ($result as $key => &$row) {
            $savedReport = $this->getSavedReportFromData($row);

            if ($savedReport->ACLAccess('list')) {
                // for front-end to check acls
                $row['_acl'] = ApiHelper::getHelper($api,$savedReport)->getBeanAcl($savedReport, $fieldList);
            }
            else {
                unset($result[$key]);
            }
        }
        return $result;
    }


    /**
     * Retrieves a saved report and chart data, given a report ID in the args
     *
     * @param $api ServiceBase The API class of the request
     * @param $args array The arguments array passed in from the API
     * @return array
     */
    public function getSavedReportChartById($api, $args)
    {
        require_once("include/SugarCharts/ChartDisplay.php");

        $chartReport = $this->getSavedReportById($args['reportId']);

        if (!empty($chartReport)) {
            if (!$chartReport->ACLAccess('view')) {
                throw new SugarApiExceptionNotAuthorized('No access to view this report');
            }

            $returnData = array();

            $this->title = $chartReport->name;

            require_once("modules/Reports/Report.php");

            $reporter = new Report($chartReport->content);
            $reporter->saved_report_id = $chartReport->id;

            if ($reporter && !$reporter->has_summary_columns()) {
                return '';
            }

            // build report data since it isn't a SugarBean
            $reportData = array();
            $reportData['name'] = $reporter->name;
            $reportData['id'] = $reporter->saved_report_id;

            // add reportData to returnData
            $returnData['reportData'] = $reportData;

            $chartDisplay = new ChartDisplay();
            $chartDisplay->setReporter($reporter);

            $chart = $chartDisplay->getSugarChart();

            $json = json_decode($chart->buildJson($chart->generateXML()));

            $returnData['chartData'] = $json;

            return $returnData;
        }
    }

    /**
     * Retrieves a saved Report by Report Id
     * @param $reportId
     *
     * @return SugarBean
     */
    protected function getSavedReportById($reportId)
    {
        return BeanFactory::getBean("Reports", $reportId, array("encode" => false));
    }

    /**
     * Creates a SavedReport bean from query result
     * @param $row
     *
     * @return SugarBean
     */
    protected function getSavedReportFromData($row)
    {
        $savedReport = BeanFactory::getBean('Reports');
        $savedReport->populateFromRow($row);
        return $savedReport;
    }
}
