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
 * Class that analyzes the data type of a bean
 * getting the value of this field according to the data type
 * if there is a date data type used the classes TimeDate()
 *
 */
class PMSEFieldParser implements PMSEDataParserInterface
{
    /**
     * Object Bean
     * @var object
     */
    private $evaluatedBean;

    /**
     * Lists modules Bean
     * @var array
     */
    private $beanList;
    private $currentUser;
    private $pmseRelatedModule;

    /**
     * List of token parse methods
     * @var array
     */
    public $tokenMethods = array(
        'current_user' => 'parseCurrentUser',
        'supervisor' => 'parseSupervisor',
        'owner' => 'parseOwner',
    );

    /**
     * gets the bean list
     * @return array
     * @codeCoverageIgnore
     */
    public function getBeanList()
    {
        return $this->beanList;
    }

    /**
     * sets the bean list
     * @param array $beanList
     */
    public function setBeanList($beanList)
    {
        $this->beanList = $beanList;
    }

    /**
     * gets the bean
     * @return object
     * @codeCoverageIgnore
     */
    public function getEvaluatedBean()
    {
        return $this->evaluatedBean;
    }

    /**
     * sets the bean
     * @param object $evaluatedBean
     */
    public function setEvaluatedBean($evaluatedBean)
    {
        $this->evaluatedBean = $evaluatedBean;
    }

    /**
     * sets the current user
     * @param object $currentUser
     * @codeCoverageIgnore
     */
    public function setCurrentUser($currentUser)
    {
        $this->currentUser = $currentUser;
    }

    /**
     * get the class TimeDate()
     * @return object
     * @codeCoverageIgnore
     */
    public function getTimeDate()
    {
        if (!isset($this->timeDate) || empty($this->timeDate)) {
            $this->timeDate = new TimeDate();
        }
        return $this->timeDate;
    }

    /**
     * set the class TimeDate()
     * @param object $timeDate
     * @codeCoverageIgnore
     */
    public function setTimeDate($timeDate)
    {
        $this->timeDate = $timeDate;
    }

    /**
     * Parser token incorporando el tipo de dato, en el caso de tipo de dato date, datetime se usa la clase TimeDate
     * @global object $current_user cuurrent user
     * @param object $criteriaToken token to be parsed
     * @param array $params
     * @return object
     */
    public function parseCriteriaToken($criteriaToken, $params = array())
    {
        if ($criteriaToken->expType === 'VARIABLE') {
            $criteriaToken = $this->parseVariable($criteriaToken, $params);
        } else {
            $criteriaToken = $this->parseCriteria($criteriaToken, $params);
        }
        return $criteriaToken;
    }

    /**
     * parse the token ussing the old function
     * @global object $current_user
     * @param type $criteriaToken
     * @param type $params
     * @return type
     */
    public function parseCriteria($criteriaToken, $params = array())
    {
        switch ($criteriaToken->expOperator) {
            case 'equals':
                $delimiter = '==';
                break;
            case 'not_equals':
                $delimiter = '!=';
                break;
            case 'major_equals_than':
                $delimiter = '>=';
                break;
            case 'minor_equals_than':
                $delimiter = '<=';
                break;
            case 'minor_than':
                $delimiter = '<';
                break;
            case 'major_than':
                $delimiter = '>';
                break;
            case 'within':
                $delimiter = 'within';
                break;
            case 'not_within':
                $delimiter = 'not within';
                break;
            default:
                $delimiter = '==';
                break;
        }

        //$tokenValueArray = explode($delimiter, $criteriaToken->expLabel);
        $tokenDelimiter = '::';
        $newTokenArray = array('{', 'future', $criteriaToken->expModule, $criteriaToken->expField, '}');
        $assembledTokenString = implode($tokenDelimiter, $newTokenArray);
        $tokenValue = $this->parseTokenValue($assembledTokenString);
        $criteriaToken->expToken = $assembledTokenString;
        $criteriaToken->currentValue = $tokenValue;
        $criteriaToken->expValue = $this->setExpValueFromCriteria($criteriaToken);

        $fieldType = $this->evaluatedBean->field_name_map[$criteriaToken->expField]['type'];

        if ($fieldType == 'date') {
            $criteriaToken->expSubtype = 'date';
        } elseif ($fieldType == 'datetime' || $fieldType =='datetimecombo') {
            $criteriaToken->expSubtype = 'date';
        } elseif ($fieldType == 'currency') {
            $criteriaToken->expValue = $this->setCurrentValueIfCurrency($criteriaToken);
        }
        return $criteriaToken;
    }

