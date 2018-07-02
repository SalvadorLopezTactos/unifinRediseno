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
require_once 'include/SugarQuery/SugarQuery.php';
require_once 'modules/pmse_Inbox/engine/PMSEEngineUtils.php';
/**
 * CRUD Wrapper to manage records related to History Logs
 *
 * An instance of this class can get, post, put and delete the record related to History Logs
 *
 */
class PMSEHistoryLogWrapper
{
    /**
     *
     * @var string
     */
    private $pre_data;

    /**
     *
     * @var string
     */
    private $post_data;

    /**
     *
     * @var long
     */
    private $start_time;

    /**
     *
     * @var long
     */
    private $end_time;

    /**
     *
     * @var object
     */
    private $formAction;

    /**
     *
     * @var object
     */
    private $flow;

    /**
     *
     * @var object
     */
    private $flowItself;

    /**
     *
     * @var integer
     */
    private $case_id;

    /**
     * Setting formActionBean, flowBean, userBean objects
     * @param int caseId
     */
    public function __construct($caseId = 0)
    {
        $this->case_id = $caseId;
        ///$this->formAction = new BpmFormAction();
        $this->formAction = BeanFactory::getBean('pmse_BpmFormAction');
        //$this->flowItself = new BpmnFlow();
        $this->flowItself = BeanFactory::getBean('pmse_BpmnFlow');
        //$this->flow = new BpmFlow();
        $this->flow = BeanFactory::getBean('pmse_BpmFlow');
        $this->data = new stdClass();
        $this->currentUser = new User();
        global $db;
        $this->db = $db;
    }

    /**
     * GET data with client object.
     * Returns assembly data object by id. that id is passed into an array named args.
     * return the object is constructed with the success attribute set to true if
     * records are obtained, false otherwise
     *
     * @param array $args
     * @return multitype:boolean Ambigous <string, array>
     */
    public function _get(array $args)
    {

        if (!isset($args) || !is_array($args) || sizeof($args) <= 0) {

            $this->data->error = translate('LBL_PMSE_ADAM_WRAPPER_HISTORYLOG_ARGUMENTEMPTY', 'pmse_Project');
            $this->data->result = false;
        } else {
            $this->case_id = (isset($args['filter']) ? $args['filter'] : 0);
            $this->data->case_fetch = $this->case_id;
            $this->data->result = $this->assemblyEntries();
            $this->data->success = sizeof($this->data->result) > 0;
        }


        return $this->data;
    }

    /**
     * POST data with client object.
     * This method overrides the bpmFormAction record object. that object is passed
     * into an array named args.
     *
     * @param array $args
     * @return object
     */
    public function _post(array $args)
    {
        //$result->message = translate('LBL_PMSE_ADAM_WRAPPER_HISTORYLOG_CANNOTUPDATELOG', 'pmse_Project');
        $this->data->success = false;
        return $this->data;
    }

    /**
     * PUT data with client object.
     * This method updates the bpmFormAction record object. that object is passed
     * into an array named args.
     * @param array $args
     * @return object
     */
    public function _put(array $args)
    {
        //$result = new stdClass();
        //$result->message = translate('LBL_PMSE_ADAM_WRAPPER_HISTORYLOG_CANNOTADDLOG', 'pmse_Project');
        $this->data->success = false;
        return $this->data;
    }

    /**
     * DELETE data with client object.
     * This method deletes the bpmFormAction record object by id. that object id is passed
     * into an array named args.
     * @param array $args
     * @return object
     */
    public function _delete(array $args)
    {
        //$result = new stdClass();
        //$this->data->message = translate('LBL_PMSE_ADAM_WRAPPER_HISTORYLOG_CANNOTDELETELOG', 'pmse_Project');
        $this->data->success = false;
        return $this->data;
    }

