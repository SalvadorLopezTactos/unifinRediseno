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
 * Main layout of CJ
 *
 * @class View.Layouts.Base.DRI_WorkflowsLayout
 * @alias SUGAR.App.view.layouts.BaseDRI_WorkflowsLayout
 * @extends View.Layout
 */
({
    _rendered: false,
    loadDataClicked: false,
    enabled: true,
    journeyCreated: false,
    startingJourney: false,
    showHeaderRow: true,
    fieldsToValidate: {},
    moduleDependencies: {},

    /**
     * Status values
     *
     * @property
     */
    MORE_LESS_STATUS: {
        MORE: 'more',
        LESS: 'less',
    },

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._addedIds = {};
        this._super('initialize', [options]);

        this._setSugarLogicDependenciesForModel(['Calls', 'Meetings', 'Tasks']);

        this.context._fetchCalled = true;
        this.context.set('skipFetch', false);

        let parent = this.context.get('parentModel');
        parent.on('sync', this.reloadJourneys, this);

        this.listenTo(this.collection, 'add', this.addJourney);
        this.listenTo(this.collection, 'remove', this.removeJourney);
        this.listenTo(this.collection, 'sync', this._populateJourneys);
        this.listenTo(this.collection, 'sync', this.cleanJourneys);

        this.listenTo(this.context, 'reload_workflows', this.reloadJourneys);
        this.listenTo(this.context, 'change:moreLess', this.toggleMoreLess);
        this.listenTo(this.context, 'parent:start_cycle:click', this.startJourneyClicked);
        this.listenTo(this.context, 'parent:widget_layout_configuration:click', this.openWidgetConfigurationLayout);

        this.toggleMoreLess();

        this.context.set('fields', ['id', 'name']);
        this.collection.orderBy = {
            field: 'date_entered',
            direction: 'desc',
        };
        this.addFiltersInCollection();

        let driWorkflow = app.data.createBean('DRI_Workflows');
        let enabledModules = app.config.customer_journey && app.config.customer_journey.enabled_modules;

        if (enabledModules) {
            enabledModules = enabledModules.split(',');
            if (enabledModules.indexOf(parent.module) === -1) {
                this.enabled = false;
            }
        }

        _.each(driWorkflow.fields, function(def) {
                if (def.module === parent.module && def.customer_journey_parent) {
                    if (!def.customer_journey_parent.enabled) {
                        this.enabled = false;
                    }
                }
            }, this
        );
    },

    /**
     * @inheritdoc
     */
    _render: function() {
        this._super('_render');
        if (!this.enabled) {
            this.hide();
        }
    },

    /**
     * Toggle between more and less views
     */
    toggleMoreLess: function() {
        if (this.context.get('moreLess') === 'more' && !this.loadDataClicked) {
            this.loadDataClicked = true;
            this.loadData();
        }
    },

    /**
     * Reloads all journey view data
     */
    reloadJourneys: function() {
        this.addFiltersInCollection();
        this.removeJourneyViews();
        this.context.children = [];
        this.context.resetLoadFlag();
        this.loadData();
    },

    /**
     * Removes all journey views
     */
    cleanJourneys: function() {
        _.each(this._components, function(component) {
                if (component.name === 'dri-workflow' && !this.collection.get(component.model.id)) {
                    this.removeJourneyView(component);
                }
            }, this
        );
    },

    /**
     * Populate the collection of Journey by addinyg the journeys
     */
    _populateJourneys: function() {
        if (!this.context || !this.context.parent) {
            return;
        }

        let key = app.user.lastState.buildKey(`${this.getActiveOrArchiveMode()}-journeys-order`,
            this.context.parent.get('modelId'),
            this.context.parent.get('module')
        );
        let sortedOrder = app.user.lastState.get(key);

        // if user preference is empty then render journeys
        // according to date_entered
        if (!sortedOrder) {
            this.collection.each(this.addJourney, this);
        } else {
            let sortedJourneys = this.getSortedJourneys(sortedOrder);

            _.each(sortedJourneys, this.addJourney, this);
        }
    },

    /**
     * Sort Journeys according to Last State
     *
     * @param {Array} sortedOrder
     * @return {Array}
     */
    getSortedJourneys: function(sortedOrder) {
        let syncedJourneys = {};
        let notSyncedJourneys = [];

        // populate `syncedJourneys` object according to sortedOrder
        _.each(sortedOrder, function(id) {
            let journey = this.collection.get(id);

            if (journey) {
                syncedJourneys[id] = journey;
            }
        }, this);

        // capture those journeys which are in collection but not in `syncedJourneys` object
        this.collection.each(function(journey) {
            if (!syncedJourneys[journey.get('id')]) {
                notSyncedJourneys.push(journey);
            }
        }, this);

        return _.union(notSyncedJourneys, _.values(syncedJourneys));
    },

    /**
     * Toggles the display of all journey views according to the state
     */
    checkHide: function() {
        let completedJourney = this.collection.filter(function(journey) {
            return journey.get('state') === 'completed';
        }, this);
        let completed = completedJourney.length;

        if (completed === this.collection.length &&
            this.loadDataClicked && this.context.get('showActiveJourneys') === false
        ) {
            this.context.set('moreLess', this.MORE_LESS_STATUS.LESS);
        }
    },

    /**
     * @inheritdoc
     */
    loadData: function() {
        if (this.loadDataClicked) {
            this.context._fetchCalled = false;
            this.collection.dataFetched = false;
            this.render();
            // set skipFetch attribute to false, so that context fetch the collection
            this.context.set('skipFetch', false);
            this.context.loadData();
        }
    },

    /**
     * Initializes a new journey panel, adds it to the layout and loads the data
     *
     * @param {Object} journey
     */
    addJourney: function(journey) {
        if (this._addedIds[journey.id]) {
            return;
        }

        let context = this.context.getChildContext({
            module: 'DRI_Workflows',
            model: journey,
            forceNew: true,
        });
        let view = this.createComponentFromDef({
            view: 'dri-workflow',
            context: context,
        });

        this.addComponent(view);

        view.loadData();

        this._addedIds[journey.id] = true;

        view.render();

        journey.on('change:state', function() {
                if (journey.get('state') === 'completed') {
                    this.checkHide();
                }
            }, this
        );

        // when a journey is created we should open it by default
        if (this.journeyCreated) {
            view.toggleMoreLess(view.MORE_LESS_STATUS.MORE);
        }
    },

    /**
     * Removes a journey view
     *
     * @param {Object} view
     */
    removeJourneyView: function(view) {
        delete this._addedIds[view.model.id];
        this.removeComponent(view);
        view.dispose();
        this.collection.remove(view.model);
    },

    /**
     * Removes a journey and its related view
     *
     * @param {Object} model
     */
    removeJourney: function(model) {
        _.each(this._components, function(component) {
                if (component && component.name === 'dri-workflow' && component.model === model) {
                    this.removeJourneyView(component);
                }
            }, this
        );
    },

    /**
     * Removes all journey views
     */
    removeJourneyViews: function() {
        let remove = [];

        _.each(this._components, function(component) {
                if (component.name === 'dri-workflow') {
                    remove.push(component);
                }
            }, this
        );

        _.each(remove, this.removeJourneyView, this);
    },

    /**
     * Starts a new journey related to the parent
     *
     * @param {Object} model
     */
    startJourneyClicked: function(model) {
        if (_.isEmpty(model.get('dri_workflow_template_id')) || this.startingJourney) {
            return;
        }

        this.startingJourney = true;

        let url = app.api.buildURL(model.module, 'customer-journey/start-cycle',
            {
                id: this.context.get('parentModel').get('id'),
            },
            {
                template_id: model.get('dri_workflow_template_id'),
            }
        );

        this.$('.dri-workflows-actions-spinner').removeClass('hide');
        model.set({
            'dri_workflow_template_id': '',
            'dri_workflow_template_name': '',
        });

        this.disablingJourneyAndStartLoading();

        app.api.call('create', url, null, {
            success: _.bind(this.createJourneySuccess, this),

            error: function(result) {
                app.alert.show('error', {
                    level: 'error',
                    messages: result.message,
                    autoClose: true,
                });
            },

            complete: _.bind(function() {
                this.startingJourney = false;
                this.$('.dri-workflows-actions-spinner').addClass('hide');
                this.$('.customer-journey-loading-div').remove();
                this.$el.children().fadeTo('slow', 1);
            }, this),
        });
    },

    /**
     * Create Customer Journey success handler
     *
     * @param {Array} data
     */
    createJourneySuccess: function(data) {
        if (this.disposed) {
            return;
        }

        let parentData = data.parentData;

        if (this.context.get('moreLess') === this.MORE_LESS_STATUS.LESS) {
            this.context.set('moreLess', this.MORE_LESS_STATUS.MORE);
        }

        this._updateJourneysOrder(data.journeyId);

        this.journeyCreated = true;

        let parentModel = this.context.get('parentModel');
        let _modelBackup = app.utils.deepCopy(parentModel.attributes);

        parentModel.set(parentData);

        let diff = parentModel.getChangeDiff(_modelBackup);
        let changedAttributes = parentModel.changedAttributes();

        if (_.isUndefined(changedAttributes)) {
            changedAttributes = parentModel.changedAttributes(parentModel.getSynced());
        }

        _.each(changedAttributes, function(item, key) {
            parentModel.set(key, diff[key]);
        });

        parentModel.trigger('customer_journey:active-cycle:click', null);
        this.reloadJourneys();
    },

    /**
     * On creation of new Journey update the order
     *
     * @param {string} journeyId
     */
    _updateJourneysOrder: function(journeyId) {
        const key = app.user.lastState.buildKey('journeys-order', this.context.parent.get('modelId'),
            this.context.parent.get('module')
        );
        let sortedOrder = app.user.lastState.get(key);

        if (_.isArray(sortedOrder)) {
            // add new journey at first place
            sortedOrder.unshift(journeyId);
            // set user preference
            app.user.lastState.set(key, sortedOrder);
        }
    },

    /**
     * Disable the Smart Guide and show loader
     */
    disablingJourneyAndStartLoading: function() {
        let width = this.$el.width();
        let height = this.$el.height();
        let elm = $('<div class="customer-journey-loading-div"></div>');
        elm.height(height);
        elm.width(width);
        elm.css('position', 'absolute');
        elm.css('z-index', '100');
        this.$el.prepend(elm);
        this.$el.children().fadeTo('slow', 0.7);
    },

    /**
     * Open the Widget Configuration Layout in drawer. Here user can set the CJ view setting.
     * And on close the drawer, reload the layout on the base of flag i.e.
     * returnParam and this depicts that save button has been clicked.
     */
    openWidgetConfigurationLayout: function() {
        let context = this.context.getChildContext({
            model: this.model,
            parentLayout: this,
            parentModule: this.context.get('parentModule'),
            parentModel: this.context.get('parentModel'),
        });
        app.drawer.open(
            {
                layout: 'dri-workflows-widget-configuration',
                context: context,
            },
            function(currentThis, returnParam) {
                if (_.isEqual(returnParam, 'widget-config-saved') && _.isFunction(currentThis.reloadJourneys)) {
                    currentThis.reloadJourneys();
                }
            }
        );
    },

    /**
     * Add the filter in collection of archived on the base of selected value in widget
     * configuration layout
     */
    addFiltersInCollection: function() {
        let activeOrArchive = this.getActiveOrArchiveMode();

        if (_.isEmpty(activeOrArchive) || _.isEqual(activeOrArchive, 'active')) {
            this.collection.filterDef = {
                archived: 0,
            };
        } else if (_.isEqual(activeOrArchive, 'archived')) {
            this.collection.filterDef = {
                archived: 1,
            };
        }
    },

    /**
     * Returns the active or archive mode saved by user in widget setting
     *
     * @return {string}
     */
    getActiveOrArchiveMode: function() {
        let moduleName = (this.context && this.context.get('parentModule')) ? this.context.get('parentModule') : '';

        return app.CJBaseHelper.getValueFromCache('toggleActiveArchived', 'cj_active_or_archive_filter',
            moduleName, 'dri-workflows-widget-configuration');
    },

    /**
     * It will cache the view level and field level dependencies of given modules
     *
     * @param {Array} modules
     */
    _setSugarLogicDependenciesForModel: function(modules) {
        _.each(modules, function(module) {
            // cache all dependencies of specific module
            if (_.isEmpty(this.moduleDependencies[module])) {
                let moduleMetadata = app.metadata.getModule(module) || {};
                let dependencies = moduleMetadata.dependencies || [];

                if (moduleMetadata.views && moduleMetadata.views.record) {
                    let recordMetadata = moduleMetadata.views.record.meta;

                    if (!_.isUndefined(recordMetadata.dependencies)) {
                        dependencies = dependencies.concat(recordMetadata.dependencies);
                    }
                }

                // Cache the results so we don't have to do this expensive lookup any more
                this.moduleDependencies[module] = dependencies;
            }

            if (_.isEmpty(this.fieldsToValidate[module])) {
                let fieldsToValidate = {};
                const allFields = App.metadata.getField({module: module});
                let model = app.data.createBean(module);

                // add fields having required dependency to fieldsToValidate
                _.each(this.moduleDependencies[module], function(dependency) {
                    _.each(dependency.actions, function(action) {
                        if (action.action == 'SetRequired' && action.params.target && action.params.value) {
                            fieldsToValidate[action.params.target] = action.params.value;
                        }
                    }, this);
                }, this);

                // add required fields to fieldsToValidate
                for (let fieldKey in allFields) {
                    let field = allFields[fieldKey];

                    if (app.acl.hasAccessToModel('edit', model, fieldKey) && field.required) {
                        if (field.source && field.id_name) {
                            fieldsToValidate[field.id_name] = field.required_formula;
                        } else {
                            fieldsToValidate[fieldKey] = field.required_formula;
                        }
                    }
                }

                this.fieldsToValidate[module] = fieldsToValidate;
            }
        }, this);
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        this.stopListening();
        this._super('_dispose');
    },
});
