<?php
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
require_once("include/Expressions/Trigger.php");
require_once("include/Expressions/Dependency.php");
require_once("include/Expressions/Expression/Parser/Parser.php");
require_once("include/Expressions/Expression/AbstractExpression.php");

/**
 * Base action class
 * @api
 */
abstract class AbstractAction {
    protected $targetField = array();
    protected $params = array();

    /**
     * array Array of actions for which the Expression Action is not allowed
     */
    protected $disallowedActions = array();

	/**
	 * Actions are expressions which modify data or layouts.
	 *
	 * @param Array $params A set of parameters to use in this action.
	 * @return AbstractAction
	 */
	function AbstractAction($params) {
		$this->params = $params;
		if (is_array($params) && isset($params['target'])) {
			$this->targetField = $params['target'];
		} else {
			$this->targetField = $params;
		}
	}

	/**
	 * Returns the javascript class equavalent to this php class
	 *
	 * @return string javascript.
	 */
	abstract static function getJavascriptClass() ;

    /**
     * Checks if the Expression Action is allowed for the given action
     * If disallowedActions array is empty in_array will always return true
     * otherwise, it just checks if $action exists there
     *
     * @param String $action name of the action ("edit", "view", "save", ...)
     * @return boolean true if allowed, false otherwise
     */
    public function isActionAllowed($action)
    {
        return !in_array($action, $this->disallowedActions);
    }

	/**
	 * Returns the javascript code to create a new action of this type
	 * and execute the action.
	 *
	 * @return string javascript.
	 */
	abstract function getJavascriptFire();

	/**
	 * Applies the Action to the target.
	 *
	 * @param SugarBeam $target
	 */
	abstract function fire(&$target);

	/**
	 * Returns the definition of this action in array format.
	 *
	 */
	function getDefinition() {
		return array(
			"action" => $this->getActionName(),
	        "params" => $this->params,
	    );
	}

	abstract static function getActionName();

}

function handleExpressionError($errno, $errstr, $errfile, $errline, array $errcontext)
{
    $GLOBALS['log']->fatal("Error evaluating expression: {$errstr}\nLine {$errline} of file {$errfile}");
}