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
 * @class View.Views.Base.ActivityTimelineBaseView
 * @alias SUGAR.App.view.views.BaseActivityTimelineBaseView
 * @extends View.View
 */
({

    className: 'activity-timeline-base',

    plugins: ['EmailClientLaunch', 'LinkedModel'],

    /**
     * Object icon names for modules
     */
    moduleIcons: {
        Calls: 'sicon-phone-lg',
        Emails: 'sicon-email-lg',
        Meetings: 'sicon-meetings-lg',
        Messages: 'sicon-message-lg',
        Notes: 'sicon-note-lg',
        Cases: 'sicon-case-lg',
        Contacts: 'sicon-contact-lg',
        Accounts: 'sicon-account-lg',
        Leads: 'sicon-lead-lg',
        Opportunities: 'sicon-opportunity-lg',
        Quotes: 'sicon-quote-lg',
        Escalations: 'sicon-escalation-lg',
        Tasks: 'sicon-task-lg'
    },

    /**
     * Array default modules
     */
    defaultModules: [
        'Calls',
        'Emails',
        'Meetings',
        'Messages',
        'Notes',
        'Tasks'
    ],

    /**
     * Default mapping of module to link name
     */
    moduleLinkMapping: {
        Calls: 'calls',
        Emails: 'emails',
        Meetings: 'meetings',
        Messages: 'messages',
        Notes: 'notes',
        Tasks: 'tasks',
        Audit: 'audit'
    },

    /**
     * String id of the expanded model
     */
    expandedModelId: '',

    /**
     * Rendered layout activities
     */
    renderedActivities: [],

    /**
     * Boolean status of whether all models been fetched
     */
    fetchCompleted: false,

    /**
     * Array models of related modules
     */
    models: [],

    /**
     * Fields to show as record date for different modules
     */
    recordDateFields: {},

    /**
     * String param for store selected module in filter
     */
    filter: {
        module: null,
    },

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        if (options.context) {
            this.baseModule = options.context.get('module');
            this.module = this.baseModule;
            this.baseRecord = this._getBaseModel(options);
        }

        if (this.baseModule) {
            this._setActivityModulesAndFields(this.baseModule);
        }

        options.meta = _.extend({}, options.meta,
            {preview: this._getModuleFieldMeta()}
        );

        this._super('initialize', [options]);

        this.events = _.extend({}, this.events, {
            'click .static-contents': 'handleExpandedClick',
            'click .btn.more': 'fetchModels',
        });
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        // listen for activity-card-emailactions
        this.listenTo(this.context, 'emailclient:close', function() {
            this.reloadData();
        }, this);
    },

    /**
     * @inheritdoc
     *
     * Inject the singular module name.
     */
    _render: function() {
        this.disposeActivities();

        this._super('_render');

        if (this.models) {
            this.appendCardsToView(this.models);
        }
    },

    /**
     * Get base model from parent context
     *
     * @param {Object} options
     * @return {Data.Bean} model the base model of the dashlet
     */
    _getBaseModel: function(options) {
        var model;
        var baseModule = options.context.get('module');
        var currContext = options.context;
        while (currContext) {
            var contextModel = currContext.get('rowModel') || currContext.get('model');

            if (contextModel && contextModel.get('_module') === baseModule) {
                model = contextModel;

                var parentHasRowModel = currContext.parent && currContext.parent.has('rowModel');
                if (!parentHasRowModel) {
                    break;
                }
            }

            currContext = currContext.parent;
        }
        return model;
    },

    /**
     * Get the activity-timeline metadata for the baseModule
     *
     * @param {string} baseModule module name
     */
    getModulesMeta: function(baseModule) {
        return app.metadata.getView(baseModule, 'activity-timeline-base');
    },

    /**
     * Set activity modules and module field names
     *
     * @param {string} baseModule module name
     */
    _setActivityModulesAndFields: function(baseModule) {
        var modulesMeta = this.getModulesMeta(baseModule);
        var modules = [];

        if (!modulesMeta) {
            return;
        }

        if (this.filter.module && this.filter.module !== 'all_modules') {
            modules = _.filter(modulesMeta.activity_modules, function(module) {
                return (module.module.toLowerCase() === this.filter.module.toLowerCase());
            }, this);
        } else {
            modules = modulesMeta.activity_modules;
        }

        this.activityModules = _.map(modules, function(module) {
            return module.module;
        });

        if (this.activityModules.length === 0) {
            this.activityModules = this.defaultModules;
        }

        this.moduleFieldNames = {};
        this.recordDateFields = {};
        _.each(modules, function(module) {
            this.moduleFieldNames[module.module] = module.fields;
            this.recordDateFields[module.module] = module.record_date || 'date_entered';
        }, this);
    },

    /**
     * Get preview field metadata or record field metadata to render content
     *
     * @return {Object} fieldMeta view metadata of available fields for related modules
     */
    _getModuleFieldMeta: function() {
        var fieldMeta = {};
        _.each(this.activityModules, function(module) {
            var fieldMap = {};
            _.each(this.moduleFieldNames[module], function(field) {
                fieldMap[field] = true;
            });

            var meta = app.metadata.getView(module, 'preview') ||
                app.metadata.getView(module, 'record') || {};
            var fields = [];
            _.each(meta.panels, function(panel) {
                _.each(panel.fields, function(field) {
                    if (fieldMap[field.name]) {
                        fields.push(field);
                    }
                });
            });

            meta.panels = [{fields: fields}];
            fieldMeta[module] = meta;
        }, this);
        return fieldMeta;
    },

    /**
     * Initialize collection of related records to base record
     * @private
     */
    _initCollection: function() {
        if (!(this.baseModule && this.baseRecord && this.activityModules)) {
            return;
        }
        var self = this;
        var RelatedActivityCollection = app.MixedBeanCollection.extend({
            activityModules: this.activityModules,
            buildURL: _.bind(function(params) {
                params = params || {};

                var url = app.api.serverUrl + '/' + this.baseModule + '/' +
                    this.baseRecord.get('id') + '/' + 'link/related_activities';

                if (this.activityModules.indexOf('Audit') !== -1 && !_.isEmpty(this.moduleFieldNames.Audit)) {
                    params.field_list = {
                        'Audit': this.moduleFieldNames.Audit.join(','),
                    };
                }

                params.module_list = this.activityModules.join(',');

                if (params.module_list === 'Audit') {
                    params.ignore_field_presence = ['assigned_user_id'];
                }

                params = $.param(params);
                if (params.length > 0) {
                    url += '?' + params;
                }
                return url;
            }, this),
            sync: function(method, model, options) {
                options = app.data.parseOptionsForSync(method, model, options);
                if (options.params.fields) {
                    delete options.params.fields;
                }
                options.params.alias_fields = {
                    'record_date': self.recordDateFields
                };
                options.params.order_by = 'record_date:desc';
                var url = this.buildURL(options.params);
                var callbacks = app.data.getSyncCallbacks(method, model, options);

                app.api.call(method, url, options.attributes, callbacks);
            }
        });
        this.relatedCollection = new RelatedActivityCollection();
    },

    /**
     * @inheritdoc
     */
    loadData: function() {
        if (this._mode === 'config' || !this.filter.module) {
            return;
        }

        if (!this.relatedCollection) {
            this._initCollection();
        }

        this.fetchModels();
    },

    /**
     * Fetch models from related collection if not all models had been fetched
     */
    fetchModels: function() {
        if (!this.fetchCompleted && !_.isUndefined(this.relatedCollection)) {
            this.relatedCollection.fetch({
                offset: this.relatedCollection.next_offset,
                success: _.bind(function(coll) {
                    if (this.disposed) {
                        return;
                    }
                    _.each(coll.models, function(model) {
                        model.set('record_date', model.get(this.recordDateFields[model.get('_module')]));
                    }, this);
                    var appendToView = this.models.length !== 0;
                    this.models = this.models.concat(coll.models);
                    this.fetchCompleted = coll.next_offset === -1;
                    if (this.fetchCompleted) {
                        this.$('.dashlet-footer').hide();
                    }

                    if (appendToView) {
                        this.appendCardsToView(coll.models);
                    } else {
                        this.render();
                    }
                }, this)
            });
        }
    },

    /**
     * Set icon class attributess on related collection models base on module type
     */
    _setIconClass: function() {
        if (this.models) {
            _.each(this.models, function(model) {
                // it's a change card if the model's module is Audit, use this.module
                var mod = model.get('_module') == 'Audit' ? this.module : model.get('_module');
                model.set('icon_module', mod);
                model.set('icon_class', this.moduleIcons[mod]);
            }, this);
        }
    },

    /**
     * Set field metadata on related collection models
     *
     * @private
     * @param {Data.Bean} model the model to be patched with fields meta
     */
    _patchFieldsToModel: function(model) {
        var fieldsMeta = this.meta.preview;
        model.set('fieldsMeta', fieldsMeta[model.get('_module')]);
    },

    /**
     * Handle expand/collapse action when expand/collapse icon is clicked
     *
     * @param {Event} event Click event that triggers the action
     */
    handleExpandedClick: function(event) {
        var $element = this.$(event.currentTarget);
        var $parent = $element.closest('.timeline-entry');
        var modelId = $parent.data('id');
        // to toggle chevron up and down
        var $el = $element.find('.expand-collapse');

        // if model is already expanded, reset id and collapse panel
        if (modelId === this.expandedModelId) {
            this.expandedModelId = '';
            $el.removeClass('sicon-chevron-up').addClass('sicon-chevron-down');
            $parent.children('.expanded-contents').addClass('hide');
            $parent.children('.static-contents').removeClass('expanded');
            return;
        }

        // collapse existing expanded model
        if (this.expandedModelId) {
            var $expanded = this.$('.timeline-entry[data-id="' + this.expandedModelId + '"]');
            $expanded.children('.expanded-contents').addClass('hide');
            $expanded.children('.static-contents').removeClass('expanded');
            $expanded.find('.expand-collapse').removeClass('sicon-chevron-up').addClass('sicon-chevron-down');
        }

        var model = _.find(this.models, function(model) {
            return model.get('id') === modelId;
        });
        this.expandedModelId = modelId;

        // if model data fetched, expand; if not fetch then expand
        if (model.get('fullBeanFetched')) {
            $parent.children('.expanded-contents').removeClass('hide');
            $parent.children('.static-contents').addClass('expanded');
            $el.removeClass('sicon-chevron-down').addClass('sicon-chevron-up');
        } else {
            model.fetch({
                view: app.metadata.getView(model.get('_module'), 'preview') ? 'preview' : 'record',
                success: _.bind(function(m) {
                    model.set('fullBeanFetched', true);
                    this._patchFieldsToModel(model);
                    this._render();

                    var $modelEl = this.$('.timeline-entry[data-id="' + modelId + '"]');
                    $modelEl.children('.expanded-contents').removeClass('hide');
                    $modelEl.children('.static-contents').addClass('expanded');
                    $modelEl.find('.expand-collapse').removeClass('sicon-chevron-down').addClass('sicon-chevron-up');
                }, this)
            });
        }
    },

    /**
     * Reload data.
     */
    reloadData: function() {
        if (this.relatedCollection) {
            this.relatedCollection.reset([], {silent: true});
            this.relatedCollection.resetPagination();
        }
        this.fetchCompleted = false;
        this.models = [];
        this.render();
        this.loadData();
    },

    /**
     * Create new record.
     *
     * @param {Event} event Click event.
     * @param {Object} params
     * @param {string} params.module Module name.
     * @param {string} params.link Relationship link.
     */
    createRecord: function(event, params) {
        var self = this;
        var model = this.createLinkModel(this.baseRecord, params.link);

        app.drawer.open({
            layout: 'create',
            context: {
                create: true,
                module: params.module,
                model: model
            }
        }, function(context, model) {
            if (!model) {
                return;
            }
            self.reloadData();
        });
    },

    /**
     * Compose an email related to the relevant record.
     *
     * @param {Event} event Event.
     * @param {Object} params Parameters.
     * @param {string} params.module Module name.
     * @param {string} params.link Relationship link.
     */
    composeEmail: function(event, params) {
        if (this.useSugarEmailClient()) {
            this.once('emailclient:close', function() {
                this.reloadData();
            }, this);

            this.launchEmailClient(event);
        } else {
            var options = this._retrieveEmailOptions($(event.currentTarget));
            window.open(this._buildMailToURL(options), '_blank');
        }
    },

    /**
     * Used by EmailClientLaunch as a hook point to retrieve email options that
     * are specific to a view/field.
     *
     * @return {Object} Email options.
     * @private
     */
    _retrieveEmailOptionsFromLink: function() {
        var parentModel = this.baseRecord;
        var emailOptions = {};

        if (parentModel && parentModel.id) {
            // set parent model as option to be passed to compose for To address & relate
            // if parentModel does not have email, it will be ignored as a To recipient
            // if parentModel's module is not an available module to relate, it will also be ignored
            emailOptions = {
                to: [{bean: parentModel}],
                related: parentModel
            };
        }

        return emailOptions;
    },

    /**
     * Create and render card layout
     *
     * @param model
     * @return {Object}
     */
    createCard: function(model) {
        var module = model.get('_module') || model.module || '';

        if (module) {
            model.link = {
                name: this.getModuleLink(module),
                bean: this.baseRecord,
                type: 'card-link',
            };
        } else {
            model.link = {};
        }

        if (module === 'Audit') {
            model.set({
                parent_model: this.model
            });
        }

        var layout = app.view.createLayout({
            type: 'activity-card',
            context: this.context,
            module: module,
            model: model,
            layout: this.layout,
            timelineType: this.name || 'activity-timeline-base'
        });

        layout.initComponents();

        this.renderedActivities.push(layout);

        // cz Seedbed doesn't like it any other way
        layout.render();
        return layout;
    },

    /**
     * Appends cards
     * @param models array of models to be added to the view
     */
    appendCardsToView: function(models) {
        this._setIconClass();

        _.each(models, _.bind(function(model) {
            this._patchFieldsToModel(model);
            var layout = this.createCard(model);

            if (layout) {
                this.$('.activity-timeline-cards').append(layout.el);
            }

            // check menu icon visibilities
            layout.setCardMenuVisibilities();
        }, this));
    },

    /**
     * Get card module link.
     *
     * @param {string} moduleName The name of card module.
     * @return {string} The card module link.
     */
    getModuleLink: function(moduleName) {
        let link;
        let activityModules = this.getModulesMeta(this.baseModule).activity_modules;
        let module = activityModules.find(item => item.module === moduleName);

        if (module) {
            link = module.link || this.moduleLinkMapping[moduleName] || moduleName.toLowerCase();
        }

        return link;
    },

    /**
     * Disposes activities
     */
    disposeActivities: function() {
        _.each(this.renderedActivities, function(component) {
            component.dispose();
        });
        this.renderedActivities = [];
    },
    /**
     * @inheritdoc
     */
    _dispose: function() {
        this.disposeActivities();
        this._super('_dispose');
    }
})
