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
    dashboardLayouts: {
        'record': 'record-dashboard',
        'records': 'list-dashboard'
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
     * {@inheritdoc}
     */
    initialize: function(options) {
        var context = options.context,
            module = context.parent && context.parent.get('module') || context.get('module');

        if (options.meta && options.meta.method && options.meta.method === 'record' && !context.get('modelId')) {
            context.set('create', true);
        }

        var model = this._getNewDashboardObject('model', context);
        if (context.get('modelId')) {
            model.set('id', context.get('modelId'), {silent: true});
        }
        context.set({
            model: model,
            collection: this._getNewDashboardObject('collection', context)
        });

        this._super('initialize', [options]);

        this.model.on('setMode', function(mode) {
            if (mode === 'edit' || mode === 'create') {
                this.$('.dashboard').addClass('edit');
            } else {
                this.$('.dashboard').removeClass('edit');
            }
        }, this);


        // help dashboard triggers
        app.events.on('app:help:show', this.openHelpDashboard, this);
        app.events.on('app:help:hide', this.closeHelpDashboard, this);

        var defaultLayout = this.closestComponent('sidebar');
        if (defaultLayout) {
            this.listenTo(defaultLayout, 'sidebar:state:changed', function(state) {
                this.dashboardVisibleState = state;
                if (state === 'open' && this.isHelpDashboard()) {
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
            if (this.dashboardVisibleState === 'open' && this.isHelpDashboard()) {
                app.events.trigger('app:help:shown');

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

        // When the module is Activities, and it doesn't have a modelId set and the model mode is undefined
        // it should fetch the collection and hand off to the setDefaultDashboard
        if (module === 'Activities' && !context.has('modelId') && _.isUndefined(this.model.mode)) {
            this.once('render', function() {
                this.collection.fetch({
                    silent: true,
                    success: _.bind(this.setDefaultDashboard, this)
                });
            }, this);
        }
    },

    /**
     * Method to open the help dashboard if it's not already loaded
     *
     * This will also toggle the sidebar to open if it's collapsed
     */
    openHelpDashboard: function() {
        if (this.dashboardVisibleState === 'close') {
            var defaultLayout = this.closestComponent('sidebar');
            if (defaultLayout) {
                defaultLayout.toggleSidePane(true);
            }
        }
        if (!this.isHelpDashboard()) {
            // if the help dashboard is already visible, just leave it
            this.collection.fetch({
                silent: true,
                success: _.bind(this.showHelpDashboard, this)
            });
        }
    },

    /**
     * Method to close the help dashbaord, if the help dashboard is visible
     */
    closeHelpDashboard: function() {
        // the active one is not a help dashboard, don't bother refreshing the page
        if (this.isHelpDashboard()) {
            this.collection.fetch({
                silent: true,
                success: _.bind(this.hideHelpDashboard, this)
            });
        }
    },

    /**
     * Load the dashboards for the current module/view and then find the help dashboard and display it, it should always
     * exists but if it doesn't, just ignore it.
     *
     * @param {Object} collection   The collection of dashboards returned from the fetch
     */
    showHelpDashboard: function(collection) {
        var dashboard = _.find(collection.models, function(model) {
            return (model.get('dashboard_type') === 'help-dashboard');
        });

        this._navigate(dashboard);
    },

    /**
     * Load the dashboards for the current module/view and then find the first non-help dashboard and display it
     *
     * @param {Object} collection   The collection of dashboards returned from the fetch
     */
    hideHelpDashboard: function(collection) {
        var dashboard = _.find(collection.models, function(model) {
            return (model.get('dashboard_type') != 'help-dashboard');
        });

        // clear out the last state key for the help dashboard,
        // it will be reset
        app.user.lastState.set(this.getLastStateKey(), '');

        this._navigate(dashboard);
    },

    /**
     * Is the current open dashboad a help dashboard
     */
    isHelpDashboard: function() {
        return (this.model.get('dashboard_type') === 'help-dashboard');
    },

    /**
     * {@inheritdoc}
     */
    loadData: function(options, setFields) {
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
        var modelId = this.context.get('modelId');
        if (!(modelId && this.context.get('create')) && this.collection) {
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

        return this.addHelpDashboardMetadata(initDash);
    },

    /**
     * Adds the help-dashboard metadata to a metadata Object
     *
     * @param {Object} _initDashboard The default dashboard for a module
     */
    addHelpDashboardMetadata: function(_initDashboard) {
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
        var layout = this.layout,
            lastVisitedStateKey = this.getLastStateKey(),
            type = (_.isUndefined(type)) ? 'dashboard' : type;
        this.dispose();

        if (!_.contains(['dashboard', 'help-dashboard'], type)) {
            type = 'dashboard';
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

        layout._addComponentsFromDef([
            {
                layout: {
                    type: 'dashboard',
                    components: (id === 'list') ? [] : [
                        {
                            view: type + '-headerpane'
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
    }
})
