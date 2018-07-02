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
 * @class View.Fields.Base.LanguageField
 * @alias SUGAR.App.view.fields.BaseLanguageField
 * @extends View.Fields.Base.EnumField
 */
({
    extendsFrom: 'EnumField',

    /**
     * @inheritDoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        if (!this.model.has(this.name)) {
            this._setToDefault();
        }
    },

    /**
     * Ensure we load enum templates
     *
     * @override
     * @private
     */
    _loadTemplate: function() {
        this.type = 'enum';
        app.view.Field.prototype._loadTemplate.call(this);
        this.type = 'language';
    },

    /**
     * {@inheritDoc}
     * If no value, set the application default language as default value.
     * If edit mode, set the application default language on the model.
     */
    format: function(value) {
        if (!this.items[value]) {
            value = this._getDefaultOption();
            this._setToDefault();
        }

        return value;
    },

    /**
     * {@inheritdoc}
     *
     * @returns {String}  The default language as the default value
     */
    _getDefaultOption: function(optionsKeys) {
        return app.lang.defaultLanguage;
    },

    /**
     * Sets the default value for the field.
     */
    _setToDefault: function() {
        var defaultValue = this._getDefaultOption();
        this.model.set(this.name, defaultValue);
        //Forecasting uses backbone model (not bean) for custom enums so we have to check here
        if (_.isFunction(this.model.setDefaultAttribute)) {
            this.model.setDefaultAttribute(this.name, defaultValue);
        }
    }
})
