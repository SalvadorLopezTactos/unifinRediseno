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
 * @class View.Views.Base.AdministrationCspSettingView
 * @alias SUGAR.App.view.views.BaseCspSettingView
 * @extends View.Views.Base.AdministrationAdminConfigView
 */
({
    extendsFrom: 'AdministrationAdminConfigView',

    /**
     * @inheritdoc
     */
    settingPrefix: 'csp',

    /**
     * @inheritdoc
     */
    saveMessage: 'LBL_CSP_SETTING_SAVED',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this.helpBlockContext = {
            linkToDocumentation: app.help.getDocumentationUrl('ContentSecurityPolicy')
        };

        this._super('initialize', [options]);

        this.boundSaveHandler = _.bind(this.validateModel, this);
        this.context.on('save:cspdefaultsrc', this.boundSaveHandler);
    },

    /**
     * @inheritdoc
     */
    loadSettings: function() {
        var options = {
            success: _.bind(function(settings) {
                this.copySettingsToModel(settings);
            }, this),
        };
        app.api.call('get', app.api.buildURL(this.module, this.settingPrefix), [], options, {context: this});
    },

    /**
     * Triggers the field validation through the model.
     * Validation of the following components: IPv4 and IPv6 addresses.
     */
    validateModel: function() {
        var fieldValue = this.model.get('csp_default_src');
        if (this.validateSpecificValue(fieldValue)) {
            this.showValidationAlert();
            return false;
        }
        this.model.doValidate(this.options.meta.panels[0].fields, _.bind(this.validationComplete, this));
    },

    /**
     * Alert for validation failure.
     */
    showValidationAlert: function() {
        var message = app.lang.get('LBL_CSP_ERROR_MESSAGE', null, this.helpBlockContext);
        app.alert.show('csp_send_warning', {
            level: 'error',
            messages: message,
            autoClose: false,
        });
        this.getField('csp_default_src').decorateError();
    },

    /**
     * Show alert if validation fails.
     */
    saveErrorHandler: function() {
        this.showValidationAlert();
    },

    /**
     * On a successful save a message will be shown indicating that the settings have been saved.
     * The page will be reloaded in order to refresh CSP settings in browser.
     *
     * @param {Object} settings The CSP settings.
     */
    saveSuccessHandler: function(settings) {
        this.updateConfig(settings);
        this.closeView();
        app.alert.show(this.settingPrefix + '-info', {
            autoClose: true,
            level: 'success',
            messages: app.lang.get(this.saveMessage, this.module),
            onAutoClose: () => window.location.reload(true)
        });
    },

    /**
     * Simple initial validation. The main validation will be handled on the backend.
     *
     * @param {string} string The string to validate.
     * @return {boolean}
     */
    validateSpecificValue: function(string) {
        return new RegExp(['\'none\'|[,;]'].join(''), 'g').test(string);
    },

    /**
     * Unbind save handler.
     * @inheritdoc
     */
    dispose: function() {
        if (!this.disposed) {
            this.context.off('save:cspdefaultsrc', this.boundSaveHandler);
            this._super('dispose');
        }
    },
})
