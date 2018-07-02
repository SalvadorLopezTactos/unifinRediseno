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
 * Alert View.
 *
 * Interface for creating alerts via show and dismiss. Also, this module
 * keeps an internal dictionary of alerts created which can later be accessed
 * by key. This is useful so that client code can dismiss a particular alert.
 *
 * Note that the client application may provide custom implementation of {@link View.AlertView} class.
 * This implementation will be in charge of rendering the alert to its UI.
 *
 * At minimum, a client app's must provide:
 *
 * 1. `#alerts` element in its `index.html`.
 * 2. Pre-compiled template called `alert`. The template can be compiled at application start-up:
 * <code>app.template.compile("alert", "template body...");</code>
 */
(function(app) {

    // Dictionary of alerts
    var _alerts = {};

    var _alert = {

        //When this flag is set to true, it prevents any new alert to be shown.
        //This is useful for `confirmation` type alerts because you want the
        //user to focus and confirm/cancel the action and don't bother him with
        //anything else.
        preventAnyAlert: false,

        /**
         * Initializes alert module at application start-up.
         */
        init: function() {
            /**
             * Alert element selector.
             *
             * The default value is `$('#alerts')`. Override using {@link Config#alertsEl} setting.
             * @property {Object}
             */
            this.$alerts = $('#alerts');

            /**
             * Alert view class.
             *
             * The default value is {@link View.AlertView}.
             * However, if `app.view.[Capitalized-appId]AlertView` or `app.view.[Capitalized-platform]AlertView` class
             * exists, it will be used instead.
             * @property {Function}
             */
            this.klass = app.view.AlertView;

            if (app.config) {
                this.$alerts = $(app.config.alertsEl).length ? $(app.config.alertsEl) : this.$alerts;

                this.klass = app.view[app.utils.capitalize(app.config.appId) + "AlertView"] ||
                app.view.views[app.utils.capitalize(app.config.platform) + 'AlertView'] ||
                app.view.views.BaseAlertView ||
                app.view[app.utils.capitalize(app.config.platform) + "AlertView"] ||
                this.klass;
            }

            // Check for existing alerts and convert them into AlertView.
            _.each(this.$alerts.find('.alert-wrapper'), function(el, i) {
                var key = 'init-' + i;
                if (!_alerts[key]) {
                    _alerts[key] = this._create(key, {el: el});
                }
            }, this);
        },

        /**
         * Displays an alert message and adds to internal dictionary of alerts.
         * Use supplied key later to dismiss the alert. Caller is responsible for using language translation
         * before calling!
         *
         * To create and close alerts, this function uses private factory method {@link View.Alert#_create}
         * which instantiates alert view class specified by the {@link View.Alert#klass} property and places the alert
         * instance in the DOM as the first element in the {@link View.Alert#$alerts} element.
         *
         * The {@link View.AlertView} class provides boilerplate implementation for a typical single alert view.
         * You can customize alert behavior by extending {@link View.AlertView} class.
         * At minimum, you have to make sure that a pre-compiled template named `"alert"` exists.
         *
         * In case we are showing a `confirmation` alert, we want to dismiss all other
         * existing alerts and prevent any other alerts
         *
         * </code></pre>
         *
         * Examples:
         * <pre><code>
         * var a1 = app.alert.show('delete_warning', {
         *     level: 'warning',
         *     title: 'Warning',
         *     messages: 'Are you sure you want to delete this record?',
         *     autoclose: true
         * });
         *
         * var a2 = app.alert.show('internal_error', {
         *     level: 'error',
         *     messages: ['Internal Error', 'Response code: 500']
         * })
         *
         * </code></pre>
         *
         * @param {Object} options(optional) The options below are handled by
         *   the framework. The base application {@link View.Views.Base.AlertView#initialize AlertView}
         *   defines more options for specific behaviors.
         *
         * @param {string} options.level: alert level. `alert-[level]` class
         *   will be added to the alert view.
         * @param {boolean} options.autoClose: boolean flag indicating if the
         *   alert must be closed after dismiss delay: See
         *   {@link Config#alertAutoCloseDelay} setting.
         * @param {string} options.messages: string or array of string messages.
         *   This parameter is normalized to array before rendering alerts.
         * @param {string} options.title: the title of the alert, it's displayed
         *   in bold.
         * @return {View.AlertView} Alert instance.
         */
        show: function(key, options) {
            if (!this.$alerts || this.$alerts.length == 0) return null;

            if (this.preventAnyAlert) return null;

            options = _.extend({
                level: 'info',
                autoClose: false
            }, options || {});

            if (options.level === 'confirmation') {
                this.dismissAll();
                this.preventAnyAlert = true;
            }

            if (options.messages) {
                options.messages = _.isString(options.messages) ? [options.messages] : options.messages;
            }

            var alert = _alerts[key];
            // Create a new alert view if it doesn't exist
            if (!alert) {
                alert = this._create(key, options);
                _alerts[key] = alert;
            }

            alert.level = options.level;

            // Initialize autoclose timer
            if (!!options.autoClose) this._setAutoCloseTimer(alert, options.onAutoClose, options.autoCloseDelay);

            alert.render();

            return alert;
        },

        /**
         * Creates an instance of alert view class and places view in the DOM.
         * @param {String} key Alert ID.
         * @param {Object} options Options.
         * @return {View.AlertView} Instance of alert view class.
         * @private
         */
        _create: function(key, options) {
            var alert = new this.klass(options);
            alert.key = key;
            alert.$el.prependTo(this.$alerts);
            return alert;
        },

        /**
         * Sets the timeout to dismiss the alert view after either the alertAutoCloseDelay configured or 9 seconds
         * @param {Object} alert the alert to auto close
         * @param {Function} onAutoClose callback function to call on the autoclose
         * @private
         */
        _setAutoCloseTimer: function(alert, onAutoClose, autoCloseDelay) {
            if (alert.timerId) clearTimeout(alert.timerId);
            alert.timerId = setTimeout(_.bind(function() {
                if(_.isFunction(onAutoClose)) {
                    onAutoClose(alert.key); //callback for when the timeout occurs and the alert is closing
                }
                this.dismiss(alert.key);

            }, this), autoCloseDelay || app.config.alertAutoCloseDelay || 9000);
        },

        /**
         * Removes an alert message by key.
         * @param {String} key The key provided when previously calling show.
         * @param {Object} options(optional) Options.
         * @method
         */
        dismiss: function(key, options) {
            this.preventAnyAlert = false;
            var alert = _alerts[key];
            if (!alert) return;
            if (alert.timerId) clearTimeout(alert.timerId);
            alert.close(options);
            delete _alerts[key];
        },

        /**
         * Removes all alert messages with a given level.
         * @param {String} level(optional) Level of alerts to dismiss.
         * @param {Object} options(optional) Options.
         * Dismisses all alerts if the level is not specified.
         * @method
         */
        dismissAll: function(level, options) {
            _.each(_alerts, function(alert, key) {
                if (!level || alert.level == level) {
                    this.dismiss(key, options);
                }
            }, this);
        },

        /**
         * Gets an alert with a given key.
         * @param {String} key The key of the alert to retrieve.
         * @return {View.AlertView} Alert view with the specified key.
         */
        get: function(key) {
            return _alerts[key];
        },

        /**
         * Gets alerts that are currently displayed.
         * @return {Object} All alerts.
         */
        getAll: function() {
            return _alerts;
        }
    };

    /**
     * Base class for alerts.
     *
     * Extend this class to provide custom alert behavior:
     * <pre><code>
     * var PortalAlertView = app.view.AlertView.extend({
     *
     *    initialize: function(options) {
     *       app.view.AlertView.prototype.initialize.call(this, options);
     *
     *       // You may override and/or pre-compile alert template
     *       this.tpl = 'my-alert';
     *       app.template.compile('my-alert', 'handlebars code...');     *
     *    },
     *
     *    render: function(options) {
     *        // Provide your custom rendering logic.
     *        // For example, switch between different templates
     *        this.tpl = "alert2";
     *        app.view.AlertView.prototype.render.call(this, options);
     *    },
     *
     *    close: function() {
     *        // Provide your custom dismiss logic: animation, fade effects, etc.
     *    }
     * });
     * </code></pre>
     *
     * @class View.AlertView
     * @alias SUGAR.App.view.AlertView
     */
    app.view.AlertView = app.view.Component.extend({

        /**
         * Name of the default template.
         */
        tpl: '<div class="alert alert-block">{{#if title}}<strong>{{title}}</strong>{{/if}}{{#each messages}}{{./this}}{{/each}}</div>',

        /**
         * Closes an alert.
         *
         * @deprecated since 7.7 please use {@link #dispose}.
         */
        close: function() {
            this.remove();
        },

        /**
         * Renders an alert.
         *
         * The method executes a pre-compiled template and replaces the inner
         * HTML of this view root DOM element.
         * Additionally, `alert-[level]` class is added to the root element.
         */
        render: function() {
            var tpl = Handlebars.compile(this.tpl);
            this.$el.html(tpl(this.options));
            this.$('.alert').addClass('alert-' + this.options.level);
        }

    });

    app.augment("alert", _alert, true);

})(SUGAR.App);
