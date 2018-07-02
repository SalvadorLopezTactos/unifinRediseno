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

require_once('include/RecordListFactory.php');
require_once('modules/Reports/Report.php');
require_once('clients/base/api/ModuleApi.php');

class ReportsApi extends ModuleApi
{
    public function registerApiRest()
    {
        return array(
            'recordListCreate' => array(
                'reqType' => 'POST',
                'path' => array('Reports', '?', 'record_list'),
                'pathVars' => array('', 'record', ''),
                'method' => 'createRecordList',
                'shortHelp' => 'An API to create a record list from a saved report',
                'longHelp' => 'modules/Reports/api/help/module_recordlist_post.html',
            ),
        );
    }

    /**
     * Creates a record list from a saved report
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API containing the module and the records
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiException
     * @return array id, module, records
     */
    public function createRecordList($api, $args)
    {
        $this->requireArgs($args, array("record"));

        $savedReport = BeanFactory::newBean("Reports");
        if (!$savedReport->ACLAccess('access')) {
            throw new SugarApiExceptionNotAuthorized();
        }

        $recordIds = $this->getRecordIdsFromReport($args["record"]);
        $id = RecordListFactory::saveRecordList($recordIds, "Reports");
        $loadedRecordList = RecordListFactory::getRecordList($id);

        return $loadedRecordList;
    }

    /**
     * Returns the record ids of a saved report
     * @param $reportId
     *
     * @return array Array of record ids
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiException
     */
    protected function getRecordIdsFromReport($reportId)
    {
        $recordIds = array();

        $savedReport = $this->getSavedReportById($reportId);

        if (!$savedReport->ACLAccess('view')) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: Reports');
        }
        if (empty($savedReport->id)) {
            throw new SugarApiExceptionNotAuthorized('Unable to retrieve report');
        }
        if (!empty($savedReport->content)) {
            $results = $savedReport->runReportQuery();

            foreach ($results as $record) {
                if(isset($record['primaryid'])){
                    $recordIds[] = $record['primaryid'];
                }
            }
        }

        return $recordIds;
    }

    /**
     * Retrieves a saved Report by Report Id
     * @param $reportId
     *
     * @return SugarBean
     */
    protected function getSavedReportById($reportId)
    {
        return BeanFactory::getBean("Reports", $reportId);
    }
}
