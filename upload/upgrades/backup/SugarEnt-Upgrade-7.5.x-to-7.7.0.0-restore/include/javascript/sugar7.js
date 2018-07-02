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
(function(app) {
    app.events.on("app:init", function() {
        var routes,
            homeOptions = {
                dashboard: 'dashboard',
                activities: 'activities'
            },
            getLastHomeKey = function() {
                return app.user.lastState.buildKey('last-home', 'app-header');
            };

        // FIXME: Routes should be an extension of router.js, and not in a
        // privately-scoped variable; will be addressed in SC-2761.
        routes = [
            {
                name: "index",
                route: ""
            },
            {
                name: "logout",
                route: "logout/?clear=:clear"
            },
            {
                name: "logout",
                route: "logout"
            },
            {
                name: "forgotpassword",
                route: "forgotpassword",
                callback: function(){
                    app.controller.loadView({
                        module: "Forgotpassword",
                        layout: "forgotpassword",
                        create: true
                    });
                }
            },
            {
                name: "home",
                route: "Home",
                callback: function() {
                    var lastHomeKey = getLastHomeKey(),
                        lastHome = app.user.lastState.get(lastHomeKey);
                    if (lastHome === homeOptions.dashboard) {
                        app.router.list("Home");
                    } else if (lastHome === homeOptions.activities) {
                        app.router.redirect('#activities');
                    }
                }
            },
            {
                name: 'about',
                route: 'about',
                callback: function() {
                    app.controller.loadView({
                        layout: 'about',
                        module: 'Home',
                        skipFetch: true
                    });
                }
            },
            {
                name: "activities",
                route: "activities",
                callback: function(){
                    //when visiting activity stream, save last state of activities
                    //so future Home routes go back to activities
                    var lastHomeKey = getLastHomeKey();
                    app.user.lastState.set(lastHomeKey, homeOptions.activities);

                    app.controller.loadView({
                        layout: "activities",
                        module: "Activities",
                        skipFetch: true
                    });
                }
            },
            {
                name: "bwc",
                route: "bwc/*url",
                callback: function(url) {
                    app.logger.debug("BWC: " + url);

                    var frame = $('#bwc-frame');
                    if (frame.length === 1 &&
                        app.utils.rmIframeMark('index.php' + frame.get(0).contentWindow.location.search) === url
                    ) {
                        // update hash link only
                        return;
                    }

                    // if only index.php is given, redirect to Home
                    if (url === 'index.php') {
                        app.router.navigate('#Home', {trigger: true});
                        return;
                    }
                    var params = {
                        layout: 'bwc',
                        url: url
                    };
                    var module = /module=([^&]*)/.exec(url);

                    if (!_.isNull(module) && !_.isEmpty(module[1])) {
                        params.module = module[1];
                        // on BWC import we want to try and take the import module as the module
                        if (module[1] === 'Import') {
                            module = /import_module=([^&]*)/.exec(url);
                            if (!_.isNull(module) && !_.isEmpty(module[1])) {
                                params.module = module[1];
                            }
                        }
                    }

                    app.controller.loadView(params);
                }
            },
            {
                name: "sg_index",
                route: "Styleguide",
                callback: function() {
                    app.controller.loadView({
                        module: "Styleguide",
                        layout: "styleguide",
                        page_name: "home"
                    });
                }
            },
            {
                name: "sg_module",
                route: "Styleguide/:layout/:resource",
                callback: function(layout, resource) {
                    var page = '',
                        field = '';
                    if (layout === 'field') {
                        //route: "Styleguide/field/text"
                        page = 'field';
                        field = resource;
                    } else if (layout === 'view') {
                        //route: "Styleguide/view/list"
                        page = 'layouts_' + resource;
                    } else if (layout === 'docs') {
                        //route: "Styleguide/docs/base_grid"
                        page = resource;
                    } else if (layout === 'layout') {
                        //route: "Styleguide/layout/records"
                        layout = resource;
                        page = 'module';
                    }
                    app.controller.loadView({
                        module: "Styleguide",
                        layout: layout,
                        page_name: page,
                        field_type: field,
                        skipFetch: true
                    });
                }
            },
            {
                name: "list",
                route: ":module"
            },
            {
                name: "create",
                route: ":module/create",
                callback: function(module) {
                    if (module === "Home") {
                        app.controller.loadView({
                            module: module,
                            layout: "record"
                        });

                        return;
                    }

                    // FIXME: We shouldn't be calling private methods like this.
                    // Will be addressed in SC-2761.
                    if (!app.router._moduleExists(module)) {
                        return;
                    }

                    var previousModule = app.controller.context.get("module"),
                        previousLayout = app.controller.context.get("layout");
                    if (!(previousModule === module && previousLayout === "records")) {
                        app.controller.loadView({
                            module: module,
                            layout: "records"
                        });
                    }

                    app.drawer.open({
                        layout: 'create-actions',
                        context: {
                            create: true
                        }
                    }, _.bind(function(context, model) {
                        var module = context.get("module") || model.module,
                            route = app.router.buildRoute(module);

                        app.router.navigate(route, {trigger: (model instanceof Backbone.Model)});
                    }, this));
                }
            },
            {
                name: "vcardImport",
                route: ":module/vcard-import",
                callback: function(module) {
                    // FIXME: We shouldn't be calling private methods like this.
                    // Will be addressed in SC-2761.
                    if (!app.router._moduleExists(module)) {
                        return;
                    }
                    app.controller.loadView({
                        module: module,
                        layout: "records"
                    });

                    app.drawer.open({
                        layout: 'vcard-import'
                    }, _.bind(function() {
                        //if drawer is closed (cancel), just put the URL back to default view for module
                        var route = app.router.buildRoute(module);
                        app.router.navigate(route, {replace: true});
                    }, this));
                }
            },
            {
                name: "layout",
                route: ":module/layout/:view"
            },
            {
                name: 'config',
                route: ':module/config',
                callback: function(module) {
                    // FIXME: We shouldn't be calling private methods like this.
                    // Will be addressed in SC-2761.
                    if (!app.router._moduleExists(module)) {
                        return;
                    }
                    // figure out where we need to go back to on cancel
                    var previousModule = app.controller.context.get("module"),
                        previousLayout = app.controller.context.get("layout");
                    if (!(previousModule === module && previousLayout === "records")) {
                        app.controller.loadView({
                            module: module,
                            layout: "records"
                        });
                    }

                    app.drawer.open({
                        layout: 'config',
                        context: {
                            module: module,
                            create: true
                        }
                    }, _.bind(function(context, model) {
                        var module = context.get("module") || model.module,
                            route = app.router.buildRoute(module);

                        app.router.navigate(route, {trigger: (model instanceof Backbone.Model)});
                    }, this));
                }
            },
            {
                name: "homeRecord",
                route: "Home/:id",
                callback: function(id) {
                    //when visiting a dashboard, save last state of dashboard
                    //so future Home routes go back to dashboard
                    var lastHomeKey = getLastHomeKey();
                    app.user.lastState.set(lastHomeKey, homeOptions.dashboard);

                    //then continue on with default record routing
                    app.router.record("Home", id);
                }
            },
            {
                name: "record",
                route: ":module/:id"
            },
            {
                name: "record",
                route: ":module/:id/:action"
            },
            {
                name: "record_layout",
                route: ":module/:id/layout/:view",
                callback: function(module, id, view) {
                    // FIXME: We shouldn't be calling private methods like this.
                    // Will be addressed in SC-2761.
                    if (!app.router._moduleExists(module)) {
                        return;
                    }
                    app.router.record(module, id, null, view);
               }
            },
            {
                name: "record_layout_action",
                route: ":module/:id/layout/:view/:action",
                callback: function(module, id, layout, action) {
                    // FIXME: We shouldn't be calling private methods like this.
                    // Will be addressed in SC-2761.
                    if (!app.router._moduleExists(module)) {
                        return;
                    }
                    app.router.record(module, id, action, layout);
                }
            }
        ];

        app.routing.setRoutes(routes);

        // allow subscription to successful token refresh
        app.api.setRefreshTokenSuccessCallback(function(callback) {
            callback();
            app.events.trigger("api:refreshtoken:success");
        });
    });

    app.routing.before('route', function(options) {
        var hasAccess = app.router.hasAccessToModule(options) !== false,
            isBwcRedirect = app.router.bwcRedirect(options) !== false;

        return hasAccess && isBwcRedirect;
    });

    //template language string for each page
    //i.e. records for listview, record for recordview
    var titles = {
            'records': 'TPL_BROWSER_SUGAR7_RECORDS_TITLE',
            'record': 'TPL_BROWSER_SUGAR7_RECORD_TITLE',
            'about': 'TPL_BROWSER_SUGAR7_ABOUT_TITLE'
        };
    // FIXME: This should have unit test coverage, e.g. on `app:view:change`
    // ensure `document.title` is updated. Will be addressed in SC-2761.
    var getTitle = function(model) {
        var context = app.controller.context,
            module = context.get('module'),
            template = Handlebars.compile(app.lang.get(titles[context.get('layout')], module) || ''),
            moduleString = app.lang.getAppListStrings('moduleList'),
            title;
        //pass current translated module name and current page's model data
        title = template(_.extend({
            module: moduleString[module],
            appId: app.config.appId
        }, model ? model.attributes : {}));
        // title may contain XML entities because Handlebars escapes characters
        // by replacing them for use in HTML, so the true text needs to be
        // lifted before it can be set on the title
        return $('<span/>').html(title).text();
    };
    // FIXME: This should have unit test coverage, will be addressed in SC-2761.
    //set current document title with template format
    var setTitle = function(model) {
        var title = getTitle(model);
        document.title = title || document.title;
    };
    //store previous view's model
    var prevModel;

    app.events.on("app:view:change", function() {
        var context = app.controller.context,
            module = context.get("module"),
            metadata = app.metadata.getModule(module),
            title;

        if (prevModel) {
            //if previous model is existed, clean out setTitle listener
            prevModel.off("change", setTitle);
        }

        if (_.isEmpty(metadata) || metadata.isBwcEnabled) {
            //For BWC module, current document title will be replaced with BWC title
            title = $('#bwc-frame').get(0) ? $('#bwc-frame').get(0).contentWindow.document.title : getTitle();
        } else {
            title = getTitle();
            if (!_.isEmpty(context.get("model"))) {
                //for record view, the title should be updated once model is fetched
                var currModel = context.get("model");
                currModel.on("change", setTitle, this);
                app.controller.layout.once("dispose", function() {
                    currModel.off("change", setTitle);
                });
                prevModel = currModel;
            }
        }
        document.title = title || document.title;
    }, this);

    // FIXME: This should have unit test coverage, will be addressed in SC-2761.
    var refreshExternalLogin = function() {
        var config = app.metadata.getConfig();
        app.api.setExternalLogin(config && config['externalLogin']);
    };

    app.events.on("app:sync:complete", refreshExternalLogin, this);
    app.events.on("app:init", refreshExternalLogin, this);

    // FIXME: This functionality should move into router.js, see SC-2761.
    app.Router = app.Router.extend({
        /**
         * Redirects the user to the appropriate BWC route if the requested
         * module has metadata and is in backward compatibility mode.
         *
         * If the route contains a valid BWC action that isn't the original
         * route, this function will route to that action (if the route is
         * invalid), otherwise it will route to the detail view (if an ID is
         * present).
         *
         * @param {Object} options Object containing routing information.
         * @return {Boolean} Returns `false` if redirected, `true` otherwise.
         */
        bwcRedirect: function(options) {
            if (options && _.isArray(options.args) && options.args[0]) {
                var module = options.args[0],
                    id = options.args[1],
                    action = id ? 'DetailView' : 'index',
                    meta = app.metadata.getModule(module);
                if (meta && meta.isBwcEnabled) {
                    var sidecarAction = options.args[2] || options.route,
                        bwcAction = app.bwc.getAction(sidecarAction);

                    if (bwcAction !== sidecarAction) {
                        action = bwcAction;
                    }

                    var redirect = 'bwc/index.php?module=' + module + '&action=' + action;

                    if (id) {
                        redirect += '&record=' + id;
                    }

                    app.router.navigate(redirect, {trigger: true, replace: true});
                    return false;
                }
            }
            return true;
        },

        /**
         * Check module access before navigating to certain routes.
         * Redirects to access denied page if user is lacking module access.
         *
         * @param {Object} [options] Object containing routing information.
         * @return {Boolean} Returns `false` if the ACL check for module access
         *   fails, `true` otherwise.
         */
        hasAccessToModule: function(options) {
            options = options || {};

            var checkAccessRoutes = {
                    'record': 'view',
                    'create': 'create',
                    'vcardImport': 'create'
                },
                route = options.route || '',
                args = options.args || [],
                module = args[0],
                accessCheck = checkAccessRoutes[route];

            if (accessCheck && !app.acl.hasAccess(accessCheck, module)) {
                app.controller.loadView({
                    layout: 'access-denied'
                });
                return false;
            }

            // FIXME: Show wizard functionality should be broken out into
            // another function; will be addressed in SC-2761.

            // Check if first time login wizard should be shown
            var showWizard = false;
            if (app.user && app.user.has('show_wizard')) {
                showWizard = app.user.get('show_wizard');
                if (showWizard) {
                    // If the license settings need to be input, don't show the wizard
                    var system_config = app.metadata.getConfig();
                    if (system_config.system_status &&
                        system_config.system_status.level &&
                        system_config.system_status.level === 'admin_only'
                    ) {
                        showWizard = false;
                    }
                }
            }
            // FIXME: Should be in a separate function, will be addressed in
            // SC-2761.
            if (showWizard) {
                var callbacks = {
                    complete: function() {
                        var module = app.utils.getWindowLocationParameterByName('module', window.location.search),
                            action = app.utils.getWindowLocationParameterByName('action', window.location.search);

                        // work around for saml authentication of a new user
                        if (_.isString(module) && _.isString(action) &&
                            module.toLowerCase() === 'users' && action.toLowerCase() === 'authenticate') {
                            window.location = window.location.pathname;
                        } else {
                            window.location.reload(); //Reload when done
                        }
                    }
                };
                app.controller.loadView({
                    layout: 'first-login-wizard',
                    module: 'Users',
                    modelId: app.user.get('id'),
                    callbacks: callbacks,
                    wizardName: app.user.get('type')
                });
                // FIXME: Should be event-driven, see:
                // https://github.com/sugarcrm/Mango/pull/18722#discussion_r11782561
                // Will be addressed in SC-2761.
                $('#header').hide();
                return false;
            }

            var passwordExpired = false;
            //If the password has expired (and we're not logging out which is ignored)
            if (route && route !== 'logout' && app.user && app.user.has('is_password_expired')) {
                passwordExpired = app.user.get('is_password_expired');
                if (passwordExpired) {
                    app.controller.loadView({
                        layout: 'password-expired',
                        module: 'Users',
                        callbacks: {
                            complete: function() {
                                window.location.reload();//Reload when password reset
                            }
                        },
                        modelId: app.user.get('id')
                    });
                    return false;
                }
            }

            var subroute;
            if (module) {
                var qpos = module.indexOf('?');
                subroute = qpos > -1 ? module.substring(0, module.indexOf('?')) : module;
            }
            var viewId = options.route + (subroute ? '/' + subroute : '');

            // FIXME: Analytics should not be tracked in hasAccessToModule,
            // will be moved into another function in SC-2761.
            app.analytics.currentViewId = viewId;
            app.analytics.trackPageView(app.analytics.currentViewId);

            return true;
        }
    });

    app.augment("progress", _.extend({
        init: function() {
            NProgress.configure({
                template: '<div class="loading gate">' +
                    '    <div class="progress progress-danger">' +
                    '        <div role="bar" class="bar"></div>' +
                    '    </div>' +
                    '</div>'
            });
            NProgress.start();
            NProgress.set(0.25);
        },
        hide: function() {
            $("#nprogress").hide();
        }}, NProgress),
        false
    );

    // For SAML Logout support
    app.events.on("app:logout:success", function(data) {
        if (app.config && app.config.externalLogin && data && data.url) {
            if (!$('#logoutframe').length) {
                $("#sugarcrm").append('<iframe id="logoutframe" />');
                $('#logoutframe').hide();
            }
            $('#logoutframe').load(function() {
                $('#logoutframe').off('load');
                $('#logoutframe').attr('src','');
            });
            $('#logoutframe').attr('src',data.url);
        }
    });
})(SUGAR.App);
