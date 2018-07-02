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

namespace Sugarcrm\Sugarcrm\Elasticsearch\Query\Parser;

/**
 * helper class for basic term parser operators
 * Class TermParserHelper
 * @package Sugarcrm\Sugarcrm\Elasticsearch\Query\Parser
 */
class TermParserHelper
{
    protected $defaultOperator;
    
    /**
     * consts definition for operators
     */
    const OPERATOR_AND = 'AND';
    const OPERATOR_OR = 'OR';
    const OPERATOR_NOT = 'NOT';

    /**
     * list of valid operators
     * @var array
     */
    protected static $operators = array(
        self::OPERATOR_AND,
        self::OPERATOR_OR,
        self::OPERATOR_NOT,
        '&',
        '|',
        '-',
    );

    /**
     * static class, not ctor is provided
     */
    private function __construct()
    {

    }

    /**
     * check if it is an operator
     * @param string $term
     * @return bool
     */
    public static function isOperator($term)
    {
        if (!is_string($term)) {
            return false;
        }

        if (in_array($term, self::$operators)) {
            return true;
        }
        return false;
    }

    /**
     * check if it is 'AND' operator
     * @param string $term
     * @return bool
     */
    public static function isAndOperator($term)
    {
        return is_string($term) && in_array($term, array(self::OPERATOR_AND, '&'));
    }

    /**
     * check if it is 'OR' operator
     * @param string $term
     * @return bool
     */
    public static function isOrOperator($term)
    {
        return is_string($term) && in_array($term, array(self::OPERATOR_OR, '|'));
    }

    /**
     * check if it is 'OR' operator
     * @param string $term
     * @return bool
     */
    public static function isNotOperator($term)
    {
        return is_string($term) && in_array($term, array(self::OPERATOR_NOT, '-'));
    }

    /**
     * to stadandize operator
     * @param string $term
     * @return bool|string
     */
    public static function getOperator($term)
    {
        if (self::isAndOperator($term)) {
            return self::OPERATOR_AND;
        }

        if (self::isOrOperator($term)) {
            return self::OPERATOR_OR;
        }

        if (self::isNotOperator($term)) {
            return self::OPERATOR_NOT;
        }

        return false;
    }
}
