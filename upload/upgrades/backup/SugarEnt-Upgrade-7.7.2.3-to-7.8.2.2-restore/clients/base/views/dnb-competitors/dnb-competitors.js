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
 * @class View.Views.Base.DnbCompetitorsView
 * @alias SUGAR.App.view.views.BaseDnbCompetitorsView
 * @extends View.Views.Base.DnbView
 */
({
    extendsFrom: 'DnbView',

    duns_num: null,

    competitorsList: null,

    events: {
        'click a.dnb-company-name': 'getCompanyDetails',
        'click .backToList' : 'backToCompanyList'
    },

    //D&B Firmographic API product codes
    competitorsDD: {
        'dunsnum': {
            'json_path': 'DUNSNumber'
        },
        'orgname': {
            'json_path': 'OrganizationPrimaryName.OrganizationName.$',
            'case_fmt': true
        },
        'town': {
            'json_path': 'PrimaryAddress.PrimaryTownName',
            'case_fmt': true
        },
        'ctrycd': {
            'json_path': 'PrimaryAddress.CountryISOAlpha2Code',
            'case_fmt': false
        },
        'territoryabbreviatedname': {
            'json_path': 'PrimaryAddress.TerritoryAbbreviatedName',
            'case_fmt': true
        },
        'countryofficialname': {
            'json_path': 'PrimaryAddress.CountryOfficialName',
            'case_fmt': true
        },
        'salesrevenueamt': {
            'json_path': 'salesrevenueamt',
            'case_fmt': false
        },
        'topcompetitorindicator': {
            'json_path': 'TopCompetitorIndicator',
            'case_fmt': false
        },
        'isDupe': {
            'json_path': 'isDupe'
        }
    },

    competitorsConst: {
        'responseCode' : 'FindCompetitorResponse.TransactionResult.ResultID',
        'responseMsg' : 'FindCompetitorResponse.TransactionResult.ResultText',
        'competitorsPath' : 'FindCompetitorResponse.FindCompetitorResponseDetail.Competitor',
        'salesRevenuePath' : 'SalesRevenueAmount.0.$'
    },

    initialize: function(options) {
        this._super('initialize', [options]);
        if (this.layout.collapse) {
            this.layout.collapse(true);
        }
        this.layout.on('dashlet:collapse', this.loadCompetitors, this);
        app.events.on('dnbcompinfo:duns_selected', this.collapseDashlet, this);
        //listen on expand all button click on the dashboard
        this.layout.layout.context.on('dashboard:collapse:fire', this.loadCompetitors, this);
    },

    loadData: function(options) {
        if (this.model.get('duns_num')) {
            this.duns_num = this.model.get('duns_num');
        }
    },

    /**
     * Refresh dashlet once Refresh link clicked from geat button
     * To show updated data from D&B Competitors service
     */
    refreshClicked: function() {
        this.loadCompetitors(false);
    },

    /**
     * Handles the dashlet expand | collapse events
     * @param  {Boolean} isCollapsed
     */
    loadCompetitors: function(isCollapsed) {
        //if the dashlet is not collapsed load data from D&B
        if (!isCollapsed) {
            //check if account is linked with a D-U-N-S
            this.loadDNBData('duns_num', 'dnb_temp_duns_num', this.getDNBCompetitors, null, 'dnb.dnb-no-duns', 'dnb.dnb-no-duns-field');
        }
    },

    /**
     * Retrieves dnb competitors for the given duns no.
     * @param  {String} duns_num
     */
    getDNBCompetitors: function(duns_num) {
        var self = this;
        if (duns_num) {
            self.template = app.template.get(self.name);
            if (!self.disposed) {
                self.render();
                self.$('div#dnb-competitors-list').hide();
                self.$('div#dnb-no-data').hide();
            }
            //check if cache has this data already
            var cacheKey = 'dnb:competitors:' + duns_num;
            var cacheContent = app.cache.get(cacheKey);
            if (cacheContent) {
                var dupeCheckParams = {
                    'type': 'duns',
                    'apiResponse': cacheContent,
                    'module': 'competitors'
                };
                this.competitorsList = cacheContent;
                this.baseDuplicateCheck(dupeCheckParams, this.renderCompetitors);
            } else {
                var dnbCompetitorsURL = app.api.buildURL('connector/dnb/competitors/' + duns_num, '', {},{});
                var resultData = {'product': null, 'errmsg' : null};
                app.api.call('READ', dnbCompetitorsURL, {},{
                    success: function(data) {
                        var responseCode = self.getJsonNode(data, self.competitorsConst.responseCode),
                            responseMsg = self.getJsonNode(data, self.competitorsConst.responseMsg);
                        if (responseCode && responseCode === self.responseCodes.success) {
                            resultData.product = data;
                            app.cache.set(cacheKey, data);
                            self.competitorsList = data;
                        } else {
                            resultData.errmsg = responseMsg || app.lang.get('LBL_DNB_SVC_ERR');
                        }
                        self.renderCompetitors.call(self, resultData);
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
     * Renders the competitors list
     */
    backToCompanyList: function() {
        if (this.disposed) {
            return;
        }
        this.template = app.template.get(this.name);
        this.render();
        this.$('div#dnb-competitors-loading').show();
        this.$('div#dnb-competitors-list').hide();
        if (this.layout.getComponent('dashlet-toolbar').getField('import_dnb_data')) {
            this.layout.getComponent('dashlet-toolbar').getField('import_dnb_data').getFieldElement().hide();
        }
        var dupeCheckParams = {
            'type': 'duns',
            'apiResponse': this.competitorsList,
            'module': 'competitors'
        };
        this.baseDuplicateCheck(dupeCheckParams, this.renderCompetitors);
    },

    /**
     * Renders competitors list
     * @param {Object} competitorsList
     */
    renderCompetitors: function(competitorsList) {
        this.template = app.template.get(this.name);
        if (this.disposed) {
            return;
        }
        this.template = app.template.get(this.name);
        this.dnbComp = {};
        if (competitorsList.product) {
            var competitors = this.getJsonNode(competitorsList.product, this.competitorsConst.competitorsPath);
            this.dnbComp.product = this.formatCompetitors(competitors, this.competitorsDD);
        } else {
            this.dnbComp.errmsg = competitorsList.errmsg;
        }
        this.render();
        this.$('div#dnb-competitors-loading').hide();
        this.$('div#dnb-no-data').hide();
        this.$('div#dnb-competitors-list').show();
        //hide import button when rendering the list
        if (this.layout.getComponent('dashlet-toolbar').getField('import_dnb_data')) {
            this.layout.getComponent('dashlet-toolbar').getField('import_dnb_data').getFieldElement().hide();
        }
    },

    /**
     * Preprocessing search results
     * @param {Object} competitorsList DNB API Response for Competitors
     * @param {Object} competitorsDD Data Elements Map
     * @return {Array} Formatted array of competitors
     */
    formatCompetitors: function(competitorsList, competitorsDD) {
        var formattedCompetitors = [];

        //grouping top competitors
        var topCompGroup = _.groupBy(competitorsList, function (competitorObj) {
            return competitorObj.TopCompetitorIndicator;
        });
        if (topCompGroup.hasOwnProperty('true') && topCompGroup.hasOwnProperty('false')) {
            competitorsList = _.union(topCompGroup.true, topCompGroup.false);
        }
        //formatting sales revenue
        _.each(competitorsList, function (competitorObj) {
            var salesRevenue = this.getJsonNode(competitorObj,this.competitorsConst.salesRevenuePath);
            if (salesRevenue) {
                competitorObj.salesrevenueamt = '$' + this.formatSalesRevenue(salesRevenue) + app.lang.get('LBL_DNB_MILLION');
            }
        }, this);
        //iterate thru the search results, extract the necessary info
        //populate a js object
        //push it through an array
        _.each(competitorsList, function(competitorObj) {
            var frmtCompetitorsObj = {};
            _.each(competitorsDD, function(value, key) {
                var dataElement = this.getJsonNode(competitorObj, value.json_path);
                if (dataElement) {
                    if (value.case_fmt) {
                        dataElement = this.properCase(dataElement);
                    }
                    frmtCompetitorsObj[key] = dataElement;
                }
            },this);
            formattedCompetitors.push(frmtCompetitorsObj);
        },this);
        return formattedCompetitors;
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
            this.template = app.template.get('dnb.dnb-company-details');
            this.render();
            this.$('div#dnb-company-details').hide();
            this.baseCompanyInformation(duns_num, this.compInfoProdCD.lite, app.lang.get('LBL_DNB_COMPETITORS_LIST'), this.renderCompanyDetails);
        }
    }
})
