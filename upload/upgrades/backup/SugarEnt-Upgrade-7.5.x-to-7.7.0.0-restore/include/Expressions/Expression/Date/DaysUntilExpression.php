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
require_once('include/Expressions/Expression/Numeric/NumericExpression.php');

/**
 * <b>daysUntil(Date d)</b><br>
 * Returns number of days from now until the specified date.
 */
class DaysUntilExpression extends NumericExpression
{
	/**
	 * Returns the entire enumeration bare.
	 */
	function evaluate() {
		$params = DateExpression::parse($this->getParameters()->evaluate());
        if(!$params) {
            return false;
        }
        $now = TimeDate::getInstance()->getNow();
        //set the time to 0, as we are returning an integer based on the date.
        $now->setTime(0, 0, 0);
        $params->setTime(1, 0, 0);
        $tsdiff = $params->ts - $now->ts;
        $diff = (int)floor($tsdiff/86400);
        $extrasec = $tsdiff%86400;
        if($extrasec != 0) {
            $extra = $params->get(sprintf("%+d seconds", $extrasec));
            if($extra->day_of_year != $params->day_of_year) {
                $diff++;
            }
        }
        return $diff;
	}


	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
            var then = SUGAR.util.DateUtils.parse(this.getParameters().evaluate(), 'user');
			var now = new Date();
			now.setHours(0);
			now.setMinutes(0);
			now.setSeconds(0);
			then.setHours(1);
			then.setMinutes(0);
			then.setSeconds(0);
			var diff = then - now;
			var days = Math.floor(diff / 86400000);
			var extrasec = diff % 86400000;
			var extra = new Date();
			extra.setTime(then.getTime() + extrasec);
			if (extra.getDate() != then.getDate())
			    days++;

			return days;
EOQ;
	}


	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "daysUntil";
	}

	/**
	 * All parameters have to be a date.
	 */
    static function getParameterTypes() {
		return array(AbstractExpression::$DATE_TYPE);
	}

	/**
	 * Returns the maximum number of parameters needed.
	 */
	static function getParamCount() {
		return 1;
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}
}
