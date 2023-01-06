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
        'emails' => 'Emails',
        'messages' => 'Messages',
        'tasks' => 'Tasks',
        'changes' => 'Audit',
        // Market Modules
        'sf_webactivity' => 'sf_webActivity',
        'sf_dialogs' => 'sf_Dialogs',
        'sf_eventmanagement' => 'sf_EventManagement',
    ];

    /**
     * Custom links.
     * @var array
     */
    protected $linkNames = [
        'Accounts' => [
            'sf_webActivity' => 'sf_webactivity_accounts',
        ],
        'Contacts' => [
            'Tasks' => 'all_tasks',
            'Messages' => 'message_invites',
            'sf_webActivity' => 'sf_webactivity_contacts',
            'sf_Dialogs' => 'sf_dialogs_contacts',
            'sf_EventManagement' => 'sf_eventmanagement_contacts',
        ],
        'Leads' => [
            'Messages' => 'message_invites',
            'sf_webActivity' => 'sf_webactivity_leads',
            'sf_Dialogs' => 'sf_dialogs_leads',
            'sf_EventManagement' => 'sf_eventmanagement_leads',
        ],
    ];

    /**
     * {@inheritDoc}
     */
    protected $moduleFilters = [];

    /**
     * {@inheritDoc}
     */
    protected $validFields = [];

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
    public function getRelatedActivities(ServiceBase $api, array $args, string $acl = 'list'): array
    {
        if (!empty($args['module_list'])) {
            $moduleList = explode(',', $args['module_list']);
            if (in_array('Audit', $moduleList)) {
                $this->auditSetup($api, $args);
            }
        }

        $this->setupLinks($api, $args);

        // get a list of relate records ordered by date
        $data = $this->filterModuleList($api, $args, $acl);
        // get all changes
        $changes = $this->getAuditRecords($api, $args);
        $records = [];

        foreach ($data['records'] as $record) {
            $module = $record['_module'];
            if ($module === 'Audit') {
                $index = array_search($record['id'], array_column($changes, 'id'));
                if ($index !== false) {
                    $changes[$index]['_module'] = $module;
                    $records[] = $changes[$index];
                }
            } else {
                $fields = $args['field_list'] ?? [];
                $moduleFields = $fields[$module] ?? '';
                $records[] = $this->getFullRecord($api, $record, $moduleFields);
            }
        }

        $data['records'] = $records;
        return $data;
    }

    /**
     * Set custom links.
     * @param ServiceBase $api
     * @param array $args
     */
    protected function setupLinks(ServiceBase $api, array $args)
    {
        $module = $args['module'] ?? '';
        if (in_array($module, array_keys($this->linkNames))) {
            $links = $this->linkNames[$module];
            foreach ($links as $linkModule => $linkName) {
                $key = array_search($linkModule, $this->moduleList);
                if ($key !== false) {
                    unset($this->moduleList[$key]);
                }
                $this->moduleList[$linkName] = $linkModule;
            }
        }
    }

    /**
     * Setup configs for Audit query.
     * @param ServiceBase $api
     * @param array $args
     */
    protected function auditSetup(ServiceBase $api, array $args)
    {
        // need extra fields for query
        $this->validFields = [
            'assigned_user_id',
            'event_id',
        ];

        // add filter to exclude changes from 'create' event
        $this->moduleFilters['Audit'] = [];
        $eventId = $this->getCreateEventId($args['record']);

        if ($eventId) {
            $this->moduleFilters['Audit'][] = [
                'event_id' => [
                    '$not_equals' => $eventId,
                ],
            ];
        }

        // add filter to get changes for selected fields
        $fields = $this->getAuditFields($api, $args);

        if (!empty($fields)) {
            $this->moduleFilters['Audit'][] = [
                'field_name' => [
                    '$in' => $fields,
                ],
            ];
        }
    }

    /**
     * Get field_list for Audit and check access
     * @param ServiceBase $api
     * @param array $args
     * @return array
     */
    protected function getAuditFields(ServiceBase $api, array $args): array
    {
        $fields = [];

        if (isset($args['field_list']) && !empty($args['field_list']['Audit'])) {
            $fields = explode(',', $args['field_list']['Audit']);
            $module = $args['module'];
            $fields = array_filter($fields, function ($field) use ($module) {
                return SugarACL::checkField($module, $field, 'access');
            });
        }

        return $fields;
    }

    /**
     * Get audit event id for the 'create' event for a bean
     * @param string $beanId
     * @return string
     */
    protected function getCreateEventId(string $beanId): string
    {
        $id = '';
        $qb = DBManagerFactory::getInstance()->getConnection()->createQueryBuilder();
        // 'create' event should be the first 'update' event for a bean
        $query = $qb->select('id')
            ->from('audit_events')
            ->where($qb->expr()->eq('parent_id', $qb->expr()->literal($beanId)))
            ->andWhere($qb->expr()->eq('type', $qb->expr()->literal('update')))
            ->orderBy('date_created', 'ASC')
            ->setMaxResults(1);
        $result = $query->execute();

        if ($result) {
            $row = $result->fetchAssociative();
            $id = $row['id'] ?? '';
        }

         return $id;
    }

    /**
     * Get full data for a bean
     * @param ServiceBase $api
     * @param array $record
     * @param array $fields
     * @return array
     */
    protected function getFullRecord(ServiceBase $api, array $record, string $fields = ''): array
    {
        $moduleApi = new ModuleApi();
        $metadataManager = MetaDataManager::getManager($api->platform);
        // use the same logic as frontend to decide which view to return data for
        $module = $record['_module'];
        $view = empty($metadataManager->getModuleView($module, 'preview')) ? 'record' : 'preview';
        $args = [
            'module' => $module,
            'record' => $record['id'],
            'view' => $view,
            'erased_fields' => true,
        ];
        if (!empty($fields)) {
            $args['fields'] = $fields;
        }
        return $moduleApi->retrieveRecord($api, $args);
    }

    /**
     * Get audit records for a bean
     * @param ServiceBase $api
     * @param array $args
     * @return array
     */
    protected function getAuditRecords(ServiceBase $api, array $args): array
    {
        // global $focus is needed by some Audit functions
        global $focus;
        $focus = BeanFactory::getBean($args['module'], $args['record']);
        $audit = BeanFactory::getBean('Audit');
        $records = $audit->getAuditLog($focus);
        unset($focus);
        return $records;
    }

    /**
     * {@inheritDoc}
     * @see RelateApi::getLinkBean()
     */
    protected function getLinkBean(SugarBean $record, string $linkName): SugarBean
    {
        // 'changes' is purposely not added to vardefs to avoid being picked up accidently by other processes
        if ($linkName === 'changes') {
            if (!$record->$linkName) {
                // add link field
                $relName = strtolower($record->getModuleName()) . '_audit';
                if (!SugarRelationshipFactory::getInstance()->relationshipExists($relName)) {
                    throw new SugarApiExceptionNotFound('Could not find a relationship named: ' . $relName);
                }
                $linkDef = [
                    'name' => 'changes',
                    'type' => 'link',
                    'relationship' => $relName,
                    'source' => 'non-db',
                    'vname' => 'LBL_CHANGES',
                ];
                $record->$linkName = new Link2($linkName, $record, $linkDef);
            }
            $linkModuleName = 'Audit';
            $linkSeed = BeanFactory::newBean($linkModuleName);
            $linkSeed->table_name = $record->get_audit_table_name();
            if (!$linkSeed->ACLAccess('list')) {
                throw new SugarApiExceptionNotAuthorized('No access to list records for module: ' . $linkModuleName);
            }
        } else {
            $linkSeed = parent::getLinkBean($record, $linkName);
        }
        return $linkSeed;
    }
}