    /**
     *
     * Moved function from BpmInboxViewShowHistoryEntries class [view.showhistoryentries.php]
     * Using variable members and some fields added.
     */
    public function assemblyEntries()
    {
        $entries = array();
        $queryOptions = array('add_deleted' => true);
        $beanFlow = BeanFactory::getBean('pmse_BpmFlow');
        $fields = array(
            'id',
            'date_entered',
            'date_modified',
            'cas_id',
            'cas_index',
            'pro_id',
            'cas_previous',
            'cas_reassign_level',
            'bpmn_id',
            'bpmn_type',
            'cas_user_id',
            'cas_thread',
            'cas_flow_status',
            'cas_sugar_module',
            'cas_sugar_object_id',
            'cas_sugar_action',
            'cas_adhoc_type',
            'cas_adhoc_parent_id',
            'cas_task_start_date',
            'cas_delegate_date',
            'cas_start_date',
            'cas_finish_date',
            'cas_due_date',
            'cas_queue_duration',
            'cas_duration',
            'cas_delay_duration',
            'cas_started',
            'cas_finished',
            'cas_delayed',
        );

        $q = new SugarQuery();
        $q->from($beanFlow, $queryOptions);
        $q->distinct(false);
        $q->where()
            ->equals('cas_id', $this->case_id);
        $q->orderBy('cas_index', 'ASC');

        $q->select($fields);

        $caseDerivations = $q->execute();

        foreach ($caseDerivations as $key => $caseData) {
            $entry = $this->fetchUserType($caseData);

            $currentDate = new DateTime();

            $entry['due_date'] = !empty($caseData['cas_due_date']) ? PMSEEngineUtils::getDateToFE($caseData['cas_due_date'], 'datetime'): '';
            $entry['end_date'] = !empty($caseData['cas_finish_date']) ? PMSEEngineUtils::getDateToFE($caseData['cas_finish_date'], 'datetime'): '';
            $entry['current_date'] =  PMSEEngineUtils::getDateToFE(TimeDate::getInstance()->nowDb(), 'datetime');
            $entry['delegate_date'] = !empty($caseData['cas_delegate_date']) ? PMSEEngineUtils::getDateToFE($caseData['cas_delegate_date'], 'datetime'): '';
            $entry['start_date'] = !empty($caseData['cas_start_date']) ? PMSEEngineUtils::getDateToFE($caseData['cas_start_date'], 'datetime'): '';
            $entry['var_values'] = '';
            $entry['completed'] = true;
            $entry['cas_user_id'] = $caseData['cas_user_id'];

            if ($caseData['cas_previous'] == 0) {
                //cas_flow_status field should set something instead be empty.
                $dataString = sprintf(translate('LBL_PMSE_HISTORY_LOG_CREATED_CASE', 'pmse_Inbox'), $caseData['cas_id']);
            } else if ($caseData['bpmn_type'] === 'bpmnFlow') {
                $dataString = translate('LBL_PMSE_HISTORY_LOG_FLOW', 'pmse_Inbox');
            } else {
                if ($caseData['cas_flow_status'] == 'CLOSED') {
                    $dataString = sprintf(translate('LBL_PMSE_HISTORY_LOG_DERIVATED_CASE', 'pmse_Inbox'),
                        $caseData['cas_id']);
                } else {
                    $dataString = sprintf(translate('LBL_PMSE_HISTORY_LOG_CURRENTLY_HAS_CASE', 'pmse_Inbox'),
                        $caseData['cas_id']);
                }
            }

            $action = '';
            if ($caseData['bpmn_type'] == 'bpmnActivity') {
                $currentCaseState = $this->getActionStatusAndAction($caseData['cas_flow_status'],
                    $caseData['cas_sugar_action']);
                $dataString .= sprintf(translate('LBL_PMSE_HISTORY_LOG_ACTIVITY_NAME', 'pmse_Inbox'),
                    $this->getActivityName($caseData['bpmn_id']));
                if ($caseData['cas_flow_status'] != 'FORM') {
                    $dataString .= sprintf(translate('LBL_PMSE_HISTORY_LOG_MODULE_ACTION', 'pmse_Inbox'),
                        $this->getActivityModule($caseData), $currentCaseState);
                    $res = $this->formAction->retrieve_by_string_fields(array(
                        'cas_id' => $caseData['cas_id'],
                        'act_id' => $caseData['bpmn_id'],
                        'user_id' => $caseData['cas_user_id']
                    ));
                    if (isset($this->formAction->frm_action) && !empty($this->formAction->frm_action)) {
                        // frm_action can contains action strings such as "Approved" or json return values (in 
                        // case of Business Rules). We want to skip json return values from appearing in the 
                        // Process History 
                        if (json_decode($this->formAction->frm_action) == null) {
                            $action = strtoupper($this->formAction->frm_action);
                        }
                    } else {
                        $action = translate('LBL_PMSE_HISTORY_LOG_NOT_REGISTERED_ACTION', 'pmse_Inbox');
                    }
                    if (!empty($action)) {
                        $dataString .= sprintf(translate('LBL_PMSE_HISTORY_LOG_ACTION_PERFORMED', 'pmse_Inbox'), $action);
                    }
                    if (isset($this->formAction->cas_pre_data)) {
                        $logdata = json_decode($this->formAction->cas_pre_data);
                        $entry['var_values'] = $logdata;
                    }
                } else {
                    $dataString .= sprintf(translate('LBL_PMSE_HISTORY_LOG_ACTION_STILL_ASSIGNED', 'pmse_Inbox'));
                    $entry['completed'] = false;
                }
            } else {
                if ($caseData['bpmn_type'] == 'bpmnEvent') {
                    $name = sprintf(translate('LBL_PMSE_HISTORY_LOG_ACTIVITY_NAME', 'pmse_Inbox'),
                        $this->getEventName($caseData['bpmn_id']));
                    $currentCaseState = sprintf(translate('LBL_PMSE_HISTORY_LOG_WITH_EVENT', 'pmse_Inbox'), $name);
                    $dataString .= sprintf(translate('LBL_PMSE_HISTORY_LOG_MODULE_ACTION', 'pmse_Inbox'),
                        $this->getActivityModule($caseData), $currentCaseState);
                } else {
                    if ($caseData['bpmn_type'] == 'bpmnGateway') {
                        $name = sprintf(translate('LBL_PMSE_HISTORY_LOG_ACTIVITY_NAME', 'pmse_Inbox'),
                            $this->getGatewayName($caseData['bpmn_id']));
                        $currentCaseState = sprintf(translate('LBL_PMSE_HISTORY_LOG_WITH_GATEWAY', 'pmse_Inbox'),
                            $name);
                        $dataString .= sprintf(translate('LBL_PMSE_HISTORY_LOG_MODULE_ACTION', 'pmse_Inbox'),
                            $this->getActivityModule($caseData), $currentCaseState);
                    }
                }
            }
            $dataString .= '.';
            $entry['data_info'] = $dataString;
            $entries[] = $entry;
        }
        return $entries;
    }

