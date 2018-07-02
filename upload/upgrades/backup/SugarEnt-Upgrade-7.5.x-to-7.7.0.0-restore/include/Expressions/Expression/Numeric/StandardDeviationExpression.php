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
 * <b>stddev(Number n, ...)</b><br>
 * Returns the population standard deviation of the <br/>
 * given values.<br>
 * ex: <i>stddev(4, 5, 6, 7, 10)</i> = 2.06
 */
class StandardDeviationExpression extends NumericExpression {
	/**
	 * Returns itself when evaluating.
	 */
	function evaluate() {
		$params = $this->getParameters();
		$values = array();
		
		// find the mean
		$sum   = 0;
		$count = sizeof($params);
		foreach ( $params as $param ) {
			$value = $param->evaluate();
			$values[] = $value;
			$sum += $value;
		}
		$mean = $sum / $count;
		
		// find the summation of deviations
		$deviation_sum = 0;
		foreach ( $values  as $value )
		{
			$deviation_sum += pow($value - $mean, 2);
		}	

		// find the std dev
		$variance = (1/$count)*$deviation_sum;
		
		return sqrt($variance);
	}
	
	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var params = this.getParameters();
			var values = new Array();
			
			// find the mean
			var sum   = 0;
			var count = params.length;
			for ( var i = 0; i < params.length; i++ ) {
				value = params[i].evaluate();
				values[values.length] = value;
				sum += value;
			}
			var mean = sum / count;
			
			// find the summation of deviations
			var deviation_sum = 0;
			for ( var i = 0; i < values.length; i++ )
				deviation_sum += Math.pow(values[i] - mean, 2);
	
			// find the std dev
			var variance = (1/count)*deviation_sum;
			
			return Math.sqrt(variance);
EOQ;
	}
	
	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "stddev";
	}
	
	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
		//pass
	}
}
?>