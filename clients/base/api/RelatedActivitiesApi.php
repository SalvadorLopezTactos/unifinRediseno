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

/**
 * Class RelatedActivitiesApi
 */
class RelatedActivitiesApi extends HistoryApi
{
    /**
     * {@inheritDoc}
     */
    protected $moduleList = [
        'meetings' => 'Meetings',
        'calls' => 'Calls',
        'notes' => 'Notes',
        'tasks' => 'Tasks',
        'emails' => 'Emails',
        'messages' => 'Messages',
    ];

    /**
     * {@inheritDoc}
     */
    protected $moduleFilters = [];

    /**
     * {@inheritDoc}
     */
    public function registerApiRest()
    {
        return [
            'recordListView' => [
                'reqType' => 'GET',
                'path' => ['<module>', '?', 'link', 'related_activities'],
                'pathVars' => array('module', 'record', ''),
                'method' => 'getRelatedActivities',
                'minVersion' => '11.7',
                'shortHelp' => 'Get the related activity records for a specific record',
                'longHelp' => 'include/api/help/related_activities.html',
            ],
        ];
    }

    /**
     * @param ServiceBase $api
     * @param array $args
     * @param string $acl
     * @return array
     */
    public function getRelatedActivities(ServiceBase $api, array $args, string $acl = 'list')
    {
        return parent::filterModuleList($api, $args, $acl);
    }
}
