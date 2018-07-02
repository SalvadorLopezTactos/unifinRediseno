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

require_once 'clients/base/api/FilterApi.php';
require_once 'modules/pmse_Inbox/engine/PMSEEngineUtils.php';

class PMSEEngineFilterApi extends FilterApi
{
    /**
     * Visibility Applied flag
     * @var bool
     */
    public static $isVisibilityApplied = false;

    /**
     * Predefined scalar filters
     * @var array
     */
    protected static $customFilters = array('visibility', 'in_time', 'assignment_method');

    /**
     * FilterApi filters blocked by PA PMSEEngineFilterApi
     * @var array
     */
    protected static $blockedFilters = array('$favorite', '$tracker');

    /**
     * List of supported operators
     * @var array
     */
    protected static $supportedOperators = array(
        '$equals',
        '$not_equals',
        '$in',
        '$not_in',
        '$dateRange',
        '$starts',
    );

    public function registerApiRest()
    {
        return array(
            'filterModuleGet' => array(
                'reqType' => 'GET',
                'path' => array('pmse_Inbox', 'filter'),
                'pathVars' => array('module', ''),
                'method' => 'filterList',
                'jsonParams' => array('filter'),
                'exceptions' => array(
                    // Thrown in filterList
                    'SugarApiExceptionInvalidParameter',
                    // Thrown in filterListSetup and parseArguments
                    'SugarApiExceptionNotAuthorized',
                ),
//                'shortHelp' => 'Returns a list of Processes by user',
            ),
            'filterModuleAll' => array(
                'reqType' => 'GET',
                'path' => array('pmse_Inbox'),
                'pathVars' => array('module'),
                'method' => 'filterListAllPA',
                'jsonParams' => array('filter'),
                'exceptions' => array(
                    // Thrown in filterList
                    'SugarApiExceptionInvalidParameter',
                    // Thrown in filterListSetup and parseArguments
                    'SugarApiExceptionNotAuthorized',
                ),
//                'shortHelp' => 'Returns a list of Processes by user using filters',
            ),
            'filterModuleAllCount' => array(
                'reqType' => 'GET',
                'path' => array('pmse_Inbox', 'count'),
                'pathVars' => array('module', ''),
                'jsonParams' => array('filter'),
                'method' => 'filterListCount',
                'exceptions' => array(
                    // Thrown in filterListSetup
                    'SugarApiExceptionNotAuthorized',
                ),
//                'shortHelp' => 'List of all records in this module',
            ),
            'filterModuleById' => array(
                'reqType' => 'GET',
                'path' => array('pmse_Inbox', 'filter', '?'),
                'pathVars' => array('module', '', 'record'),
                'method' => 'filterById',
                'exceptions' => array(
                    // Thrown in filterById
                    'SugarApiExceptionNotFound',
                    // Thrown in filterList
                    'SugarApiExceptionInvalidParameter',
                    // Thrown in filterListSetup and parseArguments
                    'SugarApiExceptionNotAuthorized',
                ),
//                'shortHelp' => 'Filter records for a module by a predefined filter id.',
            ),
        );
    }

    /**
     * @param ServiceBase $api
     * @param array $args
     * @param string $acl
     * @return array
     * @throws SugarApiExceptionInvalidParameter
     */
    public function filterListAllPA(ServiceBase $api, array $args, $acl = 'list')
    {
        // Set the default visibility to a regular user
        if (empty($args['filter']['visibility'])) {
            $args['filter'][] = array('visibility' => 'regular_user');
        }

        return parent::filterList($api, $args, $acl);
    }

    /**
     * Overwrite filterList setup to using PA tables
     * {@inheritdoc }
     */
    public function filterListSetup(ServiceBase $api, array $args, $acl = 'list')
    {
        $seed = BeanFactory::newBean('pmse_BpmFlow');

        $options = $this->parseArguments($api, $args, $seed);

        // In case the view parameter is set, reflect those fields in the
        // fields argument as well so formatBean only takes those fields
        // into account instead of every bean property.
        if (!empty($args['view'])) {
            $args['fields'] = $options['select'];
        }

        // Create SugarQuery object including PA tables
        $q = self::getQueryObjectPA($seed, $options);

        if (!isset($args['filter']) || !is_array($args['filter'])) {
            $args['filter'] = array();
        }

        // Applying filters using PA logic
        $this->addFiltersPA($args['filter'], $q->where(), $q);

        return array($args, $q, $options, $seed);
    }

