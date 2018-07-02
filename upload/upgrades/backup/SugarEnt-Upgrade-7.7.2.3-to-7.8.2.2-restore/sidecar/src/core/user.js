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

    /**
     * Represents application's current user object.
     *
     * The user object contains settings that are fetched from the server
     * and whatever settings application wants to store.
     *
     * <pre><code>
     * // Sample user object that is fetched from the server:
     * {
     *      id: "1",
     *      full_name: "Administrator",
     *      user_name: "admin",
     *      preferences: {
     *          timezone: "America\/Los_Angeles",
     *          datepref: "m\/d\/Y",
     *          timepref: "h:ia"
     *      }
     * }
     *
     * // Use it like this:
     * var userId = SUGAR.App.user.get('id');
     * // Set app specific settings
     * SUGAR.App.user.set("sortBy:Cases", "case_number");
     *
     * // Bind event handlers if necessary
     * SUGAR.App.user.on("change", function() {
     *     // Do your thing
     * });
     *
     * </code></pre>
     *
     * @class Core.User
     * @alias SUGAR.App.user
     * @singleton
     */
    var User = Backbone.Model.extend({

        /**
         * Retrieves and sets the user preferences
         *
         * @param {Function} callback(optional) Callback called when update completes.
         */
        load: function(callback) {
            app.api.me('read', null, null, {
                success: function(data) {
                    if (data && data.current_user) {
                        // Set the user pref hash into the cache for use in
                        // checking user pref state change
                        if (data.current_user._hash) {
                            app.cache.set('userpref:hash', data.current_user._hash);
                        }
                        app.user.set(data.current_user);
                        var language = app.user.getPreference('language');
                        if (app.lang.getLanguage() != language) {
                            app.lang.setLanguage(language, null, {noUserUpdate: true, noSync: app.isSynced});
                        }
                    }
                    if (callback) callback();
                },
                error: function(err) {
                    app.error.handleHttpError(err);
                    if (callback) callback(err);
                }
            });
        },
        // Fixme This doesn't belong in user. See TY-526.
        loadLocale: function(callback) {
            app.api.call('read', app.api.buildURL('locale'), null, {
                success: function(data) {
                    if (callback) callback(data);
                },
                error: function(err) {
                    app.error.handleHttpError(err);
                    if (callback) callback(err);
                }
            });
        },
        /**
         * Updates the preferred language of the user.
         *
         * @param {String} language language Key
         * @param {Function} callback(optional) Callback called when update completes.
         */
        getLanguage: function() {
            return app.user.getPreference('language') || app.cache.get("lang");
        },

        /**
         * Updates the preferred language of the user.
         *
         * @param {String} language language Key
         * @param {Function} callback(optional) Callback called when update completes.
         */
        updateLanguage: function(language, callback) {
            //Note that `err` is only relevant here when called for error case
            var done = function(err) {
                if (!err) app.lang.updateLanguage(language);
                if (callback) callback(err);
            };
            this.update("update", {preferred_language: language}, done);
        },

        /**
         * Updates the user's profile.
         *
         * @param {Object} attributes The model attributes to update for user.
         * @param {Function} callback(optional) Callback called when update completes.
         */
        updateProfile: function(attributes, callback) {
            //Note that `err` is only relevant here when called for error case
            var done = function(err) {
                if (callback) callback(err);
            };
            this.update("update", attributes, done);
        },
        /**
         * Updates the user's preferences.
         *
         * @param {Object} attributes The attributes to update for user.
         * @param {Function} callback(optional) Callback called when update completes.
         */
        updatePreferences: function(attributes, callback) {
            var self = this;
            if (app.api.isAuthenticated()) {
                app.api.call("update", app.api.buildURL('me/preferences'), attributes, {
                    success: function(data) {
                        if (data._hash) {
                            app.cache.set("userpref:hash", data._hash);
                            app.user.set({"_hash":data._hash});
                        }
                        //Immediately update our user's preferences to reflect latest changes
                        _.each(attributes, function(val, key) {
                            if (data[key]) {
                                self.setPreference(key, data[key]);
                            }
                        });
                        if (callback) callback();
                    },
                    error: function(err) {
                        app.error.handleHttpError(err);
                        if (callback) callback(err);
                    }
                });
            } else {
                if (callback) callback();
            }
        },

        /**
         * Updates the user
         *
         * @param {String} method operation type: read, update, create, delete {@see SUGAR.Api#me}
         * @param {Object} payload An object literal with payload
         * @param {Object} done Callback called when update completes. In case of
         * error, app.error.handleHttpError will already be handled here.
         */
        update: function(method, payload, callback) {
            if (app.api.isAuthenticated()) {
                app.api.me(method, payload, null, {
                    success: function(data) {
                        if (data.current_user) {
                            if (data.current_user._hash) {
                                app.cache.set("userpref:hash", data.current_user._hash);
                            }
                            app.user.set(data.current_user);
                        }
                        if (callback) callback();
                    },
                    error: function(err) {
                        app.error.handleHttpError(err);
                        if (callback) callback(err);
                    }
                });
            } else {
                callback();
            }
        },

        /**
         * Gets ACLs.
         *
         * @return Dictionary of ACLs. Precondition - user's logged in or a _reset call has set the user manually.
         */
        getAcls: function() {
            return app.user.get('acl') || {};
        },

        /**
         * Get preference by name.
         *
         * TODO support category parameter for preferences.
         *
         * @param {String} name The preference name.
         * @return {Array/Object/String/Number/Boolean} The value of the user preference.
         */
        getPreference: function(name) {

            var preferences = app.user.get('preferences') || {};
            return preferences[name];
        },

        /**
         * Set preference by name, will only be stored locally.
         *
         * TODO support category parameter for preferences.
         * TODO support save preferences on server.
         *
         * @param {String} name The preference name.
         * @param {Array/Object/String/Number/Boolean} value The new value of the user preference.
         * @return {Object} the instance of this user.
         */
        setPreference: function(name, value) {
            var preferences = app.user.get('preferences') || {};
            preferences[name] = value;
            return app.user.set('preferences', preferences);
        },

        /**
         * Returns an object with all the user's currency preferences
         * If the user hasn't specified any preferences, these default to system currency preferences
         *
         * @return {Object} The currency preferences of the user
         */
        getCurrency: function() {
            var preferences = app.user.get('preferences'),
                currencyObj = {};

            if (preferences) {
                currencyObj.currency_id = preferences.currency_id;
                currencyObj.currency_iso = preferences.currency_iso;
                currencyObj.currency_name = preferences.currency_name;
                currencyObj.currency_rate = preferences.currency_rate;
                currencyObj.currency_show_preferred = preferences.currency_show_preferred;
                currencyObj.currency_symbol = preferences.currency_symbol;
            }

            return currencyObj;
        },

        /**
         * Allows interactions with the last state values, which are used to implement last application
         * states or the "stickiness" of the application.
         */
        lastState: (function() {
            var keySeparator = ':',
                keyPrefix = 'last-state',
                lastStates = {},
                preservedKeys = [ ];

            var buildLastStateKeyForStorage = function(key) {
                var keyParts = key.split(keySeparator),
                    storedKey = [app.user.id, keyPrefix];

                storedKey = storedKey.concat(keyParts);

                return storedKey.join(keySeparator);
            };

            var getLastStateId = function(component) {
                var lastStateId;

                if (component.meta && component.meta.last_state) {
                    lastStateId = component.meta.last_state.id;
                }

                return lastStateId;
            };

            return {
                /**
                 * Get the last state value given a key. If doesn't exist,
                 * return the default value as specified in the component
                 * metadata.
                 *
                 * @param {string} key
                 * @return {string}
                 */
                get: function(key) {
                    var result, storedKey;

                    if (!_.isUndefined(key)) {
                        storedKey = buildLastStateKeyForStorage(key);
                        result = app.cache.get(storedKey) || this.defaults(key);
                    }

                    return result;
                },

                /**
                 * Save the last state in local storage.
                 *
                 * @param {string} key
                 * @param {string} value
                 */
                set: function(key, value) {
                    if (!_.isUndefined(key) && !_.isUndefined(value)) {
                        var storedKey = buildLastStateKeyForStorage(key);
                        app.cache.set(storedKey, value);
                    }
                },

                /**
                 * Register a state as important (should survive a cache clean)
                 *
                 * @param {string} key
                 * @param {string} value
                 */
                preserve: function(key) {
                    if (!_.isUndefined(key)) {
                        preservedKeys.push(key);
                    }
                },

                /**
                 * Get the key for a given component, which is used as a key for CRUD operations on
                 * last state values.
                 *
                 * @param {string} name
                 * @param {Object} component
                 * @return {string}
                 */
                key: function(name, component) {
                    var lastStateId = getLastStateId(component);
                    return this.buildKey(name, lastStateId, component.module);
                },

                /**
                 * Build the key for a given name, lastStateId, and (optionally) module,
                 * which is used as a key for CRUD operations on last state values.
                 *
                 * @param {string} name
                 * @param {string} lastStateId
                 * @param {string} [module]
                 * @return {string}
                 */
                buildKey: function(name, lastStateId, module) {
                    var keyString, keyParts = [];

                    if (lastStateId) {
                        if (module) {
                            keyParts.push(module);
                        }
                        keyParts.push(lastStateId, name);
                        keyString = keyParts.join(keySeparator);
                    }

                    return keyString;
                },

                /**
                 * Get the default last state for a key.
                 *
                 * @param {string} key
                 * @return {string}
                 */
                defaults: function(key) {
                    return lastStates[key];
                },

                /**
                 * Register last states default values given a component.
                 * The default value is specified in the component metadata.
                 *
                 * @param {Object} component
                 */
                register: function(component) {
                    var lastStateId = getLastStateId(component);
                    if (lastStateId){
                        _.each(component.meta.last_state.defaults, function(defaultState, key) {
                            lastStates[this.key(key, component)] = defaultState;
                        }, this);
                    }
                },

                /**
                 * Delete last state from local storage
                 *
                 * @param {String} key
                 */
                remove: function(key) {
                    var storedKey;
                    if (!_.isUndefined(key)) {
                        storedKey = buildLastStateKeyForStorage(key);
                        app.cache.cut(storedKey);
                    }
                },
                /**
                 * @return {Array} list of high value keys in cache
                 * @private
                 */
                _getPreservedKeys: function() {
                    var ret = [];
                    _.each(preservedKeys, function(key) {
                        ret.push(buildLastStateKeyForStorage(key));
                    });
                    return ret;
                }
            };
        })()
    });

    app.events.on("app:logout", function(clear) {
        if (clear === true) {
            app.user.clear({silent:true});
        }
    });

    app.events.on("cache:clean", function(cb) {
        cb(app.user.lastState._getPreservedKeys());
    });

    app.augment("user", new User(), false);

})(SUGAR.App);
