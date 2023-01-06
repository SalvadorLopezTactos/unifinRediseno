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
 * @class View.Views.Base.ActivityTimelineView
 * @alias SUGAR.App.view.views.BaseActivityTimelineView
 * @extends View.View
 */
({

    plugins: ['Dashlet', 'EmailClientLaunch', 'LinkedModel'],

    /**
     * Object icon names for modules
     */
    moduleIcons: {
        Calls: 'fa-phone',
        Emails: 'fa-envelope',
        Meetings: 'fa-calendar',
        Messages: 'fa-comment',
        Notes: 'fa-file-text',
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
    ],

    /**
     * String id of the expanded model
     */
    expandedModelId: '',

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
     *
     * Inject the singular module name.
     */
    _render: function() {
        this._super('_render');

        if (_.isFunction(this.layout.setTitle)) {
            var moduleSingular = app.lang.get(this.meta.label,
                this.module,
                {
                    moduleSingular: app.lang.getModuleName(this.module)
                }
            );
            this.layout.setTitle(moduleSingular);
        }
    },

    /**
     * Must implement this method as a part of the contract with the Dashlet
     * plugin. Kicks off the various paths associated with a dashlet:
     * Configuration, preview, and display.
     *
     * @param {string} viewName The name of the view as defined by the `oninit`
     *   callback in {@link DashletView#onAttach}.
     */
    initDashlet: function(viewName) {
        this._mode = viewName;

        if (this._mode === 'config') {
            this.layout.before('dashletconfig:save', function() {
                // save the toolbar
                if (this.meta.custom_toolbar) {
                    this.settings.set('custom_toolbar', this.meta.custom_toolbar);
                }
            }, this);
        }
    },

    /**
     * Get base model from parent context
     *
     * @param {Object} options
     * @return {Data.Bean} model the base model of the dashlet
     * @private
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
     * Set activity modules and module field names
     *
     * @param {string} baseModule module name
     */
    _setActivityModulesAndFields: function(baseModule) {
        var modulesMeta = app.metadata.getView(baseModule, 'activity-timeline');

        if (!modulesMeta) {
            return;
        }

        var modules = modulesMeta.activity_modules;

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

                params.module_list = this.activityModules.join(',');
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
        if (this._mode === 'config') {
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
                    this.models = this.models.concat(coll.models);
                    this.fetchCompleted = coll.next_offset === -1;
                    this._setIconClass();
                    this._render();
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
                model.set('icon_class', this.moduleIcons[model.get('_module')]);
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
            $el.removeClass('fa-chevron-up').addClass('fa-chevron-down');
            $parent.children('.expanded-contents').addClass('hide');
            $parent.children('.static-contents').removeClass('expanded');
            return;
        }

        // collapse existing expanded model
        if (this.expandedModelId) {
            var $expanded = this.$('.timeline-entry[data-id="' + this.expandedModelId + '"]');
            $expanded.children('.expanded-contents').addClass('hide');
            $expanded.children('.static-contents').removeClass('expanded');
            $expanded.find('.expand-collapse').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        }

        var model = _.find(this.models, function(model) {
            return model.get('id') === modelId;
        });
        this.expandedModelId = modelId;

        // if model data fetched, expand; if not fetch then expand
        if (model.get('fullBeanFetched')) {
            $parent.children('.expanded-contents').removeClass('hide');
            $parent.children('.static-contents').addClass('expanded');
            $el.removeClass('fa-chevron-down').addClass('fa-chevron-up');
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
                    $modelEl.find('.expand-collapse').removeClass('fa-chevron-down').addClass('fa-chevron-up');
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
    }
})
