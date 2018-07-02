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
    /**
     * Events proxy object. For inter-component communications, please register your events and please subscribe
     * your events from the events hub. This allows components to not depend on each other in a tightly coupled capacity.
     *
     * <pre><code>
     * (function(app) {
     *   var foo = {
     *     initialize: function() {
     *         // Register the event with the events hub.
     *         app.events.register("mynamespaced:event", this);
     *     },
     *     action: function() {
     *         // Broadcast you revent to the events hub.
     *         // The events hub will then broadcast this event to all its subscribers.
     *         this.trigger("mynamespaced:event");
     *     }
     *   }
     *
     *   var bar = {
     *     initialize: function() {
     *         // Call a callback when the event is received.
     *         app.events.on("mynamespaced:event", function() {
     *             alert("Event!");
     *         });
     *     }
     *   }
     *
     * })(SUGAR.App);
     * </pre></code>
     *
     * @class Core.Events
     * @alias SUGAR.App.events
     * @singleton
     */
    app.augment('events', _.extend({}, Backbone.Events, {
        /**
         * List of deprecated events. A warning will be shown in console when a
         * component is listening to them.
         *
         * @property {Object} _deprecated
         * @property {string} [_deprecated.message] The custom deprecated message.
         * @private
         */
        _deprecated: {},

        /**
         * Registers an event with the event proxy.
         *
         * @param {string} event The name of the event.
         *   A good practice is to namespace your events with a colon.
         *   For example: `app:start`.
         * @param {Object} context The object that will trigger the event.
         * @param {Object} [options] Optional params.
         * @param {boolean} [options.deprecated=false] `true` if the event is
         *   deprecated.
         * @param {string} [options.message] The deprecated message to log. A
         *   default message will be triggered if not defined.
         */
        register: function (event, context, options) {
            if (options && options.deprecated) {
                this._deprecated[event] = _.pick(options, 'message');
            }

            context.on(event, function() {
                var args = [].slice.call(arguments, 0);
                args.unshift(event);
                this.trigger.apply(this, args);
            }, this);
        },

        /**
         * Unregisters an event from the event proxy.
         *
         * @param {Object} context Source to be cleared from.
         * @param {string} [event] Event name to be cleared.
         * @method
         */
        unregister: function(context, event) {
            context.off(event);
        },

        /**
         * Subscribe to global ajax events.
         */
        registerAjaxEvents: function() {
            var self = this;

            // First unbind then rebind
            $(document).off("ajaxStop");
            $(document).off("ajaxStart");

            $(document).on("ajaxStart", function(args) {
                self.trigger("ajaxStart", args);
            });

            $(document).on("ajaxStop", function(args) {
                self.trigger("ajaxStop", args);
            });
        },

        /**
         * Wraps [Backbone.Events#on](http://backbonejs.org/#Events-on) method
         * to throw a warning if the event listened to is deprecated.
         */
        on: _.wrap(Backbone.Events.on, function (fn, name, callback, context) {

            if (_.has(this._deprecated, name)) {
                var warnMessage;
                if (this._deprecated[name].message) {
                    warnMessage = this._deprecated[name].message;
                } else {
                    warnMessage = 'The global event `' + name + '` is deprecated.';
                }

                if (context) {
                    warnMessage += '\n' + context + ' should not listen to it anymore.';
                }

                app.logger.warn(warnMessage);
            }

            return fn.call(this, name, callback, context);
        }),
    }));

})(SUGAR.App);
