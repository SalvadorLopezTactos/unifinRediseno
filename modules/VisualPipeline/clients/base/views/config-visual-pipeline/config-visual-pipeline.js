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
 * @class View.Views.Base.VisualPipeline.ConfigPanelView
 * @alias SUGAR.App.view.views.BaseVisualConfigPanelView
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'BaseConfigPanelView',

    selectedModules: [],

    activeTabIndex: 0,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.customizeMetaFields();
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this.collection.on('add remove reset', this.render, this);
    },

    /**
     * @inheritdoc
     */
    render: function() {
        this._super('render');
        this.$('#tabs').tabs({
            active: this.context.get('activeTabIndex')
        });

        //event used in tile preview
        this.context.trigger('pipeline:config:tabs-initialized');
    },

    /**
     *  Adds the fields to the module into a two column layout
     */
    customizeMetaFields: function() {
        var twoColumns = [];
        var customizedFields = []; // To use as row in the UI

        _.each(this.meta.panels, function(panel) {
            _.each(panel.fields, function(field) {
                if (field.twoColumns) {
                    twoColumns.push(field);
                    if (twoColumns.length === 2) {
                        customizedFields.push(twoColumns);
                        twoColumns = [];
                    }
                } else {
                    customizedFields.push([field]);
                }
            }, this);
        }, this);

        this.meta.customizedFields = customizedFields;
    }
})
