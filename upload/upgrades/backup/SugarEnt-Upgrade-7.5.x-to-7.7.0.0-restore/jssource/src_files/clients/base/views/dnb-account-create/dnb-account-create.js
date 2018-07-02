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
 * @class View.Views.Base.DnbAccountCreateView
 * @alias SUGAR.App.view.views.BaseDnbAccountCreateView
 * @extends View.Views.Base.DnbView
 */
({
    extendsFrom: 'DnbView',

    duns_num: '',

    //used to detect if import was clicked for the first time when company info was loaded
    //this flag is being used to avoid the warning message for account name
    //when the user clicks the import button first time when company info is loaded
    //a user clicks import
    importFlag: false,

    companyList: null,

    keyword: null,

    plugins: ['Connector'],

    events: {
        'click a.dnb-company-name': 'dunsClickHandler',
        'click .showMoreData': 'showMoreData',
        'click .showLessData': 'showLessData',
        'click .importDNBData': 'importAccount',
        'click .dnb_checkbox': 'importCheckBox',
        'click .clearDNBResults': 'clearDNBResults',
        'click .backToList' : 'backToCompanyList',
        'click [data-action="show-more"]': 'invokePagination'
    },

    configuredKey: 'dnb:account:create:configured',

    initialize: function(options) {
        this._super('initialize', [options]);
        this.initDashlet();
        this.loadData();
        this.initPaginationParams();
        this.paginationCallback = this.baseAccountsBAL;
    },

    loadData: function() {
        if (this.disposed) {
            return;
        }
        this.checkConnector('ext_rest_dnb',
            _.bind(this.loadDataWithValidConnector, this),
            _.bind(this.handleLoadError, this),
            ['test_passed']);
    },

    /**
     * Success callback to be run when Connector has been verified and validated
     */
    loadDataWithValidConnector: function() {
        if (this.disposed) return;
        this.template = app.template.get(this.name + '.dnb-search-hint');
        this.render();
        this.context.on('input:name:keyup', this.dnbSearch, this);
        this.errmsg = null;
    },

    /**
     * Failure callback to be run if Connector verification fails
     * @param {object} connector that failed
     */
    handleLoadError: function(connector) {
        if (this.disposed) return;
        this.errmsg = 'LBL_DNB_NOT_CONFIGURED';
        this.template = app.template.get(this.name + '.dnb-need-configure');
        this.render();
        this.context.off('input:name:keyup', this.dnbSearch);
    },

    /**
     * Navigates from the company details screen to the search results screen
     */
    backToCompanyList: function() {
        if (this.disposed) {
            return;
        }
        this.template = app.template.get(this.name);
        this.render();
        this.$('div#dnb-company-list-loading').show();
        this.$('div#dnb-search-results').hide();
        this.$('.importDNBData').hide();
        var dupeCheckParams = {
            'type': 'duns',
            'apiResponse': this.currentPage,
            'module': 'dunsPage'
        };
        this.baseDuplicateCheck(dupeCheckParams, this.renderPage);
    },

    /**
     * Render search results
     * @param  {Object} dnbSrchApiResponse
     */
    renderCompanyList: function(dnbSrchApiResponse) {
        var dnbSrchResults = {};
        if (this.resetPaginationFlag) {
            this.initPaginationParams();
        }
        if (dnbSrchApiResponse.product) {
            var apiCompanyList = this.getJsonNode(dnbSrchApiResponse.product, this.commonJSONPaths.srchRslt);
            //setting the formatted set of records to context
            //will be required when we paginate from the client side itself
            this.formattedRecordSet = this.formatSrchRslt(apiCompanyList, this.searchDD);
            //setting the api recordCount to context
            //will be used to determine if the pagination controls must be displayed
            this.recordCount = this.getJsonNode(dnbSrchApiResponse.product, this.commonJSONPaths.srchCount);
            this.paginateRecords();
            dnbSrchResults.product = this.currentPage;
            if (this.recordCount) {
                dnbSrchResults.count = this.recordCount;
            }
        } else if (dnbSrchApiResponse.errmsg) {
            dnbSrchResults.errmsg = dnbSrchApiResponse.errmsg;
        }
        this.renderPage(dnbSrchResults);
    },

    /**
     * Renders the currentPage
     * @param {Object} pageData
     */
    renderPage: function(pageData) {
        if (this.disposed) {
            return;
        }
        this.template = app.template.get(this.name);
        this.dnbSrchResults = pageData;
        //pageData count is not defined when the page is being rendered after
        //dupe check
        //hence using the count from the context variable
        if (_.isUndefined(pageData.count)) {
            pageData.count = this.recordCount;
        }
        //if the api returns a success response then only set the count
        if (pageData.product) {
            this.dnbSrchResults.count = app.lang.get('LBL_DNB_BAL_ACCT_HEADER') + " (" + this.formatSalesRevenue(pageData.count) + ")";
        } else {
            delete this.dnbSrchResults['count'];
        }
        this.render();
        this.$('div#dnb-company-list-loading').hide();
        this.$('div#dnb-search-results').show();
        //render pagination controls only if the api returns a success response
        if (pageData.product) {
            this.renderPaginationControl();
        }
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
            this.paginationCallback(this.setApiPaginationParams(this.balParams), this.renderCompanyList);
        } else {
            this.paginateRecords();
            var pageData = {
                'product': this.currentPage,
                'count': this.recordCount
            };
            this.renderPage(pageData);
        }
    },

    /** event listener for keyup / autocomplete feature
     * @param {String} searchString
     */
    dnbSearch: function(searchString) {
        if (this.disposed) {
            return;
        }
        if (!this.keyword || (this.keyword && this.keyword !== searchString)) {
            this.keyword = searchString;
            this.template = app.template.get(this.name);
            //deleting the count of the previous search results
            if (this.dnbSrchResults && this.dnbSrchResults.count) {
                delete this.dnbSrchResults['count'];
            }
            this.render();
            this.$('table#dnb_company_list').empty(); //empty results table
            this.$('div#dnb-search-results').hide(); //hide results div
            this.$('div#dnb-company-list-loading').show(); //show loading text
            this.$('.clearDNBResults').attr('disabled', 'disabled'); //disable clear button
            this.$('.clearDNBResults').removeClass('enabled');
            this.$('.clearDNBResults').addClass('disabled');
            this.companyList = null;
            var balParams = {
                'KeywordText': searchString
            };
            this.balParams = balParams;
            this.baseAccountsBAL(this.setApiPaginationParams(balParams), this.renderCompanyList);
        }
    },

    /**
     * Clear D&B Search Results
     */
    clearDNBResults: function() {
        this.$('table#dnb_company_list').empty();
        this.template = app.template.get(this.name + '.dnb-search-hint');
        this.render();
    },

    /**
     * Event handler for handling clicks on D&B Search Results
     * @param  {Object} evt
     */
    dunsClickHandler: function(evt) {
        var duns_num = evt.target.id;
        this.dnbProduct = null;
        if (duns_num) {
            this.template = app.template.get(this.name + '.dnb-company-details');
            this.render();
            this.$('div#dnb-company-detail-loading').show();
            this.$('div#dnb-company-details').hide();
            this.$('.importDNBData').hide();
            this.baseCompanyInformation(duns_num, this.compInfoProdCD.std,
            app.lang.get('LBL_DNB_BACK_TO_SRCH'), this.renderCompanyDetails);
        }
    },


    /**
     * Renders the dnb company details with checkboxes
     * @param {Object} companyDetails
     */
    renderCompanyDetails: function(companyDetails) {
        if (this.disposed) {
            return;
        }
        this.dnbProduct = {};
        if (companyDetails.product) {
            var duns_num = this.getJsonNode(companyDetails.product, this.appendSVCPaths.duns);
            if (!_.isUndefined(duns_num)) {
                this.duns_num = duns_num;
                this.dnbProduct.product = this.formatCompanyInfo(companyDetails.product, this.accountsDD);
            }
        }
        if (companyDetails.errmsg) {
            this.dnbProduct.errmsg = companyDetails.errmsg;
        }
        this.render();
        this.$('div#dnb-company-detail-loading').hide();
        this.$('div#dnb-company-details').show();
        if (this.dnbProduct.errmsg) {
            this.$('.importDNBData').hide();
        } else {
            this.$('.importDNBData').show();
        }
    },

    /**
     * Import Account Information
     */
    importAccount: function() {
        this.importAccountsData(this.importFlag);
        this.importFlag = true;
    },

    /**
     * Checkbox change event handler
     */
    importCheckBox: function() {
        var dnbCheckBoxes = this.$('.dnb_checkbox:checked');
        this.$('.importDNBData').toggleClass('disabled', dnbCheckBoxes.length === 0);
    }
})
