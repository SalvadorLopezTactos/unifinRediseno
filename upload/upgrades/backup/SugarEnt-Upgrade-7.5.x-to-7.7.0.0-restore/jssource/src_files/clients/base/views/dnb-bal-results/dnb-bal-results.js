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
    extendsFrom: 'DnbView',

    plugins: ['Connector'],

    events: {
        'click .importContacts': 'importContacts',
        'click .backToContactsList': 'backToContactsList',
        'click .dnb-cnt-prem': 'baseGetContactDetails',
        'click .dnb-cnt-std': 'baseGetContactDetails',
        'click [data-action="show-more"]': 'invokePagination'
    },

    selectors: {
        'load': '#dnb-bal-result-loading',
        'rslt': '#dnb-bal-result',
        'contactrslt': '#dnb-bal-contact-list'
    },

    /**
     * @override
     * @param {Object} options
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.initDashlet();
        app.events.on('dnbbal:invoke', this.invokeBAL, this);
        var originalMeta = app.metadata.getView('','dnb-bal-results');
        if (originalMeta.import_enabled_modules) {
            this.import_enabled_modules = originalMeta.import_enabled_modules;
        }
        this.paginationCallback = this.baseContactsBAL;
    },

    /**
     * Overriding the render function to populate the import type drop down
     */
    _render: function() {
        //TODO: Investigate why using this._super('_renderHtml');
        //we get Unable to find method _renderHtml on parent class of dnb-bal-results
        app.view.View.prototype._renderHtml.call(this);
        this.$('#importType').select2();
    },

    loadData: function(options) {
        this.checkConnector('ext_rest_dnb',
            _.bind(this.loadDataWithValidConnector, this),
            _.bind(this.handleLoadError, this),
            ['test_passed']);
    },

    /**
     * Success callback to be run when Connector has been verified and validated
     */
    loadDataWithValidConnector: function() {
        this.template = app.template.get(this.name + '.dnb-bal-hint');
        this.render();
        this.dnbError = null;
        //placed here instead of initialize
        //so that pagination params are reset when
        //reset is clicked on dnb-bal-params view
        this.initPaginationParams();
    },

    /**
     * Failure callback to be run if Connector verification fails
     * @param {object} connector that failed
     */
    handleLoadError: function(connector) {
        //checks if the current user has admin access
        var showAdmin = app.acl.hasAccess('admin', 'Administration');
        if (showAdmin) {
            this.dnbError = {
                'errMsg': 'LBL_DNB_NOT_CONFIGURED',
                'errorLink': this.commonConst.connectorSettingsURL,
                'label': 'LBL_DNB_BAL'
            };
        } else {
            this.dnbError = {
                'errMsg': 'LBL_DNB_CONNECTOR_ERR',
                'label': 'LBL_DNB_BAL'
            };
        }
        this.template = app.template.get('dnb.dnb-sidepane-error');
        this.render();
    },

    /**
     * Listens for model change for certain attributes
     * Captures these attributes and invokes bal
     * @param {Object} balParams
     */
    invokeBAL: function(balParams) {
        if (!_.isEmpty(balParams)) {
            //resetting the pagination parameters every time a new bal call is made
            this.initPaginationParams();
            //setting the balParams to context
            //this is required to invoke the api with the altered
            //pagination parameters
            this.balParams = balParams;
            this.buildAList(this.setApiPaginationParams(balParams));
        } else {
            this.loadData();
        }
    },

    /**
     * Build a list of accounts
     * @param {Object} balParams
     */
    buildAList: function(balParams) {
        if (this.disposed) {
            return;
        }
        this.template = app.template.get(this.name + '.dnb-bal-contacts-rslt');
        if (this.dnbContactsList && this.dnbContactsList.count) {
            delete this.dnbContactsList['count'];
        }
        this.render();
        this.$(this.selectors.load).removeClass('hide');
        this.$(this.selectors.rslt).addClass('hide');
        //this is required for duplicate check
        balParams.contactType = this.module;
        this.baseContactsBAL(balParams, this.renderBAL);
    },

    /**
     * Renders the list of D&B Contacts
     * @param {Object} dnbApiResponse
     */
    renderBAL: function(dnbApiResponse) {
        var dnbContactsList = {};
        if (this.resetPaginationFlag) {
            this.initPaginationParams();
        }
        if (dnbApiResponse.product) {
            var apiContactList = this.getJsonNode(dnbApiResponse.product, this.contactConst.contactsPath);
            //setting the formatted set of records to context
            //will be required when we paginate from the client side itself
            this.formattedRecordSet = this.formatContactList(apiContactList, this.contactsListDD);
            //setting the api recordCount to context
            //will be used to determine if the pagination controls must be displayed
            this.recordCount = this.getJsonNode(dnbApiResponse.product, this.contactConst.srchCount);
            this.paginateRecords();
            dnbContactsList.product = this.currentPage;
            if (this.recordCount) {
                dnbContactsList.count = this.recordCount;
            }
        } else if (dnbApiResponse.errmsg) {
            dnbContactsList.errmsg = dnbApiResponse.errmsg;
        }
        this.renderPage(dnbContactsList);
    },

    /**
     * Renders the currentPage
     * @param {Object} pageData
     */
    renderPage: function(pageData) {
        if (this.disposed) {
            return;
        }
        this.template = app.template.get(this.name + '.dnb-bal-contacts-rslt');
        this.dnbContactsList = pageData;
        //pageData count is not defined when the page is being rendered after
        //dupe check
        //hence using the count from the context variable
        if (_.isUndefined(pageData.count)) {
            pageData.count = this.recordCount;
        }
        //if the api returns a success response then only set the count
        if (pageData.product) {
            this.dnbContactsList.count = app.lang.get('LBL_DNB_BAL_RSLT_CNT', this.module) + " (" + this.formatSalesRevenue(pageData.count) + ")";
        } else {
            delete this.dnbContactsList['count'];
        }
        this.render();
        this.$(this.selectors.load).addClass('hide');
        this.$(this.selectors.rslt).removeClass('hide');
        //render pagination controls only if the api returns a success response
        if (pageData.product) {
            this.renderPaginationControl();
        }
    },

    /**
     * Back to contacts list functionality
     */
    backToContactsList: function() {
        if (this.disposed) {
            return;
        }
        this.template = app.template.get(this.name + '.dnb-bal-contacts-rslt');
        if (this.dnbContactsList && this.dnbContactsList.count) {
            delete this.dnbContactsList['count'];
        }
        this.render();
        this.$(this.selectors.load).removeClass('hide');
        this.$(this.selectors.rslt).addClass('hide');
        var dupeCheckParams = {
            'type': this.module,
            'apiResponse': this.currentPage,
            'module': 'contactsPage'
        };
        this.baseDuplicateCheck(dupeCheckParams, this.renderPage);
    },

    importContacts: function() {
        var module = this.$('#importType').val();
        this.baseImportContact(module);
    },

    /**
     * Event handler for pagination controls
     * Renders next page from context if available
     * else invokes the D&B API to get the next page
     */
    invokePagination: function() {
        this.displayPaginationLoading();
        this.setPaginationParams();
        //if the endRecord after pagination is greater than apiPageEndRecord
        //we have to invoke the api with the pagination controls
        if (this.endRecord > this.apiPageEndRecord) {
            this.apiPageEndRecord = (this.startRecord + this.apiPageSize) - 1;
            this.resetPaginationFlag = false;
            //setting the apiPageOffset
            this.apiPageOffset = this.startRecord;
            this.paginationCallback(this.setApiPaginationParams(this.balParams), this.renderBAL);
        } else {
            this.paginateRecords();
            var pageData = {
              'product': this.currentPage,
              'count': this.recordCount
            };
            this.renderPage(pageData);
        }
    }
})
