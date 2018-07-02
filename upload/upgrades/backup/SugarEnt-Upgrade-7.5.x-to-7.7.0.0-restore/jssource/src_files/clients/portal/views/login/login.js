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
 * @class View.Views.LoginView
 * @alias SUGAR.App.view.views.PortalLoginView
 */
({
    /**
     * @inheritDoc
     */
    plugins: ['ErrorDecoration', 'Tooltip'],

    /**
     * @inheritDoc
     */
    events: {
        'click [name=login_button]': 'login',
        'click [name=signup_button]': 'signup',
        'keypress': 'handleKeypress'
    },

    /**
     * @inheritDoc
     *
     * Hide `forgot password` tooltip when clicking anywhere outside the link.
     */
    initialize: function(options) {
        var self = this;

        this._super('initialize', [options]);

        $(document).on('click.login', function(event) {
            var $forgotPassword = self.$('#forgot-password'),
                forgotPassword = $forgotPassword.get(0);
            if (!$.contains(forgotPassword, event.target)) {
                app.utils.tooltip.hide(forgotPassword);
            }
        });
    },

    /**
     * Navigate to the `Signup` view.
     */
    signup: function() {
        app.router.navigate('#signup');
        app.router.start();
    },

    /**
     * @inheritDoc
     */
    postLogin: function() {
        app.$contentEl.show();
    },

    /**
     * @inheritDoc
     *
     * Remove event handler for hiding `forgot password` tooltip.
     */
    _dispose: function() {
        $(document).off('click.login');
        this._super('_dispose');
    }
})
