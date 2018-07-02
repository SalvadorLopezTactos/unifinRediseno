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
        'click [data-action="show-more"]': 'invokePagination',
        'click .bulkImport': 'bulkImport',
        'change .dnb-bi-chk': 'importCheckBox',
        'change [name="dnb-bi-slctall"]': 'selectRecords'
    },

    selectors: {
        'load': '#dnb-bal-result-loading',
        'rslt': '#dnb-bal-result',
        'rsltList': 'ul#dnb-results-list'
    },

    /*
     * @property {Boolean} for check box selects
     */
    selectAll: true,

    /*
     * @property {Object} balAcctDD Data Dictionary For D&B BAL Response
     */
    balAcctDD: null,

    //limit on the max # of records that can be bulk imported
    bulkImportLimit: 20,

    /**
     * @override
     * @param {Object} options
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.initDD();
        this.initDashlet();
        this.paginationCallback = this.baseAccountsBAL;
        this.rowTmpl = app.template.getView(this.name + '.dnb-account-row', this.module);
        this.resultTemplate = app.template.getView(this.name + '.dnb-bal-acct-rslt', this.module);
        this.resultCountTmpl = app.lang.get('LBL_DNB_BAL_ACCT_HEADER');
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
        this.template = this.resultTemplate;
        if (this.listData && this.listData.count) {
            delete this.listData['count'];
        }
        this.render();
        this.$(this.selectors.load).removeClass('hide');
        this.$(this.selectors.rslt).addClass('hide');
        this.toggleButton(true, '.bulkImport');
        this.baseAccountsBAL(balParams, this.renderBAL);
    },

    /**
     * Render BAL Accounts results
     * @param {Object} dnbBalApiRsp BAL API Response
     */
    renderBAL: function(dnbBalApiRsp) {
        var dnbBalRslt = {},
            appendRecords = false;
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
            var nextPage = this.paginateRecords();
            //currentPage is set to null by initPaginationParams
            if (_.isNull(this.currentPage)) {
                this.currentPage = nextPage;
                dnbBalRslt.product = this.currentPage;
            } else {
                //this loop gets executed when api is called again to obtain more records
                dnbBalRslt.product = nextPage;
                appendRecords = true;
            }
            if (this.recordCount) {
                dnbBalRslt.count = this.recordCount;
            }
        } else if (dnbBalApiRsp.errmsg) {
            dnbBalRslt.errmsg = dnbBalApiRsp.errmsg;
        }
        this.renderPage(dnbBalRslt, appendRecords);
    },

    /**
     * @override
     * Renders the currentPage
     * @param {Object} pageData
     * @param {Boolean} append boolean to indicate if records need to be appended to existing list
     */
    renderPage: function(pageData, append) {
        var slctRecCnt;
        //if selectAll flag is true
        //then limit the # of selected records to be 20
        if (this.selectAll) {
            //if append is false
            //select all records
            if (append) {
                //get the # of selected records via selectors
                slctRecCnt = this.$('.dnb-bi-chk:checked').length;
            } else {
                slctRecCnt = 0;
            }
            _.each(pageData.product, function(balRsltObj) {
                //once this.bulkImportLimit is reached exit the function
                if(slctRecCnt >= this.bulkImportLimit) {
                    return;
                }
                //if balRsltObj is not a dupe then set the isSelected to true
                //is selected defines if the checkbox is selected or not
                if (_.isUndefined(balRsltObj.isDupe) && slctRecCnt < this.bulkImportLimit) {
                    balRsltObj.isSelected = true;
                    slctRecCnt++;
                } else {
                    balRsltObj.isSelected = false;
                }
            }, this);
        } else {
            _.each(pageData.product, function(balRsltObj) {
                balRsltObj.isSelected = false;
            }, this);
            slctRecCnt = 0;
        }
        //call the base renderPage function
        this._super('renderPage', [pageData, append]);
        //decide on the state of select all button
        //disable import button if selected record count is 0
        var disableImportBtn = slctRecCnt === 0;
        if (this.selectAll && disableImportBtn) {
            this.selectAll = false;
            this.$('[name="dnb-bi-slctall"]').prop('checked', false);
        }
        //decide on the state of import button
        this.toggleButton(disableImportBtn, '.bulkImport');
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
            this.baseCompanyInformation(duns_num, this.compInfoProdCD.lite, app.lang.get('LBL_DNB_BAL_LIST'), this.renderCompanyDetails);
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
        dnbFirmo.backToListLabel = companyDetails.backToListLabel;
        //if there are no company details then get the erroe message
        if (companyDetails.errmsg) {
            dnbFirmo.errmsg = companyDetails.errmsg;
        } else if (companyDetails.product) {
            formattedFirmographics = this.formatCompanyInfo(companyDetails.product, this.accountsDD);
            dnbFirmo.product = formattedFirmographics;
            this.currentCompany = companyDetails.product;
        }
        this.dnbFirmo = dnbFirmo;
        this.render();
        // hide / show importDNBData button
        this.$('.importDNBData').toggleClass('hide', !_.isUndefined(this.dnbFirmo.errmsg));
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
        if (this.listData && this.listData.count) {
            delete this.listData['count'];
        }
        this.template = app.template.getView(this.name + '.dnb-bal-acct-rslt', this.module);
        this.render();
        this.$(this.selectors.load).removeClass('hide');
        this.$(this.selectors.rslt).addClass('hide');
        this.toggleButton(true, '.bulkImport');
        var dupeCheckParams = {
            'type': 'duns',
            'apiResponse': this.currentPage,
            'module': 'dunsPage'
        };
        this.baseDuplicateCheck(dupeCheckParams, this.renderPage);
    },

    /**
     * bulkImports accounts
     */
    bulkImport: function() {
        var selectedDuns = this.$('.dnb_checkbox:checked').map(function() {
            return this.name;
        });
        if (!_.isUndefined(selectedDuns) && selectedDuns.length > 0) {
            this.toggleButton(true, '.bulkImport');
            //filter the selectedDUNS from the this.dnbBalRslt.product
            var recToImport = this.currentPage.filter(function(rsltObj) {
                if(_.contains(selectedDuns, rsltObj.duns_num)) {
                    return rsltObj;
                }
            }).map(function(rsltObj) {
               return {
                   'name': rsltObj.name,
                   'duns_num': rsltObj.duns_num
               }
            });
            if (!_.isUndefined(recToImport) && recToImport.length > 0) {
                //invoke the bulk import api
                this.invokeBulkImport(recToImport, this.module, this.backToCompanyList);
            }
        } else {
            //display warning that no records were selected
            app.alert.show('dnb-import', {
                level: 'warning',
                title: app.lang.get('LBL_WARNING') + ':',
                messages: app.lang.get('LBL_DNB_BI_NO_SLCT'),
                autoClose: true
            });
        }
    },

    /**
     * Sees to it that only the # of records specified in bulkImportLimit are allowed to be checked
     * if # of checkboxes selected is 0 then disable the import button
     */
    importCheckBox: function(evt) {
        var dnbCheckBoxes = this.$('.dnb-bi-chk:checked');
        var isChecked = this.$(evt.currentTarget).prop('checked');
        //if # of selected records exceeds the bulkImportLimit display error message
        if (isChecked && dnbCheckBoxes.length > this.bulkImportLimit) {
            this.$(evt.currentTarget).prop('checked', false);
            app.alert.show('dnb-import', {
                level: 'warning',
                title: app.lang.get('LBL_WARNING') + ':',
                messages: app.lang.get('LBL_DNB_BI_REC_LIMIT'),
                autoClose: true
            });
        }
        this.toggleButton(dnbCheckBoxes.length === 0, '.bulkImport');
    },

    /**
     * Select / Unselect all records
     * @param {Object} evt
     */
    selectRecords: function(evt) {
        this.selectAll = this.$(evt.currentTarget).prop('checked');
        var slctCnt = 0;
        if (this.selectAll) {
            _.each(this.$('.dnb-bi-chk'), function(chkBox) {
                if (!this.$(chkBox).prop('disabled') && slctCnt < this.bulkImportLimit) {
                    this.$(chkBox).prop('checked', true);
                    slctCnt++;
                }
            }, this);
            this.toggleButton(slctCnt === 0, '.bulkImport');
        } else {
            this.$('.dnb-bi-chk').prop('checked', false);
            //disable the import button
            this.toggleButton(true, '.bulkImport');
        }
    }
})
