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
     * Regular expression used to split event strings.
     *
     * @private
     * @type {RegExp}
     */
    var eventSplitter = /\s+/;

    /**
     * Events API used to process various event actions and handle inputs such
     * as event maps and space-separated event names.
     *
     * This is taken from the Backbone.js library to simplify event-handling.
     *
     * @private
     * @type {Function}
     * @param {Object} obj Scope in which the `action` will be executed.
     * @param {string} action The function being executed (e.g. 'triggerBefore')
     * @param {string|Object} name Event(s) to trigger before. Accepts
     *   multiple space-separated event names, or an event map.
     * @param {Array} [rest] List of arguments to be passed to the before event.
     * @return {boolean} `false` if an event map or space-separated event names
     *   were used, `true` otherwise.
     */
    var eventsApi = function(obj, action, name, rest) {
        if (!name) return true;

        // Handle event maps.
        if (typeof name === 'object') {
            for (var key in name) {
                obj[action].apply(obj, [key, name[key]].concat(rest));
            }
            return false;
        }

        // Handle space separated event names.
        if (eventSplitter.test(name)) {
            var names = name.split(eventSplitter);
            for (var i = 0, l = names.length; i < l; i++) {
                obj[action].apply(obj, [names[i]].concat(rest));
            }
            return false;
        }

        return true;
    };

    /**
     * An optimized event-triggering method used to speed up common event calls
     * with 1, 2, or 3 arguments. Prevents the event from triggering if any
     * provided before callback returns `false`.
     *
     * This is taken from the Backbone.js library to simplify event-dispatching.
     *
     * @private
     * @type {Function}
     * @param {Array} events The list of before event listeners.
     * @param {Array} [args] Arguments passed to the before event callback.
     * @return {boolean} `true` if the before event should be triggered, `false`
     *   otherwise.
     */
    var triggerEvents = function(events, args) {
        var stop = false;
        var ev, tmp, i = -1,
            l = events.length;
        switch (args.length) {
            case 0:
            case 1:
            case 2:
            case 3:
                while (++i < l) stop = (ev = events[i]).callback.call(ev.ctx, args[0], args[1], args[2]) === false || stop;
                break;
            default:
                while (++i < l) stop = (ev = events[i]).callback.apply(ev.ctx, args) === false || stop;
        }
        return !stop;
    };

    /**
     * @class Core.BeforeEvent
     * @alias SUGAR.App.beforeEvent
     * @singleton
     */
    _.extend(app, {
        'beforeEvent': {
            /**
             * Adds a callback/hook to be fired before an action is taken. If
             * that callback returns false, the action will not be taken. The
             * only action supported in the base component is `render`.
             *
             * The following example binds a callback function and passes
             * the scope from the view component to use in that callback:
             *
             *     model.before('save', this.doSomethingBeforeSave, this);
             *
             * Multiple space-separated event names can be bound to a single
             * callback:
             *
             *     view.before('save dispose', this.callback, this);
             *
             * This method also supports an event map syntax, as an alternative
             * to positional arguments:
             *
             *     this.before({
             *         'render': this.doSomethingBeforeRender,
             *         'dispose': this.doSomethingBeforeDispose
             *     });
             *
             * @chainable
             * @param {string|Object} name Event(s) to trigger before. Accepts
             *   multiple space-separated event names, or an event map.
             * @param {Function} callback Function to be called.
             * @param {Object} [context] Value to be assigned to `this` when the
             *   callback is fired.
             * @return {Core.BeforeEvent} Instance of this class.
             */
            before: function(name, callback, context) {
                if (!eventsApi(this, 'before', name, [callback, context]) || !callback) {
                    return this;
                }

                this._before || (this._before = {});
                var events = this._before[name] || (this._before[name] = []);

                events.push({
                    callback: callback,
                    context: context,
                    ctx: context || this
                });
                return this;
            },

            /**
             * Triggers the before callback for the given event `name` or list
             * of events.
             *
             * The following example triggers the callback bound to the before
             * 'save' event given:
             *
             *     this.triggerBefore('save');
             *
             * Multiple events can be triggered as well:
             *
             *     this.triggerBefore('save render dispose');
             *
             * Custom arguments (e.g. `a`, `b`, `c`) can be passed to the
             * callback:
             *
             *     this.triggerBefore('save', a, b, c);
             *
             * @param {string} name The event(s) to trigger before on.
             * @return {boolean} Returns `true` if the event should be
             *   triggered, `false` otherwise.
             */
            triggerBefore: function(name) {
                var stop = false;
                if (!this._before) {
                    return !stop;
                }
                var args = Array.prototype.slice.call(arguments, 1);

                // Handle space separated event names.
                if (eventSplitter.test(name)) {
                    var names = name.split(eventSplitter);
                    for (var i = 0, l = names.length; i < l; i++) {
                        stop = !this['triggerBefore'].apply(this, [names[i]].concat(args)) || stop;
                    }
                    return !stop;
                }

                var events = this._before[name];
                var allEvents = this._before.all;
                if (events) {
                    stop = (triggerEvents(events, args) === false);
                }
                if (allEvents) {
                    stop = (triggerEvents(allEvents, args) === false) || stop;
                }
                return !stop;
            },

            /**
             * Remove a previously-bound callback function from a before event.
             *
             * If no context is given, all of the versions of the callback with
             * different contexts will be removed:
             *
             *     this.offBefore('render', this.onRenderBefore);
             *
             * If no callback is given, all callbacks for the before event will
             * be removed:
             *
             *     this.offBefore('render');
             *
             * If no event is specified, all callbacks for all before events
             * will be removed from the object (similar to the Backbone.js `off`
             * event):
             *
             *     this.offBefore();
             *
             * This is taken from the Backbone.js library to simplify
             * event-handling.
             *
             * @chainable
             * @param {string} [name] Event(s) to remove the listeners for.
             * @param {Function} [callback] Callback to remove specifically for
             *   a given event.
             * @param {Object} [context] Context to use when determining which
             *   callback to remove.
             * @return {Core.BeforeEvent} Instance of this class.
             */
            offBefore: function(name, callback, context) {
                var retain, ev, events, names, i, l, j, k;
                if (!this._before || !eventsApi(this, 'offBefore', name, [callback, context])) {
                    return this;
                }
                if (!name && !callback && !context) {
                    this._before = void 0;
                    return this;
                }
                names = name ? [name] : _.keys(this._before);
                for (i = 0, l = names.length; i < l; i++) {
                    name = names[i];
                    if (events = this._before[name]) {
                        this._before[name] = retain = [];
                        if (callback || context) {
                            for (j = 0, k = events.length; j < k; j++) {
                                ev = events[j];
                                if ((callback && callback !== ev.callback) || (context && context !== ev.ctx)) {
                                    retain.push(ev);
                                }
                            }
                        }
                        if (!retain.length) {
                            delete this._before[name];
                        }
                    }
                }
                return this;
            }
        }
    });

})(SUGAR.App);
