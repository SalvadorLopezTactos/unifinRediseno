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
 * The ccp container of the Omnichannel console.
 *
 * @class View.Views.Base.OmnichannelCcpView
 * @alias SUGAR.App.view.views.BaseOmnichannelCcpView
 * @extends View.View
 */
({
    className: 'omni-ccp',

    /**
     * A map of contact type to module
     */
    contactTypeModule: {
        voice: 'Calls',
        chat: 'Messages',
    },

    /**
     * Default maximum number of results to be returned by search query
     */
    maxQueryResultsDefault: 5,

    /**
     * The list of source types
     */
    sourceType: {
        voice: 'Phone',
        chat: 'Chat',
    },

    /**
     * The active contact
     */
    activeContact: null,

    /**
     * Call/chat records
     */
    connectionRecords: {},

    /**
     * The list of connected contacts
     */
    connectedContacts: {},

    /**
     * Chat controllers, keyed by contact ID
     */
    chatControllers: {},

    /**
     * Transcripts of chat messages, keyed by contact ID
     */
    chatTranscripts: {},

    /**
     * Is the ccp loaded?
     */
    ccpLoaded: false,

    /**
     * Have we loaded the CCP library?
     */
    libraryLoaded: false,

    /**
     * Is agent logged in?
     */
    agentLoggedIn: false,

    /**
     * Default CCP settings. Will be overridden by admin settings in the future
     */
    defaultCCPOptions: {
        loginPopupAutoClose: true,
        softphone: {
            allowFramedSoftphone: true
        }
    },

    /**
     * Prefix for AWS connect instance URLs
     */
    urlPrefix: 'https://',

    /**
     * Suffix for AWS connect instance URLs
     */
    urlSuffix: '.awsapps.com/connect/ccp-v2/',

    /**
     * A list of fields that might be updated through API from other sources (eg. lambda functions).
     */
    multiSourceFields: ['call_recording_url', 'contact_id'],

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this._super('bindDataChange');
        // Load the CCP when console drawer opens
        this.layout.on('omniconsole:open', function() {
            this.loadCCP();
            this.resize();
        }, this);
        this.layout.on('omniconsole:toggle', this.resize, this);
        // Event listener for manual refreshes
        $(window).on('beforeunload', _.bind(this._warnOnRefresh, this));

        // resize the CCP on window resize
        var debouncedResize = _.bind(_.debounce(this.resize, 100), this);
        $(window).on('resize.' + this.cid, debouncedResize);
    },

    /**
     * Change the height of CCP when the console (and detail panel) toggles.
     */
    resize: function() {
        if (!this.disposed) {
            this.$el.css('top', this._determineTop());
        }
    },

    /**
     * Calculate the top of CPP.
     * @return {number}
     * @private
     */
    _determineTop: function() {
        var detailPanel = this.layout.getComponent('omnichannel-detail');
        var top = parseInt(detailPanel.$el.css('top'), 10);
        // add the height of detail panel if its visible
        if (this.layout.isExpanded()) {
            top += parseInt(detailPanel.$el.css('height'), 10) + 1;
        }
        return top;
    },

    /**
     * Load the CCP library if needed, then initialize the CCP. Show an alert
     * message if loading the CCP fails. We expect it to fail in IE and Safari,
     * as the CCP itself is not compatible with those browsers.
     */
    loadCCP: function() {
        if (!this._loadAdminConfig()) {
            this._showNonConfiguredWarning();
            return;
        }
        if (this.libraryLoaded) {
            this.initializeCCP();
            return;
        }
        try {
            var self = this;
            // Load the connect-streams library and initialize the CCP
            $.getScript('include/javascript/amazon-connect/amazon-connect-1.4.9-1-gf9242a0.js', function() {
                // Load chat library here, must be loaded after connect-streams
                $.getScript('include/javascript/amazon-connect/amazon-connect-chat.js', function() {
                    self.libraryLoaded = true;
                    self.initializeCCP();
                    self.initializeChat();
                });
            });

        } catch (error) {
            app.alert.show(error.name, {
                level: 'error',
                messages: 'ERROR_OMNICHANNEL_LOAD_FAILED'
            });
            App.logger.error('Loading connect-streams library failed: ' + error);
        }
    },

    /**
     * Initialize library with options defined above, and load event listeners
     * for different CCP objects.
     */
    initializeCCP: function() {
        if (!this.ccpLoaded) {
            connect.core.initCCP(_.first(this.$('#containerDiv')), this.defaultCCPOptions);
            this.loadAgentEventListeners();
            this.loadContactEventListeners();
            this.loadGeneralEventListeners();
            this.ccpLoaded = true;
        } else if (!this.agentLoggedIn) {
            if (connect.core.loginWindow == null || connect.core.loginWindow.closed) {
                connect.core.loginWindow = window.open(this.defaultCCPOptions.ccpUrl, connect.MasterTopics.LOGIN_POPUP);
            } else {
                connect.core.loginWindow.focus();
            }
        }
    },

    /**
     * Provide initial chat config for use with amazon-connect-chatjs library
     */
    initializeChat: function() {
        var globalConfig = {
            region: this.defaultCCPOptions.region
        };
        connect.ChatSession.setGlobalConfig(globalConfig);
    },

    /**
     * Tear down the CCP instance when an agent logs out. We have to terminate
     * the instance via the Amazon library, and completely remove the iFrame from
     * the DOM so we can load a new one when the drawer is re-opened.
     */
    tearDownCCP: function() {
        this.styleFooterButton('logged-out');
        connect.core.terminate();
        this.$el.find('#containerDiv').empty();
        this.ccpLoaded = false;
        this.agentLoggedIn = false;
    },

    /**
     * Load agent event listeners.
     */
    loadAgentEventListeners: function() {
        var self = this;
        connect.agent(function(agent) {
            // When CCP agent is authenticated, we set the footer style
            self.styleFooterButton('logged-in');
            self.agentLoggedIn = true;

            // Trigger global changes so all parts of the app can go into
            // "CCP mode"
            app.events.trigger('ccp:initiated');

            agent.onStateChange(function(agentStateChange) {
                var isOffline = agentStateChange.newState.toLowerCase() === connect.AgentStateType.OFFLINE;
                var configMode = (isOffline) ? 'init' : 'disabled';

                $('.omni-button .config-menu').attr('data-mode', configMode);
            });
        });
    },

    /**
     * Gets the active contacts.
     * @return {contacts} Active contacts
     */
    getContacts: function() {
        return new connect.Agent().getContacts();
    },

    /**
     * Get the contact id for the active contact
     *
     * @return {string} the contact id or empty string if no active contact
     */
    getActiveContactId: function() {
        if (this.activeContact) {
            return this.activeContact.getContactId();
        }
        return '';
    },

    /**
     * Get active contact
     *
     * @return {Object} active contact
     */
    getActiveContact: function() {
        return this.activeContact;
    },

    /**
     * Load contact event listeners.
     */
    loadContactEventListeners: function() {
        var self = this;

        connect.core.onViewContact(function(event) {
            if (self.connectedContacts[event.contactId]) {
                self._setActiveContact(event.contactId);
            }
        });

        connect.contact(function(contact) {
            var connection = contact.getAgentConnection();
            if (connection.getMediaType() === connect.MediaType.CHAT) {
                self.loadChatListeners(connection);
            }

            contact.onConnecting(function() {
                if (app.omniConsole.isConfigPaneExpanded) {
                    connection.destroy();
                    app.alert.show('finish_configuring', {
                        level: 'warning',
                        messages: app.lang.get('LBL_OMNICHANNEL_FINISH_CONFIGURING_BEFORE_OUTBOUND_CALL'),
                    });
                } else {
                    self.layout.open();
                }
            });

            contact.onConnected(function(contact) {
                self.styleFooterButton('active-session');
                self.addContactToContactsList(contact);
                self._setActiveContact(contact.contactId);
                self._createConnectionRecord(contact);
            });

            // this listener is subscribed to both call and chat end (ENDED) event
            contact.onEnded(function(contact) {
                if (this.eventName.includes(connect.ContactEvents.ENDED)) {
                    // if the call/chat has ended but the contact is not closed
                    self._handleConnectionEnd(contact);
                }
            });
        });
    },

    /**
     * Update call/chat record when a call/chat is ended.
     * @param {Object} contact connect-streams Contact object
     * @private
     */
    _handleConnectionEnd: function(contact) {
        // do nothing if connection record doesn't exist
        if (!this._hasConnectionRecord(contact)) {
            return;
        }

        var data = {};
        var startTime = this.getContactConnectedTime(contact);
        var timeDuration = this.getTimeAndDuration(startTime);
        data.date_end = timeDuration.nowTime;

        if (this.isCall(contact)) {
            data.status = 'Held';
            data.duration_hours = timeDuration.durationHours;
            data.duration_minutes = timeDuration.durationMinutes;
        } else {
            data.status = 'Completed';
            data.conversation = this._getTranscriptForContact(contact);
        }

        this._updateConnectionRecord(contact, data);
    },

    /**
     * Get relevant contact information based on contact type.
     *
     * @param contact
     * @return {Object}
     */
    getContactInfo: function(contact) {
        if (this.isCall(contact)) {
            return this.getVoiceContactInfo(contact);
        } else if (this.isChat(contact)) {
            return this.getChatContactInfo(contact);
        }
    },

    /**
     * Load general event listeners. If the connect-streams API exposes an
     * object.onEvent function, we should prefer that method of event listening.
     * The EventBus should only be used for low-level events that aren't exposed
     * via the agent, contact, etc. object APIs.
     */
    loadGeneralEventListeners: function() {
        var self = this;
        var eventBus = connect.core.getEventBus();
        // This event is fired when an agent logs out, or the connection is lost
        eventBus.subscribe(connect.EventType.TERMINATED, function() {
            self.tearDownCCP();
            self.layout.trigger('ccp:terminated');

            // trigger global events to take app out of "CCP mode"
            app.events.trigger('ccp:terminated');
        });
        // This event is fired if we cannot synchronize with the CCP server
        eventBus.subscribe(connect.EventType.ACK_TIMEOUT, function() {
            if (self.agentLoggedIn) {
                self._showConnectionWarning();
            }
        });
        // This event is triggered when 'Clear Contact' button is clicked
        eventBus.subscribe(connect.ContactEvents.DESTROYED, function(contact) {
            self._closeConnectionRecord(contact);
            if (_.isEmpty(self.getContacts())) {
                // no more active contacts
                self.styleFooterButton('logged-in');

                // empty the active contact
                self._unsetActiveContact();
            }
            self.removeStoredContactData(contact);
            self.layout.trigger('contact:destroyed', contact.getContactId());
        });
    },

    /**
     * Util to trigger the footer style update
     *
     * @param status
     */
    styleFooterButton: function(status) {
        this.layout.context.trigger('omnichannel:auth', status);
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        this.layout.off('omniconsole:open', null, this);
        this.layout.off('omniconsole:toggle', this.resize, this);
        $(window).off('beforeunload', this._warnOnRefresh(), this);
        $(window).off('resize.' + this.cid);
        this._super('_dispose');
    },

    /**
     * Warn users if their admin hasn't added Amazon Connect settings
     * @private
     */
    _showNonConfiguredWarning: function() {
        app.alert.show('omnichannel-not-configured', {
            level: 'warning',
            messages: 'ERROR_OMNICHANNEL_NOT_CONFIGURED'
        });
    },

    /**
     * Warn users if the attempt to contact their Connect instance timed out
     * @private
     */
    _showConnectionWarning: function() {
        app.alert.show('omnichannel-timeout', {
            level: 'warning',
            messages: 'ERROR_OMNICHANNEL_TIMEOUT'
        });
    },

    /**
     * Load admin configuration for AWS Connect. Return true if successful, else
     * false.
     *
     * @return {boolean} whether or not config was loaded
     * @private
     */
    _loadAdminConfig: function() {
        var instanceName = App.config.awsConnectInstanceName;
        var region = App.config.awsConnectRegion;
        var instanceUrl = App.config.awsConnectUrl;
        var identityProvider = App.config.awsConnectIdentityProvider;
        var loginSSO = App.config.awsLoginUrl;
        if (_.isEmpty(instanceName) || _.isEmpty(region)) {
            return false;
        }

        if (_.isEmpty(instanceUrl)) {
            this.defaultCCPOptions.ccpUrl = this.urlPrefix + instanceName + this.urlSuffix;
        } else {
            this.defaultCCPOptions.ccpUrl = instanceUrl;
        }
        if (!_.isUndefined(identityProvider) && identityProvider === 'SAML') {
            this.defaultCCPOptions.loginUrl = loginSSO;
        }
        this.defaultCCPOptions.region = region;
        return true;
    },

    /**
     * Caches the last viewed contact
     *
     * @param {string} id
     * @private
     */
    _setActiveContact: function(id) {
        this.activeContact = _.findWhere(this.getContacts(), {contactId: id});
        this.layout.trigger('contact:view', this.activeContact);
    },

    /**
     * Unset the active contact and other relevant data
     *
     * @private
     */
    _unsetActiveContact: function() {
        this.activeContact = null;
        this.context.unset('quickcreateModelData');
        this.context.unset('quickcreateCreatedModel');
    },

    /**
     * Add the contact to the list of connected contacts
     *
     * @param contact
     */
    addContactToContactsList: function(contact) {
        this.connectedContacts[contact.getContactId()] = {
            connectedTimestamp: contact.getStatus().timestamp,
        };
    },

    /**
     * Remove the contact from the list of connected contacts, if it exists
     *
     * @param contact
     */
    removeStoredContactData: function(contact) {
        var contactId = contact.getContactId();

        if (_.has(this.connectedContacts, contactId)) {
            this.connectedContacts = _.omit(this.connectedContacts, contactId);
        }

        if (_.has(this.chatControllers, contactId)) {
            this.chatControllers = _.omit(this.chatControllers, contactId);
        }

        if (_.has(this.chatTranscripts, contactId)) {
            this.chatTranscripts = _.omit(this.chatTranscripts, contactId);
        }

        if (_.has(this.connectionRecords, contactId)) {
            this.connectionRecords = _.omit(this.connectionRecords, contactId);
        }
    },

    /**
     * Get generic contact info that all contact types should have
     *
     * @param contact
     * @return {Object}
     */
    getGenericContactInfo: function(contact) {
        var data = {};

        try {
            data.isContactInbound = contact.isInbound();
        } catch (err) {
            app.logger.error('Amazon Connect: Unable to determine contact inbound/outbound direction');
        }

        data.contactType = contact.getType();
        data.startTime = this.getContactConnectedTime(contact);
        data.aws_contact_id = contact.contactId;

        return data;
    },

    /**
     * Get the relevant information for a voice type contact
     *
     * @param contact
     * @return {Object}
     */
    getVoiceContactInfo: function(contact) {
        var conn = contact.getInitialConnection();
        var endpoint = conn.getEndpoint();

        return {
            phone_work: endpoint.phoneNumber,
            source: this.sourceType.voice
        };
    },

    /**
     * Get the relevant information for a chat type contact
     *
     * @param contact
     * @return {Object}
     */
    getChatContactInfo: function(contact) {
        var lastName = '';
        var data = contact._getData();

        var connectionInfo = _.findWhere(data.connections, {type: 'inbound'});
        if (connectionInfo) {
            lastName = connectionInfo.chatMediaInfo.customerName;
        }

        return {
            last_name: lastName,
            name: (lastName) ? lastName : app.lang.get('LBL_OMNICHANNEL_DEFAULT_CUSTOMER_NAME'),
            source: this.sourceType.chat,
        };
    },

    /**
     * Get the Utils/Date from the contact's timestamp
     *
     * @param contact
     * @return {Date}
     */
    getContactConnectedTime: function(contact) {
        var timestamp = this.connectedContacts[contact.getContactId()].connectedTimestamp;

        return app.date(timestamp);
    },

    /**
     * Get a readable title per the contact type
     *
     * @param module
     * @param data
     * @param contact
     * @return {string}
     */
    getRecordTitle: function(module, data, contact) {
        var title = '';

        // if unfamiliar type, return empty
        if (!(this.isChat(contact) || this.isCall(contact))) {
            return title;
        }

        if (this.isCall(contact)) {
            var contactTypeStr = 'Call';
            var identifier = data.phone_work;
        } else {
            var contactTypeStr = 'Chat';
            var identifier = data.name;
        }
        var direction = _.has(data, 'isContactInbound') ? (data.isContactInbound ? 'from' : 'to') : 'from';

        title = app.lang.get('TPL_OMNICHANNEL_NEW_RECORD_TITLE', module, {
            type: contactTypeStr,
            direction: direction,
            identifier: identifier,
            time: data.startTime.formatUser()
        });

        return title;
    },

    /**
     * Get the time in server format and calculate the duration
     *
     * @param {Date} startTime
     * @return {Object}
     */
    getTimeAndDuration: function(startTime) {
        var nowTime = app.date();

        var timeDiff = nowTime.diff(startTime);
        var durationHours = Math.floor(app.date.duration(timeDiff).asHours());
        var durationMinutes = app.date.duration(timeDiff).minutes();

        return {
            startTime: startTime.formatServer(),
            nowTime: nowTime.formatServer(),
            durationHours: durationHours,
            durationMinutes: durationMinutes,
        };
    },

    /**
     * Create a call/chat record for a new contact.
     * @param {Object} contact connect-streams Contact object
     * @private
     */
    _createConnectionRecord: function(contact) {
        // do nothing if contact type is unfamiliar
        if (!_.has(this.contactTypeModule, contact.getType())) {
            app.logger.error('Amazon Connect: Contact type: ' + contact.getType() + ' is not voice or chat');
            return;
        }

        var module = this.contactTypeModule[contact.getType()];
        var contactId = contact.getContactId();

        // do nothing if contact was from a previous session
        if (!_.has(this.connectedContacts, contactId)) {
            return;
        }

        var searchCallback = _.bind(function(results) {
            var model;

            // do not create a connection record if the unique contact id is already associated with a record
            if (_.isArray(results.records) && results.records.length > 0) {
                model = app.data.createBean(module, _.first(results.records));
                this._handlePostConnectionRecordCreation(model, contact);
            } else {
                var data = _.extendOwn(
                    this.getContactInfo(contact),
                    this.getGenericContactInfo(contact)
                );
                model = this.getNewModelForContact(module, data, contact);
                model.save({}, {
                    silent: true,
                    showAlerts: false,
                    success: _.bind(this._handlePostConnectionRecordCreation, this, model, contact),
                    error: function() {
                        app.logger.error('Failed to create call/chat record for ' + contactId);
                    }
                });
            }
        }, this);

        // before creating the connection record, ensure that the contact id is not
        // already associated with a record
        this._searchRecordByContactId(module, contactId, searchCallback);
    },

    /**
     * Handle actions after the connection record has been created or fetched
     *
     * @param model the model created or fetched
     * @param contact the contact
     * @private
     */
    _handlePostConnectionRecordCreation: function(model, contact) {
        var contactId = contact.getContactId();

        this.connectionRecords[contactId] = model;
        this.layout.trigger('contact:model:loaded', this.activeContact);

        this._searchContact(contact);
        this._searchCase(contact);
    },

    /**
     * Check if the connection record exists
     * @param {Object} contact connect-streams Contact object
     *
     * @return {boolean} true if the Connect-stream contact object is present in connection records
     * @private
     */
    _hasConnectionRecord: function(contact) {
        return _.has(this.connectionRecords, contact.getContactId());
    },

    /**
     * Update call/chat record when a contact is closed.
     * @param {Object} contact connect-streams Contact object
     * @private
     */
    _closeConnectionRecord: function(contact) {
        // do nothing if connection record doesn't exist
        if (!this._hasConnectionRecord(contact)) {
            return;
        }

        var detailPanel = this.layout.getComponent('omnichannel-detail');
        var data = {
            contact: detailPanel.getContactModel(contact),
            case: detailPanel.getCaseModel(contact)
        };

        this._updateConnectionRecord(contact, data);
    },

    /**
     * Based on the search parameters used for the search call it will create a filter
     * for the contact search dashlet.
     *
     * @param {Object} searchParams The input parameters for the search that has been made.
     * @return {Object} A filter definition used for filtering the contact search dashlet.
     * @private
     */
    _createContactFilterDef: function(searchParams) {
        var filter;
        var filterDef = [{
            '$or': []
        }];

        _.each(searchParams.fields.split(','), function(field, index) {
            filter = {};
            // if the query is an array then the filter fields and query text should be in their corresponding orders
            // for the filterdefs. This is needed to generate filterdefs for first and last names.
            filter[field] = {
                '$equals': _.isArray(searchParams.q) ? searchParams.q[index] : searchParams.q
            };
            filterDef[0].$or.push(filter);
        });

        return filterDef;
    },

    /**
     * Handles a successful search for contacts. In case there is only 1 contact, the
     * contact being found will be opened in the details tab. In case there are multiple
     * contact results the contact search dashlet will be populated.
     *
     * @param {Object} searchParams The input parameters for the search that has been made.
     * @param {Object} contact Connect-streams Contact object.
     * @param {Array} data The list of contact records.
     * @private
     */
    _handleContactResults: function(searchParams, contact, data) {
        if (_.isArray(data.records)) {
            if (data.records.length === 1) {
                var contactModel = app.data.createBean('Contacts', _.first(data.records));
                contactModel.set('name', app.utils.formatNameModel('Contacts', contactModel.attributes));
                delete this.dialedNumber;
                this._setContactModel(contact, contactModel);
                this._updateConnectionRecord(contact, {contact: contactModel});
            } else if (data.records.length > 1) {
                this._displayContactSearchDashlet(contact, searchParams);
            }
        }
    },

    /**
     * Handles creating filterdef based on search params and display the search tab in SugarLive.
     * Shows the Console list view dashlet for Contacts module in search tab with results based
     * on the filterdef created.
     *
     * @param {Object} contact Connect-streams Contact object.
     * @param {Object} searchParams The input parameters for the search that has been made.
     * @private
     */
    _displayContactSearchDashlet: function(contact, searchParams) {
        var switchDashboard = this.layout.getComponent('omnichannel-dashboard-switch');
        var activeDashboard = switchDashboard.getDashboard(contact.contactId);
        if (!activeDashboard) {
            return;
        }

        var contactSearchDashlet = activeDashboard.getComponent('dashboard')
            .getComponent('dashlet-main').getComponent('dashboard-grid')
            .getComponent('dashlet-grid-wrapper').getComponent('dashlet-console-list');

        if (!contactSearchDashlet) {
            return;
        } else {
            var filterDef = this._createContactFilterDef(searchParams);
            // update the contact dashlet search bar with the search term such as contact phone number
            if (searchParams.q) {
                contactSearchDashlet.$('input.search-name').val(searchParams.q);
            }
            contactSearchDashlet._displayDashlet(filterDef);
        }
    },

    /**
     * Gets the maximum number of search query results to be fetched from the app config or sets it to a default value
     * @return {number} Number of results to be fetched from search query
     * @private
     */
    _getMaxQueryResults: function() {
        return app.config && app.config.maxSearchQueryResult ? app.config.maxSearchQueryResult :
            this.maxQueryResultsDefault;
    },

    /**
     * Search for contact by phone number.
     *
     * @param {Object} contact connect-streams Contact object
     * @private
     */
    _searchContact: function(contact) {
        if (this.isCall(contact)) {
            var maxNum = this._getMaxQueryResults();
            var connection = contact.getInitialConnection();
            var endpoint = connection.getEndpoint();
            var searchParams = {
                q: this.dialedNumber || endpoint.phoneNumber,
                fields: 'phone_home,phone_mobile,phone_work,phone_other,assistant_phone' +
                    ',salutation,first_name,last_name,account_name,account_id',
                module_list: 'Contacts',
                max_num: maxNum
            };
            var successCallback = _.bind(this._handleContactResults, this, searchParams, contact);
            app.api.search(searchParams, {success: successCallback});
        } else {
            this._searchContactById(contact);
        }
    },

    /**
     * Search for contact by sugar contact Id
     *
     * @param contact
     * @private
     */
    _searchContactById: function(contact) {
        var attr = contact.getAttributes();
        if (this._contactIdSet(attr)) {
            var contactBean = app.data.createBean('Contacts', {id: attr.sugarContactId.value});
            contactBean.fetch({
                success: _.bind(function(data) {
                    // We only want to load the contact tab if we do not have a
                    // case details
                    var silentLoadContact = this._caseNumberSet(attr);
                    this._setContactModel(contact, contactBean, silentLoadContact);
                }, this)
            });
        }
    },

    /**
     * Search for contact by email.
     *
     * @param {Object} contact connect-streams Contact object
     * @private
     */
    _searchContactByEmail: function(contact) {
        var attr = contact.getAttributes();
        if (this._contactIdSet(attr)) {
            return;
        }
        if (attr && attr.sugarContactEmail && attr.sugarContactEmail.value) {
            var maxNum = this._getMaxQueryResults();
            var searchParams = {
                q: attr.sugarContactEmail.value,
                fields: 'email',
                module_list: 'Contacts',
                max_num: maxNum
            };
            var url = app.api.serverUrl + '/Contacts?filter[0][email][$equals]=' + attr.sugarContactEmail.value;
            app.api.call('read', url, null, {
                success: _.bind(function(data) {
                    if (_.isArray(data.records) && data.records.length === 1) {
                        var contactModel = app.data.createBean('Contacts', _.first(data.records));
                        this._setContactModel(contact, contactModel);
                        this._updateConnectionRecord(contact, {contact: contactModel});
                    } else if (_.isArray(data.records) && data.records.length > 1) {
                        // in case of multiple matches show the matched results in search tab
                        this._displayContactSearchDashlet(contact, searchParams);
                    } else {
                        this._searchContactByName(contact);
                    }
                }, this)
            });
        } else {
            this._searchContactByName(contact);
        }
    },

    /**
     * Search for contact by name.
     *
     * @param {Object} contact connect-streams Contact object
     * @private
     */
    _searchContactByName: function(contact) {
        var attr = contact.getAttributes();
        if (this._contactIdSet(attr)) {
            return;
        }
        if (attr && attr.sugarContactName && attr.sugarContactName.value) {
            var maxNum = this._getMaxQueryResults();
            var nameArray = attr.sugarContactName.value.split(' ');
            if (nameArray.length >= 2) {
                // We don't know the format of the name as it comes from Amazon.
                // Assuming the first string is first name and the last string is last name.
                var url = app.api.serverUrl + '/Contacts?filter[0][first_name][$equals]=' + nameArray[0];
                url += '&filter[1][last_name][$equals]=' + nameArray[nameArray.length - 1];

                // here we want to query name separately for the first_name and last_name fields.
                // In order to perform search in this case we need to make sure that the order of query text correspond
                // correctly with the query param fields. For example: To search for John Doe if the query is
                // an array like ['John', 'Doe'] where John is the first name and Doe is the last name
                // then the query fields should be 'first_name,last_name'
                var searchParams = {
                    q: [nameArray[0], nameArray[nameArray.length - 1]],
                    fields: 'first_name,last_name',
                    module_list: 'Contacts',
                    max_num: maxNum
                };
                app.api.call('read', url, null, {
                    success: _.bind(function(data) {
                        if (_.isArray(data.records) && data.records.length === 1) {
                            var contactModel = app.data.createBean('Contacts', _.first(data.records));
                            this._setContactModel(contact, contactModel);
                            this._updateConnectionRecord(contact, {contact: contactModel});
                        } else if (_.isArray(data.records) && data.records.length > 1) {
                            // in case of multiple matches show the matched results in search tab
                            this._displayContactSearchDashlet(contact, searchParams);
                        }
                    }, this)
                });
            }
        }
    },

    /**
     * Util to check if sugarContactId is set in aws contact attributes
     *
     * @param attr {Object} aws contact attributes
     * @return {boolean} true if sugarContactId is set
     * @private
     */
    _contactIdSet: function(attr) {
        return !!(attr && attr.sugarContactId && attr.sugarContactId.value);
    },

    /**
     * Util to check if sugarCaseNumber is set in aws contact attributes
     *
     * @param attr aws contact attributes
     * @return {boolean} true if sugarCaseNumber is set
     * @private
     */
    _caseNumberSet: function(attr) {
        return !!(attr && attr.sugarCaseNumber && attr.sugarCaseNumber.value);
    },

    /**
     * Search for case by case number.
     *
     * @param {Object} contact connect-streams Contact object
     * @private
     */
    _searchCase: function(contact) {
        var attr = contact.getAttributes();
        if (this._caseNumberSet(attr)) {
            var url = app.api.serverUrl + '/Cases?filter[0][case_number][$equals]=' + attr.sugarCaseNumber.value;
            app.api.call('read', url, null, {
                success: _.bind(function(data) {
                    if (_.isArray(data.records) && data.records.length === 1) {
                        var caseModel = app.data.createBean('Cases', _.first(data.records));
                        this._setCaseModel(contact, caseModel);
                        this._updateConnectionRecord(contact, {case: caseModel});
                    } else {
                        this._searchContactByEmail(contact);
                    }
                }, this)
            });
        } else {
            this._searchContactByEmail(contact);
        }
    },

    /**
     * Sets contact model. This function is
     * the success callback used in the search API on calls.
     *
     * @param {Object} contact - connect-streams Contact object
     * @param {Bean} contactModel
     * @param {boolean} silent
     * @private
     */
    _setContactModel: function(contact, contactModel, silent) {
        var detailPanel = this.layout.getComponent('omnichannel-detail');
        detailPanel.setContactModel(contact, contactModel);
        var dashboardSwitch = this.layout.getComponent('omnichannel-dashboard-switch');
        dashboardSwitch.setContactModel(contact.contactId, contactModel, silent);
    },

    /**
     * Sets case model. This function is
     * the success callback used in the search API on calls.
     *
     * @param {Object} contact - connect-streams Contact object
     * @param {Bean} caseModel
     * @private
     */
    _setCaseModel: function(contact, caseModel) {
        var detailPanel = this.layout.getComponent('omnichannel-detail');
        detailPanel.setCaseModel(contact, caseModel);
        var dashboardSwitch = this.layout.getComponent('omnichannel-dashboard-switch');
        dashboardSwitch.setCaseModel(contact.contactId, caseModel);
    },

    /**
     * Failure handler for saving a model from the CCP.
     *
     * @param {Object} contact Connect-streams Contact object.
     */
    saveModelError: function(contact) {
        app.logger.error('Failed to update call/chat record for ' + contact.getContactId());
    },

    /**
     * Success handler for saving a model from the CCP.
     *
     * @param {Bean} model The model to be saved.
     */
    saveModelSuccess: function(model) {
        var context = _.extend({
            module: model.module,
            moduleSingularLower: app.lang.getModuleName(model.module).toLowerCase()
        }, model.attributes);

        app.alert.show('save_success', {
            level: 'success',
            autoClose: true,
            messages: app.lang.get('LBL_OMNICHANNEL_RECORD_CREATED', model.module, context)
        });
    },

    /**
     * Create the options for saving a model tied to the given contact and save the model.
     *
     * @param {Bean} model The model to be saved.
     * @param {Object} contact Connect-streams Contact object.
     */
    saveModel: function(model, contact) {
        var options = {
            silent: true,
            showAlerts: false,
            error: _.bind(this.saveModelError, this, contact)
        };

        if (_.contains(['Held', 'Completed'], model.get('status'))) {
            options.success = _.bind(this.saveModelSuccess, this, model);
        }

        model.save(null, options);
    },

    /**
     * Re-apply the values of fields that can be changed only through other sources.
     *
     * @param {Bean} model The model tied to the active call/chat.
     * @param {Bean} dbModel The model tied to the active call/chat holding the most up to date data.
     */
    preserveDBFieldValues: function(model, dbModel) {
        //contact_id is handled separately in `updateContactIdField`.
        var fieldNames = _.without(this.multiSourceFields, 'contact_id');
        _.each(fieldNames, function(name) {
            if (dbModel.get(name)) {
                model.set(name, dbModel.get(name));
            }
        });
    },

    /**
     * Check and compare the value of the contact id field from different sources and apply the relevant one.
     *
     * @param {Bean} model The model kept on the view (and thus might be outdated).
     * @param {Bean} dbModel The same model the one kept on the view, but holding the most recent data.
     * @param {Bean} contactModel The contact module record related to the current call model.
     */
    updateContactIdField: function(model, dbModel, contactModel) {
        var contacts = {};
        var dbContactId = dbModel.get('contact_id');
        if (contactModel) {
            if (dbContactId && dbContactId !== contactModel.get('id')) {
                contacts.delete = [dbContactId];
                contacts.add = [contactModel.attributes];
            } else if (!dbContactId) {
                contacts.add = [contactModel.attributes];
            }
            model.set('contact_id', contactModel.get('id'));
        } else {
            if (dbContactId) {
                contacts.delete = [dbContactId];
            }
            model.set('contact_id', '');
        }
        model.set('contacts', contacts);
    },

    /**
     * Given a data structure apply the values on the model.
     * In case a contact model or a case model is given, apply only specific fields.
     *
     * @param {Bean} model The model tied to the active call/chat.
     * @param {Bean} dbModel The model tied to the active call/chat
     * and holding the most up to date data.
     * @param {Object} contact Connect-streams Contact object.
     * @param {*} value A value to be applied on the model.
     * @param {string} key Field name or related model module name.
     */
    applyChangesToModel: function(model, dbModel, contact, value, key) {
        if (key === 'contact') {
            if (this.isCall(contact)) {
                this.updateContactIdField(model, dbModel, value);
            } else if (value) {
                model.set('contact_id', value.get('id'));
            }
        } else if (key === 'case' && value) {
            model.set('parent_type', 'Cases');
            model.set('parent_id', value.get('id'));
        } else {
            model.set(key, value);
        }
    },

    /**
     * It will apply a given set of data on the model then save it.
     *
     * @param {Bean} viewModel The model tied to the active contact.
     * @param {Object} clientData A set of details to be saved on the model.
     * @param {Object} contact Connect-streams Contact object.
     * @param {Bean} dbModel The viewModel with the most up to date field values.
     */
    _updateFetchedRecord: function(viewModel, clientData, contact, dbModel) {
        _.each(clientData, _.bind(this.applyChangesToModel, this, viewModel, dbModel, contact));
        this.preserveDBFieldValues(viewModel, dbModel);
        this.saveModel(viewModel, contact);
    },

    /**
     * It will find the model tied to the given contact and fetch a copy of it.
     * The given set of data will be applied on the model only after it has been
     * re-fetched. We do this in order to avoid overriding model data saved
     * through other sources.
     *
     * @param {Object} contact Connect-streams Contact object.
     * @param {Object} data A set of details to be saved on the model.
     */
    _updateConnectionRecord: function(contact, data) {
        var model = this.connectionRecords[contact.getContactId()];
        if (model) {
            var baseModel = app.data.createBean(model.module, {id: model.get('id')});

            baseModel.fetch({
                silent: true,
                showAlerts: false,
                fields: this.multiSourceFields,
                success: _.bind(this._updateFetchedRecord, this, model, data, contact)
            });
        }
    },

    /**
     * Create the model and set appropriate attributes for the contact
     *
     * @param module
     * @param data
     * @param {Object} contact connect-streams Contact object.
     * @return {Object} the model
     */
    getNewModelForContact: function(module, data, contact) {
        var model = app.data.createBean(module);

        if (_.has(data, 'isContactInbound')) {
            model.set({
                direction: data.isContactInbound ? 'Inbound' : 'Outbound',
            });
        }

        if (this.isChat(contact)) {
            model.set({
                channel_type: 'Chat',
            });
        } else {
            model.set({
                duration_hours: 0,
                duration_minutes: 0,
                users: {
                    add: [{
                        id: app.user.id,
                        _module: 'Users'
                    }]
                }
            });
        }

        model.set({
            name: this.getRecordTitle(module, data, contact),
            date_start: data.startTime.formatServer(),
            status: 'In Progress',
            assigned_user_id: app.user.id,
            aws_contact_id: data.aws_contact_id || ''
        });

        return model;
    },

    /**
     * Load event listeners specific to chat sessions
     *
     * @param {Object} connection - connect-streams Connection object
     */
    loadChatListeners: function(connection) {
        var controllerHandler = _.bind(this._handleChatMediaController, this);
        connection.getMediaController().then(controllerHandler);
    },

    /**
     * Bind any event listeners onto chat media controllers.
     *
     * @param {Object} controller - ChatSessionController from connect-streams-chatjs
     * @private
     */
    _handleChatMediaController: function(controller) {
        var contactId = controller.controller.contactId;
        this.chatControllers[contactId] = controller;
        controller.onMessage(_.bind(this._handleChatMessage, this));
    },

    /**
     * ChatSessionController.onMessage event handler. Receives the API response
     * object from when messages are sent/received. Overwrites the existing chat
     * transcript for this contact with the most up-to-date version so whenever
     * the chat is ended we can save the transcript.
     *
     * @param {Object} response - connect-streams-chatjs API response
     * @private
     */
    _handleChatMessage: function(response) {
        var controller = this.chatControllers[response.chatDetails.contactId];
        controller.getTranscript({})
            .then(_.bind(this._setChatTranscript, this))
            .catch(function(error) {
                console.log(error);
            });
        if (response.data &&
            response.data.Type === 'MESSAGE' &&
            response.data.ParticipantRole === 'CUSTOMER') {
            this.layout.trigger('omnichannel:message');
        }
    },

    /**
     * Sets a chat transcript to this object's context for reference when the
     * chat session ends
     *
     * @param {Object} transcript - connect-streams-chatjs Transcript object
     * @private
     */
    _setChatTranscript: function(transcript) {
        var currentTranscript = this.chatTranscripts[transcript.data.InitialContactId];
        this.chatTranscripts[transcript.data.InitialContactId] = _.uniq(_.union(
            currentTranscript, transcript.data.Transcript
        ), function(message) {
            return message.Id;
        });
    },

    /**
     * Get a human-readable chat transcript for this contact. This function is
     * called when chat sessions end, and the return value is set on the model
     * when the Messages create drawer opens.
     *
     * @param {Object} contact - connect-streams Contact object
     * @return {string} readableTranscript - human readable chat transcript
     * @private
     */
    _getTranscriptForContact: function(contact) {
        var readableTranscript = '';
        var transcriptJson = this.chatTranscripts[contact.contactId] ||
            this.chatTranscripts[contact.getInitialContactId()] || [];

        _.each(transcriptJson, function(message) {
            readableTranscript += this._formatChatMessage(message);
        }, this);

        return readableTranscript.trim();
    },

    /**
     * Convert a single chat message from JSON to a human-readable format
     *
     * @param {Object} message - JSON-format chat message
     * @return {string} readableMessage - single human-readable chat message
     * @private
     */
    _formatChatMessage: function(message) {
        if (_.isEmpty(message.Content)) {
            return '';
        }
        var offset = app.user.getPreference('tz_offset_sec');
        var dateTime = app.date(message.AbsoluteTime).utcOffset(offset / 60);
        var timeStamp = dateTime.format(app.date.getUserTimeFormat());
        var header = '[' + message.ParticipantRole + ' ' + message.DisplayName + ']';
        header += ' ' + timeStamp;
        return header + '\n' + message.Content + '\n\n';
    },

    /**
     * Search for a record per the specified contact id
     *
     * @param {string} module
     * @param {string} contactId
     * @param {Function} successCallback
     * @private
     */
    _searchRecordByContactId: function(module, contactId, successCallback) {
        var url = app.api.serverUrl + '/' + module + '?filter[0][aws_contact_id][$equals]=' + contactId;
        app.api.call('read', url, null, {
            success: successCallback
        });
    },

    /**
     * Display warning message of potential data loss when user attempts to manually trigger a refresh
     *
     * @return {string|null}
     * @private
     */
    _warnOnRefresh: function() {
        // Only display browser popup if we have an active session
        if (!_.isNull(this.activeContact)) {
            return app.lang.get('LBL_WARN_ACTIVE_CCP_UNSAVED_CHANGES');
        }
    },

    isChat: function(contact) {
        return contact.getType() === connect.ContactType.CHAT;
    },

    isCall: function(contact) {
        return contact.getType() === connect.ContactType.VOICE;
    }
})
