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
 * Login form view.
 *
 * @class View.Views.Base.LoginView
 * @alias SUGAR.App.view.views.BaseLoginView
 * @extends View.View
 */
({
    /**
     * @inheritdoc
     */
    plugins: ['ErrorDecoration'],

    /**
     * @inheritdoc
     */
    fallbackFieldTemplate: 'edit',

    /**
     * @inheritdoc
     */
    events: {
        'click [name=login_button]': 'login',
        'keypress': 'handleKeypress',
        "click [name=external_login_button]": "external_login",
        "click [name=login_form_button]": "login_form"
    },

    /**
     * An object containing the keys of the alerts that may be displayed in this
     * view.
     *
     * @type {Object}
     */
    _alertKeys: {
        adminOnly: 'admin_only',
        invalidGrant: 'invalid_grant_error',
        login: 'login',
        needLogin: 'needs_login_error',
        offsetProblem: 'offset_problem',
        unsupportedBrowser: 'unsupported_browser'
    },

    /**
     * Flag to indicate if the link to reset the password should be displayed.
     *
     * @type {Boolean}
     */
    showPasswordReset: false,

    /**
     * The company logo url.
     *
     * @type {String}
     */
    logoUrl: null,

    /**
     * Process login on key `Enter`.
     *
     * @param {Event} event The `keypress` event.
     */
    handleKeypress: function(event) {
        if (event.keyCode === 13) {
            this.$('input').trigger('blur');
            this.login();
        }
    },

    /**
     * Get the fields metadata from panels and declare a Bean with the metadata
     * attached.
     *
     * Fields metadata needs to be converted to {@link Data.Bean#declareModel}
     * format.
     *
     *     @example
     *      {
     *        "username": { "name": "username", ... },
     *        "password": { "name": "password", ... },
     *        ...
     *      }
     *
     * @param {Object} meta The view metadata.
     * @private
     */
    _declareModel: function(meta) {
        meta = meta || {};

        var fields = {};
        _.each(_.flatten(_.pluck(meta.panels, 'fields')), function(field) {
            fields[field.name] = field;
        });
        app.data.declareModel('Login', {fields: fields});
    },

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        if (app.progress) {
            app.progress.hide();
        }
        // Declare a Bean so we can process field validation
        this._declareModel(options.meta);

        // Reprepare the context because it was initially prepared without metadata
        options.context.prepare(true);

        this._super('initialize', [options]);

        var config = app.metadata.getConfig();
        if (config && app.config.forgotpasswordON === true) {
            this.showPasswordReset = true;
        }
        
        if (config && 
            app.config.externalLogin === true && 
            app.config.externalLoginSameWindow === true &&
            !_.isEmpty(app.config.externalLoginUrl)
        ) {
            this.externalLoginForm = true;
            this.externalLoginUrl = app.config.externalLoginUrl;
        }

        // Set the page title to 'SugarCRM' while on the login screen
        $(document).attr('title', 'SugarCRM');
    },

    /**
     * @inheritdoc
     */
    _render: function() {
        this.logoUrl = app.metadata.getLogoUrl();
        //It's possible for errors to prevent the postLogin from triggering so contentEl may be hidden.
        app.$contentEl.show();

        this._super('_render');

        this.refreshAdditionalComponents();

        if (!this._isSupportedBrowser()) {
            var linkLabel = Handlebars.Utils.escapeExpression(app.lang.get('LBL_ALERT_SUPPORTED_PLATFORMS_LINK'));
            var link = '<a href="http://support.sugarcrm.com/05_Resources/03_Supported_Platforms/">' +  linkLabel + '</a>';
            var safeLink = new Handlebars.SafeString(link);
            var label = app.lang.get('TPL_ALERT_BROWSER_SUPPORT', null, {link: safeLink});

            app.alert.show(this._alertKeys.unsupportedBrowser, {
                level: 'warning',
                title: '',
                messages: [
                    app.lang.get('LBL_ALERT_BROWSER_NOT_SUPPORTED'),
                    label
                ]
            });
        }

        var config = app.metadata.getConfig(),
            level = config.system_status && config.system_status.level;

        if (level === 'maintenance' || level === 'admin_only') {
            app.alert.show(this._alertKeys.adminOnly, {
                level: 'warning',
                title: '',
                messages: [
                    '',
                    app.lang.get(config.system_status.message)
                ]
            });
        }
        app.alert.dismiss(this._alertKeys.offsetProblem);
        return this;
    },

    /**
     * Refresh additional components
     */
    refreshAdditionalComponents: function() {
        _.each(app.additionalComponents, function(component) {
            component.render();
        });
    },

    /**
     * Process login.
     *
     * We have to manually set `username` and `password` to the model because
     * browser autocomplete does not always trigger DOM change events that would
     * propagate changes into the model.
     */
    login: function() {
        //FIXME: Login fields should trigger model change (SC-3106)
        this.model.set({
            password: this.$('input[name=password]').val(),
            username: this.$('input[name=username]').val()
        });
        this.model.doValidate(null,
            _.bind(function(isValid) {
                if (isValid) {
                    app.$contentEl.hide();

                    app.alert.show(this._alertKeys.login, {
                        level: 'process',
                        title: app.lang.get('LBL_LOADING'),
                        autoClose: false
                    });

                    var args = {
                        password: this.model.get('password'),
                        username: this.model.get('username')
                    };

                    app.login(args, null, {
                        error: function() {
                            app.$contentEl.show();
                            app.logger.debug('login failed!');
                        },
                        success: _.bind(function() {
                            app.logger.debug('logged in successfully!');
                            app.alert.dismiss(this._alertKeys.invalidGrant);
                            app.alert.dismiss(this._alertKeys.needLogin);

                            app.events.on('app:sync:complete', function() {
                                app.logger.debug('sync in successfully!');
                                _.defer(_.bind(this.postLogin, this));
                            }, this);
                        }, this),
                        complete: _.bind(function() {
                            app.alert.dismiss(this._alertKeys.login);
                        }, this)
                    });
                }
            }, this)
        );

        app.alert.dismiss('offset_problem');
    },

    /**
     * After login and app:sync:complete, we need to see if there's any post
     * login setup we need to do prior to rendering the rest of the Sugar app.
     */
    postLogin: function() {
        if (!app.user.get('show_wizard') && !app.user.get('is_password_expired')) {

            this.refreshAdditionalComponents();

            if (new Date().getTimezoneOffset() != (app.user.getPreference('tz_offset_sec') / -60)) {
                var link = new Handlebars.SafeString('<a href="#' +
                    app.router.buildRoute('Users', app.user.id, 'edit') + '">' +
                    app.lang.get('LBL_TIMEZONE_DIFFERENT_LINK') + '</a>');

                var message = app.lang.get('TPL_TIMEZONE_DIFFERENT', null, {link: link});

                app.alert.show(this._alertKeys.offsetProblem, {
                    messages: message,
                    closeable: true,
                    level: 'warning'
                });
            }
        }
        app.$contentEl.show();
    },

    /**
     * Taken from sugar_3.
     *
     * @return {Boolean} `true` if the browser is supported, `false` otherwise.
     * @private
     */
    _isSupportedBrowser: function() {
        var supportedBrowsers = {
            // For Safari & Chrome jQuery.Browser returns the webkit revision
            // instead of the browser version and it's hard to determine this
            // number.
            msie : {min:11}, // IE 11
            safari : {min:600}, // Safari 8.0.8, 9.0.1
            mozilla : {min:41}, // Firefox 41, 42
            chrome : {min:537.36} // Chrome 47
        };

        var current = parseFloat($.browser.version);

        // For IE11, navigator behaves differently in order to conform to HTML5
        // standards. This changes the behavior of jQuery.Browser and so IE11
        // will show up as not supported in the above checks when it should be
        // supported. The following check rectifies this issue.
        if ((/Trident\/7\./).test(navigator.userAgent)) {
            var supported = supportedBrowsers['msie'];
            return current >= supported.min;
        // jquery $.browser returns 'safari' on a Chrome browser
        // we want to make sure the right browser type to be checked
        } else if ($.browser['safari'] && navigator.userAgent.indexOf('Chrome') != -1) {
            var supported = supportedBrowsers['chrome'];
            return current >= supported.min;
        } else {
            for (var b in supportedBrowsers) {
                if ($.browser[b]) {
                    var supported = supportedBrowsers[b];
                    return current >= supported.min;
                }
            }
        }
    },
    
    /**
     * Process Login
     */
    external_login: function() {
        window.location.replace(this.externalLoginUrl);
    },
    
    /**
     * Show Login form
     */
    login_form: function() {
        app.config.externalLogin = false;
        app.controller.loadView({
            module: "Login",
            layout: "login",
            create: true
        });
    }
})
