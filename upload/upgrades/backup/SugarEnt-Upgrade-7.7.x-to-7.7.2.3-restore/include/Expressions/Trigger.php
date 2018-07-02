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
require_once("include/Expressions/Dependency.php");
require_once("include/Expressions/Actions/AbstractAction.php");
require_once("include/Expressions/Expression/Parser/Parser.php");
require_once("include/Expressions/Expression/AbstractExpression.php");

/**
 * Expression trigger
 * @api
 */
class Trigger
{
	public $triggerFields = array();
	public $conditionFunction = "";
	static $ValueNotSetError = -1;

	function Trigger($condition, $fields = array()) {
		$this->conditionFunction = $condition;
		if (!is_array($fields))
			$fields = array($fields);
		$this->triggerFields = $fields;
	}

	function evaluate($target) {
		$result = Parser::evaluate($this->conditionFunction, $target)->evaluate();
		if ($result == AbstractExpression::$TRUE){
			return true;
		} else {
			return false;
		}
	}

	function getJavascript() {
		$js = "new SUGAR.forms.Trigger([";
		for ($i=0; $i < sizeOf($this->triggerFields); $i++) {
			$js .= "'{$this->triggerFields[$i]}'";
			if ($i < sizeOf($this->triggerFields) - 1){
				$js .= ",";
			}
		}
		$js .= "], '" . str_replace("\n","",$this->conditionFunction) . "')";
		return $js;
	}

	function getCondition() {
		return $this->conditionFunction;
	}

    function getFields(){
        return $this->triggerFields;
    }
}