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
/**
 * @class View.Views.Base.CJForms.CreateView
 * @alias SUGAR.App.view.views.CJFormsCreateView
 * @extends View.Views.Base.CreateView
 */
({
    extendsFrom: 'CreateView',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.on('record:showHidePanel', app.CJBaseHelper.showHidePanel, this);
    },

    /**
     * @inheritdoc
     */
    _render: function() {
        this._super('_render');
        this.$('div[data-panelname="hidden_panel"]').hide();
        this.$('div[data-panelname="LBL_RECORDVIEW_PANEL4"]').hide();
    },

    /**
     * @inheritdoc
     */
    validateModelWaterfall: function(callback) {
        let fields = this.getFields(this.module);
        let populateFields = this.getField('populate_fields');

        if (populateFields) {
            fields = _.extend({}, fields, populateFields.addedFieldsDefs);
        }
        this.model.doValidate(fields, function(isValid) {
            callback(!isValid);
        });
    },
});
