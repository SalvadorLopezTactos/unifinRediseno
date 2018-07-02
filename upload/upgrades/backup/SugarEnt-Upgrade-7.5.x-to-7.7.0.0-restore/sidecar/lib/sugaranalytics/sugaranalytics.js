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
/*;
 * SugarCRM Analytics API
 */

//create the SUGAR namespace if one does not exist already
var SUGAR = SUGAR || {};

/**
 * SugarCRM Analytics API allows user actions to be tracked via an analytics engine.
 *
 * The application event "app:analytics:init" will fire on app.start(). It is recommended that applications use a
 * universal handler to handle pave view changes. Please see the Page Tracking section below for an example of this.
 *
 * Connectors:
 *
 * Analytics connectors are loaded from SUGAR.App.analytics.connectors.
 *
 * Connectors implement the following functions:
 *
 * initialize()
 *
 * - called on app:init, load the analytics api.
 *
 * @public
 * @member SUGAR.analytics.connectors
 *
 * start(id, options)
 *
 * - called on app:start, prepare or open the connection to the analytics system.
 *
 * @param  {String}id, tracking id of for analytics system
 * @param  {Object}options, SUGAR.App.config.analytics configuration.
 * @public
 * @member SUGAR.analytics.connectors
 *
 * trackPageView(pageURI)
 *
 * - track a change of page.
 *
 * @param  {String} pageURI.
 * @public
 * @member SUGAR.analytics.connectors
 *
 * trackEvent()
 *
 * - track an event on the page.
 *
 * @param  {Object} event, with the following attributes: category, action, label, value. Label is always set as the current route the user is on.
 * @public
 * @member SUGAR.analytics.connectors
 *
 * Below is a sample connector.
 * <pre>
 * (function(app) {
 * SUGAR.App.analytics = SUGAR.App.analytics || {};
 * SUGAR.App.analytics.connectors = SUGAR.App.analytics.connectors || {};
 * SUGAR.App.analytics.connectors["FakeConnector"]  = {
 *     initialized: false,
 *     connectorId: null,
 *       pageLog: [],
 *       eventLog: [],
 *       initialize: function() {
 *           this.initialized = true;
 *       },
 *       start: function(id, options) {
 *           this.connectorId = id;
 *       },
 *       trackPageView: function(pageUri) {
 *           this.pageLog.push(pageUri);
 *       },
 *       trackEvent: function(event) {
 *           this.eventLog.push(event);
 *       }
 *   };
 * })(SUGAR.App);
 * </pre>
 *
 *
 * Configuration:
 *
 * Set the following in SUGAR.App.config.analytics. The entire config is passed to the connector start method as options.
 *
 * <pre>
 * {
 *     enabled: true,
 *     connector: "GoogleAnalytics",
 *     id: 'UA-XXXXXXXX-X'
 * }
 * </pre>
 *
 *
 * Page Tracking:
 *
 * Use SUGAR.App.analytics.trackPageView(uri); to track page views. An example of a universal way of handling page
 * tracking would be the following.
 *
 * <pre>
 * app.on("app:analytics:init", function() {
 *     app.routing.before('route', function(options){
 *          options = options || {};
 *          var args = options.args || [];
 *          var subroute;
 *          if (args[0]) {
 *              var qpos = args[0].indexOf('?');
 *              subroute = qpos > -1 ? args[0].substring(0, args[0].indexOf('?')) : args[0];
 *          }
 *          var viewId = options.route + (subroute ? '/' + subroute : '');
 *
 *          app.analytics.currentViewId = viewId;
 *          app.analytics.trackPageView(app.analytics.currentViewId);
 *      }, {}, this);
 * });
 * app.start();
 * </pre>
 *
 *
 * Event Tracking:
 *
 * Use SUGAR.App.analytics.trackEvent(category, action, event, value); to track events.
 *
 * The label will always be the app.analytics.currentViewId for any event.
 *
 * In JavaScript, this method can be called directly to track any event.
 *
 * In Templates, the analytics engine plugs into all views to look for elements with a track attribute on them.
 * The value of the attribute will contain the event data <category>:<action>.<css class to check>.
 * The event value is sent as 1 or 0 depending on if that css class is present on the element.
 *
 * <pre>
 *    <a href="#" class="trackedClass" track="click:home.trackedClass">Home</a>
 * </pre>
 *
 * @class SUGAR.analytics
 */
