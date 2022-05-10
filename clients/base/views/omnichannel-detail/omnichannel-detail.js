/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * The call/chat detail panel.
 *
 * @class View.Layouts.Base.OmnichannelDetailView
 * @alias SUGAR.App.view.layouts.BaseOmnichannelDetailView
 * @extends View.View
 */
({
    className: 'omni-detail',

    events: {
        'click [data-action=show-contact]': 'showContactTab',
        'click [data-action=show-case]': 'showCaseTab'
    },

    /**
     * Contact models.
     * @property {Object}
     */
    contactModels: {},

    /**
     * Case models.
     * @property {Object}
     */
    caseModels: {},

    /**
     * Current AWS connect contact id.
     * @property {string}
     */
    currentContactId: null,

    /**
     * Current module for the contact
     * @property {string}
     */
    currentContactModule: 'Calls',

    /**
     * Current contact model.
     * @property {Object}
     */
    currentContact: null,

    /**
     * Current case model.
     * @property {Object}
     */
    currentCase: null,

    /**
     * Editable information from the summary panel.
     * @property {Object}
     */
    summary: {},

    /**
     * Title of the detail block.
     * @property {string}
     */
    summaryTitle: null,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        options.model = app.data.createBean();
        this._super('initialize', [options]);

        this.updateMetadata();
        this.currentCase = null;
        this.currentContact = null;
        this.currentContactId = null;
        this.context.set('model', this.model);
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this._super('bindDataChange');
        this.layout.on('omniconsole:toggle', this.toggle, this);
        this.layout.on('contact:view', this.showContact, this);
        this.layout.on('contact:destroyed', this.removeContact, this);
        this.layout.on('contact:model:loaded', this._setInitialSummary, this);
        this.layout.on('omniconfig:reopen', this._updateAndRender, this);
        this.on('render', this._resizeCCP, this);
    },

    /**
     * Show contact tab.
     */
    showContactTab: function() {
        var dashboardSwitch = this.layout.getComponent('omnichannel-dashboard-switch');
        dashboardSwitch.setContactModel(this.currentContactId, this.contactModels[this.currentContactId]);
    },

    /**
     * Show contact tab.
     */
    showCaseTab: function() {
        var dashboardSwitch = this.layout.getComponent('omnichannel-dashboard-switch');
        dashboardSwitch.setCaseModel(this.currentContactId, this.caseModels[this.currentContactId]);
    },

    /**
     * Set title of the detail panel.
     * @param {Object} contact AWS contact
     */
    setSummaryTitle: function(contact) {
        var isChat = contact.getType() === connect.ContactType.CHAT;
        var lbl = isChat ? 'LBL_OMNICHANNEL_CHAT_SUMMARY' : 'LBL_OMNICHANNEL_CALL_SUMMARY';
        this.summaryTitle = app.lang.get(lbl, this.module);
    },

    /**
     * Set data of the active contact to model.
     * @param {Object} contact AWS contact
     */
    setSummary: function(contact) {
        this.setSummaryTitle(contact);
        var ccp = this.layout.getComponent('omnichannel-ccp');
        var model = ccp.connectionRecords[contact.getContactId()];
        if (model) {
            this.model = model;
        }
    },

    /**
     * Save the summary data.
     */
    saveSummary: function() {
        var ccp = this.layout.getComponent('omnichannel-ccp');
        ccp._updateConnectionRecord(ccp.activeContact, {});
    },

    /**
     * Set the initial summary after the contact model is created
     *
     * @param contact
     * @private
     */
    _setInitialSummary: function(contact) {
        var ccp = this.layout.getComponent('omnichannel-ccp');
        var model = ccp.connectionRecords[contact.getContactId()];

        if (model) {
            this.updateMetadata(contact);
            this.model = model;
            this.model.on('change', this.saveSummary, this);
            this.render();
            this._resizeCCP();
        }
    },

    /**
     * Show/hide the detail panel
     */
    toggle: function() {
        this.$el.toggle();
    },

    /**
     * Show contact and case records for a different AWS contact.
     * @param {Object} contact AWS contact
     */
    showContact: function(contact) {
        this.updateMetadata(contact);
        this.setSummary(contact);

        var contactId = contact.getContactId();

        if (this.contactModels[contactId]) {
            this.currentContact = {
                id: this.contactModels[contactId].get('id'),
                name: app.utils.formatNameModel('Contacts', this.contactModels[contactId].attributes)
            };
        } else {
            this.currentContact = null;
        }
        if (this.caseModels[contactId]) {
            this.currentCase = {
                id: this.caseModels[contactId].get('id'),
                name: this.caseModels[contactId].get('name')
            };
        } else {
            this.currentCase = null;
        }
        this.currentContactId = contactId;
        this.render();
        this._resizeCCP();
    },

    /**
     * Remove contact and case records for a AWS contact.
     * @param {string} contactId The id of a contact.
     */
    removeContact: function(contactId) {
        this.contactModels = _.omit(this.contactModels, contactId);
        this.caseModels = _.omit(this.caseModels, contactId);
    },

    /**
     * Set contact or case model
     * @param {Bean} model
     */
    setModel: function(model) {
        if (model.module === 'Contacts') {
            var displayName = app.utils.formatNameModel('Contacts', model.attributes);
            this._setLinkModel('contact', displayName, 'Contact', model);
        } else if (model.module === 'Cases') {
            this._setLinkModel('case', model.get('name'), 'Case', model);
        }
    },

    /**
     * Set model for a link
     * @param {string} linkName
     * @param {string} displayName
     * @param {string} objectName
     * @param {Bean} model
     * @private
     */
    _setLinkModel(linkName, displayName, objectName, model) {
        this[[linkName + 'Models']][this.currentContactId] = model;
        this[['current' + objectName]] = {
            id: model.get('id'),
            name: displayName
        };
        var ccp = this.layout.getComponent('omnichannel-ccp');
        ccp._updateConnectionRecord(ccp.activeContact, {[linkName]: model});
        this.render();
    },

    /**
     * Set contact model.
     * @param {Object} contact AWS contact
     * @param {Bean} contactModel Sugar contact
     */
    setContactModel: function(contact, contactModel) {
        this.contactModels[contact.getContactId()] = contactModel;
        this.showContact(contact);
    },

    /**
     * Set case model.
     * @param {Object} contact AWS contact
     * @param {Bean} caseModel Sugar case
     */
    setCaseModel: function(contact, caseModel) {
        this.caseModels[contact.getContactId()] = caseModel;
        this.showContact(contact);
    },

    /**
     * Get contact model.
     * @param {Object} contact AWS contact
     * @return {Bean} contactModel Sugar contact
     */
    getContactModel: function(contact) {
        var contactId = contact ? contact.getContactId() : this.currentContactId;
        return this.contactModels[contactId];
    },

    /**
     * Get case model.
     * @param {Object} contact AWS contact
     * @return {Bean} caseModel Sugar case
     */
    getCaseModel: function(contact) {
        var contactId = contact ? contact.getContactId() : this.currentContactId;
        return this.caseModels[contactId];
    },

    /**
     * Updates view metadata to use appropriate module-specific custom metadata.
     * This is called when setting initial summary, and when viewing a new
     * contact.
     *
     * @param {Object} contact AWS Contact
     */
    updateMetadata: function(contact) {
        var ccp = this.layout.getComponent('omnichannel-ccp');
        if (!_.isUndefined(ccp) && !_.isUndefined(contact)) {
            this.currentContactModule = ccp.contactTypeModule[contact.getType()];
        }
        this.meta = app.metadata.getView(this.currentContactModule, this.name);
        this.model.module = this.currentContactModule;
    },

    /**
     * Private util function to update metadata and rerender the view.
     * @private
     */
    _updateAndRender: function() {
        this.updateMetadata();
        this.render();
    },

    /**
     * Resizes CCP after re-render as our height might have changed.
     * @private
     */
    _resizeCCP: function() {
        var ccp = this.layout.getComponent('omnichannel-ccp');
        ccp.resize();
    },

    _dispose: function() {
        this.layout.off('omniconsole:toggle', this.toggle, this);
        this.layout.off('contact:view', this.showContact, this);
        this.layout.off('contact:destroyed', this.removeContact, this);
        this.layout.off('contact:model:loaded', this._setInitialSummary, this);
        this.layout.off('omniconfig:reopen', this._updateAndRender, this);
        this.off('render', this._resizeCCP, this);
        this._super('_dispose');
    }
})
