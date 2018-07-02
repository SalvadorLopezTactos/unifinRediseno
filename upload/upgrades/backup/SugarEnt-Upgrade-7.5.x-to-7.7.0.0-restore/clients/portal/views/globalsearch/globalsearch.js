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
({
    extendsFrom:'GlobalsearchView',
    _renderHtml: function() {
        if (!app.api.isAuthenticated() || app.config.appStatus == 'offline') return;

        app.view.View.prototype._renderHtml.call(this);

        // Search ahead drop down menu stuff
        var self = this,
            menuTemplate = app.template.getView(this.name + '.result');

        this.$('.search-query').searchahead({
            context: self,
            request: function(term) {
                self.fireSearchRequest(term);
            },
            compiler: menuTemplate,
            throttleMillis: (app.config.requiredElapsed || 500),
            throttle: function(callback, millis) {
                if(!self.debounceFunction) {
                    self.debounceFunction = _.debounce(function(){
                        callback();
                    }, millis || 500);
                }
                self.debounceFunction();
            },
            onEnterFn: function(hrefOrTerm, isHref) {
                if(isHref) {
                   window.location = hrefOrTerm;
                } else {
                    // It's the term only (user didn't select from drop down
                    // so this is essentially the term typed
                    var term = $.trim(self.$('.search-query').attr('value'));
                    if (!_.isEmpty(term)) {
                        self.fireSearchRequest(term, this);
                    }
                }
            }
        });
        // Prevent the form from being submitted
        this.$('.navbar-search').submit(function() {
            return false;
        });
    },
    /**
     * Populates search modules from displayable modules, taking acls and globalSearchEnabled in to account
     */
    populateModules: function() {
        if (this.disposed) {
            return;
        }
        var modules = app.metadata.getModules() || {};
        var moduleNames = app.metadata.getModuleNames({filter: 'display_tab'}); // visible
        this.searchModules = this.populateSearchableModules({
            modules: modules,
            moduleNames: moduleNames,
            acl: app.acl,
            // Unlike sugar7, today, portal doesn't use ftsEnabled but instead any visible modules that
            // are also globalSearchEnabled (e.g. Home should have not be global search enabled)
            checkFtsEnabled: false,
            checkGlobalSearchEnabled: true
        });
        this.render();
    },
    // TODO if we are extending this, why are we duplicating almost everything on this code?
    fireSearchRequest: function (term) {
        var self = this,
            searchModuleNames = this._getSearchModuleNames(),
            maxNum = app.config && app.config.maxSearchQueryResult ? app.config.maxSearchQueryResult : 5,
            params = {
                q: term,
                fields: 'name, id',
                module_list: searchModuleNames.join(","),
                max_num: maxNum
            };


        app.api.search(params, {
            success:function(data) {
                var formattedRecords = [],
                    modList = app.metadata.getModuleNames({filter: 'quick_create', action: 'create'}),
                    moduleIntersection = _.intersection(modList, self.searchModules);
                _.each(data.records, function(record) {
                    if (!record.id) {
                        return; // Elastic Search may return records without id and record names.
                    }
                    var formattedRecord = {
                        id: record.id,
                        name: record.name,
                        module: record._module,
                        link: '#' + app.router.buildRoute(record._module, record.id)
                    };

                    if ((record._search.highlighted)) { // full text search
                        _.each(record._search.highlighted, function(val, key) {
                            if (key !== 'name') { // found in a related field
                               formattedRecord.field_name = app.lang.get(val.label, val.module);
                               formattedRecord.field_value = val.text;
                            }
                        });
                    }
                    formattedRecords.push(formattedRecord);
                });
                self.$('.search-query').searchahead('provide', {module_list: moduleIntersection, next_offset: data.next_offset, records: formattedRecords});
            },
            error:function(error) {
                app.error.handleHttpError(error, plugin);
                app.logger.error("Failed to fetch search results in search ahead. " + error);
            }
        });
    },
    /**
     * Show full search results when the search button is clicked
     * (Show searchahead results for sugarcon because we don't have full results page yet)
     */
    gotoFullSearchResultsPage: function(evt) {
        var term;
        // Force navigation to full results page and don't let plugin get control
        evt.preventDefault();
        evt.stopPropagation();
        // URI encode search query string so that it can be safely
        // decoded by search handler (bug55572)
        term = encodeURIComponent(this.$('.search-query').val());
        if(term && term.length) {
            // Bug 57853 Shouldn't show the search result pop up window after click the global search button.
            // This prevents anymore dropdowns (note we re-init if/when _renderHtml gets called again)
            this.$('.search-query').searchahead('disable', 1000);
            app.router.navigate('#search/'+term, {trigger: true});
        }
    }
})
