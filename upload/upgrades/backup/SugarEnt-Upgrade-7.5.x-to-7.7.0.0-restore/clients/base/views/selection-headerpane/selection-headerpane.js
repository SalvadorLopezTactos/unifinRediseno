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
 * @class View.Views.Base.SelectionHeaderpaneView
 * @alias SUGAR.App.view.views.BaseSelectionHeaderpaneView
 * @extends View.Views.Base.HeaderpaneView
 */
({
    extendsFrom: 'HeaderpaneView',

    initialize: function(options) {
        var moduleMeta = app.metadata.getModule(options.module),
            isBwcEnabled = (moduleMeta && moduleMeta.isBwcEnabled),
            buttonsToRemove = [],
            additionalEvents = {};

        if (isBwcEnabled) {
            buttonsToRemove.push('create_button');
        } else {
            additionalEvents['click .btn[name=create_button]'] = 'createAndSelect';
            this.events = _.extend({}, this.events, additionalEvents);
        }

        this.isMultiLink = options.context.has('recLink');
        if (!this.isMultiLink) {
            buttonsToRemove.push('link_button');
        }

        options = this._removeButtons(options, buttonsToRemove);
        this._super('initialize', [options]);
    },

    /**
     * @inheritDoc
     */
    _renderHtml: function() {
        this._super('_renderHtml');

        this.layout.on('selection:closedrawer:fire', _.once(_.bind(function() {
            this.$el.off();
            app.drawer.close();
        }, this)));

        if (this.isMultiLink) {
            this.layout.on('selection:link:fire', function() {
                this.context.trigger('selection-list:link:multi');
            });
        }
    },

    /**
     * @inheritDoc
     */
    _formatTitle: function(title) {
        var moduleName = app.lang.get('LBL_MODULE_NAME', this.module);
        return app.lang.get(title, this.module, {module: moduleName});
    },

    /**
     * Open create inline modal with no dupe check
     * On save, set the selection model which will close the selection-list inline modal
     */
    createAndSelect: function() {
        app.drawer.open({
            layout: 'create-nodupecheck',
            context: {
                module: this.module,
                create: true
            }
        }, _.bind(function(context, model) {
            if (model) {
                this.context.trigger('selection-list:select', model);
            }
        }, this));
    },

    /**
     * Remove the specified buttons from the options metadata
     *
     * @param {object} options
     * @param {array} buttons
     * @return {*}
     * @private
     */
    _removeButtons: function(options, buttons) {
        if (options && options.meta && options.meta.buttons) {
            options.meta.buttons = _.filter(options.meta.buttons, function(button) {
                return !_.contains(buttons, button.name);
            });
        }

        return options;
    }
})
