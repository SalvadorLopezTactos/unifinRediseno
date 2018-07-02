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

require_once 'modules/pmse_Inbox/engine/PMSERelatedModule.php';
/**
 * Parses a condition of a business rule to a standard criterion to the value of the condition
 * one json is entered as a parameter to parser and get the new value of each case
 * a new json will be returned to the field value and data type
 *
 */
class PMSEBusinessRuleConversor
{
    /**
     *
     * @var type 
     */
    protected $evaluatedBean;
    
    /**
     * Case modulo
     * @var type string
     */
    protected $baseModule;

    protected $pmseRelatedModule;

    public function __construct()
    {
        $this->pmseRelatedModule = new PMSERelatedModule();
    }

    /**
     * Gets the module case
     * @return string name module case
     * @codeCoverageIgnore
     */
    public function getBaseModule()
    {
        return $this->baseModule;
    }

    /**
     * Sets the module case
     * @param string $baseModule set name module case
     * @codeCoverageIgnore
     */
    public function setBaseModule($baseModule)
    {
        $this->baseModule = $baseModule;
    }

    /**
     * Sets the bean
     * @param object $name set object bean
     * @codeCoverageIgnore
     */
    public function setEvaluatedBean($evaluatedBean)
    {
        $this->evaluatedBean = $evaluatedBean;
    }

    /**
     * Method that parser the conditions
     * @param object $businessRule token contains all the conditions and results
     * @return object
     */
    public function transformBusinessRule($businessRule)
    {
        if (isset($businessRule)) {
            $this->baseModule = $businessRule->base_module;
            foreach ($businessRule->ruleset as $key => $ruleset) {
                $businessRule->ruleset[$key]->conditions = $this->transformCondition($ruleset->conditions);
            }
        }
        return $businessRule;
    }

    /**
     * Method that adds an AND if there various business rules
     * @param array $conditionList token contains all the conditions
     * @return array
     */
    public function transformCondition($conditionList = array())
    {
        $criteriaArray = array();
        $counter = 0;
        
        if (is_array($conditionList) && empty($conditionList)) {
            $criteriaArray = $this->retrieveDefaultCondition();
        }
        
        foreach ($conditionList as $condition) {
            if ($counter > 0) {
                $andObject = new stdClass();
                $andObject->expValue = "AND";
                $andObject->expType = "LOGIC";
                $andObject->expLabel = "AND";
                $criteriaArray[] = $andObject;
            }
            $criteriaArray[] = $this->transformToken($condition);
            $counter++;
        }
        return $criteriaArray;
    }

    /**
     * Transforms a type expression business rules in a standard token
     * @param object $businessRuleToken token original
     * @return object token modified
     */
    public function transformToken($businessRuleToken)
    {
        $criteriaToken = new stdClass();
        if (is_object($businessRuleToken)) {
            $criteriaToken->expField = $businessRuleToken->variable_name;
            $criteriaToken->expOperator = $this->transformConditionOperator($businessRuleToken->condition);
            $criteriaToken->expDirection = "after";
            $criteriaToken->expType = "MODULE";
            $valueToken = $this->processValueExpression($businessRuleToken->value);
            $criteriaToken->expSubtype = $valueToken->type;
            $criteriaToken->expValue = $valueToken->value;
            $separator = $criteriaToken->expSubtype == "STRING" ? "&" : "";
            $criteriaToken->expLabel = $criteriaToken->expField . " " . $businessRuleToken->condition . " " . $separator . $valueToken->value . $separator;
            $criteriaToken->expModule = $businessRuleToken->variable_module;
//            $criteriaToken->expModule = $this->baseModule;
        }
        return $criteriaToken;
    }

