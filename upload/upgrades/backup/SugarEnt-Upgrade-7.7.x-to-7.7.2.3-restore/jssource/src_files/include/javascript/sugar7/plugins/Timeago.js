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

    if (!$.fn.timeago) {
        return;
    }

    app.events.on('app:init', function() {

        /**
         * Plugin to keep timeago labels live.
         *
         * @deprecated since 7.2.0. Please use {@link Plugin.RelativeTime}
         * plugin.
         */
        app.plugins.register('Timeago', ['view'], {
            onAttach: function(component, plugin) {
                component.on('render', function() {
                    component.$('span.relativetime').timeago({
                        logger: SUGAR.App.logger,
                        date: SUGAR.App.date,
                        lang: SUGAR.App.lang,
                        template: SUGAR.App.template,
                        dateFormat: app.user.getPreference('datepref'),
                        timeFormat: app.user.getPreference('timepref')
                    });
                });
            }
        });
    });
})(SUGAR.App);
