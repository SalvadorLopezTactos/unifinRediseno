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
 * @class View.Fields.Base.Opportunities.FieldsetCascadeField
 * @alias SUGAR.App.view.fields.BaseOpportunitiesFieldsetCascadeField
 * @extends View.Fields.Base.FieldsetField
 */
({
    extendsFrom: 'FieldsetField',

    initialize: function(options) {
        this.plugins = _.union(this.plugins || [], ['Cascade']);
        this._super('initialize', [options]);
        this.def.lblString = app.lang.get('LBL_UPDATE_OPPORTUNITIES_RLIS', 'Opportunities') +
            ' ' +
            app.lang.getModuleName('RevenueLineItems', {plural: true});
    },

    /**
     * @inheritdoc
     */
    _loadTemplate: function() {
        // If the field isn't editable or disabled, fall back to fieldset's
        // base templates.
        if (this.action !== 'edit' && this.action !== 'disabled') {
            this.type = 'fieldset';
        }

        // Make sure that when the cascade plugin sets the field to be disabled
        // or not, that stays consistent on both base field and subfields.
        if (!_.isEmpty(this.fields)) {
            if (_.every(this.fields, function(field) {
                return field.action === 'detail';
            })) {
                this.type = 'fieldset';
                this.action = 'detail';
            }
            if (this.action === 'disabled') {
                this.setDisabled(true);
            }
        }

        this._super('_loadTemplate');
        this.type = this.def.type;
    }
})
