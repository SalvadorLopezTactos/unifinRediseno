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
 * @extends View.AlertView
 */
({
    /**
     * extendsFrom: This needs to be app.view.AlertView since it's extending
     * a Sidecar specific view class. This is a special case, as the normal
     * method is for it to be a string.
     */
    extendsFrom: app.view.AlertView,

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
     * Supported options are:
     *  - options.level: Type of alert
     *  - options.onConfirm: Handler of action Confirm for confirmation alerts
     *  - options.onCancel: Handler of action Cancel for confirmation alerts
     *  - options.onLinkClicked: Handler for click actions on a link inside the
     *    alert
     *  - options.onClose: Handler for the close event on the (x)
     *  - options.templateOptions: Augment template context with custom object
     *
     * @override
     * @param {Object} options
     */
    initialize: function(options) {
        app.plugins.attach(this, 'view');
        this.onConfirm = options.onConfirm;
        this.onCancel = options.onCancel;
        this.onLinkClick = options.onLinkClick;
        this.onClose = options.onClose;
        this.alertLevel = options.level;
        this.templateOptions = options.templateOptions;
        this.name = 'alert';
    },

    /**
     * {@inheritDoc}
     * Render the custom alert view template.
     *
     * Binds `Esc` and `Return` keys for confirmation alerts.
     */
    render: function(options) {
        if (!this.triggerBefore('render')) {
            return false;
        }
        if (_.isUndefined(options)) {
            return this;
        }

        var template = this.getAlertTemplate(options.level, options.messages, options.title, this.templateOptions);
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
     * Get the HTML string for alert given alert level
     * @param {String} level
     * @param {String/Array} messages
     * @param {String} title(optional)
     * @param {Object} templateOptions(optional) additional custom options
     *                 passed to template function
     * @return {String}
     */
    getAlertTemplate: function(level, messages, title, templateOptions) {
        var template,
            alertClasses = this.getAlertClasses(level);

        title = title ? title : this.getDefaultTitle(level);

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
            messages: this.getTranslatedLabels(messages)
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
                return new Handlebars.SafeString(app.lang.getAppString(text));
            });
        } else {
            result = new Handlebars.SafeString(app.lang.getAppString(stringOrArray));
        }

        return result;
    },

    /**
     * Remove br tags after alerts which are needed to stack alerts vertically.
     */
    close: function() {
        this.unbindCancelAndReturn();
        this.$el.next('br').remove();
        this._super('close');
    },

    /**
     * Used by confirmation alerts so pressing `Esc` will Cancel, pressing
     * `Return` will Confirm
     */
    bindCancelAndReturn: function() {
        $(document).on('keydown.' + this.cid, _.bind(function(event) {
            var keyReturn = 13, keyEsc = 27;
            if (_.indexOf([keyReturn, keyEsc], event.which) > -1) {
                event.preventDefault();
                if (event.which === keyReturn) {
                    this.$('[data-action=confirm]').click();
                } else {
                    this.$('[data-action=cancel]').click();
                }
            }
        }, this));
    },

    /**
     * Unbind keydown event
     */
    unbindCancelAndReturn: function() {
        $(document).off('keydown.' + this.cid);
    },

    /**
     * @override
     */
    bindDataChange: function() {
    }
})