    /**
     * Check if the filter is supported by PA Process Filter API
     * @param $filter
     * @param SugarQuery $q
     * @return bool
     */
    public static function isSupportedPAFilter($filter, SugarQuery $q) {
        $fields = array_keys($q->select()->select);
        $filters = array_merge(self::$customFilters, self::$blockedFilters, $fields);
        return in_array($filter, $filters);
    }

    /**
     * @param $filter
     * @param $expression
     * @param SugarQuery_Builder_Where $where
     */
    public static function processFilterPA($filter, $expression, SugarQuery_Builder_Where $where)
    {
        switch ($filter) {
            case 'visibility':
                self::addVisibilityFilter($expression, $where);
                break;
            case 'in_time':
                self::addInTimeFilter($expression, $where);
                break;
            case 'assignment_method':
                self::addAssignmentMethodFilter($expression, $where);
                break;
            default:
                if (in_array($filter, self::$blockedFilters)) {
                    self::addInvalidFilter($where);
                } else {
                    self::addFieldFilter($filter, $expression, $where);
                }
        }
    }

    /**
     * Applies filters to the current query using PA logic
     * @param $filters
     * @param SugarQuery_Builder_Where $where
     * @param SugarQuery $q
     * @throws SugarApiExceptionInvalidParameter
     */
    public function addFiltersPA($filters, SugarQuery_Builder_Where $where, SugarQuery $q)
    {
        foreach ($filters as $filterDef) {
            foreach ($filterDef as $filter => $expression) {
                if (!self::isSupportedPAFilter($filter, $q)) {
                    throw new SugarApiExceptionInvalidParameter('ERROR_PA_FILTER_UNSUPPORTED_FILTER');
                }
                self::processFilterPA($filter, $expression, $where, $q);
            }
        }

        // Apply visibility check by default unless it was defined previously
        self::addVisibilityFilter('', $where);
    }

    /**
     * Apply visibility filters
     * @param $access
     * @param SugarQuery_Builder_Where $where
     */
    public static function addVisibilityFilter($access, SugarQuery_Builder_Where $where)
    {
        if (!self::$isVisibilityApplied) {
            // First things first... filter all records through ACLs. Start by
            // getting the PMSE supported module list...
            $supportedModules = PMSEEngineUtils::getSupportedModules();

            // Filter the PMSE modules through ACLs
            $supportedModules = SugarACL::filterModuleList($supportedModules, 'access', true);

            if (!empty($supportedModules)) {
                $where->queryAnd()->in('cas_sugar_module', $supportedModules);
            }

            // Now handle the access setting, if there is one
            if ($access == 'regular_user') {
                global $current_user;
                $where->queryAnd()->equals('cas_user_id', $current_user->id);
                $where->queryOr()->notEquals('cas_assignment_method', 'selfservice')->isNull('cas_assignment_method');
            } else {
                $supportedModules = PMSEEngineUtils::getSupportedModules();
                if (!empty($supportedModules)) {
                    $where->queryAnd()->in('cas_sugar_module', $supportedModules);
                }
            }
        }
        self::$isVisibilityApplied = true;
    }

    /**
     * Applies the in_time filter used by Process Dashlets to determinate due dates
     * @param $expression
     * @param SugarQuery_Builder_Where $where
     */
    public static function addInTimeFilter($expression, SugarQuery_Builder_Where $where) {
        $exp = self::getRawExpression($expression);
        if ($exp=== 'true') {
            $where->queryOr()
                ->gte('cas_due_date', TimeDate::getInstance()->nowDb())
                ->isNull('cas_due_date');
        } else if ($exp === 'false') {
            $where->queryAnd()
                ->isNotEmpty('cas_due_date')
                ->lte('cas_due_date', TimeDate::getInstance()->nowDb());
        }
    }

