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

/**
 * Class that an analysis of a business rule and evaluates
 * classes used PMSEBusinessRuleConversor where it parses a business rule and
 * PMSEExpressionEvaluator performs an evaluation of the conditions have a business rule
 *
 */

require_once 'modules/pmse_Inbox/engine/PMSEBusinessRuleConversor.php';
require_once 'modules/pmse_Inbox/engine/PMSEEvaluator.php';

class PMSEBusinessRuleReader
{
    /**
     * Global evaluation extencion
     * @var string
     */
    public $extensionGlobal = 'G@';

    /**
     * additional variables necessary
     * @var array
     */
    public $appDataVar = array();

    /**
     * global variables
     * @var array
     */
    public $globalVar = array();

    /**
     * Object of class PMSEExpressionEvaluator
     * @var object
     */
    public $evaluator;
    
    /**
     * Object of class PMSEBusinessRuleConversor
     * @var object
     */
    public $businessRuleConversor;

    /**
     * Constructor
     * @param type $appData
     * @param type $global
     */
    public function __construct($appData = array(), $global = array())
    {
        $this->appDataVar = $appData;
        $this->globalVar = $global;
        $this->businessRuleConversor = new PMSEBusinessRuleConversor();
        $this->evaluator = new PMSEEvaluator();
    }

    /**
     * get object variable to analyze the business rule
     * @return object
     */
    public function getBusinessRuleParser()
    {
        return $this->businessRuleConversor;
    }

    /**
     * set object variable to analyze the business rule
     * @param object $businessRuleParser
     */
    public function setBusinessRuleParser($businessRuleParser)
    {
        $this->businessRuleConversor = $businessRuleParser;
    }

    /**
     * get variable object for evaluation
     * @return object
     */
    public function getEvaluator()
    {
        return $this->evaluator;
    }

    /**
     * set variable object for evaluation
     * @param object $evaluator
     */
    public function setEvaluator($evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     * Method that converts a standard business rule conditions and makes the evaluation of the condition
     * @param string $sugarModule the module case
     * @param json $ruleSetJSON the expression
     * @param string $type
     * @return array
     */
    public function parseRuleSetJSON($sugarModule, $ruleSetJSON, $type = 'single')
    {
        
        $res = '';
        $evaluatedBean = BeanFactory::getBean($sugarModule, $this->appDataVar['id']);
        $ruleSet = json_decode($ruleSetJSON);
        $appData = array();
        $newAppData = array();
        $successReturn = "";
        $evaluationResult = true;
        $this->businessRuleConversor->setBaseModule($ruleSet->base_module);
        foreach ($ruleSet->ruleset as $key => $rule) {
            $this->businessRuleConversor->setEvaluatedBean($evaluatedBean);
            $transformedCondition = $this->businessRuleConversor->transformCondition($rule->conditions);
            $transformedCondition = json_encode($transformedCondition);
            $evaluationResult = $this->evaluator->evaluateExpression($transformedCondition, $evaluatedBean);
            if ($evaluationResult) {
                $successReturn = $this->businessRuleConversor->getReturnValue($rule->conclusions);
                $newAppData = array_merge($newAppData,
                    $this->businessRuleConversor->processAppData($rule->conclusions, $appData));
                $res .= $this->businessRuleConversor->processConditionResult($rule->conclusions, $appData);
            }
            if ($type == 'single' && $evaluationResult) {
                break;
            }
        }
        /*
        foreach ($this->appDataVar as $key => $value) {
            if ($value != $appData[$key])) {
                $newAppData[$key] = $appData[$key];
            }
        }
        */
        //$successReturn = "ANOTHER_ZONE";

        //$newAppData = array(
        //    "description" => "POTENTIAL SALE",
        //    "probability" => 0.16
        //);

        //$res = "{::Opportunities::description::} = 'POTENTIAL CONTACT';{::Opportunities::probability::} = 0.06;";
        $log = "The following condition: \n" . $transformedCondition . " has returned: \n" . json_encode($successReturn);
        $resultArray = array('log' => $log, 'return' => $successReturn, 'result' => $res, 'newAppData' => $newAppData);
        return $resultArray;
    }
}
