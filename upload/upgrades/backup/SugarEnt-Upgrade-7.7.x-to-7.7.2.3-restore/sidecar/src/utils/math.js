
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

(function(app) {
    /**
     * Math module provides utility methods for working with basic calculations
     * that JS normally fails to do well.
     *
     * @class Utils.Math
     * @alias SUGAR.App.math
     * @singleton
     */
    app.augment('math', {

        /**
         * Do math calculations in javascript,
         * sans floating point errors.
         *
         * ex. $10.52 is really 1052 cents. Think of currency as
         * cents and apply math that way (as integers)  and this should
         * help keep floating point issues out of the picture.
         *
         * @param {String} operator
         * @param {Number} n1
         * @param {Number|undefined} n2
         * @param {Number|undefined} (decimals)
         * @param {boolean|undefined} (fixed) return value as fixed string
         * @return {Number|String} rounded amount
         */
        _math: function(operator, n1, n2, decimals, fixed) {
            decimals = (_.isFinite(decimals) && decimals >= 0) ? parseInt(decimals) : 6;
            fixed = fixed || false;
            var result;
            var divisor = Math.pow(10, decimals);
            var r1 = parseFloat(n1) * divisor;
            var r2 = !_.isUndefined(n2) ? (parseFloat(n2) * divisor) : undefined;
            switch (operator) {
                case 'round':
                    result = Math.round(r1) / divisor;
                    break;
                case 'add':
                    result = (r1 + r2) / divisor;
                    break;
                case 'sub':
                    result = (r1 - r2) / divisor;
                    break;
                case 'mul':
                    result = this.round(r1 * r2 / divisor / divisor, decimals, fixed);
                    break;
                case 'div':
                    result = this.round(r1 / r2, decimals, fixed);
                    break;
                default:
                    // no valid operator, just return number
                    return n1;
            }
            return (fixed && !_.isString(result)) ? result.toFixed(decimals) : result;
        },

        /**
         * round a number to specified decimals as integer value.
         *
         * @param {Number} number
         * @param {Number|undefined} decimals
         * @param {boolean|undefined} fixed return value as fixed string
         * @return {Number|String} rounded amount
         */
        round: function(number, decimals, fixed) {
            return this._math('round', number, null, decimals, fixed);
        },

        /**
         * add two numbers as integer values
         *
         * @param {Number} n1
         * @param {Number} n2
         * @param {Number|undefined} decimals
         * @param {boolean|undefined} fixed return value as fixed string
         * @return {Number|String} rounded amount
         */
        add: function(n1, n2, decimals, fixed) {
            return this._math('add', n1, n2, decimals, fixed);
        },

        /**
         * subtract two numbers as integer values
         *
         * @param {Number} n1
         * @param {Number} n2
         * @param {Number|undefined} decimals
         * @param {boolean|undefined} fixed return value as fixed string
         * @return {Number|String} rounded amount
         */
        sub: function(n1, n2, decimals, fixed) {
            return this._math('sub', n1, n2, decimals, fixed);
        },

        /**
         * multiply two numbers as integer values
         *
         * @param {Number} n1
         * @param {Number} n2
         * @param {Number|undefined} decimals
         * @param {boolean|undefined} fixed return value as fixed string
         * @return {Number|String} rounded amount
         */
        mul: function(n1, n2, decimals, fixed) {
            return this._math('mul', n1, n2, decimals, fixed);
        },

        /**
         * divide two numbers as integer values
         *
         * @param {Number} n1
         * @param {Number} n2
         * @param {Number|undefined} decimals
         * @param {boolean|undefined} fixed return value as fixed string
         * @return {Number|String} rounded amount
         */
        div: function(n1, n2, decimals, fixed) {
            return this._math('div', n1, n2, decimals, fixed);
        },

        /**
         * Check to see if two values are different that will compute with a given precision
         *
         * This will compute the difference between the newValue and oldValue and figure out if it's changed
         * by at least 1 rounded out to the decimal precision that the users has set in their preferences
         *
         * @param {String|Number} newValue      The New Value
         * @param {String|Number} oldValue      The Old Value
         * @param {Number} (precision)          What precision should we use (optional)
         * @return {boolean}
         */
        isDifferentWithPrecision: function(newValue, oldValue, precision) {
            var config = app.metadata.getConfig(),
                user_precision = precision || app.user.getPreference('decimal_precision'),
                precision = (_.isFinite(user_precision)) ? user_precision : config.defaultCurrencySignificantDigits || 2,
                diff = this._math('round', this.getDifference(newValue, oldValue, true), null, precision),
                diffPrecision = (precision === 0) ? 0 : this._math('div', 0.1, Math.pow(10, (precision-1)));

            // if the diff is 0 (zero) always return false, this should only happen when precision is 0
            return (diff === 0) ? false : (diff >= diffPrecision);
        },

        /**
         * Get the difference of two number
         *
         * @param {Number} newValue
         * @param {Number} oldValue
         * @param {Boolean} [absolute=false]
         */
        getDifference: function(newValue, oldValue, absolute) {
            var diff = this._math('sub', newValue, oldValue),
                absolute = _.isUndefined(absolute) ? false : absolute;

            return (absolute) ? Math.abs(diff) : diff;
        }

    }, false);
})(SUGAR.App);
