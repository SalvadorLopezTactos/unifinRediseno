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
 * Description of PMSECriteriaEvaluator
 * 
 */
class PMSECriteriaEvaluator
{
    protected $expressionEvaluator;

    public function __construct()
    {
        $this->expressionEvaluator = new PMSEExpressionEvaluator();
    }
    
    public function isCriteriaToken($token)
    {
        $result = false;
        $criteriaTypes = array (
            'MODULE',
            'CONTROL',
            'BUSINESS_RULES',
            'USER_ROLE',
            'USER_ADMIN',
            'USER_IDENTITY'
        );

        if (in_array($token->expType, $criteriaTypes)) {
            $result = true;
        }
        
        return $result;
    }
    
    public function evaluateCriteriaToken($criteriaToken)
    {
        $resultToken = new stdClass();
        $resultToken->expType = 'CONSTANT';
        $operationGroup = 'relation';
        if (!isset($criteriaToken->expSubtype)) {
            $criteriaToken->expSubtype = '';
        }
        $resultToken->expValue = $this->expressionEvaluator->routeFunctionOperator(
            $operationGroup,
            $criteriaToken->currentValue,
            $criteriaToken->expOperator,
            $criteriaToken->expValue,
            $criteriaToken->expSubtype
        );
        $this->expressionEvaluator->processTokenAttributes($resultToken);
        return $resultToken;
    }
    
    public function evaluateCriteriaTokenList($tokenArray)
    {
        foreach ($tokenArray as $key => $token) {
            if ($this->isCriteriaToken($token)) {
                $tokenArray[$key] = $this->evaluateCriteriaToken($token);
            }
        }
        return $tokenArray;
    }
    
//    public function retrieveCriteriaSubtype($subType)
//    {
//        $type = 'string';
//        switch (strtolower($subtype)) {
//            case 'name':
//            case 'textfield':
//            case 'varchar':
//            case 'dropdown':
//            case 'enum':
//            case 'textarea':
//            case 'text':
//            case 'html':
//            case 'url':
//            case 'radio':
//            case 'radioenum':
//                $type = 'string';
//            break;
//            case 'checkbox':
//            case 'bool':
//                $type = 'boolean';
//            break;
//            case 'date':
//            case 'datetime':
//            case 'datetimecombo':
//                $type = 'date';
//            break;            
//            case 'currency':
//            case 'float':
//            case 'integer':
//            case 'int':
//            case 'decimal':
//                $type = 'number';
//            break;
//            default :
//                $type = $subType;
//            break;
//        }
//        return $type;
//    }
//    
//    public function retrieveCaster($subtype)
//    {
//        switch ($subtype) {
//            case 'string':
//            case 'date':
//            case 'boolean':
//                $caster = $subtype;
//                break;
//            case 'number':
//                $caster = '';
//            default:
//                break;
//        }
//    }
}
