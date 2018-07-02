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
 * @class View.Views.Base.AlertView
 * @alias SUGAR.App.view.views.BaseAlertView
 * @extends View.View
 */
({
    className: 'alert-wrapper', //override default class

    plugins: ['Tooltip'],

        events: {
            'click [data-action=cancel]': 'cancelClicked',
            'click [data-action=confirm]': 'confirmClicked',
            'click [data-action=close]': 'closeClicked',
            'click a': 'linkClick'
        },

    LEVEL: {
        PROCESS: 'process',
        SUCCESS: 'success',
        WARNING: 'warning',
        INFO: 'info',
        ERROR: 'error',
        CONFIRMATION: 'confirmation'
    },

    /**
     * Initialize alert view.
     *
     * @param {Object} options Options to be passed to the alert view.
     * @param {boolean} options.closeable: boolean flag indicating if the alert
     *   can be closed by the user. Note that non-"info" alerts are closeable by
     *   default if this setting is not specified.
     * @param {Function} options.onConfirm: Handler of action Confirm for
     *   confirmation alerts.
     * @param {Function} options.onCancel: Handler of action Cancel for
     *   confirmation alerts.
     * @param {Function} options.onLinkClicked: Handler for click actions on a
     *   link inside the alert.
     * @param {Function} options.onClose: Handler for the close event on the (x).
     * @param {Object} options.templateOptions: Augment template context with
     *   custom object.
     *
     * @override
     */
    initialize: function(options) {
        app.plugins.attach(this, 'view');

        options || (options = {});
        options.confirm || (options.confirm = {});
        options.cancel || (options.cancel = {});

        this.onConfirm = options.onConfirm || options.confirm.callback;
        this.confirmLabel = options.confirm.label || 'LBL_CONFIRM_BUTTON_LABEL';
        this.onCancel = options.onCancel || options.cancel.callback;
        this.cancelLabel = options.cancel.label || 'LBL_CANCEL_BUTTON_LABEL';
        this.onLinkClick = options.onLinkClick;
        this.onClose = options.onClose;
        this.templateOptions = options.templateOptions;
        this.name = 'alert';
    },

    /**
     * Gets selector for DOM elements that need to be clicked in order to close an alert.
     * @return {Object} jQuery/Zepto selector of the close button.
     */
    getCloseSelector: function() {
        return this.$('.close');
    },

    /**
     * Renders the custom alert view template. Binds `Esc` and `Return` keys for
     * confirmation alerts.
     *
     * @override
     */
    render: function() {
       var options = this.options;

        if (!this.triggerBefore('render')) {
            return false;
        }
        if (_.isUndefined(options)) {
            return this;
        }

        var template = this._getAlertTemplate(options, this.templateOptions);

        this.$el.html(template);

        if (options.level === 'confirmation') {
            this.bindCancelAndReturn();
        }

        this.trigger('render');
    },

    /**
     * Dismiss the alert when user clicks `cancel`
     */
    cancel: function() {
        this.trigger('dismiss');
        app.alert.dismiss(this.key);
    },

    /**
     * Executes assigned handlers when user clicks `cancel`.
     */
    cancelClicked: function() {
        this.cancel();
        app.events.trigger('alert:cancel:clicked');
        if (_.isFunction(this.onCancel)) {
            this.onCancel();
        }
    },

    /**
     * Executes assigned handlers when user clicks `confirm`.
     */
    confirmClicked: function() {
        this.cancel();
        app.events.trigger('alert:confirm:clicked');
        if (_.isFunction(this.onConfirm)) {
            this.onConfirm();
        }
    },

    /**
     * Fired when a link is clicked
     *
     * @param {Event} event
     */
    linkClick: function(event) {
        if (_.isFunction(this.onLinkClick)) {
            this.onLinkClick(event);
        }
    },

    /**
     * Fired when the close (x) is clicked
     * @param {Event} event
     */
    closeClicked: function(event) {
        if (_.isFunction(this.onClose)) {
            this.onClose();
        }
        app.alert.dismiss(this.key);
    },
    /**
     * Gets the HTML string for alert given options.
     *
     * @param {Object} options The options object passed to the alert object when it was
     *   created. See {@link #initialize} documentation to know the available
     *   options.
     * @param {Object} [templateOptions] Optional template options to be passed
     *   to the template.
     * @return {string} The generated template.
     * @private
     */
    _getAlertTemplate: function(options, templateOptions) {
        var template;
        var level = options.level;
        var alertClasses = this.getAlertClasses(level);
        var title = options.title || this.getDefaultTitle(level);

        switch (level) {
            case this.LEVEL.PROCESS:
                //Cut ellipsis at the end of the string
                title = title.substr(-3) === '...' ? title.substr(0, title.length - 3) : title;
                template = app.template.getView(this.name + '.process');
                break;
            case this.LEVEL.SUCCESS:
            case this.LEVEL.WARNING:
            case this.LEVEL.INFO:
            case this.LEVEL.ERROR:
                template = app.template.getView(this.name + '.error');
                break;
            case this.LEVEL.CONFIRMATION:
                template = app.template.getView(this.name + '.confirmation');
                break;
            default:
                template = app.template.empty;
        }
        var seed = _.extend({}, {
            alertClass: alertClasses,
            title: this.getTranslatedLabels(title),
            messages: this.getTranslatedLabels(options.messages),
            closeable: _.isUndefined(options.closeable) || options.closeable,
            alert: this
        }, templateOptions);
        return template(seed);
    },

    /**
     * Get CSS classes given alert level
     * @param {String} level
     * @return {String}
     */
    getAlertClasses: function(level) {
        switch (level) {
            case this.LEVEL.PROCESS:
                return 'alert-process';
            case this.LEVEL.SUCCESS:
                return 'alert-success';
            case this.LEVEL.WARNING:
                return 'alert-warning';
            case this.LEVEL.INFO:
                return 'alert-info';
            case this.LEVEL.ERROR:
                return 'alert-danger';
            case this.LEVEL.CONFIRMATION:
                return 'alert-warning';
            default:
                return '';
        }
    },

    /**
     * Get the default title given alert level
     * @param {String} level
     * @return {String}
     */
    getDefaultTitle: function(level) {
        switch (level) {
            case this.LEVEL.PROCESS:
                return 'LBL_ALERT_TITLE_LOADING';
            case this.LEVEL.SUCCESS:
                return 'LBL_ALERT_TITLE_SUCCESS';
            case this.LEVEL.WARNING:
                return 'LBL_ALERT_TITLE_WARNING';
            case this.LEVEL.INFO:
                return 'LBL_ALERT_TITLE_NOTICE';
            case this.LEVEL.ERROR:
                return 'LBL_ALERT_TITLE_ERROR';
            case this.LEVEL.CONFIRMATION:
                return 'LBL_ALERT_TITLE_WARNING';
            default:
                return '';
        }
    },

    /**
     * Return translated text, given a string or an array of strings.
     * @param {String/Array} stringOrArray
     * @return {String/Array}
     */
    getTranslatedLabels: function(stringOrArray) {
        var result;

        if (_.isArray(stringOrArray)) {
            result = _.map(stringOrArray, function(text) {
                return new Handlebars.SafeString(app.lang.get(text));
            });
        } else {
            result = new Handlebars.SafeString(app.lang.get(stringOrArray));
        }

        return result;
    },

    /**
     * Remove br tags after alerts which are needed to stack alerts vertically.
     */
    close: function() {
        this.unbindCancelAndReturn();
        this.$el.next('br').remove();
        this.dispose();
    },

    /**
     * Used by confirmation alerts so pressing `Esc` will Cancel, pressing
     * `Return` will Confirm
     */
    bindCancelAndReturn: function() {
        app.shortcuts.saveSession();
        app.shortcuts.createSession([
            'Alert:Confirm',
            'Alert:Cancel'
        ], this);

        app.shortcuts.register('Alert:Confirm', ['enter'], function() {
            this.$('[data-action=confirm]').click();
        }, this);

        app.shortcuts.register('Alert:Cancel', ['esc'], function() {
            this.$('[data-action=cancel]').click();
        }, this);
    },

    /**
     * Unbind keydown event
     */
    unbindCancelAndReturn: function() {
        if (this.level === 'confirmation') {
            app.shortcuts.restoreSession();
        }
    },

    /**
     * @override
     */
    bindDataChange: function() {
    }
})
