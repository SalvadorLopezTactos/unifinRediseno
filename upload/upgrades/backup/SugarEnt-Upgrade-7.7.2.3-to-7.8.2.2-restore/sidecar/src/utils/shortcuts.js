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
     * Bind keyboard keys to a particular functional call.
     * @param {Array} keys - an array of strings of shortcut key combinations and sequences
     * @param {Function} func - callback function to be called
     * @param {View.Component} component - component that the shortcut keys are registered from
     */
    var bindShortcutKeys = function(keys, func, component) {
        var wrapper = _.wrap(func, function(callback) {
            var args = Array.prototype.slice.call(arguments, 1);
            if (!component.disposed) {
                callback.apply(component, args);
            }
            return false;
        });

        Mousetrap.bind(keys, wrapper);
    };

    /**
     * Remove keyboard binding to a particular set of keys.
     * @param {Array} keys - an array of strings of shortcut key combinations and sequences
     */
    var unbindShortcutKeys = function(keys) {
        Mousetrap.unbind(keys);
    };

    /**
     * Find callOnFocus value for the given key in the shortcuts object.
     * @param {Object} shortcuts Shortcuts object.
     * @param {string} key Shortcut key combination or sequence.
     * @return {boolean}
     */
    var findCallOnFocus = function(shortcuts, key) {
        var callOnFocus = false,
            shortcutKey = _.find(shortcuts, function(shortcut, id) {
                return _.contains(shortcut.keys, key)
            });

        if (shortcutKey) {
            callOnFocus = !!shortcutKey.callOnFocus;
        }

        return callOnFocus;
    };

    /**
     * Should not execute callback function if it's focused inside an input field, unless
     * shortcuts are registered to be called on focus.
     *
     * Should not call shortcut callbacks if shortcuts are disabled.
     */
    var originalStopCallback = Mousetrap.stopCallback;
    Mousetrap.stopCallback = function(e, element, combo) {
        var isInInputField = function() {
                return element.tagName === 'INPUT' || element.tagName === 'SELECT' || element.tagName === 'TEXTAREA'
                    || element.isContentEditable;
            };

        // do not call callback if shortcuts have been disabled
        if (!app.shortcuts.isEnabled()) {
            return true;
        }

        if (isInInputField() && app.shortcuts.shouldCallOnFocus(combo)) {
            $(element).blur();
            return false;
        } else {
            return originalStopCallback(e, element);
        }
    };

    /**
     * Shortcuts should only be enabled when logged in.
     */
    app.events.on('app:login:success', function() {
        app.shortcuts.enable();
    });
    app.events.on('app:logout:success', function() {
        app.shortcuts.disable();
    });

    /**
     * Clear active shortcut keys before any view change
     */
    app.events.once('app:init', function() {
        app.before('app:view:change', function() {
            app.shortcuts.clearSession();
            return true;
        });
    });

    /**
     * Provides framework to add shortcut keys to the application. Shortcut keys are grouped into sessions,
     * which then can be activated, deactivated, saved, and restored.
     *
     * To enable shortcuts, ShortcutSession plugin must be added to the top-level layout. Any allowed shortcuts
     * for that session must be listed in shortcuts array in either the JavaScript controller or the metadata.
     *
     * To register a shortcut, add the following:
     * app.shortcuts.register('<unique shortcut ID>', '<shortcut keys>', <callback function>, <current component>);
     *
     * This framework is implemented on top of Mousetrap JS library (http://craig.is/killing/mice)
     *
     * Supported keys:
     * - all alphanumeric characters and symbols
     * - shift, ctrl, alt, option, meta, command
     * - backspace, tab, enter, return, capslock, esc, escape, space, pageup, pagedown, end, home, ins, del
     * - left, up, right, down
     *
     * Key combination: 'ctrl+s'
     * Multiple keys: ['ctrl+a','command+a']
     * Key sequence: 'f ctrl+a'
     *
     * @class Utils.Shortcuts
     * @alias SUGAR.App.shortcuts
     * @singleton
     */
    app.augment('shortcuts', {
        GLOBAL: 'Global:', //a constant to use for global shortcuts

        _currentSession: null, //current shortcut key session
        _savedSessions: [], //saved shortcut keys, which then can be restored.
        _globalShortcuts: {}, //global shortcut keys that can never be unregistered.
        _enable: false, //are shortcuts enabled?

        /**
         * Make the given shortcuts active.
         * @param {String|Array} shortcutIds
         * @param {View.Layout} layout - the layout that the shortcut session is tied to
         */
        createSession: function(shortcutIds, layout) {
            var self = this;

            this.clearSession();
            this._currentSession = new ShortcutSession(shortcutIds, layout);
            this._currentSession.activate();

            layout._dispose = _.wrap(layout._dispose, function(func) {
                var args = Array.prototype.slice.call(arguments, 1);
                func.apply(layout, args);
                self.deleteSavedSession(layout);
            });
        },

        /**
         * Remove all currents shortcuts.
         */
        clearSession: function() {
            if (this._currentSession) {
                this._currentSession.deactivate();
                this._currentSession = null;
            }
        },

        /**
         * Register shortcut keys to a session.
         *
         * Note: In the event of key conflicts, only the last registration will be kept.
         * Note: Shortcut keys are not available for dashboards and dashlets.
         *
         * @param {String} id - unique ID of the shortcut
         * @param {String|Array} keys - a string or an array of strings of shortcut key combinations and sequences
         * @param {Function} func - callback function to be called
         * @param {View.Component} component - component that the shortcut keys are registered from
         * @param {Boolean} callOnFocus (optional) - execute callback function even when focused on input field.
         */
        register: function(id, keys, func, component, callOnFocus) {
            var session;

            if (!_.isArray(keys)) {
                keys = [keys];
            }

            // Do not overwrite global shortcut keys
            if (this._isGlobalShortcutKey(keys)) {
                return;
            }

            if (id.indexOf(this.GLOBAL) === 0) {
                this._globalShortcuts[id] = {
                    keys: keys,
                    func: func,
                    component: component
                };

                if (callOnFocus) {
                    this._globalShortcuts[id].callOnFocus = callOnFocus;
                }

                bindShortcutKeys(keys, func, component);
            } else {
                session = this._getShortcutSessionForComponent(component);
                if (session) {
                    session.register(id, keys, func, component, callOnFocus);
                }
            }
        },

        /**
         * Unregister shortcut keys from a session.
         * @param {String} id - unique ID of the shortcut
         * @param {View.Component} component - component that the shortcut keys are registered from
         */
        unregister: function(id, component) {
            var session = this._getShortcutSessionForComponent(component);
            if (session) {
                session.unregister(id);
            }
        },

        /**
         * Save the currently active shortcut session.
         */
        saveSession: function() {
            this._savedSessions.push(this._currentSession); //active session could be null if there is no shortcut session
            this.clearSession();
        },

        /**
         * Restore the last shortcut session.
         */
        restoreSession: function() {
            if (this._savedSessions.length === 0) {
                return;
            }

            this.clearSession();
            this._currentSession = this._savedSessions.pop();

            if (!this._currentSession) {
                //do nothing if the active session has no shortcut session
                return;
            }

            if (this._currentSession.layout.disposed) {
                // There is a possibility of having old sessions around when layout is disposed without restoring the
                // session first.
                this.restoreSession();
            } else {
                this._currentSession.activate();
            }
        },

        /**
         * Enable shortcuts.
         */
        enable: function() {
            this._enable = true;
        },

        /**
         * Disable shortcuts.
         */
        disable: function() {
            this._enable = false;
        },

        /**
         * Is shortcuts enabled?
         * @return {boolean}
         */
        isEnabled: function() {
            return this._enable;
        },

        /**
         * Get the current shortcut session.
         * @return {ShortcutSession}
         */
        getCurrentSession: function() {
            return this._currentSession;
        },

        /**
         * Get the last saved shortcut session.
         * @return {ShortcutSession}
         */
        getLastSavedSession: function() {
            return _.last(this._savedSessions);
        },

        /**
         * Delete saved session that is tied to the particular layout.
         * @param {View.Layout} layout - the layout that the shortcut session is tied to
         */
        deleteSavedSession: function(layout) {
            var savedSessionToDelete,
                savedSession;

            for (var index = 0; index < this._savedSessions.length; index++) {
                savedSession = this._savedSessions[index];
                if (savedSession && savedSession.layout === layout) {
                    savedSessionToDelete = index;
                    break;
                }
            }

            if (!_.isUndefined(savedSessionToDelete)) {
                this._savedSessions.splice(savedSessionToDelete, 1);
            }
        },

        /**
         * Get global shortcut IDs and keys.
         * @return {Array}
         */
        getRegisteredGlobalShortcuts: function() {
            return _.map(this._globalShortcuts, function(shortcut, id) {
                return {
                    id: id,
                    keys: shortcut.keys
                };
            });
        },

        /**
         * Should this key be called when on focus?
         * @param {string} key
         * @return {boolean}
         */
        shouldCallOnFocus: function(key) {
            var shouldCall = false;

            if (this._currentSession) {
                shouldCall = this._currentSession.shouldCallOnFocus(key)
            }

            if (!shouldCall) {
                shouldCall = findCallOnFocus(this._globalShortcuts, key);
            }

            return shouldCall;
        },

        /**
         * Get the shortcut session that is tied to component.
         * @param {View.Component} component - component that the shortcut keys are registered from
         * @return {ShortcutSession}
         * @private
         */
        _getShortcutSessionForComponent: function(component) {
            var session,
                parentLayout = app.utils.getParentLayout(component);

            if (this._currentSession && this._currentSession.layout === component) {
                session = this._currentSession;
            } else {
                session = _.find(this._savedSessions, function(shortcuts) {
                    return (shortcuts && shortcuts.layout === component);
                });
            }

            if (_.isUndefined(session) && parentLayout) {
                session = this._getShortcutSessionForComponent(parentLayout);
            }

            return session;
        },

        /**
         * Are any of these keys a global shortcut key?
         * @param {Array} keys - an array of strings of shortcut key combinations and sequences
         * @return {boolean}
         * @private
         */
        _isGlobalShortcutKey: function(keys) {
            return !_.every(keys, function(key) {
                return _.every(this._globalShortcuts, function(shortcut) {
                    return _.indexOf(shortcut.keys, key) === -1;
                });
            }, this);
        }
    }, false);

    /**
     * Shortcut Session - a set of shortcuts, which can be activated and deactivated as a group.
     * @param {Array} shortcutIds - an array of strings of shortcut IDs that will be enabled
     * @param {View.Layout} layout - the layout that this shortcut session is tied to, which
     *                               is normally the top-level layout
     * @constructor
     */
    var ShortcutSession = function(shortcutIds, layout) {
        this.layout = layout; //layout that this session is tied to
        this._active = false; //is session active?
        this._shortcuts = {}; //registered shortcut keys

        _.each(shortcutIds, function(id) {
            this._allowShortcut(id);
        }, this);
    };

    _.extend(ShortcutSession.prototype, {
        /**
         * Activate the shortcut keys in this session.
         */
        activate: function() {
            this.deactivate();
            this._active = true;

            _.each(this._shortcuts, function(shortcuts) {
                if (!_.isEmpty(shortcuts)) {
                    bindShortcutKeys(shortcuts.keys, shortcuts.func, shortcuts.component);
                }
            }, this);
        },

        /**
         * Deactivate the shortcut keys in this session.
         */
        deactivate: function() {
            if (this.isActive()) {
                _.each(this._shortcuts, function(shortcuts) {
                    _.each(shortcuts.keys, function(key) {
                        unbindShortcutKeys(key);
                    });
                }, this);
                this._active = false;
            }
        },

        /**
         * Is this session active?
         * @return {boolean}
         */
        isActive: function() {
            return this._active;
        },

        /**
         * Register shortcut keys in this session.
         * @param {String} id - unique ID of the shortcut
         * @param {String|Array} keys - a string or an array of strings of shortcut key combinations and sequences
         * @param {Function} func - callback function to be called
         * @param {View.Component} component - component that the shortcut keys are registered from
         * @param {Boolean} callOnFocus (optional) - execute callback function even when focused on input field.
         */
        register: function(id, keys, func, component, callOnFocus) {
            if (!this._isShortcutAllowed(id) || this._isInDashboard(component)) {
                return;
            }

            if (!_.isArray(keys)) {
                keys = [keys];
            }

            this.unregister(id);
            this._bindShortcutKeys(id, keys, func, component, callOnFocus);
        },

        /**
         * Unregister shortcut keys from this session.
         * @param {String} id - unique ID of the shortcut
         */
        unregister: function(id) {
            if (!this._isShortcutAllowed(id)) {
                return;
            }

            if (this.isActive()) {
                _.each(this._shortcuts[id].keys, function(key) {
                    unbindShortcutKeys(key);
                });
            }

            this._shortcuts[id] = {};
        },

        /**
         * Get shortcut IDs and keys in this session.
         * @return {Array}
         */
        getRegisteredShortcuts: function() {
            var registeredShortcuts = [];

            _.each(this._shortcuts, function(shortcut, id) {
                if (!_.isEmpty(shortcut)) {
                    registeredShortcuts.push({
                        id: id,
                        keys: shortcut.keys
                    });
                }
            });

            return registeredShortcuts;
        },

        /**
         * Should this key be called when on focus?
         * @param {string} key
         * @return {boolean}
         */
        shouldCallOnFocus: function(key) {
            var shouldCall = false;

            if (this.isActive()) {
                shouldCall = findCallOnFocus(this._shortcuts, key);
            }

            return shouldCall;
        },

        /**
         * Add the shortcut keys to the session and bind them if the session is active.
         * @param {String} id - unique ID of the shortcut
         * @param {Array} keys - an array of strings of shortcut key combinations and sequences
         * @param {Function} func - callback function to be called
         * @param {View.Component} component - component that the shortcut keys are registered from
         * @param {Boolean} callOnFocus (optional) - execute callback function even when focused on input field.
         * @private
         */
        _bindShortcutKeys: function(id, keys, func, component, callOnFocus) {
            if (!this._isShortcutAllowed(id)) {
               return;
            }

            this._shortcuts[id].keys = keys;
            this._shortcuts[id].func = func;
            this._shortcuts[id].component = component;
            if (callOnFocus) {
                this._shortcuts[id].callOnFocus = callOnFocus;
            }

            if (this.isActive()) {
                bindShortcutKeys(keys, func, component);
            }
        },

        /**
         * Allow shortcut in this session.
         * @param {string} id Unique ID of the shortcut.
         * @private
         */
        _allowShortcut: function(id) {
            this._shortcuts[id] = {};
        },

        /**
         * Is shortcut allowed to be in this session?
         * @param {string} id Unique ID of the shortcut.
         * @return {boolean}
         * @private
         */
        _isShortcutAllowed: function(id) {
            return !_.isUndefined(this._shortcuts[id]);
        },

        /**
         * Is the component in a dashlet or a dashboard?
         * @param {View.Component} component
         * @return {boolean}
         * @private
         */
        _isInDashboard: function(component) {
            var layout = component.layout || (!_.isUndefined(component.view) && component.view.layout);
            return (layout.type === 'dashlet') || (layout.type === 'dashboard');
        }
    });
})(SUGAR.App);
