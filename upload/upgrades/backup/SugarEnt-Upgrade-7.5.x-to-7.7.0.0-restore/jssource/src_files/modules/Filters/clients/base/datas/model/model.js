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
/**
 * @class Data.Base.FiltersBean
 * @extends Data.Bean
 */
({
    /**
     * @inheritDoc
     */
    defaults: {
        editable: true
    },

    /**
     * Maps field types and field operator types.
     *
     * @property {Object}
     */
    fieldTypeMap: {
        'datetime': 'date',
        'datetimecombo': 'date'
    },

    /**
     * Gets the filter definition based on quick search metadata.
     *
     * The filter definition that is built is based on the `basic` filter
     * metadata. By default, modules will make a search on the `name` field, but
     * this is configurable. For instance, the `person` type modules
     * (e.g. Contacts or Leads) will perform a search on the first name and the
     * last name (`first_name` and `last_name` fields).
     *
     * For these modules whom the search is performed on two fields, you can
     * also configure to split the terms. In this case, the terms will be split
     * into one word and the rest of the string. The first word will be searched
     * on each fields, and the rest of the string will also be searched on each
     * string.
     *
     * There is a special case if the `moduleName` is `all_modules`: the
     * function will always return an empty filter definition (empty `array`).
     *
     * There is another special case with the `Users` and `Employees` module:
     * the filter will be augmented to retrieve only the records with the
     * `status` set to `Active`.
     *
     * @param {String} moduleName The filtered module.
     * @param {String} searchTerm The search term.
     * @return {Array} This search term filter.
     * @static
     */
    buildSearchTermFilter: function(moduleName, searchTerm) {
        var searchFilter = [],
            returnFilter = [],
            searchMeta,
            fieldNames,
            terms,
            filter;

        if (moduleName === 'all_modules') {
            return [];
        }
        searchMeta = app.data.getBeanClass('Filters').prototype.getModuleQuickSearchMeta(moduleName);
        fieldNames = searchMeta.fieldNames;

        if (searchTerm) {
            // Strip leading or trailing whitespace
            searchTerm = searchTerm.trim();

            // For Person Type modules, need to split the terms and build a smart
            // filter definition.
            if (fieldNames.length === 2 && searchMeta.splitTerms) {
                terms = searchTerm.split(' ');
                var firstTerm = _.first(terms.splice(0, 1));
                var otherTerms = terms.join(' ');
                // First field starts with first term, second field starts with
                // other terms. If only one term, use $or and search for the
                // term on both fields.
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

            filter = searchFilter[0];
            if (searchFilter.length > 1) {
                filter = terms ? {'$and': searchFilter} : {'$or': searchFilter};
            }
            returnFilter.push(filter);

            // See MAR-1362 for details.
            if (moduleName === 'Users' || moduleName === 'Employees') {
                returnFilter[0] = ({
                    '$and': [
                        {'status': {'$not_equals': 'Inactive'}},
                        returnFilter[0]
                    ]
                });
            }
        }
        return returnFilter;
    },

    /**
     * Combines two filters into a single filter definition.
     *
     * @param {Array|Object} [baseFilter] The selected filter definition.
     * @param {Array} [searchTermFilter] The filter for the quick search terms.
     * @return {Array} The filter definition.
     * @static
     */
    combineFilterDefinitions: function(baseFilter, searchTermFilter) {
        var isBaseFilter = _.size(baseFilter) > 0,
            isSearchTermFilter = _.size(searchTermFilter) > 0;

        baseFilter = _.isArray(baseFilter) ? baseFilter : [baseFilter];

        if (isBaseFilter && isSearchTermFilter) {
            baseFilter.push(searchTermFilter[0]);
            return [
                {'$and': baseFilter }
            ];
        } else if (isBaseFilter) {
            return baseFilter;
        } else if (isSearchTermFilter) {
            return searchTermFilter;
        }

        return [];
    },

    /**
     * Gets filterable fields from the module metadata.
     *
     * The list of fields comes from the metadata but is also filtered by
     * user acls (`detail`/`read` action).
     *
     * @param {String} moduleName The name of the module.
     * @return {Object} The filterable fields.
     * @static
     */
    getFilterableFields: function(moduleName) {
        var moduleMeta = app.metadata.getModule(moduleName),
            operatorMap = app.metadata.getFilterOperators(),
            fieldMeta = moduleMeta.fields,
            fields = {};

        if (moduleMeta.filters) {
            _.each(moduleMeta.filters, function(templateMeta) {
                if (templateMeta.meta && templateMeta.meta.fields) {
                    fields = _.extend(fields, templateMeta.meta.fields);
                }
            });
        }

        _.each(fields, function(fieldFilterDef, fieldName) {
            var fieldMetaData = app.utils.deepCopy(fieldMeta[fieldName]);
            if (_.isEmpty(fieldFilterDef)) {
                fields[fieldName] = fieldMetaData || {};
            } else {
                fields[fieldName] = _.extend({name: fieldName}, fieldMetaData, fieldFilterDef);
            }
            delete fields[fieldName]['readonly'];
        });

        var validFields = {};
        _.each(fields, function(value, key) {
            // Check if we support this field type.
            var type = this.fieldTypeMap[value.type] || value.type;
            var hasAccess = app.acl.hasAccess('detail', moduleName, null, key);
            // Predefined filters don't have operators defined.
            if (hasAccess && (operatorMap[type] || value.predefined_filter === true)) {
                validFields[key] = value;
            }
        }, this);

        return validFields;
    },

    /**
     * Retrieves and caches the quick search metadata.
     *
     * @param {String} [moduleName] The filtered module. Only required when the
     *   function is called statically.
     * @return {Object} Quick search metadata (with highest priority).
     * @return {String[]} return.fieldNames The fields to be used in quick search.
     * @return {Boolean} return.splitTerms Whether to split the search terms
     *   when there are multiple search fields.
     * @static
     */
    getModuleQuickSearchMeta: function(moduleName) {
        moduleName = moduleName || this.get('module_name');

        var prototype = app.data.getBeanClass('Filters').prototype;
        prototype._moduleQuickSearchMeta = prototype._moduleQuickSearchMeta || {};

        prototype._moduleQuickSearchMeta[moduleName] = prototype._moduleQuickSearchMeta[moduleName] ||
            this._getQuickSearchMetaByPriority(moduleName);
        return prototype._moduleQuickSearchMeta[moduleName];
    },

    /**
     * Populates empty values of a filter definition.
     *
     * @param {Object} filterDef The filter definition.
     * @param {Object} populateObj Populate object containing the
     *   `filter_populate` metadata definition.
     * @return {Object} The filter definition.
     * @static
     */
    populateFilterDefinition: function(filterDef, populateObj) {
        if (!populateObj) {
            return filterDef;
        }
        filterDef = app.utils.deepCopy(filterDef);
        _.each(filterDef, function(row) {
            _.each(row, function(filter, field) {
                var hasNoOperator = (_.isString(filter) || _.isNumber(filter));
                if (hasNoOperator) {
                    filter = {'$equals': filter};
                }
                var operator = _.keys(filter)[0],
                    value = filter[operator],
                    isValueEmpty = !_.isNumber(value) && _.isEmpty(value);

                if (isValueEmpty && populateObj && !_.isUndefined(populateObj[field])) {
                    value = populateObj[field];
                }

                if (hasNoOperator) {
                    row[field] = value;
                } else {
                    row[field][operator] = value;
                }
            });
        });
        return filterDef;
    },

    /**
     * Retrieves the quick search metadata.
     *
     * The metadata returned is the one that has the highest
     * `quicksearch_priority` property.
     *
     * @param {String} searchModule The filtered module.
     * @return {Object}
     * @return {String[]} return.fieldNames The list of field names.
     * @return {Boolean} return.splitTerms Whether to split search terms or not.
     * @private
     * @static
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
    }
})
