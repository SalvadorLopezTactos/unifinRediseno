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

    selectors: {
        'load': 'div#dnb-company-list-loading',
        'rslt': 'div#dnb-search-results',
        'rsltList': 'ul#dnb-results-list'
    },

    configuredKey: 'dnb:account:create:configured',

    initialize: function(options) {
        this._super('initialize', [options]);
        this.initDashlet();
        this.loadData();
        this.initPaginationParams();
        this.rowTmpl = app.template.get('dnb.dnb-account-row');
        this.resultTemplate = app.template.get(this.name);
        this.resultCountTmpl = app.lang.get('LBL_DNB_BAL_ACCT_HEADER');
    },

    loadData: function() {
        if (this.disposed) {
            return;
        }
        this.template = app.template.get(this.name + '.dnb-search-hint');
        this.render();
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
        // call .off first because loadDataWithValidConnector is called twice on account-create
        // we don't want to set the event listener twice
        this.context.off('update:account').on('update:account', this.dnbSearch, this);
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
        this.context.off('update:account', this.dnbSearch);
    },

    /**
     * Navigates from the company details screen to the search results screen
     */
    backToCompanyList: function() {
        if (this.disposed) {
            return;
        }
        this.template = this.resultTemplate;
        if (this.listData && this.listData.count) {
            delete this.listData['count'];
        }
        this.render();
        this.$(this.selectors.load).toggleClass('hide', false);
        this.$(this.selectors.rslt).toggleClass('hide', true);
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
        var dnbSrchResults = {},
            appendRecords = false;
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
            var nextPage = this.paginateRecords();
            //currentPage is set to null by initPaginationParams
            if (_.isNull(this.currentPage)) {
                this.currentPage = nextPage;
                dnbSrchResults.product = this.currentPage;
            } else {
                //this loop gets executed when api is called again to obtain more records
                dnbSrchResults.product = nextPage;
                appendRecords = true;
            }
            if (this.recordCount) {
                dnbSrchResults.count = this.recordCount;
            }
        } else if (dnbSrchApiResponse.errmsg) {
            dnbSrchResults.errmsg = dnbSrchApiResponse.errmsg;
        }
        this.renderPage(dnbSrchResults, appendRecords);
    },

    /**
     * Event handler for pagination controls
     * Renders next page from context if available
     * else invokes the D&B API to get the next page
     */
    invokePagination: function() {
        this._super('invokePagination', [this.baseAccountsBAL, this.balParams, this.renderCompanyList]);
    },

    /** event listener for keyup / autocomplete feature
     */
    dnbSearch: function() {
        if (this.disposed) {
            return;
        }

        //Value of input in name field
        var searchString = this.closestComponent('sidebar').getComponent('main-pane').$('[data-fieldname=name] input').val()

        //only search if the searchString is at least 3 characters
        if (!searchString || searchString.length < 3) {
            return;
        }

        if (!this.keyword || (this.keyword && this.keyword !== searchString)) {
            this.keyword = searchString;
            this.template = this.resultTemplate;
            //deleting the count of the previous search results
            if (this.listData && this.listData.count) {
                delete this.listData['count'];
            }
            this.render();
            this.$('table#dnb_company_list').empty(); //empty results table
            this.$(this.selectors.load).toggleClass('hide', false);
            this.$(this.selectors.rslt).toggleClass('hide', true);
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
            this.baseCompanyInformation(duns_num, this.compInfoProdCD.lite,
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