    /**
     * Sets filter for 'act_assignment_method' field
     * @param $expression
     * @param SugarQuery_Builder_Where $where
     */
    public static function addAssignmentMethodFilter($expression, SugarQuery_Builder_Where $where)
    {
        global $current_user;

        $method = self::getRawExpression($expression);
        if ($method == 'static') {
            $where->queryAnd()
                ->equals('cas_user_id', $current_user->id)
                ->queryOr()
                ->equals('activity_definition.act_assignment_method', 'static')
                ->equals('activity_definition.act_assignment_method', 'balanced')
                ->queryAnd()
                ->equals('activity_definition.act_assignment_method', 'selfservice')
                ->notNull('cas_start_date');
        } else if ($method == 'selfservice') {
            $teams = array_keys($current_user->get_my_teams());
            $where->queryAnd()
                ->in('cas_user_id', $teams)
                ->isNull('cas_start_date')
                ->equals('activity_definition.act_assignment_method', 'selfservice');
        }
    }

    /**
     * Process Filter for regular fields
     *
     * Notice: PA Processes module have not associated one only record as other modules in SugarCRM, current FilterApi is designed
     * to handle operations over those records. This method is trying to create a little copy to haandle queries through API for PA
     * but still needs a lot of work.
     * @param $field
     * @param $expression
     * @param SugarQuery_Builder_Where $where
     */
    public static function addFieldFilter($field, $expression, SugarQuery_Builder_Where $where)
    {
        list($operator, $value) = self::getExpression($expression);
        switch($operator) {
            case '$equals':
                //more dirty hack
                //will be fixed when we redo relationships with vardefs
                if ($field === 'act_name') {
                    $sql = "activity.name = '$value'";
                    $where->queryOr()->addRaw($sql);
                } else {
                    $where->equals($field, $value);
                }
                break;
            case '$not_equals':
                $where->notEquals($field, $value);
                break;
            case '$in':
                $where->in($field, $value);
                break;
            case '$not_in':
                $where->notIn($field, $value);
                break;
            case '$dateRange':
                $where->dateRange($field, $value);
                break;
            case '$starts':
                //Dirty hack to allow quicksearch filtering by activity name (process name)
                if ($field === 'act_name') {
                    $sql = "activity.name LIKE '" . $value . "%'";
                    $where->queryOr()->addRaw($sql);
                } else {
                    $where->starts($field, $value);
                }
                break;
        }
    }

    /**
     * This method is forcing to return an empty query all the time
     * @param SugarQuery_Builder_Where $where
     */
    public static function addInvalidFilter(SugarQuery_Builder_Where $where)
    {
        $where->queryAnd()->isNull('id');
    }

    /**
     * Remove visibility filter from SugarQuery object
     * @param SugarQuery_Builder_Where $where
     */
    public static function removeVisibilityFilter(SugarQuery_Builder_Where $where)
    {
        $conditions = $where->conditions;
        foreach($conditions as $key => $condition) {
            $field = $condition->field;
            if ($field->field == 'cas_user_id') {
                unset($where->conditions[$key]);
            }
        }
    }

    /**
     * Return an array with the supported operator and a value to compare
     * @param $expression
     * @return array
     * @throws SugarApiExceptionInvalidParameter
     */
    public static function getExpression($expression)
    {
        // we don't send an operator in args if the operator is $equals
        if (!is_array($expression)) {
            $value = $expression;
            $expression = array();
            $expression['$equals'] = $value;
        }

        $keys = array_keys($expression);
        $operator = $keys[0];
        if (in_array($operator, self::$supportedOperators)) {
            return array($operator, $expression[$operator]);
        } else {
            throw new SugarApiExceptionInvalidParameter('ERROR_PA_FILTER_UNSUPPORTED_OPERATOR');
        }

    }

    /**
     * Get raw value from a FilterApi expression
     * @param $expression
     * @return mixed
     */
    public static function getRawExpression($expression)
    {
        return is_array($expression) ? array_shift($expression) : $expression;
    }

