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
require_once 'include/Expressions/Expression/Numeric/NumericExpression.php';

/**
 * <b>rollupSum(Relate <i>link</i>, String <i>field</i>)</b><br>
 * Returns the sum of the values of <i>field</i> in records related by <i>link</i><br/>
 * ex: <i>rollupSum($opportunities, "amount")</i> in Accounts would return the <br/>
 * sum of the amount of all the Opportunities related to this Account.
 */
class SumRelatedExpression extends NumericExpression
{
    /**
     * Finds any related records based on the `link` then takes the `field` and adds all the values up and returns
     * the sum.
     *
     * @return String
     */
    public function evaluate()
    {
        $params = $this->getParameters();
        //This should be of relate type, which means an array of SugarBean objects
        $linkField = $params[0]->evaluate();
        $relfield = $params[1]->evaluate();

        $ret = '0';

        if (!is_array($linkField) || empty($linkField)) {
            return $ret;
        }

        if (!isset($this->context)) {
            //If we don't have a context provided, we have to guess. This can be a large performance hit.
            $this->setContext();
        }
        $toRate = isset($this->context->base_rate) ? $this->context->base_rate : null;

        $checkedTypeForCurrency = false;
        $relFieldIsCurrency = false;

        $precision = 6;

        foreach ($linkField as $bean) {
            // only check the target field once to see if it's a currency field.
            if ($checkedTypeForCurrency === false) {
                $checkedTypeForCurrency = true;
                $relFieldIsCurrency = $this->isCurrencyField($bean, $relfield);
                if (!$relFieldIsCurrency) {
                    // only get the precision when we are not on a currency field, as currency should always be 6
                    $precision = $this->getFieldPrecision($bean, $relfield);
                }
            }
            if (!empty($bean->$relfield)) {
                $value = $bean->$relfield;
                // if we have a currency field, it needs to convert the value into the rate of the row it's
                // being returned to.
                if ($relFieldIsCurrency) {
                    $value = SugarCurrency::convertWithRate($value, $bean->base_rate, $toRate);
                }
                $ret = SugarMath::init($ret, $precision)->add($value)->result();
            }
        }

        return $ret;
    }

    /**
     * Returns the JS Equivalent of the evaluate function.
     */
    public static function getJSEvaluate()
    {
        return <<<EOQ
		    var params = this.getParameters();
			var linkField = params[0].evaluate();
			var relField = params[1].evaluate();

			if (typeof(linkField) == "string" && linkField != "") {
                return this.context.getRelatedField(linkField, 'rollupSum', relField);
			} else if (typeof(rel) == "object") {
			    //Assume we have a Link object that we can delve into.
			    //This is mostly used for n level dives through relationships.
			    //This should probably be avoided on edit views due to performance issues.

			}

			return "";
EOQ;
    }

    /**
     * Returns the operation name that this Expression should be
     * called by.
     */
    public static function getOperationName()
    {
        return array("rollupSum", "rollupCurrencySum");
    }

    /**
     * The first parameter is a number and the second is the list.
     */
    public static function getParameterTypes()
    {
        return array(AbstractExpression::$RELATE_TYPE, AbstractExpression::$STRING_TYPE);
    }

    /**
     * Returns the maximum number of parameters needed.
     */
    public static function getParamCount()
    {
        return 2;
    }

    /**
     * Returns the String representation of this Expression.
     */
    public function toString()
    {
    }
}
