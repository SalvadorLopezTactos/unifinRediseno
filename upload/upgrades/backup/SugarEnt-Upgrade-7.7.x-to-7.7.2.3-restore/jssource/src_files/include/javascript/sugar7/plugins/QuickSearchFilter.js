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
        app.plugins.register('QuickSearchFilter', ['layout', 'view', 'field'], {
            /**
             * Retrieve and cache the quick search metadata.
             *
             * @param {string} searchModule Module name against which quick
             *   search is applied.
             *
             * @return {Object} Quick search metadata (with highest priority).
             * @return {Array} return.fieldNames The fields to be used in
             *   quick search.
             * @return {boolean} return.splitTerms Whether to split the search
             *   terms when there are multiple search fields.
             *
             * @deprecated since 7.6. Will be removed in 7.8.
             *   Use {@link Data.FiltersBean#getModuleQuickSearchMeta} instead.
             */
            getModuleQuickSearchMeta: function(searchModule) {
                app.logger.warn('Plugins.QuickSearchFilter.getModuleQuickSearchMeta is deprecated since 7.6. ' +
                    'Please update your code to use Data.FiltersBean.getModuleQuickSearchMeta');

                var filtersBeanPrototype = app.data.getBeanClass('Filters').prototype;
                return filtersBeanPrototype.getModuleQuickSearchMeta(searchModule);
            },

            /**
             * Retrieve just the array of field names for a quick search.
             *
             * @param {string} searchModule Module name against which quick
             *   search is applied.
             *
             * @return {Array} An array of field names for the searchModule.
             *
             * @deprecated since 7.6. Will be removed in 7.8.
             *   Use {@link Data.FiltersBean#getModuleQuickSearchMeta} instead.
             */
            getModuleQuickSearchFields: function(searchModule) {
                app.logger.warn('Plugins.QuickSearchFilter.getModuleQuickSearchFields is deprecated since 7.6. ' +
                    'Please update your code to use Data.FiltersBean.getModuleQuickSearchMeta');

                var filtersBeanPrototype = app.data.getBeanClass('Filters').prototype;
                return filtersBeanPrototype.getModuleQuickSearchMeta(searchModule).fieldNames;
            },

            /**
             * Get the filter definition based on quick search metadata.
             *
             * @param {string} searchModule Module name against which quick
             *   search is applied.
             * @param {string} searchTerm Search input entered.
             *
             * @return {Array} The search filter definition of quick search,
             *   otherwise an empty array.
             *
             * @deprecated since 7.6. Will be removed in 7.8.
             *   Use {@link Data.FiltersBean#buildSearchTermFilter} instead.
             */
            getFilterDef: function(searchModule, searchTerm) {
                app.logger.warn('Plugins.QuickSearchFilter.getFilterDef is deprecated since 7.6. ' +
                    'Please update your code to use Data.FiltersBean.buildSearchTermFilter');

                var filtersBeanPrototype = app.data.getBeanClass('Filters').prototype;
                return filtersBeanPrototype.buildSearchTermFilter(searchModule, searchTerm);
            }
        });
    });
})(SUGAR.App);
