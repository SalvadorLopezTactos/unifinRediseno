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
(function(app) {
    app.events.on('router:init', function(router) {
        var routes = [
            {
                name: 'user-utilities-copy-content',
                route: ':Users/copy-content',
                callback: function(module) {
                    app.controller.loadView({
                        layout: 'copy-content',
                        module: module
                    });
                }
            },
            {
                name: 'user-utilities-update-locale',
                route: ':Users/update-locale',
                callback: function(module) {
                    app.controller.loadView({
                        layout: 'copy-user-settings',
                        module: module
                    });
                }
            },
        ];
        app.router.addRoutes(routes);
    });
})(SUGAR.App);