    /**
     * Process that evaluates the expression
     * variable of type sugar or int, float, double and bool
     * @param array $businessRuleValueToken array containing all the tokens
     * @return object
     */
    public function processValueExpression($businessRuleValueToken)
    {
        global $beanList;
        $response = new stdClass();
        $dataEval = array();
        foreach ($businessRuleValueToken as $token) {
            if ($token->expType != 'VARIABLE') {
                switch (strtoupper($token->expSubtype)) {
                    case 'INT':
                        $dataEval[] = (int)$token->expValue;
                        break;
                    case 'FLOAT':
                        $dataEval[] = (float)$token->expValue;
                        break;
                    case 'DOUBLE':
                        $dataEval[] = (double)$token->expValue;
                        break;
                    case 'BOOL':
                    case 'BOOLEAN':
                        $dataEval[] = $token->expValue == 'TRUE' ? true : false;
                        break;
                    default :
                        $dataEval[] = $token->expValue;
                        break;
                }
            } else {
                $field = $token->expValue;
                if (isset($beanList[$token->expModule])) {
                    $newBean = $this->evaluatedBean;
                } else {
                    $newBean = $this->pmseRelatedModule->getRelatedModule($this->evaluatedBean, $token->expModule);
                }
                if (!empty($newBean) && is_object($newBean)) {
                    $value = $this->pmseRelatedModule->getFieldValue($newBean, $field);
                } else {
                    $value = '';
                }
                $dataEval[] = $value;
            }
        }
        if (count($dataEval) > 1) {
            $evaluator = new PMSEEvaluator();
            $response->value = $evaluator->evaluateExpression(json_encode($dataEval), $this->evaluatedBean);
            $response->type = gettype($response->value);
        } else {
            $response->value = $dataEval[0];
            $response->type = $token->expSubtype;
        }
        return $response;
    }

    /**
     * Operator transforms a literal syntax
     * @param string $condition operator sign
     * @return string operator literal equivalent
     */
    public function transformConditionOperator($condition)
    {
        switch ($condition) {
            case '=':
                return 'equals';
                break;
            case '==':
                return 'equals';
                break;
            case '!=':
                return 'not_equals';
                break;
            case '<>':
                return 'not_equals';
                break;
            case '>=':
                return 'major_equals_than';
                break;
            case '<=':
                return 'minor_equals_than';
                break;
            case '<':
                return 'minor_than';
                break;
            case '>':
                return 'major_than';
                break;
            case 'within':
                return 'within';
                break;
            case 'not within':
                return 'not_within';
                break;
            default:
                break;
        }
    }

    /**
     * Method that returns the value to returned in a business rule
     * @param array $conclusions values ​​where this conclusion
     * @return json
     */
    public function getReturnValue($conclusions)
    {
        foreach ($conclusions as $conclusion) {
            if ($conclusion->conclusion_type == "return") {
                $valueToken = $this->processValueExpression($conclusion->value);
                return json_encode($valueToken);
            }
        }
    }

    /**
     * Method that sets the value of the conclusion
     * @param array $conclusions
     * @param array $appData
     * @return array
     */
    public function processAppData($conclusions, $appData = array())
    {
        if (isset($conclusions)) {
            foreach ($conclusions as $conclusion) {
                if ($conclusion->conclusion_type == 'variable') {
                    $valueToken = $this->processValueExpression($conclusion->value);
                    $appData[$conclusion->conclusion_value] = $valueToken->value;
                }
            }
        }
        return $appData;
    }

    /**
     * Converts the conclusion to a string
     * @param array $conclusions
     * @param array $appData
     * @return string
     */
    public function processConditionResult($conclusions, $appData = array())
    {
        $result = '';
        if (isset($conclusions)) {
            $appData = $this->processAppData($conclusions, $appData);
            foreach ($appData as $key => $value) {
                $value = is_string($value) ? "'" . $value . "'" : $value;
                $result .= "{::" . $this->baseModule . "::" . $key . "::} = " . $value . ";";
            }
        }
        return $result;
    }
    
    public function retrieveDefaultCondition()
    {
        $condition = new stdClass();
        $condition->expValue = true;
        $condition->expLabel = 'true';
        $condition->expType = 'CONSTANT';
        $condition->expSubtype = 'BOOLEAN';
        return array($condition);
    }
    
}

?>
