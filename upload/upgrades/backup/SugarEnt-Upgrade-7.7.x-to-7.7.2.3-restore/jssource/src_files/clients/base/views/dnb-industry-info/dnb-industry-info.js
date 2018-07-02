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
 * @class View.Views.Base.DnbIndustryInfoView
 * @alias SUGAR.App.view.views.BaseDnbIndustryInfoView
 * @extends View.Views.Base.DnbView
 */
({
    extendsFrom: 'DnbView',

    events: {
        'click .showMoreData': 'showMoreData',
        'click .showLessData': 'showLessData'
    },

    //industry information data dictionary
    industryInfoDD: {
        'industryExplanation': {
            'json_path': 'IndustryCode.0.IndustryExplanationText',
            'case_fmt': true
        },
        'industryChapters': {
            'json_path': 'IndustryProfileChapterDetail',
            'case_fmt': true
        }
    },

    //industry info constants
    industryConst: {
        'industryInfoPath': 'OrderProductResponse.OrderProductResponseDetail.Product.IndustryProfile.IndustryProfileDetail.0'
    },

    initialize: function(options) {
        this._super('initialize', [options]);
        if (this.layout.collapse) {
            this.layout.collapse(true);
        }
        this.layout.on('dashlet:collapse', this.loadIndustryInfo, this);
        app.events.on('dnbcompinfo:duns_selected', this.collapseDashlet, this);
        //listen on expand all button click on the dashboard
        this.layout.layout.context.on('dashboard:collapse:fire', this.loadIndustryInfo, this);
    },

    /**
     * Refresh dashlet once Refresh link clicked from gear button
     * To show updated industry information from DNB service
     */
    refreshClicked: function() {
        this.loadIndustryInfo(false);
    },

    /**
     * Handles the dashlet expand | collapse events
     * @param  {Boolean} isCollapsed
     */
    loadIndustryInfo: function(isCollapsed) {
        //if the dashlet is not collapsed load data from D&B
        if (!isCollapsed) {
            //check if Hoovers Industry Code is set in context by refresh dashlet
            if (this.checkFieldExists('sic_code')) {
                var sicFromContext = app.controller.context.get('dnb_temp_hoovers_ind_code'),
                    sicFromModel = this.model.get('sic_code');
                if (!_.isUndefined(sicFromContext)) {
                    this.getDNBIndustryInfo(sicFromContext);
                } else if (sicFromModel) {
                    this.getDNBIndustryInfoFromSIC(sicFromModel);
                } else {
                    this.template = app.template.get(this.name + '.dnb-no-sic');
                    if (!this.disposed) {
                        this.render();
                    }
                }
            } else {
                this.template = app.template.get(this.name + '.dnb-no-sic-field');
                if (!this.disposed) {
                    this.render();
                }
            }
        }
    },

    /**
     * Get D&B industry information from SIC codes
     * @param  {String} sicCode
     */
    getDNBIndustryInfoFromSIC: function(sicCode) {
        var self = this;
        var sicToHicParams = {
            'industryType': this.commonConst.sic_to_hic,
            'industryCode': sicCode.substring(0,4) //use only the first 4 digits of the sic
        };
        self.template = app.template.get(self.name);
        if (!self.disposed) {
            self.render();
        }
        self.$('#dnb-industry-list-loading').show();
        self.$('#dnb-industry-info').hide();
        //check if cache has this data already
        var cacheKey = 'dnb:industrydet:' + sicToHicParams.industryType + ':' + sicToHicParams.industryCode;
        if (app.cache.get(cacheKey)) {
            self.renderIndustryInfo.call(self, app.cache.get(cacheKey));
        } else {
            var dnbIndustryURL = app.api.buildURL('connector/dnb/industry', '', {}, {});
            var resultData = {'product': null, 'errmsg': null};
            app.api.call('create', dnbIndustryURL, {'qdata': sicToHicParams}, {
                success: function(data) {
                    var responseCode = self.getJsonNode(data, self.appendSVCPaths.responseCode),
                        responseMsg = self.getJsonNode(data, self.appendSVCPaths.responseMsg);
                    if (responseCode && responseCode === self.responseCodes.success) {
                        resultData.product = data;
                        app.cache.set(cacheKey, resultData);
                    } else {
                        resultData.errmsg = responseMsg || app.lang.get('LBL_DNB_SVC_ERR');
                    }
                    self.renderIndustryInfo.call(self, resultData);
                },
                error: _.bind(self.checkAndProcessError, self)
            });
        }
    },

    /**
     * Get D&B industry information from HIC codes
     * @param {Object} industryCodeValue
     */
    getDNBIndustryInfo: function(industryCodeValue) {
        var self = this;
        if (industryCodeValue) {
            self.template = app.template.get(self.name);
            if (!self.disposed) {
                self.render();
            }
            self.$('#dnb-industry-list-loading').show();
            self.$('#dnb-industry-info').hide();
            //check if cache has this data already
            var cacheKey = 'dnb:industrydet:' + industryCodeValue;
            if (app.cache.get(cacheKey)) {
                self.renderIndustryInfo.call(self, app.cache.get(cacheKey));
            } else {
                var dnbIndustryURL = app.api.buildURL('connector/dnb/industry/' + industryCodeValue, '', {}, {});
                var resultData = {'product': null, 'errmsg': null};
                app.api.call('READ', dnbIndustryURL, {}, {
                    success: function(data) {
                        var responseCode = self.getJsonNode(data, self.appendSVCPaths.responseCode),
                            responseMsg = self.getJsonNode(data, self.appendSVCPaths.responseMsg);
                        if (responseCode && responseCode === self.responseCodes.success) {
                            resultData.product = data;
                            app.cache.set(cacheKey, resultData);
                        } else {
                            resultData.errmsg = responseMsg || app.lang.get('LBL_DNB_SVC_ERR');
                        }
                        self.renderIndustryInfo.call(self, resultData);
                    },
                    error: _.bind(self.checkAndProcessError, self)
                });
            }
        } else {
            self.template = app.template.get(self.name + '.dnb-no-duns');
            if (!self.disposed) {
                self.render();
            }
        }
    },

    /**
     * Render industry information from D&B API Response
     * @param  {Object} dnbApiResponse
     */
    renderIndustryInfo: function(dnbApiResponse) {
        if (this.disposed) {
            return;
        }
        var formattedIndustryInfo;
        this.dnbIndustryInfo = {};
        if (dnbApiResponse.product) {
            var industryProduct = this.getJsonNode(dnbApiResponse.product, this.industryConst.industryInfoPath);
            if (industryProduct) {
                formattedIndustryInfo = this.formatIndustryInfo(industryProduct, this.industryInfoDD);
                if (!_.isNull(formattedIndustryInfo)) {
                    this.dnbIndustryInfo.product = formattedIndustryInfo;
                } else {
                    this.dnbIndustryInfo.errmsg = app.lang.get('LBL_DNB_NO_DATA');
                }
            } else {
                this.dnbIndustryInfo.errmsg = app.lang.get('LBL_DNB_NO_DATA');
            }
        } else {
            this.dnbIndustryInfo.errmsg = dnbApiResponse.errmsg || app.lang.get('LBL_DNB_NO_DATA');
        }
        this.template = app.template.get(this.name);
        this.render();
        this.$('#dnb-industry-list-loading').hide();
        this.$('#dnb-industry-info').show();
        this.$('.showLessData').hide();
    },

    /**
     * Preprocessing industry information
     * @param {Object} industryDetails DNB API Response for IndustryInfo
     * @param {Object} industryInfoDD Data Dictionary for industry information
     * @return {Object}
     */
    formatIndustryInfo: function(industryDetails, industryInfoDD) {
        var formattedIndustryInfo = {};
        //iterate through data dictionary and extract required
        //data elements
        //populate them as key value pairs in the JS object
        _.each(industryInfoDD, function(value, key) {
            var dataElement = this.getJsonNode(industryDetails, value.json_path);
            if (dataElement) {
                formattedIndustryInfo[key] = dataElement;
            }
        }, this);
        if (formattedIndustryInfo.industryExplanation && formattedIndustryInfo.industryChapters) {
            return formattedIndustryInfo;
        } else {
            return null;
        }
    }
});
