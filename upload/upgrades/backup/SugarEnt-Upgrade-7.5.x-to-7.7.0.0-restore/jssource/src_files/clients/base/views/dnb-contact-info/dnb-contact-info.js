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
 * @class View.Views.Base.DnbContactInfoView
 * @alias SUGAR.App.view.views.BaseDnbContactInfoView
 * @extends View.Views.Base.DnbView
 */
({
    extendsFrom: 'DnbView',

    //for storing the duns_num
    duns_num: null,
    //for storing the contacts list
    //to be user for archiving
    contactsList: null,
    //current search parameters
    cntctSrchParams: null,
    //for storing the current contact details
    currentContact: null,
    //for storing the state of dashlet
    dashletState: null,
    searchCacheKey: null,
    detailCacheKey: null,

    events: {
        'click .showMoreData' : 'showMoreData',
        'click .showLessData' : 'showLessData',
        'click .dnb-cnt-prem' : 'baseGetContactDetails',
        'click .dnb-cnt-std' : 'baseGetContactDetails',
        'click .backToContactsList' : 'backToContactsList',
        'click #dnb-srch-clear' : 'clearSearchResults',
        'click #dnb-cntct-srch-btn' : 'searchContacts',
        'keyup .input-large': 'validateSearchParams'
    },

    initialize: function(options) {
        this._super('initialize', [options]);
        if (this.layout.collapse) {
            this.layout.collapse(true);
        }
        this.layout.on('dashlet:collapse', this.loadContacts, this);
        app.events.on('dnbcompinfo:duns_selected', this.collapseDashlet, this);
        this.dashletState = {
            'view' : null, //possible values list or detail or search,
            'content' : null, //used to store the cache key to render content
            'params' : null //used to store the search params, when view is search
        };
        //listen on expand all button click on the dashboard
        this.layout.layout.context.on('dashboard:collapse:fire', this.loadContacts, this);
    },

    /**
     * Refresh dashlet once Refresh link clicked from gear button
     * To show updated contact information from DNB service
     */
    refreshClicked: function() {
        this.loadContacts(false);
    },

    loadData: function(options) {
        if (this.model.get('duns_num')) {
            this.duns_num = this.model.get('duns_num');
        }
    },

    /**
     * Triggered when the dashlet is collapsed / expanded
     * @param {Boolean} isCollapsed  true indicating the dashlet was collapsed
     */
    loadContacts: function(isCollapsed) {
        if (!isCollapsed) {
            if (this.duns_num) {
                //check if account is linked with a D-U-N-S
                this.renderDashletFromState(this.dashletState);
            } else if (!_.isUndefined(app.controller.context.get('dnb_temp_duns_num'))) {
                //check if D-U-N-S is set in context by refresh dashlet
                this.getDNBContacts(app.controller.context.get('dnb_temp_duns_num'));
            } else {
                this.template = app.template.get(this.name + '.dnb-no-duns');
                if (!this.disposed) {
                    this.render();
                }
            }
        } else {
            //hide the import button if visible when minimized
            this.toggleImportBtn('import_dnb_data', false);
        }
    },

    /**
     * Back to contacts list functionality
     */
    backToContactsList: function() {
        if (this.disposed) {
            return;
        }
        this.template = app.template.get(this.name);
        this.toggleImportBtn('import_dnb_data', false);
        this.render();
        this.$('#dnb-contact-list-loading').show();
        this.$('#dnb-contact-list').hide();
        var dupeCheckParams = {
            'type': 'Contacts',
            'apiResponse': this.contactsList,
            'module': 'contacts'
        };
        this.baseDuplicateCheck(dupeCheckParams, this.renderContactsList);
    },

    /**
     * Renders the list of D&B Contacts
     * @param {Object} dnbApiResponse
     */
    renderContactsList: function(dnbApiResponse) {
        if (this.disposed) {
            return;
        }
        this.template = app.template.get(this.name);
        if (!_.isNull(this.searchCacheKey)) {
            this.dashletState.view = 'search';
            this.dashletState.params = this.cntctSrchParams;
            this.dashletState.content = this.searchCacheKey;
        } else {
            this.dashletState.view = 'list';
            this.dashletState.params = null;
            this.dashletState.content = null;
        }
        var dnbContactsList = {};
        if (dnbApiResponse.product) {
            this.contactsList = dnbApiResponse.product;
            var apiContactList = this.getJsonNode(dnbApiResponse.product, this.contactConst.contactsPath);
            dnbContactsList.product = this.formatContactList(apiContactList, this.contactsListDD);
        } else if (dnbApiResponse.errmsg) {
            dnbContactsList.errmsg = dnbApiResponse.errmsg;
        }
        this.dnbContactsList = dnbContactsList;
        this.render();
        this.$('#dnb-contact-list-loading').hide();
        this.$('#dnb-contact-list').show();
        this.toggleImportBtn('import_dnb_data', false);
        this.$('.showLessData').hide();
        //hide the show more link if the list has less than 3 results
        if (this.dnbContactsList.product && this.dnbContactsList.product.length < 3) {
            this.$('.showMoreData').hide();
            this.$('.dnb-show-less').attr('class', 'dnb-show-all');
        }
    },

    /**
     * Clears the search results
     */
    clearSearchResults: function() {
        this.cntctSrchParams = {'fname': null, 'lname': null, 'jobTitle': null};
        this.getDNBContacts(this.duns_num);
    },

    /**
     * Gets the list of contacts for a DUNS number
     * @param {String} duns_num
     */
    getDNBContacts: function(duns_num) {
        if (this.disposed) {
            return;
        }
        if (duns_num) {
            this.duns_num = duns_num;
            this.template = app.template.get(this.name);
            this.render();
            this.$('#dnb-contact-list-loading').show();
            this.$('#dnb-contact-list').hide();
            //check if cache has this data already
            var cacheKey = 'dnb:cntlist:' + duns_num;
            var cacheContent = app.cache.get(cacheKey);
            //setting dashlet state
            this.dashletState.view = 'list';
            this.dashletState.content = cacheKey;
            this.dashletState.params = null;
            this.searchCacheKey = null;
            if (cacheContent) {
                this.contactsList = cacheContent;
                var dupeCheckParams = {
                    'type': 'Contacts',
                    'apiResponse': cacheContent,
                    'module': 'contacts'
                };
                this.baseDuplicateCheck(dupeCheckParams, this.renderContactsList);
            } else {
                var balParams = {
                    'DUNSNumber-1': duns_num,
                    'contactType': 'Contacts'
                };
                this.baseContactsBAL(balParams, this.renderContactsList);
            }
        } else {
            this.template = app.template.get(this.name + '.dnb-no-duns');
            if (!this.disposed) {
                this.render();
            }
        }
    },

    /*
     * Imports the current contact information
     */
    importDNBContact: function() {
        this.baseImportContact('LinkedContacts');
    },

    /**
     * Searches for contacts from the D&B API
     * Based on the first name or last name or job title
     * Either one of these three inputs must be given in order to
     * perform the search
     * @param {Object} evt
     */
    searchContacts: function(evt) {
        if (this.disposed) {
            return;
        }
        //if search btn is not disabled and a duns exists then invoke contact search
        if (!this.$(evt.target).hasClass('disabled') && this.duns_num) {
            var cntctSrchParams = {}, //used for API
                srchParams = {'name': null, 'jobTitle': null}; //used for rendering view
            var name = $.trim(this.$('#dnb-name').val()),
                jobTitle = $.trim(this.$('#dnb-job').val());
            if (name !== '') {
                cntctSrchParams.ContactName = name;
                srchParams.name = name;
            }
            if (jobTitle !== '') {
                cntctSrchParams.KeywordContactText = jobTitle;
                //setting the scope for keyword search
                cntctSrchParams.KeywordContactScopeText = 'Title';
                srchParams.jobTitle = jobTitle;
            }
            cntctSrchParams['DUNSNumber-1'] = this.duns_num;
            cntctSrchParams.contactType = 'Contacts';
            this.template = app.template.get(this.name);
            this.cntctSrchParams = srchParams;
            this.render();
            this.$('div#dnb-contact-list-loading').show();
            this.$('div#dnb-contact-list').hide();
            var cacheKey = 'dnb:cntlist';
            _.each(cntctSrchParams, function(val, key) {
                cacheKey = cacheKey + ':' + key + '_' + val;
            });
            var cacheContent = app.cache.get(cacheKey);
            this.dashletState.view = 'detail';
            this.dashletState.content = cacheKey;
            this.dashletState.params = null;
            if (cacheContent) {
                this.contactsList = data;
                this.renderContactsList(cacheContent);
            } else {
                this.baseContactsBAL(cntctSrchParams, this.renderContactsList);
            }
        }
    },

    /**
     * Validates the search parameters
     * Either one of the first name / last name / job title must be given in order
     * to enable the search button
     */
    validateSearchParams: function() {
        this.$('#dnb-cntct-srch-btn').addClass('disabled');
        var searchInputsColl = this.$('.input-large');
        //A Search can be performed only if the accounts is associated with a DUNS
        if (this.duns_num) {
            _.each(searchInputsColl, function(searchInputObj) {
                if ($.trim($(searchInputObj).val()) !== '') {
                    this.$('#dnb-cntct-srch-btn').removeClass('disabled');
                }
            }, this);
        }
    },

    /**
     * Render dashlet from previously stored state information
     * @param {Object} dashletState
     */
    renderDashletFromState: function(dashletState) {
        var cacheContent = app.cache.get(dashletState.content),
            view = dashletState.view,
            srchParams = dashletState.params;
        if (!_.isNull(cacheContent) && !_.isNull(dashletState.view)) {
            if (view === 'detail') {
                this.renderContactDetails(cacheContent);
            } else if (view === 'search' && !_.isNull(srchParams)) {
                this.renderContactsList({'product' : cacheContent});
                this.cntctSrchParams = srchParams;
            } else {
                this.getDNBContacts(this.duns_num);
            }
        } else {
            this.getDNBContacts(this.duns_num);
        }
    }
})