    /**
     * Parse the token using a new function to parse variable tokens
     * @global object $current_user
     * @param type $criteriaToken
     * @param type $params
     * @return type
     */
    public function parseVariable($criteriaToken, $params = array())
    {
        switch ($criteriaToken->expOperator) {
            case 'equals':
                $delimiter = '==';
                break;
            case 'not_equals':
                $delimiter = '!=';
                break;
            case 'major_equals_than':
                $delimiter = '>=';
                break;
            case 'minor_equals_than':
                $delimiter = '<=';
                break;
            case 'minor_than':
                $delimiter = '<';
                break;
            case 'major_than':
                $delimiter = '>';
                break;
            case 'within':
                $delimiter = 'within';
                break;
            case 'not_within':
                $delimiter = 'not within';
                break;
            default:
                $delimiter = '==';
                break;
        }

        //$tokenValueArray = explode($delimiter, $criteriaToken->expLabel);
        $tokenDelimiter = '::';

        $newTokenArray = array('{', 'future', $criteriaToken->expModule, $criteriaToken->expValue, '}');
        $assembledTokenString = implode($tokenDelimiter, $newTokenArray);
        $tokenValue = $this->parseTokenValue($assembledTokenString);
        $criteriaToken->expToken = $assembledTokenString;
        if ($criteriaToken->expSubtype == 'Currency') {
            $value = json_decode($tokenValue);
            $criteriaToken->expField = $value["currency_id"];
            $criteriaToken->currentValue = $value["amount"];
        } else {
            $criteriaToken->currentValue = $tokenValue;
        }
        if (isset($this->evaluatedBean->field_name_map[$criteriaToken->expField])) {
            if ($this->evaluatedBean->field_name_map[$criteriaToken->expField]['type'] == 'date') {
                $criteriaToken->expSubtype = 'date';
            } elseif ($this->evaluatedBean->field_name_map[$criteriaToken->expField]['type'] == 'datetime'
                || $this->evaluatedBean->field_name_map[$criteriaToken->expField]['type'] == 'datetimecombo'
               ) {
                $criteriaToken->expSubtype = 'date';
              }
         }
        $criteriaToken->expValue = $criteriaToken->currentValue;
        return $criteriaToken;
    }

    /**
     * parser a token for a field element, is this: bool or custom fields
     * @param string $token field contains a parser
     * @return string field value, in the case of a currency type it returns a serialized array with the amount and
     * the currency id.
     */
    public function parseTokenValue($token)
    {
        $this->pmseRelatedModule = new PMSERelatedModule();
        $tokenArray = $this->decomposeToken($token);

        $bean = $this->evaluatedBean;
        $value = '';
        if (!empty($tokenArray)) {
            if (!isset($this->beanList[$tokenArray[1]])) {
                $bean = $this->pmseRelatedModule->getRelatedModule($bean, $tokenArray[1]);
            }
            $field = $tokenArray[2];
            if (!empty($bean) && is_object($bean)) {
                $value = $this->pmseRelatedModule->getFieldValue($bean, $field);
            }
        }

        return $value;
    }

    /**
     * converts a string {:: future :: Users :: id ::} to an array ('future','Users','id')
     * @param string $token @example {:: future :: Users :: id ::}
     * @return array
     */
    public function decomposeToken($token)
    {
        $response = array();
        $tokenArray = explode('::', $token);
        foreach ($tokenArray as $key => $value) {
            if ($value != '{' && $value != '}' && !empty($value)) {
                $response[] = $value;
            }
        }
        return $response;
    }

    /**
     * Checks to see if there is a parser method for this token
     *
     * @param object $token Criteria token object
     * @return boolean True if there is a method for this token criteria
     */
    public function hasParseMethod($token)
    {
        return !empty($token->expValue)
               && isset($this->tokenMethods[$token->expValue])
               && method_exists($this, $this->tokenMethods[$token->expValue]);
    }

    /**
     * Parses the token value for a User field element
     * @param object $token field contains a parser
     * @return string field value
     */
    public function setExpValueFromCriteria($token)
    {
        if ($this->hasParseMethod($token)) {
            $method = $this->tokenMethods[$token->expValue];
            return $this::$method($token);
        }

        return $token->expValue;
    }

    /**
     * Parse the token value for Currency
     * @param $token
     * @return float
     */
    public function setCurrentValueIfCurrency($token)
    {
        $expCurrency = empty($token->expCurrency) ? '-99' : $token->expCurrency;
        $defCurrency = SugarCurrency::getCurrency($this->evaluatedBean);
        $amount = SugarCurrency::convertAmount((float)$token->expValue, $expCurrency, $defCurrency->id);
        return $amount;
    }

    /**
     * Gets current user id or criteria token expected value
     *
     * @param object $token field contains a parser
     * @return string field value
     */
    public function parseCurrentUser($token)
    {
        return !empty($this->currentUser->id) ?
            $this->currentUser->id : $token->expValue;
    }

    /**
     * Gets assigned user id or criteria token expected value
     *
     * @param object $token field contains a parser
     * @return string field value
     */
    public function parseOwner($token)
    {
        return !empty($this->evaluatedBean->assigned_user_id) ?
            $this->evaluatedBean->assigned_user_id : $token->expValue;
    }

    /**
     * Gets reports to id or criteria token expected value
     *
     * @param object $token field contains a parser
     * @return string field value
     */
    public function parseSupervisor($token)
    {
        return !empty($this->currentUser->reports_to_id) ?
            $this->currentUser->reports_to_id : $token->expValue;
    }

}
