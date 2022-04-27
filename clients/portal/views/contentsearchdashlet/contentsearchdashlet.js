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

/**
* @class View.Views.Portal.ContentsearchdashletView
* @alias SUGAR.App.view.views.PortalContentsearchdashletView
* @extends View.View
*/
({
    plugins: ['Dashlet'],

    events: {
        'click [data-action="create-case"]': 'initCaseCreation',
        'keyup [data-action="search"]': 'searchCases'
    },

    /**
     * Search options.
     * @property {Object}
     */
    searchOptions: {
        max_num: 4,
        module_list: 'KBContents'
    },

    /**
     * Maximum number of characters of search results to display.
     * @property {number}
     */
    maxChars: 500,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.module = 'Cases';
        this.caseDeflection = this.isCaseDeflectionEnabled();
        this.canCreateCase = app.acl.hasAccess('create', this.module);
        this.greeting = app.lang.get('LBL_CONTENT_SEARCH_DASHLET_GREETING', this.module, {
            username: app.user.get('full_name')
        });
        this.searchDropdown = null;
        this.context.on('page:clicked', this._search, this);
    },

    /**
     * Gets search and display options from dashlet settings if exist.
     */
    initDashlet: function() {
        this.searchOptions = {
            module_list: this.settings.get('module_list') || this.searchOptions.module_list,
            max_num: this.settings.get('max_num') || this.searchOptions.max_num
        };
        this.maxChars = this.settings.get('max_chars') || this.maxChars;
    },

    /**
     * Checks if case deflection is enabled. In case it is enabled the dashlet
     * will render a search bar for the users, if not it will render a message
     * with the case creation button.
     *
     * @return {boolean} True if case deflection is enabled.
     */
    isCaseDeflectionEnabled: function() {
        return _.isUndefined(app.config.caseDeflection) ||
            app.config.caseDeflection === 'enabled';
    },

    /**
     * Will display the case creation drawer from where
     * the users are able to create a new case.
     */
    initCaseCreation: function() {
        app.drawer.open({
            layout: 'create',
            context: {
                create: true,
                module: 'Cases'
            }
        });
    },

    /**
     * Starts a new search and show the search results dropdown.
     */
    searchCases: _.debounce(function() {
        var $input = this.$('input[data-action=search]');
        var term = $input.val().trim();

        if (term === '') {
            if (this.searchDropdown) {
                this.searchDropdown.hide();
            }
            return;
        }

        this.searchOptions.q = term;

        if (_.isNull(this.searchDropdown)) {
            this.searchDropdown = app.view.createLayout({
                context: this.context,
                name: 'contentsearch-dropdown',
                module: 'Cases'
            });
            this.searchDropdown.initComponents();
            this.layout._components.push(this.searchDropdown);
            this.searchDropdown.render();
            $input.after(this.searchDropdown.$el);
        }

        this.searchDropdown.hide();
        this.context.trigger('data:fetching');
        this.searchDropdown.show();
        this._search();
    }, 400),

    /**
     * Calls search api
     *
     * @param {Object} options The search options
     * @private
     */
    _search: function(options) {
        var pageNumber = options && options.pageNum || 1;
        var offset = (pageNumber - 1) * this.searchOptions.max_num;
        var params = _.extend({}, this.searchOptions, {offset: offset});
        var url = app.api.buildURL('genericsearch', null, null, params);
        app.api.call('read', url, null, {
            success: _.bind(function(result) {
                if (this.disposed) {
                    return;
                }
                if (this.context) {
                    var data = this._parseData(result);
                    this.context.trigger('data:fetched', data);
                }
            }, this)
        });
    },

    /**
     * Parses search results.
     *
     * @param {Object} result The search result
     * @return {Object} parsed data
     * @private
     */
    _parseData: function(result) {
        var self = this;
        var totalPages = result.total > 0 ?
            Math.ceil(result.total / this.searchOptions.max_num) : 0;
        var currentPage = result.next_offset > 0 ?
            result.next_offset / this.searchOptions.max_num : totalPages;
        var records = _.map(result.records, function(record) {
            return {
                name: record.name,
                description: self._truncate(record.description),
                url: app.utils.buildUrl(record.url.replace(/^\/+/g, ''))
            };
        });
        return {
            options: this.searchOptions,
            currentPage: currentPage,
            records: records,
            totalPages: totalPages
        };
    },

    /**
     * Truncates search result so it is shorter than the maxChars
     * Only truncate on full words to prevent ellipsis in the middle of words
     * @param {string} text The search result entry to truncate
     * @return {string} the shortened version of an entry
     * @private
     */
    _truncate: function(text) {
        text = text || '';

        if (text.length > this.maxChars) {
            var cut = text.substring(0, this.maxChars);
            // cut at a full word
            while (!(/\s/.test(cut[cut.length - 1])) && cut.length > 0) {
                cut = cut.substring(0, cut.length - 1);
            }
            text = cut + '...';
        }

        return text;
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        if (this.context) {
            this.context.off('page:clicked', null, this);
        }
    }
})
