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
 * @class View.Views.Base.DnbCompanyInfoView
 * @alias SUGAR.App.view.views.BaseCompanyInfoView
 * @extends View.Views.Base.DnbView
 */
({
    extendsFrom: 'DnbView',
    statesList: '',
    countryList: '',
    duns_num: null,
    selectedCountry: 'Country',
    companyList: null,
    //data dictionary from cleanse match
    cleanseMatchDD: null,
    compInfoConst: {
        'responseCode' : 'GetCleanseMatchResponse.TransactionResult.ResultID',
        'responseMsg' : 'GetCleanseMatchResponse.TransactionResult.ResultText',
        'cmCandidates' : 'GetCleanseMatchResponse.GetCleanseMatchResponseDetail.MatchResponseDetail.MatchCandidate',
        'cmMaxCount' : 100
    },
    events: {
        'click a.dnb-company-name': 'dunsClickHandler',
        'click .importDNBData': 'importDNBData',
        'click .dnb_checkbox': 'importCheckBox',
        'change #countryList': 'changeState',
        'change #stateList': 'validateMatchParams',
        'click .backToList' : 'backToCompanyList',
        'click [data-action="backToImportEnrich"]': 'backToImportEnrich',
        'click [data-action="dnb-lookup"]': 'dnbSearch',
        'click [data-action="dnb-match"]': 'invokeCMRequest',
        'click [data-action="show-more"]': 'invokePagination'
    },
    selectors: {
        'load': 'div#dnb-company-list-loading',
        'rslt': 'div#dnb-company-list',
        'rsltList': 'ul#dnb-results-list'
    },

    /**
     * Init dashlet settings
     */
    initDashlet: function() {
        this._super('initDashlet');
        var pagesz = this.settings.get('pagesz');
        if (_.isUndefined(pagesz)){
            pagesz = 10;
        } else {
            this.pagesz = parseInt(pagesz, 10);
        }
        this.settings.set('pagesz', pagesz);
        this.initPaginationParams(this.pagesz);
    },

    initialize: function(options) {
        this._super('initialize', [options]);
        if (this.layout.collapse) {
            this.layout.collapse(true);
        }
        this.layout.on('dashlet:collapse', this.loadImportEnrich, this);
        app.events.register('dnbcompinfo:duns_selected', this);
        app.events.register('dnbcompinfo:industry_code', this);
        this.statesList = app.lang.getAppListKeys('dnb_states_iso');
        this.countryList = app.lang.getAppListKeys('dnb_countries_iso');
        //initializing the data dictionary for cleanse match
        this.cleanseMatchDD = this.searchDD;
        this.cleanseMatchDD.confidenceCode = { 'json_path' : 'MatchQualityInformation.ConfidenceCodeValue' };
        this.rowTmpl = app.template.get('dnb.dnb-account-row');
    },

    /**
     * Refresh dashlet
     */
    refreshClicked: function() {
        this.initPaginationParams(this.pagesz);
        this.loadImportEnrich(false);
    },

    /**
     * Handles the dashlet expand | collapse events
     * @param  {Boolean} isCollapsed
     */
    loadImportEnrich: function(isCollapsed) {
        if (this.disposed) {
            return;
        }

        //if the dashlet is not collapsed load data from D&B
        if (!isCollapsed) {
            var errTmpl = this.name + '.dnb-no-duns';
            this.loadDNBData('duns_num', null, this.getCompInfo, null, errTmpl, 'dnb.dnb-no-duns-field');
                    this.renderDropDowns();
        } else {
            this.toggleImportBtn(false, 'dnb_import');
        }
    },

    /**
     * render country and stste drop downs
     */
    renderDropDowns: function() {
        this.$('#countryList').select2({
            placeholder: app.lang.get('LBL_DNB_SLCT_CTRY'),
            data: this.populateCountry(),
            containerCss: {'width': '80%'}
        });
        this.$('#stateList').select2({
            placeholder: app.lang.get('LBL_DNB_SLCT_STATE'),
            data: this.populateState(this.selectedCountry),
            containerCss: {'width': '80%'}
        });
    },

    /**
     * Redirects from the search results or cleanse match results
     * Back to the import and enrich screen
     */
    backToImportEnrich: function() {
        if (this.disposed) {
            return;
        }
        this.template = app.template.get(this.name + '.dnb-no-duns');
        this.render();
        this.renderDropDowns();
    },

    /**
     * Gets the company information duns_num
     * @param {String} duns_num
     */
    getCompInfo: function(duns_num) {
        if (this.disposed) {
            return;
        }
        this.template = app.template.get(this.name + '.dnb-company-details');
        this.render();
        this.$('div#dnb-company-detail-loading').show();
        this.$('div#dnb-company-details').hide();
        this.baseCompanyInformation(duns_num, this.compInfoProdCD.std, null, this.renderCompanyDetails);
    },

    /**
     * Performs refresh check when the dashlet is loaded
     * @param {Array} options
     */
    loadData: function(options) {
        if (this.model.get('duns_num')) {
            this.duns_num = this.model.get('duns_num');
        }
    },

    /**
     * Renders the company list when the back button is clicked
     */
    backToCompanyList: function() {
        if (this.disposed) {
            return;
        }
        var dupeCheckParams = {
            'type': 'duns',
            'apiResponse': this.currentPage,
            'module': 'dunsPage'
        };
        if (!_.isUndefined(this.currentPage[0].confidenceCode)) {
            this.template = app.template.get(this.name + '.dnb-cm-results');
        } else {
            this.template = app.template.get(this.name + '.dnb-company-list');
        }
        this.resultTemplate = this.template
        this.render();
        this.$(this.selectors.load).toggleClass('hide', false);
        this.$(this.selectors.rslt).toggleClass('hide', true);
        var targetFields = ['dnb_import', 'data_valid_ind'];
        _.each(targetFields, function(fieldName) {
            if (!_.isUndefined(this.layout.getComponent('dashlet-toolbar').getField(fieldName))) {
                this.layout.getComponent('dashlet-toolbar').getField(fieldName).getFieldElement().hide();
            }
        }, this);
        this.baseDuplicateCheck(dupeCheckParams, this.renderPage);
    },

    /**
     * Render search and cleanse match results
     * @param {Array} dnbApiResponse list of companies from dnb search / match api
     */
    renderCompanyList: function(dnbApiResponse) {
        var dnbCompanyList = {},
            appendRecords = false;
        if (this.resetPaginationFlag) {
            this.initPaginationParams(this.pagesz);
        }
        if (dnbApiResponse.product) {
            var apiCompanyList;
            if (dnbApiResponse.product.GetCleanseMatchResponse) {
                this.resultTemplate = app.template.get(this.name + '.dnb-cm-results');
                apiCompanyList = this.getJsonNode(dnbApiResponse.product, this.compInfoConst.cmCandidates);
                this.formattedRecordSet = this.formatSrchRslt(apiCompanyList, this.cleanseMatchDD);
                this.formattedRecordSet = this.formatConfidenceCodes(this.formattedRecordSet);
                this.recordCount = this.getJsonNode(dnbApiResponse.product, this.commonJSONPaths.cmCount);
                this.paginationCallback = null;
            } else {
                this.resultTemplate = app.template.get(this.name + '.dnb-company-list');
                apiCompanyList = this.getJsonNode(dnbApiResponse.product, this.commonJSONPaths.srchRslt);
                this.formattedRecordSet = this.formatSrchRslt(apiCompanyList, this.searchDD);
                this.recordCount = this.getJsonNode(dnbApiResponse.product, this.commonJSONPaths.srchCount);
                this.paginationCallback = this.baseAccountsBAL;
            }
            var nextPage = this.paginateRecords();
            //currentPage is set to null by initPaginationParams
            if (_.isNull(this.currentPage)) {
                this.currentPage = nextPage;
                dnbCompanyList.product = this.currentPage;
            } else {
                //this loop gets executed when api is called again to obtain more records
                dnbCompanyList.product = nextPage;
                appendRecords = true;
            }
        } else if (dnbApiResponse.errmsg) {
            dnbCompanyList.errmsg = dnbApiResponse.errmsg;
        }
        this.renderPage(dnbCompanyList, appendRecords);
    },

    /**
     * Overriding the renderPage in base dashlet
     * @param {Object} pageData
     * @param {Boolean} append boolean to indicate if records need to be appended to exsiting list
     */
    renderPage: function(pageData, appendRecords) {
        this._super('renderPage', [pageData, appendRecords]);
        //if the pagination controls are not displayed then
        //display the back to import enrich link for cleanse match and for keyword search
        if (this.recordCount <= this.endRecord) {
            this.$('#dnb-page-ctrl').toggleClass('hide', false);
            this.$('[data-action="show-more"]').addClass('hide');
            this.$('.loading').hide();
        }
        this.toggleImportBtn(false, 'dnb_import');
    },

    /**
     * Invokes D&B Search API based on the company name
     */
    dnbSearch: function() {
        this.currentPage = null;
        this.initPaginationParams(this.pagesz);
        if (this.disposed) {
            return;
        }
        var companyName = this.model.get('name');
        if (companyName) {
            this.template = app.template.get(this.name + '.dnb-company-list');
            this.render();
            this.$(this.selectors.load).toggleClass('hide', false);
            this.$(this.selectors.rslt).toggleClass('hide', true);
            this.companyList = null;
            var balParams = {
                'KeywordText': companyName
            };
            //setting balParams to context because we want to retain the api parameters
            //without the pagination related parameters
            this.balParams = balParams;
            this.baseAccountsBAL(this.setApiPaginationParams(balParams), this.renderCompanyList);
        }
    },

    /**
     * Event handler for handling clicks on D&B Search Results
     * @param {Object} evt
     */
    dunsClickHandler: function(evt) {
        if (this.disposed) {
            return;
        }
        var duns_num = evt.target.id;
        if (duns_num) {
            this.template = app.template.get(this.name + '.dnb-company-details');
            this.render();
            this.$('div#dnb-company-detail-loading').show();
            this.$('div#dnb-company-details').hide();
            this.trigger('dnbcompinfo:duns_selected', duns_num);
            this.baseCompanyInformation(duns_num, this.compInfoProdCD.lite, null, this.renderCompanyDetails);
        }
    },

    /**
     * Renders the dnb company details with chechboxes
     * @param {Object} companyDetails -- dnb api response for company details
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
                app.controller.context.set('dnb_temp_duns_num', this.duns_num);
                this.dnbProduct.product = this.formatCompanyInfo(companyDetails.product, this.accountsDD);
                this.dnbProduct.product = this.getDataIndicators(this.accountsDD, this.dnbProduct.product);
                var industryCodeArray = this.getJsonNode(companyDetails.product, this.appendSVCPaths.industry);
                if (!_.isUndefined(industryCodeArray)) {
                    //extracting the primary hoovers industry code and passing it on
                    //to the industry info dashlet
                    //25838 indicates hoovers industry code
                    //if the DisplaySequence == 1
                    //it indicates that the industry code is the primary hoovers industry code
                    var industryObj = this.getPrimaryIndustry(industryCodeArray, 25838);
                    var hooversIndustryCode = this.getJsonNode(industryObj, 'IndustryCode.$'),
                        hooversTypeCode = industryObj['@DNBCodeValue'];
                    if (!_.isUndefined(hooversIndustryCode) && !_.isUndefined(hooversTypeCode)) {
                        app.controller.context.set('dnb_temp_hoovers_ind_code', hooversIndustryCode + '-' + hooversTypeCode);
                    }
                }
                //check if there are any new data
                var newDataElementsArray = _.filter(this.dnbProduct.product, function(dataElement) {
                    return dataElement.dataInd === 'new' || dataElement.dataInd === 'upd';
                });
                //if there are no new data elements then display
                // message that the company information is up to date
                if (newDataElementsArray.length === 0) {
                    this.dnbProduct.product = null;
                    this.dnbProduct.errmsg = app.lang.get('LBL_DNB_UPTODATE_MSG');
                } else {
                    this.toggleImportBtn('dnb_import', true);
                }
            }
        } else if (companyDetails.errmsg) {
            this.dnbProduct.errmsg = companyDetails.errmsg;
        }
        this.template = app.template.get(this.name + '.dnb-company-details');
        if (!this.model.get('duns_num')) {
            this.dnbProduct.isNotLinked = true;
        }
        this.render();
        this.$('div#dnb-company-detail-loading').hide();
        this.$('div#dnb-company-details').show();
        this.importCheckBox();
    },

    /**
     * Populates the stare and compare screen with duplicate / upload indicators
     * @param   {Object} accountsDD accounts data dictionary
     * @param   {Object} frmtCompInfo formatted company info
     * @return  {Object} formatted company info with data indicators
     */
    getDataIndicators: function(accountsDD, frmtCompInfo) {
        var accountsModel = this.model;
        _.each(frmtCompInfo, function(dataObj) {
            var sugarColumnName = dataObj.dataName;
            var dnbDataElement = dataObj.dataElement,
                sugarDataElement = accountsModel.get(sugarColumnName);
            if (dnbDataElement && sugarDataElement) {
                dnbDataElement = $.trim(dnbDataElement);
                sugarDataElement = $.trim(sugarDataElement);
                if (sugarDataElement == dnbDataElement) {
                    dataObj.dataInd = 'dup';
                } else if (sugarDataElement != dnbDataElement) {
                    dataObj.dataInd = 'upd';
                }
            } else if (dnbDataElement) {
                dataObj.dataInd = 'new';
            }
        },this);
        return frmtCompInfo;
    },

    /**
     * Populates the stare and compare screen with duplicate / upload indicators
     */
    importCheckBox: function() {
        var dnbCheckBoxes = $('.dnb_checkbox:checked');
        if (dnbCheckBoxes.length > 0) {
            this.toggleDashletBtn(true, 'dnb_import');
        } else {
            this.toggleDashletBtn(false, 'dnb_import');
        }
    },

    /**
     * Populate the countries drop down
     * @return {Array}
     */
    populateCountry: function() {
        var countryOptionsArray = [];
        _.each(this.countryList, function(element, index) {
            countryOptionsArray.push({
                id: index,
                text: element
            });
        });
        return countryOptionsArray;
    },

    /**
     * Populate the states drop down based on the country selected
     * @param  {String} selectedCountry country iso-code
     * @return {Array}
     */
    populateState: function(selectedCountry) {
        // Initialize the array of states that will populate the dropdown
        var stateOptionsArray = [];

        // Get the full states array from the app list strings
        var statesArray = app.lang.getAppListStrings('dnb_states_iso');

        // Grab the selected country code, since the states array is based on
        // country code
        var selectedCountryCode = this.countryList[selectedCountry];

        // Now build the states array properly, from the right states
        var state_arr = statesArray[selectedCountryCode];
        if (selectedCountry !== 'Country' && !_.isUndefined(state_arr)) {
            _.each(state_arr, function(element, index) {
                stateOptionsArray.push({
                    id: state_arr[index].code,
                    text: state_arr[index].name
                });
            });
        }
        return stateOptionsArray;
    },

    /**
     * Changes the states drop down based on the country selection
     */
    changeState: function() {
        this.selectedCountry = this.$('#countryList').val();
        //disable match button
        this.$('#dnb-match-btn').addClass('disabled');
        this.$('#countryList').select2('val', this.selectedCountry);
        this.$('#stateList').select2({
            placeholder: app.lang.get('LBL_DNB_SLCT_STATE'),
            data: this.populateState(this.selectedCountry),
            containerCss: {'width': '80%'}
        });
    },

    /**
     * validate if all the parameters for cleanse and match are available
     enable the match btn
     */
    validateMatchParams: function() {
        var accountName = this.model.get('name');
        if (!_.isUndefined(accountName) && this.$('#countryList').val() !== 'Country' && this.$('#statesList').val() !== 'State') {
            this.$('#dnb-match-btn').removeClass('disabled');
        }
    },

    /**
     * Invoke CleanseMatch
     * It is a D&B API the cleanse the company name addresses and provides a response
     * with possible matches
     * @param {Object} evt
     */
    invokeCMRequest: function(evt) {
        this.currentPage = null;
        this.initPaginationParams(this.pagesz);
        if (this.disposed) {
            return;
        }
        if (!$(evt.target).hasClass('disabled')) {
            var self = this,
                townName = this.model.get('billing_address_city'),
                zipCode = this.model.get('billing_address_postalcode');
            var cmRequestParams = {
                'IncludeCleansedAndStandardizedInformationIndicator' : 'true', //mandatory
                'CountryISOAlpha2Code' : this.$('#countryList').val(), //country code mandatory
                'cleansematch' : 'true',//mandatory
                'SubjectName' : this.model.get('name'), //company name mandatory
                'TerritoryName' : this.$('#stateList').val() //optional
            };
            if (townName) {
                cmRequestParams.PrimaryTownName = townName;
            }
            if (zipCode) {
                cmRequestParams.FullPostalCode = zipCode;
            }
            //setting the maximum # of results to be returned by cleanse match call
            cmRequestParams.CandidateMaximumQuantity = this.compInfoConst.cmMaxCount;
            self.template = app.template.get(self.name + '.dnb-cm-results');
            self.render();
            self.$(self.selectors.load).toggleClass('hide', false);
            self.$(self.selectors.rslt).toggleClass('hide', true);
            var dnbCMRequestURL = app.api.buildURL('connector/dnb/cmRequest', '', {},{});
            var cmResults = {'product': null, 'errmsg': null};
            app.api.call('create', dnbCMRequestURL, {'qdata': cmRequestParams}, {
                success: function(data) {
                    var responseCode = self.getJsonNode(data, self.compInfoConst.responseCode),
                        responseMsg = self.getJsonNode(data, self.compInfoConst.responseMsg);
                    if (responseCode && responseCode === self.responseCodes.success) {
                        cmResults.companies = self.getJsonNode(data, self.compInfoConst.cmCandidates);
                        cmResults.product = data;
                    } else {
                        cmResults.errmsg = responseMsg || app.lang.get('LBL_DNB_SVC_ERR');
                    }
                    self.renderCompanyList(cmResults);
                },
                error: _.bind(self.checkAndProcessError, self)
            });
        }
    },

    /**
     * Format confidence codes
     * @param  {Array} dnbCompanyList
     * @return {Array} dnbCompanyList formatted
     */
    formatConfidenceCodes: function(dnbCompanyList) {
        _.each(dnbCompanyList, function(compObj) {
            var confidenceCode = compObj.confidenceCode,
                matchMeta = {};
            if (confidenceCode >= 8) {
                matchMeta.confClass = 'label-success';
                matchMeta.confText = app.lang.get('LBL_DNB_HIGH_CONF');
            } else if (confidenceCode === 7 || confidenceCode === 6) {
                matchMeta.confClass = 'label-warning';
                matchMeta.confText = app.lang.get('LBL_DNB_MED_CONF');
            } else if (confidenceCode < 6) {
                matchMeta.confClass = 'label-important';
                matchMeta.confText = app.lang.get('LBL_DNB_LOW_CONF');
            }
            compObj.matchMeta = matchMeta;
        },this);
        return dnbCompanyList;
    },

    /**
     * Event handler for pagination controls
     */
    invokePagination: function() {
        if (!_.isUndefined(this.currentPage[0].confidenceCode)) {
            //invoking client side pagination alone for cleanse match
            this._super('invokePagination', [null, null, this.renderCompanyList]);
        } else {
            //invoking client and server side pagination for account search
            this._super('invokePagination', [this.baseAccountsBAL, this.balParams, this.renderCompanyList]);
        }

    }
});