    /**
     * Creates a SugarQuery instance according PA relationships
     * @param SugarBean $seed
     * @param array $options
     * @return SugarQuery
     * @throws SugarQueryException
     */
    protected static function getQueryObjectPA(SugarBean $seed, array $options)
    {
        if (empty($options['select'])) {
            $options['select'] = self::$mandatory_fields;
        }
        $queryOptions = array('add_deleted' => (!isset($options['add_deleted'])||$options['add_deleted'])?true:false);
        if ($queryOptions['add_deleted'] == false) {
            $options['select'][] = 'deleted';
        }

        $q = new SugarQuery();
        $q->from($seed, $queryOptions);
        $q->distinct(false);
        $fields = array();
        foreach ($options['select'] as $field) {
            // fields that aren't in field defs are removed, since we don't know
            // what to do with them
            if (!empty($seed->field_defs[$field])) {
                // Set the field into the field list
                $fields[] = $field;
            }
        }

        //INNER JOIN BPM INBOX TABLE
        $fields[] = array("date_entered", 'date_entered');
        $fields[] = array("cas_id", 'cas_id');
        $fields[] = array("cas_sugar_module", 'cas_sugar_module');

        $fields[] = array("cas_sugar_object_id", 'cas_sugar_object_id');
        $fields[] = array("cas_user_id",'cas_user_id');
        $fields[] = array("cas_assignment_method",'cas_assignment_method');


        $q->joinTable('pmse_inbox', array('alias' => 'inbox', 'joinType' => 'INNER', 'linkingTable' => true))
            ->on()
            ->equalsField('inbox.cas_id', 'cas_id')
            ->equals('inbox.deleted', 0);
        $fields[] = array("inbox.id", 'inbox_id');
        $fields[] = array("inbox.cas_title", 'cas_title');
        $q->where()
            ->equals('cas_flow_status', 'FORM');

        //INNER JOIN BPMN ACTIVITY DEFINITION
        $q->joinTable('pmse_bpmn_activity', array('alias' => 'activity', 'joinType' => 'INNER', 'linkingTable' => true))
            ->on()
            ->equalsField('activity.id', 'bpmn_id')
            ->equals('activity.deleted', 0);
        $fields[] = array("activity.name", 'act_name');

        //INNER JOIN BPMN ACTIVITY DEFINTION
        $q->joinTable('pmse_bpm_activity_definition', array('alias' => 'activity_definition', 'joinType' => 'INNER', 'linkingTable' => true))
            ->on()
            ->equalsField('activity_definition.id', 'activity.id')
            ->equals('activity_definition.deleted', 0);
        $fields[] = array("activity_definition.act_assignment_method", 'act_assignment_method');

        //INNER JOIN BPMN PROCESS DEFINTION
        $q->joinTable('pmse_bpmn_process', array('alias' => 'process', 'joinType' => 'INNER', 'linkingTable' => true))
            ->on()
            ->equalsField('process.id', 'inbox.pro_id')
            ->equals('process.deleted', 0);
        $fields[] = array("process.name", 'pro_title');
        $fields[] = array("process.prj_id", 'prj_id');
        $fields[] = array("process.created_by", 'prj_created_by');

        //INNER JOIN USER_DATA DEFINTION
        $q->joinTable('users', array('alias' => 'user_data', 'joinType' => 'LEFT', 'linkingTable' => true))
            ->on()
            ->equalsField('user_data.id', 'cas_user_id')
            ->equals('user_data.deleted', 0);
        $fields[] = array("user_data.user_name", 'user_name');

        //INNER JOIN TEAM_DATA DEFINTION
        $q->joinTable('teams', array('alias' => 'team_data', 'joinType' => 'LEFT', 'linkingTable' => true))
            ->on()
            ->equalsField('team_data.id', 'cas_user_id')
            ->equals('team_data.deleted', 0);
        $fields[] = array("team.name", 'team_name');

        $q->select($fields)
            ->fieldRaw('user_data.last_name', 'assigned_user_name');

        foreach ($options['order_by'] as $orderBy) {
            if ($orderBy[0] == 'pro_title'){
                $orderBy[0] = 'process.name';
            }
            if ($orderBy[0] == 'task_name'){
                $orderBy[0] = 'activity.name';
            }
            if ($orderBy[0] == 'cas_title'){
                $orderBy[0] = 'inbox.cas_title';
            }
            if ($orderBy[0] == 'cas_user_id_full_name'){
                $orderBy[0] = 'cas_user_id';
            }
            if ($orderBy[0] == 'prj_user_id_full_name'){
                $orderBy[0] = 'prj_created_by';
            }
            if ($orderBy[0] == 'assigned_user_name'){
                $orderBy[0] = 'assigned_user_name';
            }
            $q->orderBy($orderBy[0], $orderBy[1]);
        }
        // Add an extra record to the limit so we can detect if there are more records to be found
        $q->limit($options['limit'] + 1);
        $q->offset($options['offset']);

        return $q;
    }

