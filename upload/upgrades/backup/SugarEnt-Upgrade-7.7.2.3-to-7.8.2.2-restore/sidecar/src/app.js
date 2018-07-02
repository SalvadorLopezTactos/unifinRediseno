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
 * SugarCRM namespace.
 *
 * @ignore
 */
var SUGAR = SUGAR || {};

SUGAR.App = (function() {
    var _app,
        _modules = {};

    /**
     * Flag indicating an `app.sync` is in progress.
     *
     * @type {boolean}
     * @private
     */
    var _isSyncing = false;

    /**
     * A list of callback functions to call whenever `sync` is completed.
     *
     * @type {Array}
     * @private
     */
    var _syncCallbacks = [];

    var _make$ = function(selector) {
        return selector instanceof $ ? selector : $(selector);
    };

    /**
     * `SUGAR.App` contains the core instance of the app. All related modules
     * can be found within the `SUGAR` namespace.
     *
     * An uninitialized instance will exist on page load but you will need to
     * call {@link App#init} to initialize your instance.
     *
     * By default, the app uses `body` element and `div#content` as root element
     * and content element respectively.
     *
     *     var app = SUGAR.App.init({
     *         el: '#root',
     *         contentEl: '#content'
     *     });
     *
     * If you want to initialize an app without initializing its modules,
     *
     *     var app = SUGAR.App.init({el: '#root', silent: true});
     *
     *
     * @class App
     * @singleton
     * @constructor Constructor class for the main framework app.
     * @param {Object} [opts] Configuration options. See full list of options
     *   in {@link #init}.
     * @return {App} Application instance.
     * @private
     */
    function App(opts) {
        var appId = _.uniqueId('SugarApp_');
        opts = opts || {};

        return _.extend({
            /**
             * Unique application ID.
             *
             * @property {string}
             */
            appId: appId,

            /**
             * Base element to use as the root of the app.
             *
             * @property {jQuery}
             */
            $rootEl: _make$(opts.el || 'body'),

            /**
             * Content element selector.
             *
             * The {@link Core.Controller application controller} loads layouts
             * into the content element.
             *
             * @property {jQuery}
             */
            $contentEl: _make$(opts.contentEl || '#content'),

            /**
             * Additional components.
             *
             * These components are created and rendered only once, when the
             * application starts.
             *
             * Application specific code is needed for managing the components
             * after they have been put into DOM by the framework.
             */
            additionalComponents: {}

        }, this, Backbone.Events);
    }

    return {
        /**
         * Initializes the app.
         *
         * - Triggers {@link #event-app:init} if `opts.silent` is not `false`.
         * - {@link #event-app:sync:error} is fired if the public metadata could
         * not be synced.
         *
         * @param {Object} [opts] Initialization options.
         * @param {string} [opts.el='body'] The selector for the
         *   {@link #$rootEl base element} to use as the root of the app.
         * @param {string} [opts.contentEl='#content'] The selector for the
         *   {@link #$contentEl content element}.
         * @param {boolean} [opts.silent=false] Flag to indicate if modules
         *   should be initialized during application init process.
         * @param {Function} [opts.defaultErrorHandler] Allows you to define a
         *   custom error handler. Defaults to
         *   {@link Core.Error#handleHttpError}.
         *
         * @return {App} Application instance
         * @method
         */
        init: function(opts) {
            _app = _app || _.extend(this, new App(opts));
            _.extend(_app, _app.beforeEvent);

            // Register app specific events
            _app.events.register(
                /**
                 * Fires when the app object is initialized. Modules bound to
                 * this event will initialize.
                 *
                 * @event
                 */
                'app:init',
                this
            );

            _app.events.register(
                /**
                 * Fires when the application has
                 * finished loading its dependencies and should initialize
                 * everything.
                 *
                 *     obj.on('app:start', callback);
                 *
                 * @event
                 */
                'app:start',
                this
            );

            _app.events.register(
                /**
                 * Fires when the app is beginning to sync data / metadata from
                 * the server.
                 *
                 * @event
                 */
                'app:sync',
                this
            );

            _app.events.register(
                /**
                 * Fires when the app has finished its syncing process and is
                 * ready to proceed.
                 *
                 * @event
                 */
                'app:sync:complete',
                this
            );

            _app.events.register(
                /**
                 * Fires when a sync process failed.
                 *
                 * @event
                 */
                'app:sync:error',
                this
            );

            _app.events.register(
                /**
                 * Fires when a sync process failed during initialization of
                 * the app.
                 *
                 * @event
                 */
                'app:sync:public:error',
                this
            );

            _app.events.register(
                /**
                 * @event
                 * Fires when logging in.
                 */
                'app:login',
                this
            );

            _app.events.register(
                /**
                 * @event
                 * Fires when login succeeds.
                 */
                'app:login:success',
                this
            );

            _app.events.register(
                /**
                 * @event
                 * Fires when the app logs out.
                 */
                'app:logout',
                this
            );

            _app.events.register(
                /**
                 * Fires when route changes a new view has been loaded.
                 *
                 *     obj.on('app:view:change', callback);
                 *
                 * @event
                 */
                'app:view:change',
                this
            );

            _app.events.register(
                /**
                 * Fires when client application's user changes the locale, thus
                 * indicating that the application should "re-render" itself.
                 *
                 *     obj.on('app:local:change', callback);
                 *
                 * @event
                 */
                'app:locale:change',
                this
            );

            _app.events.register(
                /**
                 * Fires when the language display direction changes.
                 *
                 * Possible language display directions are `RTL` and `LTR`.
                 *
                 *
                 *     obj.on('lang:direction:change', callback);
                 *
                 * @event
                 */
                'lang:direction:change',
                this
            );

            // App cache must be inited first
            if (_app.cache) {
                _app.cache.init(this);
            }

            // Instantiate controller: <Capitalized-appId>Controller or Controller.
            var className = _app.utils.capitalize(_app.config ? _app.config.appId : '') + 'Controller';
            var Klass = this[className] || this.Controller;

            /**
             * Reference to the main controller.
             *
             * @property {Core.Controller}
             */
            this.controller = new Klass();

            /**
             * Reference to the API interface that the application uses to
             * request the server.
             *
             * @property {SUGAR.Api}
             */
            _app.api = SUGAR.Api.getInstance({
                defaultErrorHandler: (opts && opts.defaultErrorHandler) ? opts.defaultErrorHandler : SUGAR.App.error.handleHttpError,
                serverUrl: _app.config.serverUrl,
                platform: _app.config.platform,
                timeout: _app.config.serverTimeout,
                keyValueStore: _app[_app.config.authStore || 'cache'],
                clientID: _app.config.clientID,
                disableBulkApi: _app.config.disableBulkApi,
                externalLoginUICallback: opts && opts.externalLoginUICallback
            });

            this._init(opts);

            return _app;
        },

        /**
         * Initializes application.
         *
         * Performs loading css (only if `config.loadCss` is `true`), metadata
         * sync and calls sync callback.
         *
         * @param {Object} opts Options.
         * @param {boolean} [opts.silent=false] Flag to indicate if modules
         *   should be initialized during application init process.
         * @private
         * @chainable
         */
        _init: function(opts) {
            var self = this;
            var syncCallback = function(error) {

                // _app will be nulled out if destroy was called on app before we
                // asynchronously get here. This happens when running tests (see spec-helper).
                if (!_app) {
                    return;
                }
                if (error) {
                    self.trigger('app:sync:public:error', error);
                    return;
                }
                self._initModules();
                self._loadConfig();
                if (!opts.silent) {
                    _app.trigger('app:init', self);
                }
                if (opts.callback && _.isFunction(opts.callback)) {
                    opts.callback(_app);
                }
            };
            var cssCallback = function(callback) {
                if (_app.config.loadCss) {
                    _app.loadCss(callback);
                } else {
                    callback();
                }
            };
            if (_app.config.syncConfig !== false) {
                var options = {
                    getPublic: true
                };
                cssCallback(function() {
                    _app.metadata.sync(syncCallback, options);
                });
            } else {
                cssCallback(function() {
                    syncCallback();
                });
            }
            return _app;
        },

        /**
         * Initializes all modules that have an `init` function.
         *
         * @private
         */
        _initModules: function() {
            _.each(_modules, function(module) {
                if (_.isFunction(module.init)) {
                    module.init(this);
                }
            }, this);
        },

        /**
         * Extends base settings with settings from the server.
         *
         * @private
         */
        _loadConfig: function() {
            // extend our config with settings from local storage if we have it
            _app.config = _app.config || {};
            _app.config = _.extend(_app.config, _app.metadata.getConfig());
        },

        /**
         * Loads application CSS.
         *
         * Will make an HTTP request and retrieve either a list of CSS files to
         * load, or directly plain text css.
         *
         * @param {Function} [callback] Function called once CSS is loaded.
         */
        loadCss: function(callback) {

            _app.api.css(_app.config.platform, _app.config.themeName, {
                success: function(rsp) {

                    if (_app.config.loadCss === 'url') {
                        _.each(rsp.url, function(url) {
                            $('<link>')
                                .attr({
                                    rel: 'stylesheet',
                                    href: _app.utils.buildUrl(url)
                                })
                                .appendTo('head');
                        });
                    }
                    else {
                        _.each(rsp.text, function(text) {
                            $('<style>').html(text).appendTo('head');
                        });
                    }

                    if (_.isFunction(callback)) {
                        callback();
                    }
                }
            });
        },

        /**
         * Starts the main execution phase of the application.
         *
         * Triggers {@link #event-app:start}.
         *
         * @method
         */
        start: function() {
            _app.events.registerAjaxEvents();
            _app.trigger('app:start', this);
            _app.routing.start();
        },

        /**
         * Destroys the instance of the current app.
         */
        destroy: function() {
            // TODO: Not properly implemented
            if (Backbone.history) {
                Backbone.history.stop();
            }

            _app = null;
        },

        /**
         * Augments the application with a module.
         *
         * Module should be an object with an optional `init(app)` function.
         * The init function is passed the current instance of
         * the application when app's {@link App#init} method gets called.
         * Use the `init` function to perform custom initialization logic during
         * app initialization.
         *
         * @param {string} name Name of the module.
         * @param {Object} obj Module to augment the app with.
         * @param {boolean} [init=false] Flag indicating if the module should be
         *   initialized immediately.
         */
        augment: function(name, obj, init) {
            this[name] = obj;
            _modules[name] = obj;

            if (init && obj.init && _.isFunction(obj.init)) {
                obj.init.call(obj, _app);
            }
        },

        /**
         * Syncs an app.
         *
         * - {@link #event-app:sync} event is fired when the sync process
         * begins.
         * - {@link #event-app:sync:complete} event is fired when the series of
         * sync operations have finished.
         * - {@link #event-app:sync:error} is fired if it failed.
         *
         * The events are not fired if the sync happens for public metadata.
         *
         * @param {Object} [options] Options. See full list of options
         *   you can pass to {@link Core.MetadataManager#sync}.
         * @param {Function} [options.callback] Function to be invoked when the
         *   sync operation completes.
         * @param {boolean} [options.getPublic=false] Flag indicating if only
         *   public metadata should be synced.
         * @method
         */
        sync: function(options) {
            var self = this;
            options = options || {};

            // For public call, we need to do just metadata sync without triggering events
            if (options.getPublic) {
                return self.syncPublic(options);
            }

            // Register the callback if any.
            if (options.callback) {
                _syncCallbacks.push(options.callback);
            }

            // If already in `sync`, we can skip as the callback is registered
            // and will be called.
            if (_isSyncing) {
                return;
            }
            _isSyncing = true;

            // 1. Update server info and run compatibility check
            // 2. Update preferred language if it was changed
            // 3. Load user preferences
            // 4. Fetch metadata
            // 5. Declare models
            async.waterfall([function(callback) {
                self.isSynced = false;
                self.trigger('app:sync');
                var doUpdateLanguage = !options.noUserUpdate && (options.language || _app.cache.get('langHasChanged'));
                if (doUpdateLanguage) {
                    var language = options.language || _app.lang.getLanguage();
                    self.user.updateLanguage(language, callback);
                    _app.cache.cut('langHasChanged');
                }
                else {
                    callback();
                }
            }, function(cbw) {
                async.parallel([
                    function(callback) {
                        self.user.load(callback);
                    }, function(callback) {
                        self.metadata.sync(function(err) {
                            self.data.declareModels();
                            callback(err);
                        }, options);
                    }], function(err) {
                    cbw(err);
                });
            }],
                function(err) {
                    if (err) {
                        self.trigger('app:sync:error', err);
                    } else {
                        self.isSynced = true;
                        self.trigger('app:sync:complete');
                    }

                    _.each(_syncCallbacks, function(callback) {
                        callback(err);
                    });
                    // Reset the properties.
                    _isSyncing = false;
                    _syncCallbacks = [];
                }
            );
        },

        /**
         * Syncs public metadata.
         *
         * @param {Object} [options] Options. See full list of options
         *   you can pass to {@link Core.MetadataManager#sync}.
         * @param {Function} [options.callback] Function to be invoked when the
         *   sync operation completes.
         */
        syncPublic: function(options) {
            options = options || {};
            options.getPublic = true;
            this.metadata.sync(options.callback, options);
        },

        /**
         * Navigates to a new route.
         *
         * @param {Core.Context} [context] Context object to extract the module
         *   from.
         * @param {Data.Bean} [model] Model object to route with.
         * @param {string} [action] Action name.
         */
        navigate: function(context, model, action) {
            var route, id, module;
            context = context || _app.controller.context;
            model = model || context.get('model');
            id = model.id;
            module = context.get('module') || model.module;

            route = this.router.buildRoute(module, id, action);
            this.router.navigate(route, {trigger: true});
        },

        /**
         * Logs in this app.
         *
         * Triggers {@link #event-app:login:success}.
         *
         * @param {Object} credentials User credentials.
         * @param {Object} credentials.username User name.
         * @param {Object} credentials.password User password.
         * @param {Object} [info] Extra data to be passed in login request such
         *   as client user agent, etc.
         * @param {Object} [callbacks] Object containing the callbacks.
         * @param {Function} [callbacks.success] The success callback.
         * @param {Function} [callbacks.error] The error callback.
         * @param {Function} [callbacks.complete] The complete callback.
         */
        login: function(credentials, info, callbacks) {
            callbacks = callbacks || {};

            info = info || {};
            info.current_language = _app.lang.getLanguage();
            _app.api.login(credentials, info, {
                success: function(data) {
                    _app.trigger('app:login:success', data);
                    if (callbacks.success) callbacks.success(data);
                },
                error: function(error) {
                    _app.error.handleHttpError(error);
                    if (callbacks.error) callbacks.error(error);
                },
                complete: callbacks.complete
            });
        },

        /**
         * Logs out this app.
         *
         * Triggers {@link #event-app:logout}.
         *
         * @param {Object} [callbacks] Object containing the callbacks.
         * @param {Function} [callbacks.success] The success callback.
         * @param {Function} [callbacks.error] The error callback.
         * @param {Function} [callbacks.complete] The complete callback.
         * @param {Boolean} [clear=false] Flag indicating if user information
         *   must be deleted from cache.
         * @return {SUGAR.HttpRequest} XHR request object.
         */
        logout: function(callbacks, clear) {
            var originalComplete, originalError;
            callbacks = callbacks || {};
            originalComplete = callbacks.complete;
            originalError = callbacks.error;

            callbacks.complete = function(data) {
                // The 'clear' comes from the logout URL (see router.js)
                _app.trigger('app:logout', clear);
                if (originalComplete) {
                    originalComplete(data);
                }
            };
            callbacks.error = function(error) {
                _app.error.handleHttpError(error);
                if (originalError) originalError(error);
            };

            return _app.api.logout(callbacks);
        },

        /**
         * Checks if the server version and flavor are compatible.
         * @param {Object} data Server information.
         * @return {Boolean|Object} `true` if server is compatible and an error object if not.
         */
        isServerCompatible: function(data) {
            var flavors = this.config.supportedServerFlavors,
                minVersion = this.config.minServerVersion,
                isSupportedFlavor,
                isSupportedVersion,
                error;

            // We assume the app is not interested in the compatibility check if it doesn't have compatibility config.
            if (_.isEmpty(flavors) && !minVersion) {
                return true;
            }

            // Undefined or null data with defined compatibility config means the server is incompatible

            isSupportedFlavor = !!((_.isEmpty(flavors)) || (data && _.contains(flavors, data.flavor)));
            isSupportedVersion = !!(!minVersion || (data && this.utils.versionCompare(data.version, minVersion, '>=')));

            if (isSupportedFlavor && isSupportedVersion) {
                return true;
            } else if (!isSupportedVersion) {
                error = {
                    code: 'server_version_incompatible',
                    label: 'ERR_SERVER_VERSION_INCOMPATIBLE'
                };
            } else {
                error = {
                    code: 'server_flavor_incompatible',
                    label: 'ERR_SERVER_FLAVOR_INCOMPATIBLE'
                };
            }

            error.server_info = data;
            return error;
        },

        modules: _modules
    };

}());