    /**
     * Get Activity name by id. make the query and return the name of an activity
     * @param integer $id
     * @return string
     */
    private function getActivityName($id)
    {
        //$query = "select name from pmse_bpmn_activity where id = '" . $id . "'";
        //$result = $this->db->Query($query);
        //$row = $this->db->fetchByAssoc($result);
        $activityBean = BeanFactory::getBean('pmse_BpmnActivity', $id);
        return $activityBean->name; //$row['name'];
    }

    /**
     * Get Event name by id. make the query and return the name of an event
     * @param integer $id
     * @return string
     */
    private function getEventName($id)
    {
        //$query = "select name from pmse_bpmn_event where id = '" . $id . "'";
        //$result = $this->db->Query($query);
        //$row = $this->db->fetchByAssoc($result);
        $eventBean = BeanFactory::getBean('pmse_BpmnEvent', $id);
        return $eventBean->name; //$row['name'];
    }

    /**
     * Get Gateway name by id. make the query and return the name of an gateway
     * @param integer $id
     * @return string
     */
    private function getGatewayName($id)
    {
        $gatewayBean = BeanFactory::getBean('pmse_BpmnGateway', $id);
        return $gatewayBean->name;
    }

    /**
     * Get Module name by id. make the query and return the name of an sugar module
     * @param array $caseData
     * @return string
     */
    private function getActivityModule($caseData)
    {
        global $beanList;

        $activityDefinitionBean = BeanFactory::getBean('pmse_BpmActivityDefinition', $caseData['bpmn_id']);

        if (empty($activityDefinitionBean) || empty($activityDefinitionBean->act_field_module)) {
            return PMSEEngineUtils::getModuleLabelFromModuleName($beanList[$caseData['cas_sugar_module']]);
        }

        $related_module_data = $this->getRelationshipData($activityDefinitionBean->act_field_module);

        if ($related_module_data == null) {
            return PMSEEngineUtils::getModuleLabelFromModuleName($activityDefinitionBean->act_field_module);
        }
        return PMSEEngineUtils::getModuleLabelFromModuleName($related_module_data['rhs_module']);
    }

    /**
     * Get the relationship data name by relation name. make the query and return the object
     * @param string $relationName
     * @return array of fields
     */
    private function getRelationshipData($relationName)
    {
        return SugarRelationshipFactory::getInstance()->getRelationshipDef($relationName);
    }

