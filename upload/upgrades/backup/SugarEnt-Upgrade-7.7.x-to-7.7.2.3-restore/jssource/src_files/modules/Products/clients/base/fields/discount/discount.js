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
 * @class View.Fields.Base.Products.DiscountField
 * @alias SUGAR.App.view.fields.BaseProductsDiscountField
 * @extends View.Fields.Base.CurrencyField
 */
({
    extendsFrom: 'CurrencyField',

    /**
     * @inheritdoc
     *
     * Listen for the discount_select field to change, when it does, re-render the field
     */
    bindDataChange: function() {
        this._super('bindDataChange');

        // if discount select changes, we need to re-render this field
        this.model.on('change:discount_select', this.render, this);
    },

    /**
     * @inheritdoc
     *
     * Special handling of the templates, if we are displaying it as a percent, then use the _super call,
     * otherwise get the templates from the currency field.
     */
    _loadTemplate: function() {
        if (this.model.get('discount_select') == true) {
            this._super('_loadTemplate');
        } else {
            this.template = app.template.getField('currency', this.action || this.view.action, this.module) ||
                app.template.empty;
            this.tplName = this.action || this.view.action;
        }
    },

    /**
     * @inheritdoc
     *
     * Special handling for the format, if we are in a percent, use the decimal field to handle the percent, otherwise
     * use the format according to the currency field
     */
    format: function(value) {
        if (this.model.get('discount_select') == true) {
            return app.utils.formatNumberLocale(value);
        } else {
            return this._super('format', [value]);
        }
    },

    /**
     * @inheritdoc
     *
     * Special handling for the unformat, if we are in a percent, use the decimal field to handle the percent,
     * otherwise use the format according to the currency field
     */
    unformat: function(value) {
        if (this.model.get('discount_select') == true) {
            var unformattedValue = app.utils.unformatNumberStringLocale(value, true);
            // if unformat failed, return original value
            return _.isFinite(unformattedValue) ? unformattedValue : value;
        } else {
            return this._super('unformat', [value]);
        }
    }
})
