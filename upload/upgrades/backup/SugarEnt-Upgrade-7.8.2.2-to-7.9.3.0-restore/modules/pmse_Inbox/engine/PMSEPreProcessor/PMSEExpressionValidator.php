<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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

require_once 'modules/pmse_Inbox/engine/PMSEPreProcessor/PMSEBaseValidator.php';
require_once 'modules/pmse_Inbox/engine/PMSEPreProcessor/PMSEValidate.php';

/**
 * Description of PMSERecordValidator
 *
 */
class PMSEExpressionValidator extends PMSEBaseValidator implements PMSEValidate
{
    /**
     *
     * @param PMSERequest $request
     * @return \PMSERequest
     */
    public function validateRequest(PMSERequest $request)
    {
        $this->logger->info("Validate Request " . get_class($this));
        $this->logger->debug(array("Request data:", $request));

        $flowData = $request->getFlowData();
        $bean = $request->getBean();
        if ($flowData['evn_id'] != 'TERMINATE') {
            $paramsRelated = $this->validateParamsRelated($bean, $flowData, $request);
            if ($request->isValid()) {
                $this->validateExpression($bean, $flowData, $request, $paramsRelated);
            }
        }
        return $request;
    }

    /**
     *
     * @param type $bean
     * @param type $flowData
     * @param type $request
     * @param type $paramsRelated
     * @return type
     */
    public function validateExpression($bean, $flowData, $request, $paramsRelated = array())
    {
        $conditionResult = $this->evaluator->evaluateExpression(trim($flowData['evn_criteria']), $bean, $paramsRelated);
        if ($flowData['evn_criteria'] == '' || $flowData['evn_criteria'] == '[]' || $conditionResult) {
            $request->validate();
        } else {
            $request->invalidate();
        }

        $condition = $this->evaluator->condition();
        $this->logger->debug("Eval: $condition returned " . ($request->isValid()));
        return $request;
    }

    /**
     *
     * @param type $bean
     * @param type $flowData
     * @param type $request
     * @return array
     */
    public function validateParamsRelated($bean, $flowData, $request)
    {
        $paramsRelated = array();
        if ($request->getExternalAction() == 'EVALUATE_RELATED_MODULE') {
            if ($this->hasValidRelationship($bean, $flowData)) {
                $paramsRelated = array(
                    'replace_fields' => array(
                        $flowData['rel_element_relationship'] => $flowData['rel_element_module']
                    )
                );
            } else {
                $request->invalidate();
            }
        }

        if ($request->getExternalAction() == 'EVALUATE_MAIN_MODULE') {
            if (
                $bean->module_name != $flowData['cas_sugar_module']
                || $bean->id != $flowData['cas_sugar_object_id']
            ) {
                $request->invalidate();
            }
        }

        if ($request->getExternalAction() == 'NEW') {
            if (!PMSEEngineUtils::isTargetModule($flowData, $bean)
            ) {
                $paramsRelated = array(
                    'replace_fields' => array(
                        $flowData['rel_element_relationship'] => $flowData['rel_element_module']
                    )
                );
            }
        }

        $this->logger->debug("Parameters related returned :" . print_r($paramsRelated, true));
        return $paramsRelated;
    }


    /**
     * Return true if bean specified by data in flowdata and bean specified by bean have a link defined
     * @param $bean
     * @param $flowData
     * @return bool
     */
    public function hasValidRelationship($bean, $flowData)
    {
        $seedBean = BeanFactory::getBean($flowData['cas_sugar_module'], $flowData['cas_sugar_object_id']);
        return $seedBean->load_relationship($flowData['rel_element_relationship']);
    }
}