    protected function formatBeans(ServiceBase $api, $args, $beans)
    {
        if (!empty($args['fields']) && !is_array($args['fields'])) {
            $args['fields'] = explode(',',$args['fields']);
        }

        $ret = array();

        foreach ($beans as $bean) {
            if (!is_subclass_of($bean, 'SugarBean')) {
                continue;
            }
            $arr_aux = array();
            $arr_aux['cas_id'] = (isset($bean->fetched_row['cas_id']))? $bean->fetched_row['cas_id']:$bean->fetched_row['pmse_bpm_flow__cas_id'];
            $arr_aux['act_assignment_method'] = $bean->fetched_row['act_assignment_method'];
            $arr_aux['cas_title'] = $bean->fetched_row['cas_title'];
            $arr_aux['pro_title'] = $bean->fetched_row['pro_title'];
            $arr_aux['date_entered'] = PMSEEngineUtils::getDateToFE($bean->fetched_row['date_entered'], 'datetime');
            $arr_aux['name'] = $bean->fetched_row['cas_title'];
            $arr_aux['cas_create_date'] = PMSEEngineUtils::getDateToFE($bean->fetched_row['date_entered'], 'datetime');
            $arr_aux['flow_id'] = $bean->fetched_row['id'];
            $arr_aux['id2'] = $bean->fetched_row['inbox_id'];
            $arr_aux['task_name'] = $bean->fetched_row['act_name'];
            $arr_aux['cas_assignment_method'] = $bean->fetched_row['cas_assignment_method'];
            $arr_aux['assigned_user_name'] = $bean->fetched_row['assigned_user_name'];
            $arr_aux['cas_sugar_module'] = $bean->fetched_row['cas_sugar_module'];
            $arr_aux['cas_sugar_object_id'] = $bean->fetched_row['cas_sugar_object_id'];
            $arr_aux['prj_id'] = $bean->fetched_row['prj_id'];
            $arr_aux['in_time'] = true;

            $arr_aux['cas_user_id'] = $bean->fetched_row['cas_user_id'];
            $arr_aux['prj_created_by'] = $bean->fetched_row['prj_created_by'];

            $casUsersBean = BeanFactory::getBean('Users', $bean->fetched_row['cas_user_id']);
            $arr_aux['cas_user_id_full_name'] = $casUsersBean->full_name;
            if (empty($casUsersBean->full_name)){
                $arr_aux['cas_user_id_full_name'] = $arr_aux['cas_user_id'];
            }
            $prjUsersBean = BeanFactory::getBean('Users', $bean->fetched_row['prj_created_by']);
            $arr_aux['prj_user_id_full_name'] = $prjUsersBean->full_name;

            $assignedBean = BeanFactory::getBean($arr_aux['cas_sugar_module'], $arr_aux['cas_sugar_object_id']);
            $assignedUsersBean = BeanFactory::getBean('Users', $assignedBean->assigned_user_id);
            $arr_aux['assigned_user_name'] = $assignedUsersBean->full_name;

            $ret[] = array_merge($this->formatBean($api, $args, $bean), $arr_aux);
        }

        return $ret;
    }

    protected function getOrderByFromArgs(array $args, SugarBean $seed = null)
    {
        $orderBy = array();
        if (!isset($args['order_by']) || !is_string($args['order_by'])) {
            return $orderBy;
        }

        $columns = explode(',', $args['order_by']);
        $parsed = array();
        foreach ($columns as $column) {
            $column = explode(':', $column, 2);
            $field = array_shift($column);

            // do not override previous value if it exists since it should have higher precedence
            if (!isset($parsed[$field])) {
                $direction = array_shift($column);
                $parsed[$field] = strtolower($direction) !== 'desc';
            }
        }

        $converted = array();
        foreach ($parsed as $field => $direction) {
            $converted[] = array($field, $direction ? 'ASC' : 'DESC');
        }

        return $converted;
    }
}
