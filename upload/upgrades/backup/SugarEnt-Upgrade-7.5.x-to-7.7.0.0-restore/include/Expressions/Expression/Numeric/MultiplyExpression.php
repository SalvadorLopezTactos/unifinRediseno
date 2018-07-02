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
 * <b>multiply(Number n, ...)</b><br>
 * Multiplies the supplied numbers and returns the result.<br/>
 * ex: <i>multiply(-4, 2, 3)</i> = -24
 */
class MultiplyExpression extends NumericExpression {
	/**
	 * Returns itself when evaluating.
	 */
	function evaluate() {
		// TODO: add caching of return values
		$product = 1;
		foreach ( $this->getParameters() as $expr )
			$product *= $expr->evaluate();
		return $product;
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var params = this.getParameters();
			var product = 1;
			for ( var i = 0; i < params.length; i++ )	product *= params[i].evaluate();
			return product;
EOQ;
	}
	
	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "multiply";
	}
	
	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
		$str = "";
		
		foreach ( $this->getParameters() as $expr ) {
			if ( ! $expr instanceof ConstantExpression )	$str .= "(";
			$str .= $expr->toString() . " * ";
			if ( ! $expr instanceof ConstantExpression )	$str .= ")";
		}
	}
}
?>