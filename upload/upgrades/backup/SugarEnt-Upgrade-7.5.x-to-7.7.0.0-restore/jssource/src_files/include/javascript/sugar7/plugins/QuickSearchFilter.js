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
    app.events.on("app:init", function() {
        app.plugins.register('QuickSearchFilter', ['layout', 'view', 'field'], {
            /**
             * Metadata about how quick search should be performed
             * @private
             */
            _moduleQuickSearchMeta: {},

            /**
             * Retrieve the highest priority quick search metadata
             *
             * @param {String} searchModule
             * @return {Object} Field names and whether to split search terms
             * @private
             */
            _getQuickSearchMetaByPriority: function(searchModule) {
                var meta = app.metadata.getModule(searchModule),
                    filters = meta ? meta.filters : [],
                    fieldNames = [],
                    priority = 0,
                    splitTerms = false;

                _.each(filters, function(value) {
                    if (value && value.meta && value.meta.quicksearch_field &&
                        priority < value.meta.quicksearch_priority) {
                        fieldNames = value.meta.quicksearch_field;
                        priority = value.meta.quicksearch_priority;
                        if (_.isBoolean(value.meta.quicksearch_split_terms)) {
                            splitTerms = value.meta.quicksearch_split_terms;
                        }
                    }
                });

                return {
                    fieldNames: fieldNames,
                    splitTerms: splitTerms
                };
            },

            /**
             * Retrieve and cache the quick search metadata
             *
             * @param searchModule
             * @return {Object} Quick search metadata (with highest priority)
             * @return {Array} return.fieldNames The fields to be used in quick search
             * @return {Boolean} return.splitTerms Whether to split the search terms
             * when there are multiple search fields
             */
            getModuleQuickSearchMeta: function (searchModule) {
                this._moduleQuickSearchMeta[searchModule] = this._moduleQuickSearchMeta[searchModule] ||
                    this._getQuickSearchMetaByPriority(searchModule);
                return this._moduleQuickSearchMeta[searchModule];
            },

            /**
             * Retrieve just the array of field names for a quick search
             * @param searchModule
             * @return {Array}
             */
            getModuleQuickSearchFields: function(searchModule) {
                return this.getModuleQuickSearchMeta(searchModule).fieldNames;
            },

            /**
             * Get the filter definition based on quick search metadata
             *
             * @param searchModule
             * @param searchTerm
             * @return {Array}
             */
            getFilterDef: function(searchModule, searchTerm) {
                var searchFilter = [], returnFilter = [], searchMeta, fieldNames, terms;

                //Special case where no specific module is selected
                if (searchModule === 'all_modules') {
                    return returnFilter;
                }
                // We allow searching based on the basic search filter.
                // For example, the Contacts module will search the records
                // whose first name or last name begins with the typed string.
                // To extend the search results, you should update the metadata for basic search filter
                searchMeta = this.getModuleQuickSearchMeta(searchModule);
                fieldNames = searchMeta.fieldNames;

                if (searchTerm) {
                    //strip leading or trailing whitespace
                    searchTerm = searchTerm.trim();

                    //For Person Type modules, need to split the terms and build a smart filter definition
                    if (fieldNames.length === 2 && searchMeta.splitTerms) {
                        terms = searchTerm.split(' ');
                        var firstTerm = _.first(terms.splice(0, 1));
                        var otherTerms = terms.join(' ');
                        //First field starts with first term, second field starts with other terms
                        //If only one term, use $or and search for the term on both fields
                        terms = otherTerms ? [firstTerm, otherTerms] : null;
                    } else if (fieldNames.length > 2) {
                        app.logger.fatal('Filtering by 3 quicksearch fields is not yet supported.');
                    }
                    _.each(fieldNames, function(name, index) {
                        var o = {};
                        if (terms) {
                            o[name] = {'$starts': terms[index]};
                        } else {
                            o[name] = {'$starts': searchTerm};
                        }
                        searchFilter.push(o);
                    });
                    if (terms) {
                        returnFilter.push(searchFilter.length > 1 ? {'$and': searchFilter} : searchFilter[0]);
                    } else {
                        returnFilter.push(searchFilter.length > 1 ? {'$or': searchFilter} : searchFilter[0]);
                    }

                    // See MAR-1362 for details.
                    if (searchModule === 'Users' || searchModule === 'Employees') {
                        returnFilter[0] = ({
                            '$and': [
                                {'status': {'$not_equals': 'Inactive'}},
                                returnFilter[0]
                            ]
                        });
                    }
                }
                return returnFilter;
            }
        });
    });
})(SUGAR.App);
