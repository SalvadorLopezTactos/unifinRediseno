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

require_once 'modules/pmse_Inbox/engine/PMSEElements/PMSEScriptTask.php';
require_once 'modules/pmse_Inbox/engine/PMSERelatedModule.php';

class PMSEAddRelatedRecord extends PMSEScriptTask
{
    private $pmseRelatedModule;

    public function __construct()
    {
        $this->pmseRelatedModule = new PMSERelatedModule();
        parent::__construct();
    }

    /**
     * This method prepares the response of the current element based on the
     * $bean object and the $flowData, an external action such as
     * ROUTE or ADHOC_REASSIGN could be also processed.
     *
     * This method probably should be override for each new element, but it's
     * not mandatory. However the response structure always must pass using
     * the 'prepareResponse' Method.
     *
     * As defined in the example:
     *
     * $response['route_action'] = 'ROUTE'; //The action that should process the Router
     * $response['flow_action'] = 'CREATE'; //The record action that should process the router
     * $response['flow_data'] = $flowData; //The current flowData
     * $response['flow_filters'] = array('first_id', 'second_id'); //This attribute is used to filter the execution of the following elements
     * $response['flow_id'] = $flowData['id']; // The flowData id if present
     *
     *
     * @param type $flowData
     * @param type $bean
     * @param type $externalAction
     * @return type
     */
    public function run($flowData, $bean = null, $externalAction = '', $arguments = array())
    {
        switch ($externalAction) {
            case 'RESUME_EXECUTION':
                $flowAction = 'UPDATE';
                break;
            default :
                $flowAction = 'CREATE';
                break;
        }

        global $timedate;

        try {
            $bpmnElement = $this->retrieveDefinitionData($flowData['bpmn_id']);
            $definitionBean = $this->caseFlowHandler->retrieveBean('pmse_BpmActivityDefinition', $bpmnElement['id']);
            $processDefinitionBean = $this->caseFlowHandler->retrieveBean('pmse_BpmProcessDefinition', $definitionBean->pro_id);

            if ((isset($definitionBean->act_field_module) && !empty($definitionBean->act_field_module)) &&
                (isset($definitionBean->act_fields) && !empty($definitionBean->act_fields))
            ) {

                $arr_module = $definitionBean->act_field_module;
                $arr_fields = json_decode(htmlspecialchars_decode($definitionBean->act_fields));

                // TODO: Probably the act_module field should be used instead of pro_module
                $sugarModule = $processDefinitionBean->pro_module;

                $fields = array();

                if (!empty($arr_fields)) {
                    foreach ($arr_fields as $value) {
                        if (!empty($value->field) && !empty($value->value)) {
                            $key = $value->field;
                            $newValue = '';
                            switch ($value->type) {
                                case 'Date':
                                    $finishDate = $this->beanHandler->processValueExpression($value->value, $bean);
                                    $date = $timedate->fromIsoDate($finishDate);
                                    if (empty($date)) {
                                        $date = TimeDate::getInstance()->fromIso($finishDate);
                                    }
                                    if (!($date instanceof SugarDateTime)) {
                                        throw new Exception("AddRelatedRecord: Cannot convert '{$finishDate}' to SugarDateTime.", 1);
                                    }
                                    $newValue = $date->asDbDate();
                                    break;
                                case 'Datetime':
                                    $finishDate = $this->beanHandler->processValueExpression($value->value, $bean);
                                    $date = $timedate->fromIso($finishDate);
                                    if (empty($date)) {
                                        $date = TimeDate::getInstance()->fromString($finishDate);
                                    }
                                    if (!($date instanceof SugarDateTime)) {
                                        throw new Exception("AddRelatedRecord: Cannot convert '{$finishDate}' to SugarDateTime.", 1);
                                    }
                                    $newValue = $date->asDb();
                                    break;
                                case 'Integer':
                                case 'Float':
                                case 'Decimal':
                                    $newValue = $this->beanHandler->processValueExpression($value->value, $bean);
                                    break;
                                case 'Currency':
                                    $newValue = $this->beanHandler->processValueExpression($value->value, $bean);
                                    $newValue = json_decode($newValue);
                                    $fields['currency_id'] = $newValue->expField;
                                    $newValue = $newValue->expValue;
                                    break;
                                default:
                                    if ($value->field == 'teams') {
                                        $newValue = $value;
                                    } else {
                                        $newValue = $this->beanHandler->mergeBeanInTemplate($bean, $value->value);
                                    }
                            }
                            
                            if (in_array($key, array('assigned_user_id', 'created_by', 'modified_user_id'))) {
                                $newValue = $this->beanHandler->mergeBeanInTemplate($bean,
                                    $this->getCustomUser($value->value, $bean));
                            }
                            $fields[$key] = $newValue;
                            if (is_string($newValue)) {
                                $loggerNewValue = $newValue;
                            } else {
                                $loggerNewValue = json_encode($newValue);
                            }
                            $this->logger->info("Data generated $loggerNewValue for $key");
                        }
                    }

                    $relatedBean = $this->pmseRelatedModule->addRelatedRecord($bean, $arr_module, $fields);
                    if (!empty($relatedBean) && is_object($relatedBean)) {
                        $rel_id = $relatedBean->id;
                        $rel_name = $relatedBean->module_dir;
                        $this->logger->debug("Create related record " . $rel_name . " ID: $rel_id");
                        $this->logger->debug("Add relationship $rel_name of $sugarModule");
                    } else {
                        $this->logger->info("Not created related record!!!");
                    }
                }
                $this->logger->debug("Script executed");
            }
        } catch (PMSEExpressionEvaluationException $e) {
            throw new PMSEElementException("AddRelatedRecord: ".$e, $flowData, $this);
        }
        $this->logger->debug("Script executed");
        return $this->prepareResponse($flowData, 'ROUTE', $flowAction);
    }
}
