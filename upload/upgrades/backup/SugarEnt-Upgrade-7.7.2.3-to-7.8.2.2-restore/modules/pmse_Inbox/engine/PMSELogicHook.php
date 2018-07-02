<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
require_once 'modules/pmse_Inbox/engine/PMSEHandlers/PMSEHookHandler.php';

class PMSELogicHook
{
    function before_save($bean, $event, $arguments)
    {
        if (!$this->isSugarInstalled()) {
            return true;
        }

        if (!$this->isExpectedModule($bean)) {
            return true;
        }
        //Define PA Hook Handler
        $hookHandler = new PMSEHookHandler();
        //Define if this is a new record or an updated record
        $isNewRecord = empty($bean->fetched_row['id']);
        return $hookHandler->runStartEventBeforeSave($bean, $event, $arguments, array(), $isNewRecord);
    }

    function after_save($bean, $event, $arguments)
    {
        if (!$this->isSugarInstalled()) {
            return true;
        }

        if (!$this->isExpectedModule($bean)) {
            return true;
        }
        //Define PA Hook Handler
        $handler = new PMSEHookHandler();
        return $handler->runStartEventAfterSave($bean, $event, $arguments);
    }

    function after_delete($bean, $event, $arguments)
    {
        if (!$this->isSugarInstalled()) {
            return true;
        }

        if (!$this->isExpectedModule($bean)) {
            return true;
        }
        //Define PA Hook Handler
        $handler = new PMSEHookHandler();
        return $handler->terminateCaseAfterDelete($bean, $event, $arguments);
    }

    private function isExpectedModule($bean)
    {
        include 'modules/pmse_Inbox/engine/PMSEModules.php';
        $pmseModulesList = (isset($pmseModulesList)) ? $pmseModulesList : array();
        //returns immediately if the bean is a common module
        $result = true;
        //Modules that will not be processed by PA
        $blacklistedModules = array(
            'Teams',
            'UserPreferences',
            'Subscriptions',
            'OAuthToken',
            'Dashboards',
            'Activities',
            'Filters',
            'ACLAction',
            'SessionManager',
            'vCal',
            'TeamSetModule',
            'ForecastWorksheet',
            'ACLField',
            'ACLRole',
            'DocumentRevision',
            'SavedReport',
            'ForecastManagerWorksheet',
            'KBDocumentRevision',
            'KBDocumentKBTag',
            'EmailTemplate',
            'TeamMembership',
            'TaxRate',
            'TeamSets',
            'Import',
            'Email',
            'ACLRoleSet',
            'FieldsMetaData',
            'EmailAddress',
            'SchedulersJob',
            'Scheduler',
            'SugarFavorites',
            'OAuthKey',
            'TeamNotices',
            'UpgradeHistory',
            'WebLogicHook',
            'Currency',
            'Notifications',
            'EAPM',
            'TimePeriod',
            'MonthTimePeriod',
            'AnnualTimePeriod',
            'QuarterTimePeriod',
            'InboundEmail',
            'Home',
            'Calendar',
            'Currencies',
            'WebLogicHooks',
            'ProductCategories',
            'ProductTypes',
            'Reports',
            'ForecastWorksheets',
            'ForecastManagerWorksheets',
            'MergeRecords',
            'Quotas',
            'Manufacturers',
            'Comments',
            'Feeds',
            'iFrames',
            'TimePeriods',
            'TaxRates',
            'ContractTypes',
            'Schedulers',
            'CampaignLog',
            'CampaignTrackers',
            'DocumentRevisions',
            'Connectors',
            'Roles',
            'Sync',
            'ReportMaker',
            'DataSets',
            'CustomQueries',
            'WorkFlow',
            'Worksheet',
            'Administration',
            'ACLRoles',
            'Releases',
            'Queues',
            'EmailMarketing',
            'EmailTemplates',
            'SNIP',
            'ProspectLists',
            'SavedSearch',
            'UpgradeWizard',
            'Trackers',
            'TrackerPerfs',
            'TrackerSessions',
            'TrackerQueries',
            'FAQ',
            'Newsletters',
            'PdfManager',
            'OAuthKeys',
            'OAuthTokens',
            'UserSignatures',
            'Shippers',
            'Styleguide',
            'Library',
            'EmailAddresses',
            'Words',
            'Sugar_Favorites',
            'Audit',
        );
        if (isset($bean->module_name)) {
            $excludedModules = array_merge($blacklistedModules, $pmseModulesList);
            if (in_array($bean->module_name, $excludedModules) OR in_array($bean->object_name, $excludedModules)) {
                return false;
            }
        }

        return $result;
    }

    private function isSugarInstalled()
    {
        global $sugar_config;

        if( !isset($sugar_config['installer_locked']) || $sugar_config['installer_locked'] == false ){
            return false;
        }
        return true;
    }
}
