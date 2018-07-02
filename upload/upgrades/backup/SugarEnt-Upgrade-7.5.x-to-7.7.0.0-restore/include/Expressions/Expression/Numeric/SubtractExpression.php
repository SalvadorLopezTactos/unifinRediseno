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
require_once("include/Expressions/Expression/Numeric/NumericExpression.php");
/**
 * <b>subtract(Number a, Number b)</b><br>
 * Returns <i>a</i> minus <i>b</i>.<br/>
 * ex: <i>subtract(9, 2, 3)</i> = 4
 */
class SubtractExpression extends NumericExpression {
	/**
	 * Returns itself when evaluating.
	 */
	function evaluate() {
		// TODO: add caching of return values
		$params = $this->getParameters();
		$diff = $params[0]->evaluate();
		for ( $i = 1; $i < sizeof($params ); $i++) {
			$diff -= $params[$i]->evaluate();
		}
		return $diff;
	}
	
	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var params = this.getParameters();
			var diff   = params[0].evaluate();
			for ( var i = 1; i < params.length; i++ ) {
				diff -= params[i].evaluate();
			}
			return diff;
EOQ;
	}
	
	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "subtract";
	}
	
	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
		$str = "";
		
		foreach ( $this->getParameters() as $expr ) {
			if ( ! $expr instanceof ConstantExpression )	$str .= "(";
			$str .= $expr->toString() . " - ";
			if ( ! $expr instanceof ConstantExpression )	$str .= ")";
		}
	}
}
?>