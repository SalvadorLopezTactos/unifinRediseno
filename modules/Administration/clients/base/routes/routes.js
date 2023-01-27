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
                name: 'administration',
                route: 'Administration',
                callback: function() {
                    app.controller.loadView({
                        layout: 'administration',
                        module: 'Administration'
                    });
                }
            },
            {
                name: 'relate-denormalization',
                route: ':Administration/denormalization',
                callback: function(module) {
                    app.controller.loadView({
                        layout: 'config-drawer',
                        module: module
                    });
                }
            },
            {
                // route for Config Framework
                name: 'admin-config',
                route: ':Administration/config/:category',
                callback: function(module, category) {
                    var layout = app.metadata.getLayout(module, category + '-config') ? category + '-config' : 'config';
                    app.controller.loadView({
                        layout: layout,
                        category: category,
                        module: module
                    });
                }
            },
            {
                name: 'drive-path',
                route: ':Administration/drive-path/:type',
                callback: function(module, type) {
                    app.controller.loadView({
                        layout: 'drive-path',
                        module: module,
                        driveType: type,
                    });
                }
            },
        ];
        app.router.addRoutes(routes);
    });
})(SUGAR.App);
