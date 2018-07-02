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
 * @class View.Views.Base.DnbFinancialInfoView
 * @alias SUGAR.App.view.views.BaseDnbFinancialInfoView
 * @extends View.Views.Base.DnbView
 */
({
    extendsFrom: 'DnbView',
    duns_num: null,

    events: {
        'click .showMoreData': 'showMoreData',
        'click .showLessData': 'showLessData'
    },

    initialize: function(options) {
        this._super('initialize', [options]);
        if (this.layout.collapse) {
            this.layout.collapse(true);
        }
        this.layout.on('dashlet:collapse', this.loadFinancials, this);
        app.events.on('dnbcompinfo:duns_selected', this.collapseDashlet, this);
        //listen on expand all button click on the dashboard
        this.layout.layout.context.on('dashboard:collapse:fire', this.loadFinancials, this);
    },

    loadData: function(options) {
        if (this.model.get('duns_num')) {
            this.duns_num = this.model.get('duns_num');
        }
    },

    /**
     * D&B Finncial Response Data Dictionary
     * json_path -- refers to the json path to traverse to obtain the data element
     * label -- refers to the label to be used to name the data element
     * desc -- refers to the label used to describe the data element
     * case_fmt -- boolean -- when true specifies that this data element needs to be formatted to proper case
     * sub_array -- refers to meta data for nested json objects
     */
    financialDD: {
        'marketAnalysis' : {
            'json_path' : 'ThirdPartyAssessment.ThirdPartyAssessment.0.ThirdPartyInformation.OtherInformation',
            'label' : 'LBL_DNB_REC_MARK_ANALYSIS'
        },
        'finStmt' : {
            'json_path' : 'Financial.KeyFinancialFiguresOverview',
            'label' : 'LBL_DNB_FIN_STMT',
            'sub_array' : {
                'finStmtDate' : 'StatementHeaderDetails.FinancialStatementToDate.$',
                'salesRevenue' : 'SalesRevenueAmount.0.$',
                'salesUnits' : 'SalesRevenueAmount.0.@UnitOfSize'
            }
        },
        'stckSym' : {
            'json_path' : 'OrganizationDetail.ControlOwnershipTypeText.$',
            'label' : 'LBL_DNB_FIN_COMP_TYPE',
            'sub_array' : {
                'stckDet' : 'RegisteredDetail.StockExchangeDetails'
            }
        }
    },

    finConst: {
        'mktAnalysisPath' : 'OrderProductResponse.OrderProductResponseDetail.Product.Organization.ThirdPartyAssessment.ThirdPartyAssessment.0.ThirdPartyInformation.OtherInformation',
        'finStmtPath' : 'OrderProductResponse.OrderProductResponseDetail.Product.Organization.Financial.KeyFinancialFiguresOverview',
        'stckSymPath' : 'OrderProductResponse.OrderProductResponseDetail.Product.Organization.RegisteredDetail.StockExchangeDetails',
        'ownTypePath' : 'OrderProductResponse.OrderProductResponseDetail.Product.Organization.OrganizationDetail.ControlOwnershipTypeText.$'
    },

    /**
     * Refresh dashlet once Refresh link clicked from gear button
     * To show updated financial information from DNB service
     */
    refreshClicked: function() {
        this.loadFinancials(false);
    },

    /**
     * Handles the dashlet expand | collapse events
     * @param  {Boolean} isCollapsed
     */
    loadFinancials: function(isCollapsed) {
        if (!isCollapsed) {
            //check if account is linked with a D-U-N-S
            this.loadDNBData('duns_num', 'dnb_temp_duns_num', this.getCompanyFinancials, null, 'dnb.dnb-no-duns', 'dnb.dnb-no-duns-field');
        }
    },

    /**
     * Gets D&B Financial Information for the duns_num
     * @param  {String} duns_num
     */
    getCompanyFinancials: function(duns_num) {
        var self = this;
        self.template = app.template.get(self.name);
        if (!self.disposed) {
            self.render();
            self.$('#dnb-financials-loading').show();
            self.$('#dnb-financials-details').hide();
        }
        var cacheKey = 'dnb:financial:' + duns_num;
        if (app.cache.get(cacheKey)) {
            self.renderFinancialDetails.call(self, app.cache.get(cacheKey));
        } else {
            var dnbFinancialsURL = app.api.buildURL('connector/dnb/financial/' + duns_num, '', {},{});
            var resultData = {'product': null, 'errmsg': null};
            app.api.call('READ', dnbFinancialsURL, {},{
                success: function(data) {
                    var responseCode = self.getJsonNode(data, self.appendSVCPaths.responseCode),
                        responseMsg = self.getJsonNode(data, self.appendSVCPaths.responseMsg);
                    if (responseCode && responseCode === self.responseCodes.success) {
                        if (self.isDataExists(data)) {
                            resultData.product = data;
                        } else {
                            resultData.errmsg = app.lang.get('LBL_DNB_NO_DATA');
                        }
                        app.cache.set(cacheKey, resultData);
                    } else {
                        resultData.errmsg = responseMsg || app.lang.get('LBL_DNB_SVC_ERR');
                    }
                    self.renderFinancialDetails.call(self, resultData);
                },
                error: _.bind(self.checkAndProcessError, self)
            });
        }
    },

    /**
     *  to prevent a blank dashlet from being displayed
     * @param {Object} financialDetails dnb financial details json
     * @return {Boolean}
     */
    isDataExists: function(financialDetails) {
        if (!this.checkJsonNode(financialDetails, this.finConst.mktAnalysisPath) &&
            !this.checkJsonNode(financialDetails, this.finConst.annlIncPath) &&
            !this.checkJsonNode(financialDetails, this.finConst.stckSymPath)) {
            return false;
        } else {
            return true;
        }
    },

    /**
     * Renders the financial details
     * @param {Object} financial details
     */
    renderFinancialDetails: function(financialDetails) {
        if (this.disposed) {
            return;
        }
        var formattedFinancials, dnbFin = {};
        if (financialDetails.product) {
            formattedFinancials = this.formatFinancials(financialDetails.product, this.financialDD);
            dnbFin.product = formattedFinancials;
        }
        if (financialDetails.errmsg) {
            dnbFin.errmsg = financialDetails.errmsg;
        }
        this.dnbFin = dnbFin;
        this.render();
        this.$('#dnb-financials-loading').hide();
        this.$('#dnb-financials-details').show();
        this.$('.showLessData').hide();
    },

    /**
     * Preprocessing financial information
     * @param  {Object} dnbApiResponse DNB API Response for Firmographics
     * @param  {Object} financialDD financials data dictionary
     * @return {Object}  to be passed to the hbs file
     */
    formatFinancials: function(dnbApiResponse, financialDD) {
        var frmtFinancials = {};
        var marketAnalysis = this.getJsonNode(dnbApiResponse, this.finConst.mktAnalysisPath),
            finStmt = this.getJsonNode(dnbApiResponse, this.finConst.finStmtPath),
            stckSym = this.getJsonNode(dnbApiResponse, this.finConst.stckSymPath);
        //formatting market analysis
        if (marketAnalysis) {
            frmtFinancials.marketAnalysis = marketAnalysis;
        }
        //formatting financial statements
        if (finStmt) {
            frmtFinStmtList = [];
            _.each(finStmt, function(finStmtObj) {
                var frmtFinStmt = null;
                _.each(financialDD.finStmt.sub_array, function(value, key) {
                    var dataElement = this.getJsonNode(finStmtObj, value);
                    if (dataElement) {
                        if (_.isNull(frmtFinStmt)) {
                            frmtFinStmt = {};
                        }
                        if (key === 'salesRevenue') {
                            dataElement = this.formatSalesRevenue(dataElement);
                        }
                        frmtFinStmt[key] = dataElement;
                    }
                },this);
                if (!_.isNull(frmtFinStmt)) {
                    frmtFinStmtList.push(frmtFinStmt);
                }
            },this);
            if (frmtFinStmtList.length > 0) {
                frmtFinancials.finStmt = frmtFinStmtList;
            }
        }
        //formatting stock symbols
        var ownerType = this.getJsonNode(dnbApiResponse, this.finConst.ownTypePath),
            frmtStckSymL = {};
        if (ownerType) {
            frmtStckSymL.ownerType = ownerType;
        }
        if (stckSym) {
            frmtStckSymL.stckSymList = stckSym;
        }
        if (frmtStckSymL.ownerType || frmtStckSymL.stckSymList) {
            frmtFinancials.stckSym = frmtStckSymL;
        }
        return frmtFinancials;
    }
});
