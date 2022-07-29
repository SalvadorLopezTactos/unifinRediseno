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
                name: 'visualPipelineList',
                route: 'VisualPipeline',
                callback: function() {
                    app.router.redirect('#Opportunities/pipeline');
                }
            },
            {
                name: 'visualPipelineCreate',
                route: 'VisualPipeline/create',
                callback: function() {
                    app.router.redirect('#Opportunities/pipeline');
                }
            },
            {
                name: 'visualPipelineRecord',
                route: 'VisualPipeline/:id',
                callback: function(id) {
                    if (id === 'config') {
                        app.drawer.open({
                            layout: 'config-drawer',
                            context: {
                                module: 'VisualPipeline',
                                fromRouter: true
                            }
                        });
                    } else {
                        app.router.redirect('#Opportunities/pipeline');
                    }
                }
            }
        ];
        app.router.addRoutes(routes);
    });
})(SUGAR.App);
