<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
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
        return <<<JS

        // this is only supported in Sidecar
        if (App === undefined) {
            return SUGAR.expressions.Expression.FALSE;
        }

        var params = this.params,
            view = this.context.view,
            target = this.context.target,
            relationship = params[0].evaluate(),
            rel_field = params[1].evaluate(),
            condition_field = params[2].evaluate(),

            //_.contains expects this to be an array, so convert it if it isn't already.
            condition_values = params[3].evaluate();
            if (!_.isArray(condition_values)) {
                condition_values = [condition_values];
            }

        var model = this.context.relatedModel || this.context.model,  // the model
            // has the model been removed from it's collection
            hasModelBeenRemoved = this.context.isRemoveEvent || false,
            // is this being fired for the condition field or the rel_field?
            currentFieldIsConditionField = (this.context.changingField === condition_field),
            // did the condition field change at some point?
            conditionChanged = _.has(model.changed, condition_field),
            // is the condition field valid?
            conditionValid = _.contains(condition_values, model.get(condition_field));
        if (conditionValid || conditionChanged) {
            var isCurrency = (model.fields[rel_field].type === 'currency'),
                current_value = this.context.getRelatedField(relationship, 'rollupConditionalSum', rel_field) || '0',
                context_previous_values = this.context.previous_values || {},
                previous_value = context_previous_values[rel_field + '--' + model.get('id')] || model.previous(rel_field) || '0',
                new_value = model.get(rel_field) || '0',
                value_changed = !_.isEqual(new_value, previous_value),
                rollup_value = undefined;

            // if the new_value is not a number, set it to '0'
            if (!_.isFinite(new_value)) {
                new_value = '0';
            }

            // if the previous_value is not a number set it to '0'
            if (!_.isFinite(previous_value)) {
                previous_value = '0';
            }

            if (isCurrency) {
                previous_value = App.currency.convertWithRate(
                    previous_value,
                    model.get('base_rate'),
                    this.context.model.get('base_rate')
                );
                new_value = App.currency.convertWithRate(
                    new_value,
                    model.get('base_rate'),
                    this.context.model.get('base_rate')
                );
            }

            // they are the same value and the model has not been removed,
            if (previous_value === new_value && !hasModelBeenRemoved) {
                // if the condition didn't change or it's not the current field
                if (!(conditionChanged && currentFieldIsConditionField)) {
                    // no math is needed
                    return;
                }
            }

            // store the new_value on the context for the rel_field
            // this allows multiple different formulas to change the rel_field while
            // maintaining the correct previous_value since it's not updated on the models previous_attributes
            // every time the model.set() is called before the initial set() completes
            this.context.previous_values = this.context.previous_values || {};
            this.context.previous_values[rel_field + '--' + model.get('id')] = new_value;

            if (conditionValid && !hasModelBeenRemoved) {
                // if the condition is valid and the condition field changed, check if the previous value
                // was an invalid condition, if it was, the `new_value` just needs to be added back
                if (conditionChanged && !_.contains(condition_values, model.previous(condition_field))) {
                    rollup_value = App.math.add(current_value, new_value, 6, true);
                } else if (value_changed && !currentFieldIsConditionField) {
                    // the condition might have changed, but it's still evaluating to true and we are not on the event
                    // being fired by the condition field. so remove the `previous_value` and add
                    // the `new_value` from `current_value`
                    rollup_value = App.math.add(App.math.sub(current_value, previous_value, 6, true), new_value, 6, true);
                }
            } else if ((conditionChanged && currentFieldIsConditionField) || hasModelBeenRemoved) {
                // when just the condition changes and the currentField is the condition field or
                // the model has been removed, subtract the value.
                rollup_value = App.math.sub(current_value, previous_value, 6, true);
            }
            // rollup_value won't exist if we didnt do any math, so just ignore this
            if (!_.isUndefined(rollup_value) && _.isFinite(rollup_value)) {
                // update the model
                this.context.model.set(target, rollup_value);
                // update the relationship defs on the model
                this.context.updateRelatedFieldValue(
                    relationship,
                    'rollupConditionalSum',
                    rel_field,
                    rollup_value,
                    this.context.model.isNew()
                );
            }
        }
JS;

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
