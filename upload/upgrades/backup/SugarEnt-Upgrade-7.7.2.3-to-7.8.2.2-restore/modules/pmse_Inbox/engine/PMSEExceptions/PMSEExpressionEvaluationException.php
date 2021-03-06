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
 * Define a custom exception class
 */
class PMSEExpressionEvaluationException extends Exception
{
    protected $expressionArray;
    // Redefine the exception so message isn't optional
    public function __construct($message, $expressionArray, $code = 0, Exception $previous = null)
    {
        // make sure everything is assigned properly
        $this->expressionArray = $expressionArray;
        parent::__construct($message, $code, $previous);
    }

    public function getExpressionArray () {
        return $this->expressionArray;
    }

    // custom string representation of object
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}