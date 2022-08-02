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
    app.analytics = app.analytics || {};
    app.analytics.connectors = app.analytics.connectors || {};

    app.analytics.connectors.Pendo  = {
        // disabling of IP address/geolocation tracking is handled by talking with Pendo directly
        // see https://help.pendo.io/resources/support-library/analytics/disable-ip-address-and-geo-location-logging.html

        /**
        * List of default values needed for Pendo analytics
        */
        serverInfoDefaults: {
            'si_id': 'unknown_si_id',
            'si_name': 'unknown_si_name',
            'si_type': 'unknown_si_type',
            'si_license_current': false,
            'si_license_serve': false,
            'si_license_sell': false,
            'si_tier': 'unknown_si_tier',
            'si_customer_since': 'unknown_si_customer_since',
            'si_sic_code': 'unknown_si_sic_code',
            'si_employees_no': 'unknown_si_employees_no',
            'si_managing_team': 'unknown_si_managing_team',
            'si_partner_name': 'unknown_si_partner_name',
            'si_partner_type': 'unknown_si_partner_type',
            'si_account_record': 'unknown_si_account_record',
            'si_customer_region': 'unknown_si_customer_region',
            'si_billing_country': 'unknown_si_billing_country',
            'si_billing_state': 'unknown_si_billing_state',
            'si_billing_city': 'unknown_si_billing_city',
            'si_postal_code': 'unknown_si_postal_code',
            'si_cloud_instance': 'unknown_si_cloud_instance',
            'si_usage_designation': 'unknown_si_usage_designation',
            'si_no_of_licenses': 'unknown_si_no_of_licenses',
            'si_cloud_region': 'unknown_si_cloud_region',
            'si_upgrade_frequency': 'unknown_si_upgrade_frequency',
            'si_db_size': 'unknown_si_db_size',
            'si_file_system_size': 'unknown_si_file_system_size',
            'si_sum_size': 'unknown_si_sum_size',
            'si_rli_enabled': 'unknown_rli_enabled',
            'si_forecasts_is_setup': 'unknown_forcasts_is_setup',
            'si_product_list': 'unknown_product_list',
            'portal_active': 'unknown_portal_activated'
        },

        /*
         * Called on app:init.
         *
         * @member SUGAR.App.analytics.connectors.Pendo
         */
        initialize: function() {
            // do nothing. pendo agent will be loaded by start() when id (apiKey) is available
        },

        /*
         * Called on app:start, prepare or open the connection to the analytics system.
         *
         * @param {string} id Tracking id for the analytics system.
         * @param {Object} options SUGAR.App.config.analytics configuration.
         * @member SUGAR.App.analytics.connectors.Pendo
         */
        start: function (id, options) {
            // this code is taken directly from Pendo
            /* eslint-disable */
            (function(apiKey){
                (function(p,e,n,d,o){var v,w,x,y,z;o=p[d]=p[d]||{};o._q=[];
                    v=['initialize','identify','updateOptions','pageLoad'];for(w=0,x=v.length;w<x;++w)(function(m){
                        o[m]=o[m]||function(){o._q[m===v[0]?'unshift':'push']([m].concat([].slice.call(arguments,0)));};})(v[w]);
                    y=e.createElement(n);y.async=!0;y.src='https://cdn.pendo.io/agent/static/'+apiKey+'/pendo.js';
                    z=e.getElementsByTagName(n)[0];z.parentNode.insertBefore(y,z);})(window,document,'script','pendo');
            })(id);
            /* eslint-enable */
        },

        /*
         * Send user and account data.
         *
         * @member SUGAR.App.analytics.connector.Pendo
         */
        configure: function() {
            // check consent for portal user
            if (app.config.platform === 'portal' && !app.user.get('cookie_consent')) {
                return;
            }
            pendo.initialize(this.getPendoMetadata());
        },

        /**
         * Returns the pendo visitor and account info object
         * @return {Object} visitor object, account-info
         */
        getPendoMetadata: function() {
            // user data
            var visitorId = app.user.get('site_user_id') || 'unknown_user';
            var userType = app.user.get('type') || 'unknown_user_type';
            var language = app.user.getLanguage() || 'unknown_language';
            var roles = app.user.get('roles');
            roles = Array.isArray(roles) ? (roles.length >= 1 ? roles.join(',') : 'no_roles') : 'unknown_roles';

            var licenses = app.user.get('licenses');
            licenses = Array.isArray(licenses) && licenses.length > 0 ? licenses.join(',') : 'no_licenses';

            // account data
            var activityStreamsEnabled = app.config.activityStreamsEnabled ? 'True' : 'False';
            var editablePreviewEnabled = app.config.previewEdit ? 'True' : 'False';
            var listMaxEntriesPerPage = app.config.maxQueryResult || 'unknown_list_view_items_per_page';
            var listMaxEntriesPerSubpanel = app.config.maxSubpanelResult || 'unknown_list_view_items_per_page';
            var leadConversionOptions = app.config.leadConvActivityOpt || 'unknown_lead_conversion_options';
            var systemDefaultCurrencyCode = app.currency.getBaseCurrency().iso4217 ||
                'unknown_system_default_currency_code';
            var systemDefaultLanguage = app.lang.getLanguage() || 'unknown_system_default_language';
            var awsConnectInstanceName = app.config.awsConnectInstanceName || 'unknown_connect_instance_name';
            var awsConnectUrl = app.config.awsConnectUrl || 'unknown_connect_url';

            var serverInfo = app.metadata.getServerInfo();
            var accountId = serverInfo.site_id || 'unknown_account';
            var siteUrl = _.isFunction(app.utils.getSiteUrl) ? app.utils.getSiteUrl() : 'unknown_domain';
            var version = serverInfo.version || 'unknown_version';
            var flavor = serverInfo.flavor || 'unknown_edition';
            var accountBasicInfo = {
                id: accountId,
                domain: siteUrl,
                edition: flavor,
                version: version,
                activity_streams_enabled: activityStreamsEnabled,
                editable_preview_enabled: editablePreviewEnabled,
                list_view_items_per_page: listMaxEntriesPerPage,
                subpanel_items_per_page: listMaxEntriesPerSubpanel,
                lead_conversion_options: leadConversionOptions,
                system_default_currency_code: systemDefaultCurrencyCode,
                system_default_language: systemDefaultLanguage,
                aws_connect_instance_name: awsConnectInstanceName,
                aws_connect_url: awsConnectUrl
            };
            var accountServerInfo = _.each(this.serverInfoDefaults, function(value, name, serverInfoList) {
                serverInfoList[name] = serverInfo[name] || value;
                return serverInfoList;
            });

            return {
                visitor: {
                    id: visitorId,
                    user_type: userType,
                    language: language,
                    roles: roles,
                    licenses: licenses
                },
                account: _.extend(accountBasicInfo, accountServerInfo)
            };
        },

        /*
         * Track an activity.
         *
         * Pendo auto-tracks most events.
         * You don't have to do this every single time you want to track something.
         * See https://help.pendo.io/resources/support-library/api/index.html?bash#track-events
         * @param {string} trackType Activity type.
         * @param {Object} trackData Activity metadata.
         * @member SUGAR.App.analytics.connectors.Pendo
         */
        track: function(trackType, trackData) {
            pendo.track(trackType, trackData);
        },

        /*
         * Track a change of page.
         *
         * @param {string} pageUri Uri of the page viewed.
         * @member SUGAR.App.analytics.connectors.Pendo
         */
        trackPageView: function(pageUri) {
            // Pendo automatically collects page view data
            // see https://help.pendo.io/resources/support-library/api/index.html?bash#browser-interactions
        },

        /*
         * Track an event on the page.
         *
         * @param {Object} event Google Analytics event to track.
         * @param {string} event.category Category of the event.
         * @param {string} event.action Action of the event.
         * @param {string} event.label Always set to the route the user is on.
         * @param {number} [event.value] Value of the event.
         * @member SUGAR.App.analytics.connectors.Pendo
         */
        trackEvent: function(event) {
            // Pendo automatically collects some events
            // see https://help.pendo.io/resources/support-library/api/index.html?bash#browser-interactions
            // Pendo Agent API allows us to track more events if needed
            // see https://help.pendo.io/resources/support-library/api/index.html?bash#track-events
            // see app.analytics.track();
        },

        /*
         * Set tracker params.
         *
         * Currently do nothing.
         * @param {string} key The param name.
         * @param {*} value The configuration value to send to the tracker.
         * @member SUGAR.App.analytics.connectors.Pendo
         */
        set: function(key, value) {
            // do nothing
        }
    };
})(SUGAR.App);
