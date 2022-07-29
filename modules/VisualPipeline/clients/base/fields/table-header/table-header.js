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
 * @class View.Fields.Base.VisualPipeline.TableHeaderField
 * @alias SUGAR.App.view.fields.BaseVisualPipelineTableHeaderField
 * @extends View.Fields.Base.EnumField
 */
({
    extendsFrom: 'EnumField',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        var items = {};
        var tabContent = this.model.get('tabContent');
        if (_.isEmpty(tabContent)) {
            tabContent = this.getTabContent(this.model.get('enabled_module'));
        }

        if (options.def.name === 'table_header') {
            items = tabContent.dropdownFields;
        }
        if (options.def.name === 'tile_body_fields' || options.def.name === 'tile_header') {
            items = tabContent.fields;
        }
        this.items = items;

        var optionsBody = this.model.get('tile_body_fields');
        if (!_.isEmpty(optionsBody)) {
            //Transform the tile_body back to array if it isn't already.
            if (false === optionsBody instanceof Array) {
                var parsedOptions = JSON.parse(optionsBody);
                this.model.set('tile_body_fields', parsedOptions);
            }
        }
    },

    /**
     * Retrieves the content of the tab for the module
     * @param {string} changes Object containing the changes for the fields of an update activity message
     * @return {Object} The tab content
     */
    getTabContent: function(module) {
        var content = {};
        var dropdownFields = {};
        var allFields = {};
        var fields = app.metadata.getModule(module, 'fields');

        _.each(fields, function(field) {
            if (_.isObject(field)) {
                var label = field.vname || field.label;

                if (!_.isEmpty(app.lang.getModString(label, module))) {
                    allFields[field.name] = app.lang.getModString(label, module);

                    if (field.type === 'enum') {
                        dropdownFields[field.name] = app.lang.getModString(label, module);
                    }
                }
            }
        });

        content.dropdownFields = dropdownFields;
        content.fields = allFields;

        return content;
    }
});
