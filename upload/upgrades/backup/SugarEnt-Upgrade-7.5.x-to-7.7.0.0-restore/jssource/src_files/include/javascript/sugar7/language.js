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
    app.events.on('app:init', function() {
        app.lang = _.extend(app.lang, {

            /**
             * Retrieves module singular from name.
             *
             * @param {String} module Module name.
             * @return {String} Module singular form.
             */
            getModuleSingular: function(module) {
                var modString = app.metadata.getStrings('mod_strings')[module],
                    moduleSingular = (modString ? modString['LBL_MODULE_NAME_SINGULAR'] : '') ||
                        app.lang.getAppListStrings('moduleListSingular')[module] ||
                        app.lang.getAppListStrings('moduleList')[module] ||
                        module;

                return moduleSingular;
            }
        });

    });

    /**
     * When application finishes syncing.
     */
    app.events.on('app:sync:complete', function() {
        app.date.lang(app.user.getPreference('language'));
    });

})(SUGAR.App);
