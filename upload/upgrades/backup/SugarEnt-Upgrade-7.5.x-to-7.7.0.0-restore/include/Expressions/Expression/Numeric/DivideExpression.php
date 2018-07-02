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
 * <b>divide(Number numerator, Number denominator)</b><br>
 * Returns the <i>numerator</i> divided by the <i>denominator</i>.<br/>
 * ex: <i>divide(8, 2)</i> = 4
 */
class DivideExpression extends NumericExpression {
	/**
	 * Returns itself when evaluating.
	 */
	function evaluate() {
		// TODO: add caching of return values
		$params = $this->getParameters();
		$numerator   = $params[0]->evaluate();
		$denominator = $params[1]->evaluate();
		if($denominator == 0) {
		    throw new Exception("Division by zero");
		}
		return $numerator/$denominator;
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var params = this.getParameters();
			var numerator   = params[0].evaluate();
			var denominator = params[1].evaluate();
			if (denominator == 0)
			    throw "Devision by 0 error";
			return numerator/denominator;
EOQ;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "divide";
	}

	/**
	 * Returns the exact number of parameters needed.
	 */
	static function getParamCount() {
		return 2;
	}
}
?>