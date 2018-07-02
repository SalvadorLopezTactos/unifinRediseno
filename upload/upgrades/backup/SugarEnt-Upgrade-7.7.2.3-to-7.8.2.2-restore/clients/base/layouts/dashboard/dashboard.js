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
 * The outer layout of the dashboard.
 *
 * This layout contains the header view and wraps the daslet-main layout.
 * The layouts for each dashboard are stored in the server.
 *
 * @class View.Layouts.Base.DashboardLayout
 * @alias SUGAR.App.view.layouts.BaseDashboardLayout
 * @extends View.Layout
 */
({
    className: 'row-fluid',
    //FIXME We need to remove this. SC-4210 will address it.
    dashboardLayouts: {
        'record': 'record-dashboard',
        'records': 'list-dashboard',
        'search': 'search-dashboard'
    },
    events: {
        'click [data-action=create]': 'createClicked'
    },
    error: {
        //Dashboard is a special case where a 404 here shouldn't break the page,
        //it should just send us back to the default homepage
        handleNotFoundError: function(error) {
            var currentRoute = Backbone.history.getFragment();
            if (currentRoute.substr(0, 5) === 'Home/') {
                app.router.redirect('#Home');
                //Prevent the default error handler
                return false;
            }
        },
        handleValidationError: function(error) {
            return false;
        }
    },

    /**
     * What is the current Visible State of the dashboard
     */
    dashboardVisibleState: 'open',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        var context = options.context,
            module = context.parent && context.parent.get('module') || context.get('module');

        if (options.meta && options.meta.method && options.meta.method === 'record' && !context.get('modelId')) {
            context.set('create', true);
        }

        var hasDashboardModels;

        // The dashboard can be used to display facets on the search page.
        // This is a special use case for dashboards.
        // This checks to see if we're in the search context (i.e. the search page).
        if (context.parent && context.parent.get('search')) {
            // Note that dashboard.js is initialized twice because `navigateLayout` will call initComponents directly,
            // which creates a new context for each dashboard.
            // See `navigateLayout` for more details.
            // Also note that the module for the facets dashboard is set to `Home` in the search layout metadata.
            // Therefore, we have two brother contexts, both of which are in the `Home` module.
            // One is the initial dashboard that is created when the search layout is created.
            // The other is instantiated by the dashboard's `navigateLayout` method.
            var contextBro = context.parent.getChildContext({module: 'Home'});
            hasDashboardModels = contextBro.get('collection') && contextBro.get('collection').length;
            if (hasDashboardModels) {
                context.set({
                    // currentDashboardIndex is the index of the dashboard that is currently being displayed.
                    // For the search page, we hardcode the dashboard indexes.
                    // This is possible because in search, we only allow the
                    //   help and facets dashboards.
                    // index 1 is for the search help dashboard
                    // index 2 is for the search facets dashboard
                    // 'currentDashboardIndex' is 1-based to be in sync with `model.id`.
                    // See `loadData` for more details.
                    model: contextBro.get('collection').at(contextBro.get('currentDashboardIndex') - 1),
                    collection: this._getNewDashboardObject('collection', context),
                    skipFetch: true
                });
            }
        }

        if (!hasDashboardModels) {
            var model = this._getNewDashboardObject('model', context);
            if (context.get('modelId')) {
                model.set('id', context.get('modelId'), {silent: true});
            }
            context.set({
                model: model,
                collection: this._getNewDashboardObject('collection', context)
            });
        }

        this._super('initialize', [options]);

        this._bindButtonEvents();

        this.model.on('setMode', function(mode) {
            if (mode === 'edit' || mode === 'create') {
                this.$('.dashboard').addClass('edit');
            } else {
                this.$('.dashboard').removeClass('edit');
            }
        }, this);

        // help dashboard triggers
        app.events.on('app:help:show', function() {
            this.openHelpDashboard(true);
        }, this);
        app.events.on('app:help:hide', function() {
            this.closeHelpDashboard(true);
        }, this);

        var defaultLayout = this.closestComponent('sidebar');
        if (defaultLayout) {
            this.listenTo(defaultLayout, 'sidebar:state:changed', function(state) {
                this.dashboardVisibleState = state;
                if (state === 'open' && this.isHelpDashboard(true)) {
                    app.events.trigger('app:help:shown');
                } else {
                    app.events.trigger('app:help:hidden');
                }
            }, this);

            try {
                this.dashboardVisibleState = defaultLayout.isSidePaneVisible() ? 'open' : 'close';
            } catch (error) {
                // this happens when the dashboard component is initially created because the defaultLayout doesn't
                // have _hideLastStateKey key set yet.  Just ignore this for now as with the way dashboards work
                // it this code will get run again once the logic below selects which dashboard to show.
            }
        }

        // listen to the model sync event to figure out if we need to highlight the help button in the footer
        this.model.on('sync', function() {
            if (this.dashboardVisibleState === 'open' && this.isHelpDashboard(true)) {
                // when on the home page and the dashboard is a help dashboard, we need to hide the edit button
                // which means we need to re-render the dashboard-headerpane to contain the meta from
                // the help-dashboard-headerpane view
                if (this.module === 'Home') {
                    var list = this.getComponent('list'),
                        headerpane = (!_.isUndefined(list)) ? list.getComponent('dashboard-headerpane') : undefined;

                    if (headerpane) {
                        var help_headerpane_meta = app.metadata.getView(this.module, 'help-dashboard-headerpane');
                        help_headerpane_meta.last_state = headerpane.meta.last_state;
                        headerpane.meta = help_headerpane_meta;
                        headerpane.render();
                    }
                }
            }
        }, this);

        if (module === 'Home' && context.has('modelId')) {
            // save it as last visit
            var lastVisitedStateKey = this.getLastStateKey();
            app.user.lastState.set(lastVisitedStateKey, context.get('modelId'));
        }
    },

    /**
     * Binds the button events that are specific to the record pane.
     *
     * @protected
     */
    _bindButtonEvents: function() {
        this.context.on('button:save_button:click', this.handleSave, this);
    },

    /**
     * Overrides {@link View.Layout#initComponents} to trigger `change:metadata`
     * event if we are in the search results page.
     *
     * For other dashboards than the facet dashboard, `change:metadata` is
     * triggered by {@link View.Fields.Base.Home.LayoutbuttonField} but we don't
     * use this field in the facets dashboard so we need to trigger it here.
     *
     * @override
     */
    initComponents: function(components, context, module) {
        this._super('initComponents', [components, context, module]);
        if (this.isSearchContext()) {
            // For non-search dashboards, `change:metadata` is triggered by the
            // `layoutbutton.js`. We don't use this field in the facets
            // dashboard, so we need to trigger it here.
            this.model.trigger('change:metadata');
        }
    },

    /**
     * Indicates if we are in the search page or not.
     *
     * @return {boolean} `true` means we are in the search page.
     */
    isSearchContext: function() {
        return this.context.parent && this.context.parent.get('search');
    },

    /**
     * Method to open the help dashboard if it's not already loaded. This will
     * also toggle the sidebar to open if it's collapsed.
     *
     * @param {boolean} [fromEvent] Flag to indicate if the fuction was called
     *   from an event. `true` if called from an event and `false` if called
     *   directly. Added for deprecation logging purposes only.
     *
     * @deprecated Since 7.7. Will be removed in 7.9. Use the event
     *   {@link App#event-app:help:show} instead.
     */
    openHelpDashboard: function(fromEvent) {
        if (!fromEvent) {
            app.logger.warn('View.Layouts.Base.DashboardLayout#openHelpDashboard is deprecated since 7.7. Will be removed in 7.9. Use the event "app:help:show" instead.');
        }

        if (this.dashboardVisibleState === 'close') {
            var defaultLayout = this.closestComponent('sidebar');
            if (defaultLayout) {
                defaultLayout.toggleSidePane(true);
            }
        }
        if (!this.isHelpDashboard(fromEvent)) {
            if (this.isSearchContext()) {
                var contextBro = this.getContextBro(this.context.get('module'));
                // Index 1 is the help dashboard.
                // See comments in `initialize` for more details.
                contextBro.set('currentDashboardIndex', 1);
                this.showHelpDashboard(contextBro.get('collection'), fromEvent);
                return;
            } else {
                // if the help dashboard is already visible, just leave it
                this.collection.fetch({
                    silent: true,
                    success: _.bind(function(collection) {
                        this.showHelpDashboard.apply(this, [collection, fromEvent]);
                    }, this)
                });
            }
        }
    },

    /**
     * Method to close the help dashbaord, if the help dashboard is visible.
     *
     * @param {boolean} [fromEvent] Flag to indicate if the fuction was called
     *   from an event. `true` if called from an event and `false` if called
     *   directly. Added for deprecation logging purposes only.
     *
     * @deprecated Since 7.7. Will be removed in 7.9. Use the event
     *   {@link App#event-app:help:hide} instead.
     */
    closeHelpDashboard: function(fromEvent) {
        if (!fromEvent) {
            app.logger.warn('View.Layouts.Base.DashboardLayout#closeHelpDashboard is deprecated since 7.7. Will be removed in 7.9. Use the event "app:help:hide" instead.');
        }

        if (this.isHelpDashboard(fromEvent)) {
            if (this.isSearchContext()) {
                var contextBro = this.getContextBro(this.context.get('module'));
                // Index 2 is the facet dashboard.
                // See comments in `initialize` for more details.
                contextBro.set('currentDashboardIndex', 2);
                this.hideHelpDashboard(contextBro.get('collection'), fromEvent);
                return;
            }
            // the active one is not a help dashboard, don't bother refreshing the page
            this.collection.fetch({
                silent: true,
                success: _.bind(function(collection) {
                    this.hideHelpDashboard.apply(this, [collection, fromEvent]);
                }, this)
            });
        }
    },

    /**
     * Load the dashboards for the current module/view and then find the help
     * dashboard and display it, it should always exists but if it doesn't,
     * just ignore it.
     *
     * @param {Object} collection The collection of dashboards returned from the
     *   fetch.
     * @param {boolean} [fromEvent] Flag to indicate if the fuction was called
     *   from an event. `true` if called from an event and `false` if called
     *   directly. Added for deprecation logging purposes only.
     *
     * @deprecated Since 7.7. Will be removed in 7.9. Use the event
     *   {@link App#event-app:help:show} instead.
     */
    showHelpDashboard: function(collection, fromEvent) {
        if (!fromEvent) {
            app.logger.warn('View.Layouts.Base.DashboardLayout#showHelpDashboard is deprecated since 7.7. Will be removed in 7.9. Use the event "app:help:show" instead to open the help dashboard.');
        }

        var dashboard = _.find(collection.models, function(model) {
            return (model.get('dashboard_type') === 'help-dashboard');
        });
        this._navigate(dashboard);
        app.events.trigger('app:help:shown');
    },

    /**
     * Load the dashboards for the current module/view and then find the first
     * non-help dashboard and display it.
     *
     * @param {Object} collection The collection of dashboards returned from the
     *   fetch.
     * @param {boolean} [fromEvent] Flag to indicate if the fuction was called
     *   from an event. `true` if called from an event and `false` if called
     *   directly. Added for deprecation logging purposes only.
     *
     * @deprecated Since 7.7. Will be removed in 7.9. Use the event
     *   {@link App#event-app:help:hide} instead.
     */
    hideHelpDashboard: function(collection, fromEvent) {
        if (!fromEvent) {
            app.logger.warn('View.Layouts.Base.DashboardLayout#hideHelpDashboard is deprecated since 7.7. Will be removed in 7.9. Use the event "app:help:hide" instead to close the help dashboard.');
        }

        var dashboard = _.find(collection.models, function(model) {
            return (model.get('dashboard_type') != 'help-dashboard');
        });

        // clear out the last state key for the help dashboard,
        // it will be reset
        app.user.lastState.set(this.getLastStateKey(), '');

        this._navigate(dashboard);
    },

    /**
     * Is the current open dashboad a help dashboard.
     *
     * @param {boolean} [fromEvent] Flag to indicate if the fuction was called
     *   from an event. `true` if called from an event and `false` if called
     *   directly. Added for deprecation logging purposes only.
     *
     * @deprecated Since 7.7. Will be removed in 7.9.
     */
    isHelpDashboard: function(fromEvent) {
        if (!fromEvent) {
            app.logger.warn('View.Layouts.Base.DashboardLayout#isHelpDashboard is deprecated since 7.7. Will be removed in 7.9.');
        }

        return (this.model.get('dashboard_type') === 'help-dashboard');
    },

    /**
     * Gets the brother context.
     *
     * @param {string} module The module to get the brother context from.
     * @return {Core.Context} The brother context.
     */
    getContextBro: function(module) {
        return this.context.parent.getChildContext({module: module});
    },

    /**
     * @inheritdoc
     */
    loadData: function(options, setFields) {
        // Dashboards store their own metadata as part of their model.
        // For search facet dashboard, we do not want to load the dashboard
        // metadata from the database. Instead, we build the metadata below.
        if (this.isSearchContext()) {
            // The model does not have metadata the first time this function
            // is called. In subsequent calls, the model should have metadata
            // so we do not need to fetch it.
            if (this.model.has('metadata')) {
                return;
            }

            this._loadSearchDashboards();

            this.context.set('skipFetch', true);
            // Index 2 is the facet dashboard. We display it by default in the
            // search page.
            this.context.set('currentDashboardIndex', 2);
            this.navigateLayout(null, 'search-dashboard');
            return;
        }

        if (this.context.parent && !this.context.parent.isDataFetched()) {
            var parent = this.context.parent.get('modelId') ?
                this.context.parent.get('model') : this.context.parent.get('collection');

            if (parent) {
                parent.once('sync', function() {
                    this._super('loadData', [options, setFields]);
                }, this);
            }
        } else {
            this._super('loadData', [options, setFields]);
        }
    },

    /**
     * Loads the facet and help dashboards for the search page, and add them in
     * the collection.
     *
     * @private
     */
    _loadSearchDashboards: function() {
        var dashboardsMeta = this._getInitialDashboardMetadata();
        _.each(dashboardsMeta, function(dashMeta, index) {
            var model = this._getNewDashboardObject('model', this.context);
            // The `id` has to be 1-based, otherwise `data-id` has no value
            // in dashboardtitle/detail.hbs because 0 is falsy.
            model.set('id', ++index);
            // In `dashMeta`, we have a `metadata` property which contains all
            // the metadata needed for the dashboard.
            model.set(dashMeta);
            this.collection.add(model);
        }, this);
    },

    /**
     * Navigate to the create layout when create button is clicked.
     *
     * @param {Event} evt Mouse event.
     */
    createClicked: function(evt) {
        if (this.model.dashboardModule === 'Home') {
            var route = app.router.buildRoute(this.module, null, 'create');
            app.router.navigate(route, {trigger: true});
        } else {
            this.navigateLayout('create');
        }
    },

    /**
     * Places only components that include the Dashlet plugin and places them in the 'main-pane' div of
     * the dashlet layout.
     * @param {app.view.Component} component
     * @private
     */
    _placeComponent: function(component) {
        var dashboardEl = this.$('[data-dashboard]'),
            css = this.context.get('create') ? ' edit' : '';
        if (dashboardEl.length === 0) {
            dashboardEl = $('<div></div>').attr({
                'class': 'cols row-fluid'
            });
            this.$el.append(
                $('<div></div>')
                    .addClass('dashboard' + css)
                    .attr({'data-dashboard': 'true'})
                    .append(dashboardEl)
            );
        } else {
            dashboardEl = dashboardEl.children('.row-fluid');
        }
        dashboardEl.append(component.el);
    },

    /**
     * If current context doesn't contain dashboard model id,
     * it will trigger set default dashboard to create default metadata
     */
    bindDataChange: function() {
        if (this.isSearchContext()) {
            return;
        }
        var modelId = this.context.get('modelId');
        if (!(modelId && this.context.get('create')) && this.collection) {
            // On the search page, we don't want to save the facets dashboard
            // in the database, so we don't need to listen to changes on the
            // collection nor do we need to call `setDefaultDashboard`.
            this.collection.on('reset', this.setDefaultDashboard, this);
        }
    },

    /**
     * Build the default dashboard metadata only if dashboards are empty.
     *
     * Default dashboard metadata are stored in the following layout metadata
     * <pre>
     * listview - list-dashboard
     * recordview - record-dashboard
     * </pre>
     * If the default dashboard is not assigned,
     * the layout will render dashboard-empty template.
     */
    setDefaultDashboard: function() {
        if (this.disposed) {
            return;
        }
        var lastVisitedStateKey = this.getLastStateKey(),
            lastViewed = app.user.lastState.get(lastVisitedStateKey),
            hasHelpOnly = (this.collection.models.length == 1 &&
                _.first(this.collection.models).get('dashboard_type') === 'help-dashboard'),
            helpLastShown = (hasHelpOnly && lastViewed === _.first(this.collection.models).get('id'));

        if (hasHelpOnly && !helpLastShown) {
            // If the collection contains exactly one model that is a help dashboard,
            // and the user saw the help dashboard last and chose to hide it, show the empty template
            this._renderEmptyTemplate();
        } else if (this.collection.models.length > 0) {
            var currentModule = this.context.get('module'),
                model;

            if (currentModule !== 'Home') {
                model = _.first(this.collection.models);
            } else {
                // get the first model that is not a help-dashboard
                model = this.collection.find(function(dash) {
                    return dash.get('dashboard_type') === 'dashboard';
                });
            }

            if (lastViewed) {
                var lastVisitedModel = this.collection.get(lastViewed);
                //if last visited dashboard not in the fetching list,
                //it should navigate to the first searched dashboard.
                //And it should clean out the previous last visited dashboard,
                //since it is no longer existed.
                if (!_.isEmpty(lastVisitedModel)) {
                    app.user.lastState.set(lastVisitedStateKey, '');
                    model = lastVisitedModel;
                }
            }

            if (currentModule == 'Home' && _.isString(lastViewed) && lastViewed.indexOf('bwc_dashboard') !== -1) {
                app.router.navigate(lastViewed, {trigger: true});
            } else {
                // use the _navigate helper
                this._navigate(model);
            }
        } else {
            var _initDashboard = this._getInitialDashboardMetadata();

            if (_initDashboard && !_.isEmpty(_initDashboard.metadata)) {
                // Drill-down to the dashlet level to check permissions for that module.
                _.each(_initDashboard.metadata['components'], function(component, component_key) {
                    _.each(component['rows'], function(row, row_key) {
                        // Loop the cells checking access, rebuilding the cell array to only contain permitted dashlets.
                        _initDashboard.metadata['components'][component_key]['rows'][row_key] =
                            _.filter(row, function(cell) {
                                var module = (cell.context && cell.context.module) ? cell.context.module : this.module;
                                return (!app.acl.hasAccess('access', module));
                            });
                    }, this);

                    // Now that we've processed all the rows in this component,
                    // rebuild the array to only have rows with dashlets.
                    _initDashboard.metadata['components'][component_key]['rows'] =
                        _.filter(_initDashboard.metadata['components'][component_key]['rows'], function(row) {
                            return (row.length > 0);
                        });
                }, this);
            }

            _.each(_initDashboard, function(dash) {
                var model = this._getNewDashboardObject('model', this.context);
                model.set(dash);
                if (this.context.get('modelId')) {
                    model.set('id', this.context.get('modelId'), {silent: true});
                }
                // make sure that the model actually has some metadata
                if (!_.isUndefined(model.get('metadata'))) {
                    model.save({}, this._getDashboardModelSaveParams());
                    this.collection.add(model);
                }
            }, this);
        }
    },

    /**
     * Gets initial dashboard metadata and adds help dashboard if it doesnt exist
     *
     * @return {Array} an array of dashboard metadata
     * @private
     */
    _getInitialDashboardMetadata: function() {
        var layoutName = this.dashboardLayouts[this.context.parent && this.context.parent.get('layout') || 'record'],
            initDash = app.metadata.getLayout(this.model.dashboardModule, layoutName) || {};

        // check to make sure this module has initial dashboards assigned for this view
        if (_.has(initDash, 'metadata')) {
            // make sure there's a dashboard_type of "dashboard" by default
            // unless there's a specific custom dashboard_type already defined
            initDash.dashboard_type = initDash.dashboard_type || 'dashboard';
        }

        return this.addHelpDashboardMetadata(initDash, true);
    },

    /**
     * Adds the help-dashboard metadata to a metadata Object.
     *
     * @param {Object} _initDashboard The default dashboard for a module.
     * @param {boolean} [suppressWarning] Flag to suppress the deprecation
     *   warning. `true` if this method was called within
     *   {@link View.Layouts.Base.DashboardLayout} and `false` if called
     *   directly. Added for deprecation logging purposes only.
     *
     * @deprecated Since 7.7. Will be removed in 7.9.
     */
    addHelpDashboardMetadata: function(_initDashboard, suppressWarning) {
        if (!suppressWarning) {
            app.logger.warn('View.Layouts.Base.DashboardLayout#addHelpDashboardMetadata is deprecated since 7.7. Will be removed in 7.9.');
        }

        var _helpDB = app.metadata.getLayout(this.model.dashboardModule, 'help-dashboard');
        if (_.has(_initDashboard, 'metadata')) {
            _initDashboard = [_helpDB, _initDashboard];
        } else {
            _initDashboard = [_helpDB];
        }
        return _initDashboard;
    },

    /**
     * Build the cache key for last visited dashboard
     * Combine parent module and view name to build the unique id
     *
     * @return {String} hash key.
     */
    getLastStateKey: function() {
        if (this._lastStateKey) {
            return this._lastStateKey;
        }
        var model = this.context.get('model'),
            view = model.get('view_name'),
            module = model.dashboardModule,
            key = module + '.' + view;
        this._lastStateKey = app.user.lastState.key(key, this);
        return this._lastStateKey;
    },


    /**
     * Utility method to use when trying to figure out how we need to navigate when switching dashboards
     *
     * @param {Backbone.Model} (dashboard) The dashboard we are trying to navigate to
     * @private
     */
    _navigate: function(dashboard) {
        // if we get here and it's disposed, just return out
        if (this.disposed) {
            return;
        }
        var hasParentContext = (this.context && this.context.parent),
            hasModelId = (dashboard && dashboard.has('id')),
            actualModule = (hasParentContext) ? this.context.parent.get('module') : this.module,
            isHomeModule = (actualModule === 'Home');

        if (hasParentContext && hasModelId) {
            // we are on a module and we have an dashboard id
            this._navigateLayout(dashboard.get('id'), dashboard.get('dashboard_type'));
        } else if (hasParentContext && !hasModelId) {
            // we are on a module but we don't have a dashboard id
            this._navigateLayout('list');
        } else if (!hasParentContext && hasModelId && isHomeModule) {
            // we on the Home module and we have a dashboard id
            app.navigate(this.context, dashboard);
        } else if (isHomeModule) {
            // we on the Home module and we don't have a dashboard
            var route = app.router.buildRoute(this.module);
            app.router.navigate(route, {trigger: true});
        }
    },

    /**
     * Intercept the navigateLayout calls to make sure that the dashboard we are currently one didn't change,
     * if it did, we need to prompt and make sure they want to continue or cancel.
     *
     * @param {String} dashboard What dashboard do we want to display
     * @param {string} [type] What type of dashboard are we loading, default `dashboard`
     * @return {Boolean}
     * @private
     */
    _navigateLayout: function(dashboard, type) {
        var onConfirm = _.bind(function() {
                this.navigateLayout(dashboard, type);
            }, this),
            headerpane = this.getComponent('dashboard-headerpane');

        // if we have a headerpane and it was changed then run the warnUnsavedChanges method
        if (headerpane && headerpane.changed) {
            return headerpane.warnUnsavedChanges(
                onConfirm,
                undefined,
                _.bind(function() {
                    // when the cancel button is presses, we need to clear out the collection
                    // because it messes with the add dashlet screen.
                    this.collection.reset([], {silent: true});
                }, this)
            );
        }

        // if we didn't have a headerpane or we did have one, but nothing changed, just run the normal method
        onConfirm();
    },

    /**
     * For the RHS dashboard, this method loads entire dashboard component and adds the
     * <pre><code>dashboard_type</code></pre> member to the context of the dashboard.
     * <pre><code>dashboard_type</code></pre> gets used in dashletselect to filter dashlets
     *
     * @param {String} id dashboard id
     * @param {String} [type] what type of dashboard are we dealing with, default: `dashboard`
     */
    navigateLayout: function(id, type) {
        var layout = this.layout;
        var lastVisitedStateKey = this.getLastStateKey();
        var type = !_.isUndefined(type) ? type : 'dashboard';

        // Default to using dashboard-headerpane for the header.
        var headerPaneView = 'dashboard-headerpane';

        // In the search page, we can't use the standard help dashboard
        // headerpane for the help dashboard because we don't want the
        // action buttons.
        // Also, we can't use the same as the facets dashboard headerpane
        // because that headerpane contains a search specific cog button.
        // Therefore, we created a special headerpane for the help dashboard in
        // the search page.
        if (this.isSearchContext() && type === 'help-dashboard') {
            headerPaneView = 'search-help-dashboard-headerpane';
        } else if (app.metadata.getView('Home', type + '-headerpane')) {
            headerPaneView = type + '-headerpane';
        }

        this.dispose();

        if (type === 'help-dashboard') {
            app.events.trigger('app:help:shown');
        } else {
            app.events.trigger('app:help:hidden');
        }

        //if dashboard layout navigates to the different dashboard,
        //it should store last visited dashboard id.
        if (!_.contains(['create', 'list'], id)) {
            app.user.lastState.set(lastVisitedStateKey, id);
        }

        // add dashboard type to context variables,
        // can only create dashboards with dashboard_type of 'dashboard'
        var ctxVars = { dashboard_type: 'dashboard' };
        if (id === 'create') {
            ctxVars.create = true;
        } else if (id !== 'list') {
            ctxVars.modelId = id;
        }

        layout.initComponents([
            {
                // Note that we reinitialize the dashboard layout itself, creating a new context (forceNew: true)
                layout: {
                    type: 'dashboard',
                    components: (id === 'list') ? [] : [
                        {
                            view: headerPaneView
                        },
                        {
                            layout: 'dashlet-main'
                        }
                    ],
                    last_state: {
                        id: 'last-visit'
                    }
                },
                context: _.extend({
                    module: 'Home',
                    forceNew: true
                }, ctxVars)
            }
        ]);

        layout.removeComponent(0);
        layout.loadData({}, false);
        layout.render();
    },

    /**
     * @inheritdoc
     */
    unbindData: function() {
        var model, collection;
        if (this.collection) {
            this.collection.off('reset', this.setDefaultDashboard, this);
        }
        if (this.context.parent) {
            model = this.context.parent.get('model');
            collection = this.context.parent.get('collection');

            if (model) {
                model.off('sync', null, this);
            }
            if (collection) {
                collection.off('sync', null, this);
            }
        }

        this._super('unbindData');
    },

    /**
     * Returns a Dashboard Model or Dashboard Collection based on modelOrCollection
     *
     * @param {String} modelOrCollection The return type, 'model' or 'collection'
     * @param {Object} context
     * @return {Bean|BeanCollection}
     * @private
     */
    _getNewDashboardObject: function(modelOrCollection, context) {
        var obj,
            ctx = context && context.parent || context,
            module = ctx.get('module') || context.get('module'),
            layoutName = ctx.get('layout') || '',
            sync = function(method, model, options) {

                options = app.data.parseOptionsForSync(method, model, options);
                // there is no max limit for number of dashboards permodule view
                if (options && options.params ) {
                    options.params.max_num = -1;
                }

                var callbacks = app.data.getSyncCallbacks(method, model, options),
                    path = (this.dashboardModule === 'Home' || model.id) ?
                                this.apiModule : this.apiModule + '/' + this.dashboardModule;
                if (method === 'read') {
                    options.params.view_name = layoutName;
                }

                app.data.trigger('data:sync:start', method, model, options);
                model.trigger('data:sync:start', method, options);

                app.api.records(method, path, model.attributes, options.params, callbacks);
            };

        if (module === 'Home') {
            layoutName = '';
        }
        switch (modelOrCollection) {
            case 'model':
                obj = this._getNewDashboardModel(module, layoutName, sync);
                break;

            case 'collection':
                obj = this._getNewDashboardCollection(module, layoutName, sync);
                break;
        }

        return obj;
    },

    /**
     * Returns a new Dashboard Bean with proper view_name and sync function set
     *
     * @param {String} module The name of the module we're in
     * @param {String} layoutName The name of the layout
     * @param {Function} syncFn The sync function to use
     * @param {Boolean} getNew If you want a new instance or just the the Dashboard definition (optional)
     * @return {Dashboard} a new Dashboard Bean
     * @private
     */
    _getNewDashboardModel: function(module, layoutName, syncFn, getNew) {
        getNew = (_.isUndefined(getNew)) ? true : getNew;
        var Dashboard = app.Bean.extend({
            sync: syncFn,
            apiModule: 'Dashboards',
            module: 'Home',
            dashboardModule: module,
            maxColumns: (module === 'Home') ? 3 : 1,
            minColumnSpanSize: (module === 'Home') ? 4 : 12,
            defaults: {
                view_name: layoutName
            }
        });
        return (getNew) ? new Dashboard() : Dashboard;
    },

    /**
     * Returns a new DashboardCollection with proper view_name and sync function set
     *
     * @param {String} module The name of the module we're in
     * @param {String} layoutName The name of the layout
     * @param {Function} syncFn The sync function to use
     * @param {Boolean} getNew If you want a new instance or just the the DashboardCollection definition (optional)
     * @return {DashboardCollection} A new Dashboard BeanCollection
     * @private
     */
    _getNewDashboardCollection: function(module, layoutName, syncFn, getNew) {
        getNew = (_.isUndefined(getNew)) ? true : getNew;
        var Dashboard = this._getNewDashboardModel(module, layoutName, syncFn, false),
            DashboardCollection = app.BeanCollection.extend({
                sync: syncFn,
                apiModule: 'Dashboards',
                module: 'Home',
                dashboardModule: module,
                model: Dashboard
            });
        return (getNew) ? new DashboardCollection() : DashboardCollection;
    },

    /**
     * Collects params for Dashboard model save
     *
     * @return {Object} The dashboard model params to pass to its save function
     * @private
     */
    _getDashboardModelSaveParams: function() {
        var params = {
            silent: true,
            //Don't show alerts for this request
            showAlerts: false
        };

        params.error = _.bind(this._renderEmptyTemplate, this);

        params.success = _.bind(function(model) {
            if (!this.disposed) {
                if (model.get('dashboard_module') !== 'Home') {
                    // if this is not the Home module, only navigate to the Help dashboards
                    if (model.get('dashboard_type') === 'help-dashboard') {
                        this._navigate(model);
                    }
                } else {
                    // if this is the Home module, navigate to the non-Help My Dashboard
                    if (model.get('dashboard_type') === 'dashboard') {
                        this._navigate(model);
                    }
                }
            }
        }, this);

        return params;
    },

    /**
     * Gets the empty dashboard layout template
     * and renders it to <pre><code>this.$el</code></pre>
     *
     * @private
     */
    _renderEmptyTemplate: function() {
        var tplName = this.type || this.name,
            template = app.template.getLayout(tplName + '.dashboard-empty');
        this.$el.html(template(this));
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        // always trigger the help button off
        app.events.trigger('app:help:hidden');

        var defaultLayout = this.closestComponent('sidebar');
        if (defaultLayout) {
            this.stopListening(defaultLayout);
        }

        this.dashboardLayouts = null;
        this._super('_dispose');
    },

    /**
     * Saves the dashboard to the server.
     */
    handleSave: function() {
        this.model.save({}, {
            //Show alerts for this request
            showAlerts: true,
            fieldsToValidate: {
                'name' : {
                    required: true
                },
                'metadata' : {
                    required: true
                }
            },
            success: _.bind(function() {
                this.model.unset('updated');
                if (this.context.get('create')) {
                    // We have a parent context only for dashboards in the RHS.
                    if (this.context.parent) {
                        this.getContextBro('Home').get('collection').add(this.model);
                        this.navigateLayout(this.model.id);
                    } else {
                        app.navigate(this.context, this.model);
                    }
                } else {
                    this.context.trigger('record:set:state', 'view');
                }
            }, this),
            error: function() {
                app.alert.show('error_while_save', {
                    level: 'error',
                    title: app.lang.get('ERR_INTERNAL_ERR_MSG'),
                    messages: ['ERR_HTTP_500_TEXT_LINE1', 'ERR_HTTP_500_TEXT_LINE2']
                });
            }
        });
    }
})
