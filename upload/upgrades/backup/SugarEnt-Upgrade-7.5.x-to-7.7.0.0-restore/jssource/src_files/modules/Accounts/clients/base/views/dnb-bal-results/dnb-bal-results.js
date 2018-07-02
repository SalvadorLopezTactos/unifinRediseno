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
    extendsFrom: 'DnbBalResultsView',

    events: {
        'click .importDNBData': 'importDNBData',
        'click a.dnb-company-name': 'getCompanyDetails',
        'click .backToList' : 'backToCompanyList',
        'click [data-action="show-more"]': 'invokePagination'
    },

    selectors: {
        'load': '#dnb-bal-result-loading',
        'rslt': '#dnb-bal-result'
    },

    /*
     * @property {Object} balAcctDD Data Dictionary For D&B BAL Response
     */
    balAcctDD: null,

    /**
     * @override
     * @param {Object} options
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.initDD();
        this.initDashlet();
        this.paginationCallback = this.baseAccountsBAL;
    },

    /**
     * Initialize the bal data dictionary
     */
    initDD: function() {
        this.balAcctDD = {
            'name': this.searchDD.companyname,
            'duns_num': this.searchDD.duns_num,
            'billing_address_street': this.searchDD.streetaddr,
            'billing_address_city': this.searchDD.town,
            'billing_address_state': this.searchDD.territory,
            'billing_address_country': this.searchDD.ctrycd,
            'recordNum': {
                'json_path': 'DisplaySequence'
            }
        };
        this.balAcctDD.locationtype = this.searchDD.locationtype;
        this.balAcctDD.isDupe = this.searchDD.isDupe;
    },

    loadData: function(options) {
        this.checkConnector('ext_rest_dnb',
            _.bind(this.loadDataWithValidConnector, this),
            _.bind(this.handleLoadError, this),
            ['test_passed']);
    },

    /**
     * Overriding the render function from base bal results render function
     */
    _render: function() {
        //TODO: Investigate why using this._super('_renderHtml');
        //we get Unable to find method _renderHtml on parent class of dnb-bal-results
        app.view.View.prototype._renderHtml.call(this);
    },

    /**
     * Build a list of accounts
     * @param {Object} balParams
     */
    buildAList: function(balParams) {
        if (this.disposed) {
            return;
        }
        this.template = app.template.getView(this.name + '.dnb-bal-acct-rslt', this.module);
        if (this.dnbBalRslt && this.dnbBalRslt.count) {
            delete this.dnbBalRslt['count'];
        }
        this.render();
        this.$(this.selectors.load).removeClass('hide');
        this.$(this.selectors.rslt).addClass('hide');
        this.baseAccountsBAL(balParams, this.renderBAL);
    },

    /**
     * Render BAL Accounts results
     * @param {Object} dnbBalApiRsp BAL API Response
     */
    renderBAL: function(dnbBalApiRsp) {
        var dnbBalRslt = {};
        if (this.resetPaginationFlag) {
            this.initPaginationParams();
        }
        if (dnbBalApiRsp.product) {
            var apiCompanyList = this.getJsonNode(dnbBalApiRsp.product, this.commonJSONPaths.srchRslt);
            //setting the formatted set of records to context
            //will be required when we paginate from the client side itself
            this.formattedRecordSet = this.formatSrchRslt(apiCompanyList, this.balAcctDD);
            //setting the api recordCount to context
            //will be used to determine if the pagination controls must be displayed
            this.recordCount = this.getJsonNode(dnbBalApiRsp.product, this.commonJSONPaths.srchCount);
            this.paginateRecords();
            dnbBalRslt.product = this.currentPage;
            if (this.recordCount) {
                dnbBalRslt.count = this.recordCount;
            }
        } else if (dnbBalApiRsp.errmsg) {
            dnbBalRslt.errmsg = dnbBalApiRsp.errmsg;
        }
        this.renderPage(dnbBalRslt);
    },

    /**
     * Renders the currentPage
     * @param {Object} pageData
     */
    renderPage: function(pageData) {
        if (this.disposed) {
            return;
        }
        this.template = this.template = app.template.getView(this.name + '.dnb-bal-acct-rslt', this.module);
        this.dnbBalRslt = pageData;
        //pageData count is not defined when the page is being rendered after
        //dupe check
        //hence using the count from the context variable
        if (_.isUndefined(pageData.count)) {
            pageData.count = this.recordCount;
        }
        //if the api returns a success response then only set the count
        if (pageData.product) {
            this.dnbBalRslt.count = app.lang.get('LBL_DNB_BAL_ACCT_HEADER') + " (" + this.formatSalesRevenue(pageData.count) + ")";
        } else {
            delete this.dnbBalRslt['count'];
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
     * Gets D&B Company Details For A DUNS number
     * DUNS number is stored as an id in the anchor tag
     * @param {Object} evt
     */
    getCompanyDetails: function(evt) {
        if (this.disposed) {
            return;
        }
        var duns_num = evt.target.id;
        if (duns_num) {
            this.template = app.template.getView(this.name + '.dnb-company-details', this.module);
            this.render();
            this.$('div#dnb-company-details').hide();
            this.$('.importDNBData').hide();
            this.baseCompanyInformation(duns_num, this.compInfoProdCD.std, app.lang.get('LBL_DNB_BAL_LIST'), this.renderCompanyDetails);
        }
    },

    /**
     * Renders the dnb company details for adding companies from dashlets
     * Overriding the base dashlet function
     * @param {Object} companyDetails dnb api response for company details
     */
    renderCompanyDetails: function(companyDetails) {
        if (this.disposed) {
            return;
        }
        var formattedFirmographics, dnbFirmo = {};
        //if there are no company details hide the import button
        if (companyDetails.errmsg) {
            this.$('.importDNBData').hide();
        } else if (companyDetails.product) {
            this.$('.importDNBData').show();
            formattedFirmographics = this.formatCompanyInfo(companyDetails.product, this.accountsDD);
            dnbFirmo.product = formattedFirmographics;
            dnbFirmo.backToListLabel = companyDetails.backToListLabel;
            this.currentCompany = companyDetails.product;
        }
        this.dnbFirmo = dnbFirmo;
        this.render();
        this.$('div#dnb-company-detail-loading').hide();
        this.$('div#dnb-company-details').show();
    },

    /**
     * navigates users from company details back to results pane
     */
    backToCompanyList: function() {
        if (this.disposed) {
            return;
        }
        if (this.dnbBalRslt && this.dnbBalRslt.count) {
            delete this.dnbBalRslt['count'];
        }
        this.template = app.template.getView(this.name + '.dnb-bal-acct-rslt', this.module);
        this.render();
        this.$(this.selectors.load).removeClass('hide');
        this.$(this.selectors.rslt).addClass('hide');
        var dupeCheckParams = {
            'type': 'duns',
            'apiResponse': this.currentPage,
            'module': 'dunsPage'
        };
        this.baseDuplicateCheck(dupeCheckParams, this.renderPage);
    }
})