    /**
     * Get the user data (type, image, name) by case user id. make the query and return an array
     * @param array $caseData
     * @return array ['image','user']
     */
    private function fetchUserType($caseData)
    {
        $entry = array();

        $this->currentUser->retrieve($caseData['cas_user_id']);
        if ($caseData['cas_sugar_action'] == 'SCRIPTTASK') {
            $entry['image'] = "label label-module label-pmse_Inbox pull-left";
            $entry['user'] = translate('LBL_PMSE_LABEL_PROCESS_AUTHOR', 'pmse_Inbox');
            $entry['script'] = true;
        } else {
            if ($caseData['bpmn_type'] == 'bpmnActivity' ||
                $caseData['cas_sugar_action'] == 'DetailView' ||
                $caseData['cas_sugar_action'] == 'EditView' ||
                $caseData['cas_previous'] == 0
            ) {
                if (isset($this->currentUser->picture)) {
                    if ($this->currentUser->picture == '' || $this->currentUser->picture == null) {
                        $entry['image'] = 'include/images/default-profile.png';
                    } else {
                        $entry['image'] = 'index.php?entryPoint=download&id=' . $this->currentUser->picture . '&type=SugarFieldImage&isTempFile=1';
                    }
                } else {
                    $entry['image'] = 'include/images/default-profile.png';
                }
                $entry['user'] = $this->currentUser->full_name;
                global $current_user;
                $entry['current_user'] = $current_user->full_name;
            } else {
                //TODO check if there is other conditions to set.
                $entry['image'] = "label label-module label-pmse_Inbox pull-left";
                $entry['user'] = translate('LBL_PMSE_LABEL_PROCESS_AUTHOR', 'pmse_Inbox');
                $entry['script'] = true;
            }
        }
        // @codeCoverageIgnoreStart
        if (trim($entry['user']) == '') {
            $entry['user'] = sprintf(translate('LBL_PMSE_HISTORY_LOG_NOTFOUND_USER', 'pmse_Inbox'),
                $caseData['cas_user_id']);

        }
        // @codeCoverageIgnoreEnd
        return $entry;
    }

    /**
     * Get the action status and the action. Translate the action and obtain the equivalent string response
     * @param string $status
     * @param string $action
     * @return string
     */
    private function getActionStatusAndAction($status, $action)
    {
        if ($status == 'CLOSED') {
            $returnStatus = translate('LBL_PMSE_HISTORY_LOG_TASK_HAS_BEEN', 'pmse_Inbox');
        } else {
            if ($status == 'FORM') {
                $returnStatus = translate('LBL_PMSE_HISTORY_LOG_TASK_WAS', 'pmse_Inbox');
            } else {
                //status field is empty at this point.
                $returnStatus = translate('LBL_PMSE_HISTORY_LOG_TASK_WAS', 'pmse_Inbox');
            }
        }

        if ($action == 'SCRIPTTASK') {
            $returnAction = translate('LBL_PMSE_HISTORY_LOG_EDITED', 'pmse_Inbox');
        } else {
            if ($action == 'DetailView') {
                $returnAction = translate('LBL_PMSE_HISTORY_LOG_ROUTED', 'pmse_Inbox');
            } else {
                if ($action == 'None') {
                    $returnAction = translate('LBL_PMSE_HISTORY_LOG_CREATED', 'pmse_Inbox');
                } else {
                    $returnAction = translate('LBL_PMSE_HISTORY_LOG_DONE_UNKNOWN', 'pmse_Inbox');
                }
            }
        }
        return sprintf(" (%s %s)", $returnStatus, $returnAction);
    }

    /**
     * Set bpmFormAction object for this service instance.
     * @param mock instance $mock
     */
    public function setBpmFormAction($mock)
    {
        $this->formAction = $mock;
    }

    /**
     * Set bpmFlow object for this service instance.
     * @param mock instance $mock
     */
    public function setBpmFlow($mock)
    {
        $this->flow = $mock;
    }

    /**
     * Set bpmUser object for this service instance.
     * @param mock instance $mock
     */
    public function setUser($mock)
    {
        $this->currentUser = $mock;
    }

    /**
     * Set DB object for this service instance.
     * @param mock instance $mock
     */
    public function setDB($mock)
    {
        $this->db = $mock;
    }

}