(function(app) {

    var _analytics = {

        eventSplitter: /\s{2,}/,
        currentViewId: "",

        init: function() {
            if (app.config.analytics &&
                app.config.analytics.enabled &&
                app.config.analytics.connector &&
                app.analytics.connectors[app.config.analytics.connector])
            {
                app.on("app:init", function() {
                    app.events.register("app:analytics:init", this);
                    app.analytics.connector = app.analytics.connectors[app.config.analytics.connector];
                    app.analytics.connector.initialize();

                    // Override layout dispose
                    var origLayoutDispose = app.view.Layout.prototype._dispose;
                    app.view.Layout.prototype._dispose = function() {
                        app.analytics.detachAnalytics(this.$el);
                        origLayoutDispose.call(this);
                    };

                    // Override view render
                    var origViewRender = app.view.View.prototype._render;
                    app.view.View.prototype._render = function() {
                        app.analytics.detachAnalytics(this.$el);
                        origViewRender.call(this);
                        app.analytics.attachAnalytics(this.$el);
                    };

                }).on("app:start", function() {
                    // Apps should do their initialization of page tracking based on the following event.
                    app.trigger("app:analytics:init");

                    // Keep backwards compatible with nomad
                    var id = app.config.analytics.id;
                    id = _.isObject(id) ? (app.isNative ? id["native"] : id["web"]) : id;

                    app.analytics.connector.start(id, app.config.analytics);
                    app.logger.debug("Analytics enabled - " + id);
                });
            }
            else {
                app.logger.debug("Analytics disabled");
                this.trackPageView = function() {};
                this.trackEvent = function() {};
            }
        },

        /**
         * Track a page view
         *
         * @param  {String} page URI.
         * @public
         * @member SUGAR.analytics
         */
        trackPageView: function(page) {
            app.logger.debug("GAN-page: " + page);
            app.analytics.connector.trackPageView(page);
        },

        /**
         * Track a event
         *
         * Label will always be the current view Id.
         *
         * @param  {String} category.
         * @param  {String} action.
         * @param  {String} event.
         * @param  {String} value.
         * @public
         * @member SUGAR.analytics
         */
        trackEvent: function(category, action, event, value) {
            action = (_.isEmpty(action) && event ? event.currentTarget.id : action) || "[unknown]";
            app.logger.debug("GAN-event: " + category + ":" + action  + "(" + value + ")" + " on " + this.currentViewId);
            app.analytics.connector.trackEvent({
                category: category,
                action: action,
                label: this.currentViewId,
                value: value
            });
        },

        /**
         * Detach analytics in an element based on having the track attribute
         *
         * @param  {JQuery Object} element.
         * @public
         * @member SUGAR.analytics
         */
        detachAnalytics: function($el) {
            var $els = this.getTrackableElements($el);
            $els.unbind('.analytics');
        },

        /**
         * Attach analytics in an element based on having the 'track' attribute
         *
         * @param  {JQuery Object} element.
         * @public
         * @member SUGAR.analytics
         */
        attachAnalytics: function($el) {
            var self = this;
            var $els = this.getTrackableElements($el);
            $els.unbind('.analytics');
            $els.each(function(i, el) {
                self._attachAnalytics(el);
            });
        },

        /**
         * Find all trackable elements in an element based on them having the 'track' attribute
         *
         * @param  {JQuery Object} element.
         * @public
         * @member SUGAR.analytics
         */
        getTrackableElements: function($el) {
            var items = this._getTrackableElements($el);
            if ($el.attr('track')) {
                items = items.add($el);
            }
            return items;
        },

        /**
         * @private
         * @member SUGAR.analytics
         */
        _getTrackableElements: function(scope) {
            return $('[track]', scope);
        },

        /**
         * @private
         * @member SUGAR.analytics
         */
        _attachAnalytics: function(el) {
            var $el = $(el);
            var track = ($el.attr('track') || "").trim();
            if (track === "") return;
            var eventArgs = this.parseTrackTag(track);


            this._attachEvents(eventArgs.events, eventArgs.action, eventArgs.css, $el);
        },
        /**
         * parses track tags
         * @param {String} track
         * @returns {{}}
         */
        parseTrackTag: function(track){
            var result = {events:'', action:'', css:''};
            var pieces = track.split(":");
            var actionCss = pieces[1] ? pieces[1].split("."):pieces[0].split(".");
            result.events = pieces[0];
            result.action = actionCss[0];
            result.css = actionCss[1] || "";
            var ee = result.events.replace(this.eventSplitter,' ').split(' ');

            ee = _.map(ee, function(e) {
                return e + '.analytics';
            });

            result.events = ee.join(' ');
            return result;
        },

        /**
         * @private
         * @member SUGAR.analytics
         */
        _attachEvents: function(events, action, css, $el) {
            if (events) {
                $el.off(events);
                $el.on(events, function (e) {
                    app.analytics.trackEvent(e.type, action, e, (css && $(this).hasClass(css) ? 1 : 0));
                });
            }
        }
    };

    app.augment("analytics", _analytics, false);

})(SUGAR.App);
