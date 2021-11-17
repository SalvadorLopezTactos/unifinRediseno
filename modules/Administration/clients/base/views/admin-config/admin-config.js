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
 * @class View.Views.Base.AdministrationAdminConfigView
 * @alias SUGAR.App.view.views.AdminConfigView
 * @extends View.Views.Base.RecordView
 */
({
    extendsFrom: 'RecordView',

    /**
     * The main setting prefix.
     * @property {string}
     */
    settingPrefix: '',

    /**
     * Message to show on successful save.
     * @property {string}
     */
    saveMessage: '',

    /**
     * The css class used for the main element.
     * * @property {string}
     */
    className: 'admin-config-body',

    /**
     * The help strings to be displayed in the help block.
     * @property {Object}
     */
    helpBlock: {},

    /**
     * A collection of variables used for help block text interpolation.
     * @property {Object}
     */
    helpBlockContext: null,

    /**
     * Initialize the help block displayed below the configuration field(s).
     *
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.helpBlock = this.generateHelpBlock();
        this.loadSettings();
    },

    /**
     * Load any existing configuration.
     * @abstract
     */
    loadSettings: function() {
        // Override this method to customize actions upon loading the configuration.
    },

    /**
     * Render the view in edit mode and display the help block.
     * @inheritdoc
     */
    _render: function() {
        this._super('_render');
        this.action = 'edit';
        this.toggleEdit(true);
        this.renderHelpBlock();
    },

    /**
     * Save the settings.
     */
    save: function() {
        var options = {
            error: _.bind(this.saveErrorHandler, this),
            success: _.bind(this.saveSuccessHandler, this)
        };
        app.api.call('create', app.api.buildURL(this.module, this.settingPrefix), this.model.toJSON(), options);
    },

    /**
     * On a successful save the Save button has to be disabled and
     * a message will be shown indicating that the settings have been saved.
     *
     * @param {Object} settings The aws connect settings.
     */
    saveSuccessHandler: function(settings) {
        this.updateConfig(settings);
        this.closeView();
        app.alert.show(this.settingPrefix + '-info', {
            autoClose: true,
            level: 'success',
            messages: app.lang.get(this.saveMessage, this.module)
        });
    },

    /**
     * Set settings on the model.
     *
     * @param {Object} settings details.
     */
    copySettingsToModel: function(settings) {
        _.each(settings, function(value, key) {
            this.model.set(key, value);
        }, this);
        this.model.on('change', this.boundChangeHandler);
    },

    /**
     * Show an error message if the settings could not be saved.
     */
    saveErrorHandler: function() {
        app.alert.show(this.settingPrefix + '-warning', {
            level: 'error',
            title: app.lang.get('LBL_ERROR')
        });
    },

    /**
     * It triggers the save process if all fields are valid.
     *
     * @param {boolean} isValid If all the fields are valid.
     */
    validationComplete: function(isValid) {
        if (isValid) {
            this.save();
        }
    },

    /**
     * On a successful save return to the Administration page.
     */
    closeView: function() {
        // Config changed... reload metadata
        app.sync();
        if (app.drawer && app.drawer.count()) {
            app.drawer.close(this.context, this.context.get('model'));
        } else {
            app.router.navigate(this.module, {trigger: true});
        }
    },

    /**
     * Update the settings stored in the front-end.
     *
     * @param {Object} settings.
     */
    updateConfig: function(settings) {
        _.each(settings, function(value, key) {
            app.config[app.utils.getUnderscoreToCamelCaseString(key)] = value;
        });
    },

    /**
     * Return the strings for help block.
     *
     * @return {Object}
     */
    generateHelpBlock: function() {
        var helpTemplate = app.template.getView(this.name + '.help-block', this.module);
        var block = {};

        _.each(this.meta.panels, function(panel) {
            if (panel.helpLabels) {
                var help = [];
                _.each(panel.helpLabels, function(label) {
                    help.push({
                        name: this.getHelpBlockName(label),
                        label: label.text || '',
                        text: this.getHelpBlockText(label)
                    });
                }, this);
                block[panel.name] = helpTemplate(help);
            }
        }, this);

        return block;
    },

    /**
     * Creates and returns the translated help block title.
     *
     * @param {Object} label An object holding labels to be translated.
     * @return {string} The help block name.
     */
    getHelpBlockName: function(label) {
        if (_.isUndefined(label.name)) {
            return '';
        }
        var translation = app.lang.get(label.name, this.module, this.helpBlockContext);

        return translation + ':';
    },

    /**
     * Creates and returns the translated help block text.
     *
     * @param {Object} label An object holding labels to be translated.
     * @return {string} The help block text.
     */
    getHelpBlockText: function(label) {
        if (_.isUndefined(label.text)) {
            return '';
        }
        var translation = app.lang.get(label.text, this.module, this.helpBlockContext);

        return new Handlebars.SafeString(translation);
    },

    /**
     * Render help block. By default it will append the blocks to the record container.
     */
    renderHelpBlock: function() {
        var panel = this.$el.find('.record');
        _.each(this.helpBlock, function(block) {
            if (panel.length) {
                panel.append(block);
            }
        }, this);
    }
})
