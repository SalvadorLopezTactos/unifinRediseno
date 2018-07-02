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
 * {@inheritDoc}
 *
 * Planned Activities dashlet takes advantage of the tabbed dashlet abstraction
 * by using its metadata driven capabilities to configure its tabs in order to
 * display planned activities of specific modules.
 *
 * Besides the metadata properties inherited from Tabbed dashlet, Planned Activities
 * dashlet also supports other properties:
 *
 * - {Array} invitation_actions field def for the invitation actions buttonset
 *           triggers showing invitation actions buttons and corresponding collection
 *
 * - {Array} overdue_badge field def to support overdue calculation, and showing
 *   an overdue badge when appropriate.
 *
 * @class View.Views.Base.PlannedActivitiesView
 * @alias SUGAR.App.view.views.BasePlannedActivitiesView
 * @extends View.Views.Base.HistoryView
 */
({
    extendsFrom: 'HistoryView',

    /**
     * {@inheritDoc}
     *
     * @property {Object} _defaultSettings
     * @property {String} _defaultSettings.date Date against which retrieved
     *   records will be filtered, supported values are 'today' and 'future',
     *   defaults to 'today'.
     * @property {Number} _defaultSettings.limit Maximum number of records to
     *   load per request, defaults to '10'.
     * @property {String} _defaultSettings.visibility Records visibility
     *   regarding current user, supported values are 'user' and 'group',
     *   defaults to 'user'.
     */
    _defaultSettings: {
        date: 'today',
        limit: 10,
        visibility: 'user'
    },

    /**
     * {@inheritDoc}
     *
     * Store current date state in settings.
     */
    initDashlet: function() {
        this._super('initDashlet');
        if (!this.meta.last_state) {
            this.meta.last_state = {
                id: this.dashModel.get('id') + ':' + this.name,
                defaults: {}
            };
        }
        this.settings.on('change:date', function(model, value) {
            var specificDateKey = app.user.lastState.key('date', this);
            app.user.lastState.set(specificDateKey, value);
        }, this);
        this.settings.set('date', this.getDate());
        this.tbodyTag = 'ul[data-action="pagination-body"]';
    },

    /**
     * {@inheritDoc}
     *
     * Once new records are received, prevent rendering new rows until we fetch
     * the invitation collection by calling {@link #updateInvitation}.
     */
    _initEvents: function() {
        this.events = _.extend(this.events, {
            'click [data-action=date-switcher]': 'dateSwitcher'
        });

        this._super('_initEvents');
        this.on('planned-activities:close-record:fire', this.heldActivity, this);

        this.before('render:rows', function(data) {
            this.updateInvitation(this.collection, data);
            return false;
        }, null, this);

        return this;
    },

    /**
     * Update the invitation collection.
     *
     * @param {BeanCollection} collection Active tab's collection.
     * @param {Array} data Added recordset's data.
     */
    updateInvitation: function(collection, data) {
        var tab = this.tabs[this.settings.get('activeTab')];
        if (!data.length || !tab.invitations) {
            return;
        }
        this._fetchInvitationActions(tab, _.pluck(data, 'id'));
    },

    /**
     * Completes the selected activity.
     *
     * Shows a confirmation alert and sets the activity as `Held` on confirm.
     * Also updates the collection and re-renders the dashlet to remove it from
     * the view.
     *
     * @param {Data.Bean} model Call/Meeting model to be marked as `Held`.
     */
    heldActivity: function(model){
        var self = this;
        var name = Handlebars.Utils.escapeExpression(app.utils.getRecordName(model)).trim();
        var context = app.lang.get('LBL_MODULE_NAME_SINGULAR', model.module).toLowerCase() + ' ' + name;
        app.alert.show('close_activity_confirmation:' + model.get('id'), {
            level: 'confirmation',
            messages: app.utils.formatString(app.lang.get('LBL_PLANNED_ACTIVITIES_DASHLET_CONFIRM_CLOSE'), [context]),
            onConfirm: function() {
                model.save({status: 'Held'}, {
                    showAlerts: true,
                    success: self._getRemoveModelCompleteCallback()
                });
            }
        });
    },

    /**
     * Create new record.
     *
     * @param {Event} event Click event.
     * @param {Object} params
     * @param {String} params.layout Layout name.
     * @param {String} params.link Relationship link.
     * @param {String} params.module Module name.
     */
    createRecord: function(event, params) {
        // FIXME: At the moment there are modules marked as bwc enabled though
        // they have sidecar support already, so they're treated as exceptions
        // and drawers are used instead.
        var bwcExceptions = ['Emails'],
            meta = app.metadata.getModule(params.module) || {};

        if (meta.isBwcEnabled && !_.contains(bwcExceptions, params.module)) {
            this._createBwcRecord(params.module, params.link);
            return;
        }

        this.createRelatedRecord(params.module, params.link);
    },

    /**
     * Create new record.
     *
     * If we're on Homepage an orphan record is created, otherwise, the link
     * parameter is used and the new record is associated with the record
     * currently being viewed.
     *
     * @param {String} module Module name.
     * @param {String} link Relationship link.
     * @protected
     */
    _createBwcRecord: function(module, link) {
        if (this.module !== 'Home') {
            app.bwc.createRelatedRecord(module, this.model, link);
            return;
        }

        var params = {
            return_module: this.module,
            return_id: this.model.id
        };

        var route = app.bwc.buildRoute(module, null, 'EditView', params);

        app.router.navigate(route, {trigger: true});
    },

    /**
     * Opens create record drawer.
     *
     * @param {String} module Module name.
     * @param {String} layout Layout name, defaults to 'create-actions' if none
     *   supplied.
     * @protected
     */
    _openCreateDrawer: function(module, layout) {
        layout = layout || 'create-actions';
        app.drawer.open({
            layout: layout,
            context: {
                create: true,
                module: module,
                prepopulate: this._prePopulateDrawer(module)
            }
        }, _.bind(function(context, newModel) {
            if (newModel && newModel.id) {
                this.layout.loadData();
            }
        }, this));
    },

    /**
     * Pre-populates data for new records created via drawer based on supplied
     * module name.
     *
     * Override this method to provide custom data.
     *
     * @param {String} module Module name.
     * @return {Array} Array of pre-populated data.
     * @protected
     */
    _prePopulateDrawer: function(module) {
        var data = {
            related: this.model
        };

        if (module === 'Emails') {
            data['to_addresses'] = this.model;
        }

        return data;
    },

    /**
     * {@inheritDoc}
     * @protected
     */
    _initTabs: function() {
        this._super("_initTabs");

        _.each(this.tabs, function(tab) {
            if (!tab.invitation_actions) {
                return;
            }
            tab.invitations = this._createInvitationsCollection(tab);
        }, this);

        return this;
    },

    /**
     * Create invites collection to set the accept status on the given link.
     *
     * @param {Object} tab Tab properties.
     * @return {Data.BeanCollection} A new instance of bean collection.
     * @protected
     */
    _createInvitationsCollection: function(tab) {
        return app.data.createBeanCollection(tab.module, null, {
            link: {
                name: tab.module.toLowerCase(),
                bean: app.data.createBean('Users', {
                    id: app.user.get('id')
                })
            }
        });
    },

    /**
     * {@inheritDoc}
     */
    _getRecordsTemplate: function(module) {
        this._recordsTpl = this._recordsTpl || {};

        if (!this._recordsTpl[module]) {
            this._recordsTpl[module] = app.template.getView(this.name + '.records', module) ||
                app.template.getView(this.name + '.records', this.module) ||
                app.template.getView(this.name + '.records') ||
                app.template.getView('history.records', this.module) ||
                app.template.getView('history.records') ||
                app.template.getView('tabbed-dashlet.records', this.module) ||
                app.template.getView('tabbed-dashlet.records');
        }

        return this._recordsTpl[module];
    },

    /**
     * {@inheritDoc}
     */
    _getFilters: function(index) {

        var today = app.date().format('YYYY-MM-DD'),
            tab = this.tabs[index],
            filter = {},
            filters = [],
            defaultFilters = {
                today: {$lte: today},
                future: {$gt: today}
            };

        filter[tab.filter_applied_to] = defaultFilters[this.getDate()];

        filters.push(filter);

        return filters;
    },

    /**
     * {@inheritDoc}
     */
    tabSwitcher: function(event) {
        var tab = this.tabs[this.settings.get('activeTab')];
        if (tab.invitations) {
            tab.invitations.dataFetched = false;
        }

        this._super('tabSwitcher', [event]);
    },

    /**
     * Event handler for date switcher.
     *
     * @param {Event} event Click event.
     */
    dateSwitcher: function(event) {
        var date = this.$(event.currentTarget).val();
        if (date === this.getDate()) {
            return;
        }

        this.settings.set('date', date);
        this.layout.loadData();
    },

    /**
     * Get current date state.
     * Returns default value if can't find in last state or settings.
     *
     * @return {String} Date state.
     */
    getDate: function() {
        var date = app.user.lastState.get(
            app.user.lastState.key('date', this),
            this
        );
        return date || this.settings.get('date') || this._defaultSettings.date;
    },

    /**
     * {@inheritDoc}
     *
     * On load of new data, make sure we reload invitations related data, if
     * it is defined for the current tab.
     */
    loadData: function(options) {
        if (this.disposed || this.meta.config) {
            return;
        }

        var tab = this.tabs[this.settings.get('activeTab')];
        if (tab.invitations) {
            tab.invitations.dataFetched = false;
        }
        this._super('loadData', [options]);
    },

    /**
     * Fetch the invitation actions collection for
     * showing the invitation actions buttons
     * @param {Object} tab Tab properties.
     * @param {Array|*} addedIds New added record ids.
     * @private
     */
    _fetchInvitationActions: function(tab, addedIds) {
        this.invitationActions = tab.invitation_actions;
        tab.invitations.filterDef = {
            'id': {'$in': addedIds || this.collection.pluck('id')}
        };

        tab.invitations.fetch({
            relate: true,
            success: _.bind(function(collection) {
                if (this.disposed) {
                    return;
                }

                _.each(collection.models, function(invitation) {
                    var model = this.collection.get(invitation.get('id'));
                    model.set('invitation', invitation);
                }, this);

                if (!_.isEmpty(addedIds)) {
                    _.each(addedIds, function(id) {
                        var model = this.collection.get(id);
                        this._renderRow(model);
                    }, this);
                    return;
                }
                this.render();
            }, this),
            complete: function() {
                tab.invitations.dataFetched = true;
            }
        });
    },
    /**
     * {@inheritDoc}
     *
     * New model related properties are injected into each model:
     *
     * - {Boolean} overdue True if record is prior to now.
     * - {Bean} invitation The invitation bean that relates the data with the
     *   Users' invitation statuses. This is the model supplied to the
     *   `invitation-actions` field.
     */
    _renderHtml: function() {
        if (this.meta.config) {
            this._super("_renderHtml");
            return;
        }

        var tab = this.tabs[this.settings.get('activeTab')];

        if (tab.overdue_badge) {
            this.overdueBadge = tab.overdue_badge;
        }

        if (!this.collection.length || !tab.invitations ||
            tab.invitations.dataFetched) {
            this._super('_renderHtml');
            return;
        }

        this._fetchInvitationActions(tab);
    }
})
