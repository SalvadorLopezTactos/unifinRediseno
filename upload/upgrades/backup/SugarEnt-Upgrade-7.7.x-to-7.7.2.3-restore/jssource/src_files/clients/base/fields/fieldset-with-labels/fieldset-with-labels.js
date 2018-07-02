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
 * @class View.Fields.Base.FieldsetWithLabelsField
 * @alias SUGAR.App.view.fields.BaseFieldsetWithLabelsField
 * @extends View.Fields.Base.FieldsetField
 */
({
    extendsFrom: 'FieldsetField',

    /**
     * @inheritDoc
     *
     * @deprecated 7.5 Use {@link View.Fields.Base.FieldsetField} instead.
     * This field will be removed in 7.6.
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        app.logger.warn('FieldsetWithLabels field is deprecated and will be removed as part of 7.6.' +
            'Please use Fieldset field instead.');
    },

    /**
     * {@inheritdoc}
     */
    _render: function() {
        if (_.isEmpty(this.fields)) {
            this._createFields();
            this._renderNewFields();
        } else {
            this._renderExistingFields();
        }

        // Adds classes to the component based on the metadata.
        if(this.def && this.def.css_class) {
            this.getFieldElement().addClass(this.def.css_class);
        }

        return this;
    },

    /**
     * Load fieldset template and create fields
     * @private
     */
    _createFields: function() {
        this._loadTemplate();
        this.$el.html(this.template(this));
    },

    /**
     * Render fields that have not been rendered previously
     * @private
     */
    _renderNewFields: function() {
        _.each(this.def.fields, function(fieldDef) {
            var field = this.view.getField(fieldDef.name);
            this.fields.push(field);
            field.setElement(this.$("span[sfuuid='" + field.sfId + "']"));
            field.render();
        }, this);
    },

    /**
     * Re-render fields
     * @private
     */
    _renderExistingFields: function() {
        _.each(this.fields, function(field) {
            field.render();
        }, this);
    },

    /**
     * {@inheritdoc}
     */
    getPlaceholder: function() {
        return app.view.Field.prototype.getPlaceholder.call(this);
    },

    /**
     * {@inheritdoc}
     */
    setMode: function(name) {
        this.tplName = name;
        this._super("setMode", [name]);
    }
})
