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
 * <b>rollupConditionalSum(Relate <i>link</i>, String <i>field</i>, String <i>conditionField</i>, List <i>conditionalValues</i>)</b><br>
 * Returns the sum of the values of <i>field</i> in records related by <i>link</i> where <i>conditionField</i> contains something from <i>conditionalValues</i> <br/>
 * ex: <i>rollupConditionalSum($products, "amount", "tax_cass", "Taxable")</i> in ProductBundles would return the <br/>
 * sum of the <i>amount</i> field where <i>tax_class</i> is equal to <i>Taxable</i>
 */
class SumConditionalRelatedExpression extends NumericExpression
{
    /**
     * Ability only rollup specific values from related records when a field on the related record is equal to
     * something.
     *
     * @return string
     */
    public function evaluate()
    {
        $params = $this->getParameters();
        // This should be of relate type, which means an array of SugarBean objects
        $linkField = $params[0]->evaluate();
        $relfield = $params[1]->evaluate();

        $conditionalField = $params[2]->evaluate();
        $conditionalValues = $params[3]->evaluate();

        if (!is_array($conditionalValues)) {
            $conditionalValues = array($conditionalValues);
        }

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

        foreach ($linkField as $bean) {
            if (!in_array($bean->$conditionalField, $conditionalValues)) {
                continue;
            }
            // only check the target field once to see if it's a currency field.
            if ($checkedTypeForCurrency === false) {
                $checkedTypeForCurrency = true;
                $relFieldIsCurrency = $this->isCurrencyField($bean, $relfield);
            }
            if (!empty($bean->$relfield)) {
                $value = $bean->$relfield;
                // if we have a currency field, it needs to convert the value into the rate of the row it's
                // being returned to.
                if ($relFieldIsCurrency) {
                    $value = SugarCurrency::convertWithRate($value, $bean->base_rate, $toRate);
                }
                $ret = SugarMath::init($ret)->add($value)->result();
            }
        }

        return $ret;
    }

    /**
     * Returns the JS Equivalent of the evaluate function.
     */
    public static function getJSEvaluate()
    {
        return false;
    }

    /**
     * Returns the operation name that this Expression should be
     * called by.
     */
    public static function getOperationName()
    {
        return array("rollupConditionalSum");
    }

    /**
     * The first parameter is a number and the second is the list.
     */
    public static function getParameterTypes()
    {
        return array(
            AbstractExpression::$RELATE_TYPE,
            AbstractExpression::$STRING_TYPE,
            AbstractExpression::$STRING_TYPE,
            AbstractExpression::$GENERIC_TYPE
        );
    }

    /**
     * Returns the maximum number of parameters needed.
     */
    public static function getParamCount()
    {
        return 4;
    }
}
