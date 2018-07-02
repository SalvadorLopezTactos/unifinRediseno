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
    var optOut;

    app.analytics = app.analytics || {};
    app.analytics.connectors = app.analytics.connectors || {};

    // Use with newer Universal GA clients
    app.analytics.connectors["GoogleAnalytics"]  = {
        /* initialize()
         *
         * - called on app:init, load the analytics api.
         *
         * @public
         * @member SUGAR.analytics.connectors.GoogleAnalytics
         */
        initialize: function() {
            // this code is taken directly from Google's analytics.js API - https://developers.google.com/analytics/devguides/collection/analyticsjs/advanced
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        },
        /* start(id, options)
         *
         * - called on app:start, prepare or open the connection to the analytics system.
         *
         * @param  {String}id, tracking id of for analytics system
         * @param  {Object}options, SUGAR.App.config.analytics configuration.
         * @public
         * @member SUGAR.analytics.connectors.GoogleAnalytics
         */
        start: function(id, options) {
            // 'none' to ignore cookie domain, allow localhost
            ga('create', id, 'none');
            optOut = options.optOut;
            if (optOut) {
                window['ga-disable-' + id] = true;
            }
        },
        /* trackPageView(pageURI)
         *
         * - track a change of page.
         *
         * @param  {String} pageURI.
         * @public
         * @member SUGAR.analytics.connectors.GoogleAnalytics
         */
        trackPageView: function(pageUri) {
            ga('send', 'pageview', pageUri);
        },
        /* trackEvent()
         *
         * - track an event on the page.
         *
         * @param  {Object} event, with the following attributes: category, action, label, value. Label is always set as the current route the user is on.
         * @public
         * @member SUGAR.analytics.connectors.GoogleAnalytics
         */
        trackEvent: function(event) {
            ga('send', 'event', event.category, event.action, event.label, event.value);
        }
    };

    // Use with older traditional GA clients
    app.analytics.connectors["GoogleAnalyticsTraditional"] = {
        /* initialize()
         *
         * - called on app:init, load the analytics api.
         *
         * @public
         * @member SUGAR.analytics.connectors.GoogleAnalyticsTraditional
         */
        initialize: function() {
            // this code is taken directly from Google's ga.js API - https://developers.google.com/analytics/devguides/collection/gajs/
            _gaq = _gaq || [];

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' === document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        },
        /* start(id, options)
         *
         * - called on app:start, prepare or open the connection to the analytics system.
         *
         * @param  {String}id, tracking id of for analytics system
         * @param  {Object}options, SUGAR.App.config.analytics configuration.
         * @public
         * @member SUGAR.analytics.connectors.GoogleAnalyticsTraditional
         */
        start: function(id, options) {
            _gaq.push(['_setAccount', id]);
            // 'none' to ignore domain, allow localhost
            _gaq.push(['_setDomainName', 'none']);
            optOut = options.optOut;
        },
        /* trackPageView(pageURI)
         *
         * - track a change of page.
         *
         * @param  {String} pageURI.
         * @public
         * @member SUGAR.analytics.connectors.GoogleAnalyticsTraditional
         */
        trackPageView: function(pageUri) {
            if (!optOut) _gaq.push(['_trackPageview', pageUri]);
        },
        /* trackEvent()
         *
         * - track an event on the page.
         *
         * @param  {Object} event, with the following attributes: category, action, label, value. Label is always set as the current route the user is on.
         * @public
         * @member SUGAR.analytics.connectors.GoogleAnalyticsTraditional
         */
        trackEvent: function(event) {
            if (!optOut) _gaq.push(['_trackEvent', event.category, event.action, event.label, event.value]);
        }
    };
})(SUGAR.App);
