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
/**
 * @class View.Fields.Base.IntField
 * @alias SUGAR.App.view.fields.BaseIntField
 * @extends View.Fields.Base.BaseField
 */
({
    /**
     * @inheritdoc
     *
     * The direction for this field should always be `ltr`.
     */
    direction: 'ltr',

    /**
     * @inheritdoc
     *
     * Unformats the integer based on userPreferences (grouping separator).
     * If we weren't able to parse the value, `undefined` is returned.
     *
     * @param {String} value the formatted value based on user preferences.
     * @return {Number|undefined} the unformatted value.
     */
    unformat: function(value) {
        return app.utils.unformatNumberStringLocale(value, true);
    },

    /**
     * @inheritdoc
     *
     * Formats the integer based on user preferences (grouping separator).
     * If the field definition has `disabled_num_format` as `true` the value
     * won't be formatted. Also, if the value isn't a finite integer it will
     * return `undefined`.
     *
     * @param {Number} value the integer value to format as per user
     *   preferences.
     * @return {String|undefined} the formatted value based as per user
     *   preferences.
     */
    format: function(value) {
        var numberGroupSeparator = '', decimalSeparator = '';

        if (!this.def.disable_num_format) {
            numberGroupSeparator = app.user.getPreference('number_grouping_separator') || ',';
            decimalSeparator = app.user.getPreference('decimal_separator') || '.';
        }

        return app.utils.formatNumber(
            value, 0, 0,
            numberGroupSeparator,
            decimalSeparator
        );
    }
})
