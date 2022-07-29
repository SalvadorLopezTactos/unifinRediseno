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
 * @class View.Views.Base.PipelineRecordlistContentView
 * @alias SUGAR.App.view.views.BasePipelineRecordlistContentView
 * @extends View.Views.Base.PipelineRecordlistContentView
 */
({
    className: 'my-pipeline-content',
    monthsToDisplay: 6,

    events: {
        'click a[name=arrow-left]': 'navigateLeft',
        'click a[name=arrow-right]': 'navigateRight'
    },

    resultsPerPageColumn: 7,

    tileVisualIndicator: {
        'outOfDate': '#bb0e1b', // We can use any CSS accepted value for color, e.g: #CC1E13
        'nearFuture': '#ff9445',
        'inFuture': '#056f37',
        'default': '#145c95'
    },

    //used to force api to return these fields also for a proper coloring.
    tileVisualIndicatorFields: {
        'Opportunities': 'date_closed',
        'Tasks': 'date_due',
        'Leads': 'status',
        'Cases': 'status'
    },

    hasAccessToView: true,

    dataFetched: false,

    totalRecords: 0,

    /**
     * Cached fieldnames to retrieve for tile view
     * This does not include fields from record view
     */
    _fieldsToFetch: [],

    /**
     * Initialize various pipelineConfig variables and set action listeners
     *
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        this.startDate = app.date().format('YYYY-MM-DD');
        this.pipelineConfig = app.metadata.getModule('VisualPipeline', 'config');
        this.meta = _.extend(
            this.meta || {},
            app.metadata.getView(null, 'pipeline-recordlist-content'),
            app.metadata.getView(this.module, 'pipeline-recordlist-content')
        );
        this.pipelineFilters = [];
        this.hiddenHeaderValues = [];
        this.action = 'list';
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this._super('bindDataChange');

        this.context.on('pipeline:recordlist:model:created', this.handleTileViewCreate, this);
        this.context.on('pipeline:recordlist:filter:changed', this.buildFilters, this);
        this.context.on('button:delete_button:click', this.deleteRecord, this);
        this.context.on('pipeline:recordlist:resizeContent', this.resizeContainer, this);
        this.resizeContainerHandler = _.bind(this.resizeContainer, this);
        window.addEventListener('resize', this.resizeContainerHandler);
    },

    /**
     * Triggers a re-fetch for the model added by the create drawer.
     * @param {Data.Bean} model The model created through the drawer.
     */
    handleTileViewCreate: function(model) {
        this._callWithTileModel(model, 'addModelToCollection');
    },

    /**
     * Builds metadata for each tile in the recordlist view
     */
    buildTileMeta: function() {
        var tileDef = this.meta.tileDef || [];
        var tileBodyArr = [];
        var fieldMetadata = app.metadata.getModule(this.module, 'fields');

        _.each(tileDef.panels, function(panel) {
            if (panel.is_header) {
                panel.fields = [fieldMetadata[this.pipelineConfig.tile_header[this.module]]];
            } else {
                var tileBodyField = this.pipelineConfig.tile_body_fields[this.module];
                _.each(tileBodyField, function(tileBody) {
                    var tileFieldMeta = app.utils.deepCopy(fieldMetadata[tileBody]);
                    if (_.isObject(tileFieldMeta.displayParams)) {
                        _.extend(tileFieldMeta, tileFieldMeta.displayParams);
                        delete tileFieldMeta.displayParams;
                    }
                    tileBodyArr.push(tileFieldMeta);
                }, this);
                panel.fields = tileBodyArr;
            }
        }, this);

        this.meta.tileDef = tileDef;
    },

    /**
     * Sets number of results to be displayed for a column in the page
     * @param {integer} resultsNum
     */
    setResultsPerPageColumn: function(resultsNum) {
        var recordsPerColumn = this.pipelineConfig.records_per_column[this.module];
        resultsNum = resultsNum || recordsPerColumn;
        var results = parseInt(resultsNum);
        if (!isNaN(results)) {
            this.resultsPerPageColumn = results;
        }
    },

    /**
     * Sets values to be hidden in the tile
     * @param {Array} hiddenValues an array of values to be hidden
     */
    setHiddenHeaderValues: function(hiddenValues) {
        hiddenValues =
            hiddenValues || this.pipelineConfig.hidden_values[this.module] || [];
        if (_.isEmpty(hiddenValues)) {
            return;
        }

        this.hiddenHeaderValues = hiddenValues;
    },

    /**
     * Builds filter definition for the tiles to be recordlist to be displayed and reloads the data
     * @param {Array} filterDef
     */
    buildFilters: function(filterDef) {
        this.pipelineType = this.context.get('model').get('pipeline_type');
        this.pipelineFilters = filterDef || [];
        this.offset = 0;
        this.loadData();
    },

    /**
     * Checks if the user has access to view and loads data to be displayed on the recordlist
     */
    loadData: function() {
        this.recordsToDisplay = [];
        this.buildTileMeta();
        this.setResultsPerPageColumn();
        this.setHiddenHeaderValues();

        this.getTableHeader();
        if (this.hasAccessToView) {
            this.buildRecordsList();
        }
    },

    /**
     * Sets records to display.
     *
     * @param {string} headerField The header field
     * @param {Array} options List of options
     */
    _setRecordsToDisplay: function(headerField, options) {
        // Get all the whitelisted column names for current module
        if (!_.isUndefined(this.pipelineConfig.available_columns) &&
            !_.isUndefined(this.pipelineConfig.available_columns[this.module])) {
            var items = this.pipelineConfig.available_columns[this.module][headerField];
            var index = 0;
            _.each(items, function(item, key) {
                index = index <= 11 ? index : index % 12;
                if (!_.isEmpty(options[key]) && (_.indexOf(this.hiddenHeaderValues, item) === -1)) {
                    this.recordsToDisplay.push({
                        'headerName': options[key],
                        'headerKey': key,
                        'records': [],
                        'colorIndex': index,
                    });
                    index++;
                }
            }, this);
        } else {
            var items = _.difference(options, this.hiddenHeaderValues);
            _.each(options, function(option, key) {
                var index = _.indexOf(items, option);
                index = index <= 11 ? index : index % 12;
                if (!_.isEmpty(key) && (_.indexOf(this.hiddenHeaderValues, key) === -1)) {
                    this.recordsToDisplay.push({
                        'headerName': option,
                        'headerKey': key,
                        'records': [],
                        'colorIndex': index,
                    });
                }
            }, this);
        }
    },

    /**
     * Gets the table headers for all the columns being displayed on the page
     */
    getTableHeader: function() {
        if (this.pipelineType !== 'date_closed') {
            var headerField = this.pipelineConfig.table_header[this.module] || '';

            if (!app.acl.hasAccessToModel('read', this.model, headerField)) {
                this.context.trigger('open:config:fired');
                return;
            }

            if (headerField) {
                var moduleFields = app.metadata.getModule(this.module, 'fields');
                var optionsList = moduleFields[headerField].options;

                if (optionsList) {
                    var options = app.lang.getAppListStrings(optionsList) || [];
                }

                if (!_.isEmpty(options)) {
                    this._setRecordsToDisplay(headerField, options);
                } else {
                    // call enum api
                    app.api.enumOptions(this.module, headerField, {
                        success: _.bind(function(data) {
                            if (!this.disposed) {
                                this._setRecordsToDisplay(headerField, data);
                                this._super('_render');
                                if (this.hasAccessToView) {
                                    this.buildRecordsList();
                                }
                            }
                        }, this)
                    });
                }
            }

            this.headerField = headerField;
        } else {
            var self = this;
            var currDate = app.date(this.startDate);

            this.recordsToDisplay.push({
                'headerName': currDate.format('MMMM YYYY'),
                'headerKey': currDate.format('MMMM YYYY'),
                'records': [],
                'colorIndex': 0,
            });

            for (var i = 1; i < this.monthsToDisplay; i++) {
                currDate.add(1, 'months');
                self.recordsToDisplay.push({
                    'headerName': currDate.format('MMMM YYYY'),
                    'headerKey': currDate.format('MMMM YYYY'),
                    'records': [],
                    'colorIndex': i,
                });
            }
            this.headerField = 'date_closed';
        }

        this.hasAccessToView = app.acl.hasAccessToModel('read', this.model, this.headerField) ? true : false;
        this._super('render');
    },

    /**
     * Gets the colors for each of the column headers
     * @return {string[]|null|Array} an array of hexcode for the colors
     * @deprecated Since 10.3.0
     */
    getColumnColors: function() {
        app.logger.warn(
            'getColumnColors() is deprecated in 10.3.0. ' +
            'Please use the utility CSS class: .pipeline-bg-color-n where n is 0-11.'
        );
        var columnColor = this.pipelineConfig.header_colors;
        if (_.isEmpty(columnColor) || columnColor == 'null') {
            columnColor = {};
        }

        return columnColor;
    },

    /**
     * Sets offset to 0 before render
     */
    preRender: function() {
        this.offset = 0;
    },

    /**
     * Call the render method from the super class to render the view between the calls to preRender and postRender
     * @inheritdoc
     */
    render: function() {
        this.preRender();
        this._super('render');
        this.postRender();
    },

    /**
     * Calls methods to add draggable action to the tile and bind scroll to the view
     */
    postRender: function() {
        this.resizeContainer();
        this.buildDraggable();
        this.bindScroll();
    },

    /**
     * Adds a newly created model to the view.
     * @param {Object} model Model that should be added to a column.
     */
    addModelToCollection: function(model) {
        var collection = this.getColumnCollection(model);

        if (collection && collection.records) {
            var literal = this.addTileVisualIndicator([model.toJSON()]);
            model.set('tileVisualIndicator', literal[0].tileVisualIndicator);

            collection.records.add(model, {at: 0});
            this.dataFetched = true;
            this.totalRecords = this.totalRecords + 1;
        }

        this._super('render');
        this.postRender();
    },

    /**
     * Returns the collection of the column to which a new opportunity is being added
     * @param {Object} model for the newly created opportunity
     * @return {*} a collection object
     */
    getColumnCollection: function(model) {
        if (this.pipelineType === 'date_closed') {
            return _.findWhere(this.recordsToDisplay, {
                headerName: app.date(model.get(this.headerField)).format('MMMM YYYY')
            });
        }

        return _.findWhere(this.recordsToDisplay, {headerKey: model.get(this.headerField)});
    },

    /**
     * Shows the loading cell and calls method to fetch all the records to be displayed on the page
     */
    buildRecordsList: function() {
        app.alert.show('pipeline-records-loading', {
            level: 'process'
        });
        this.getRecords();
    },

    /**
     * Returns an array of all the filters to be applied on the records
     * @param {Object} column contains details like headerName, headerKey etc. about a column of records
     * @return {Array}
     */
    getFilters: function(column) {
        var filter = [];
        var filterObj = {};

        if (this.pipelineType !== 'date_closed') {
            filterObj[this.headerField] = {'$equals': column.headerKey};
            filter.push(filterObj);
            _.each(this.pipelineFilters, function(filterDef) {
                filter.push(filterDef);
            }, this);
        } else {
            var startMonth = app.date(column.headerName, 'MMMM YYYY').startOf('month').format('YYYY-MM-DD');
            var endMonth = app.date(column.headerName, 'MMMM YYYY').endOf('month').format('YYYY-MM-DD');
            filterObj[this.headerField] = {'$dateBetween': [startMonth, endMonth]};
            filter.push(filterObj);

            _.each(this.pipelineFilters, function(filterDef) {
                filter.push(filterDef);
            }, this);
        }

        return filter;
    },

    /**
     * Return an array of fields to be fetched and displayed on each tile
     * @return {Array} an array of fields
     */
    getFieldsForFetch: function() {
        if (!_.isEmpty(this._fieldsToFetch)) {
            return this._fieldsToFetch;
        }
        var fields =
            _.flatten(
                _.map(_.flatten(_.pluck(this.meta.tileDef.panels, 'fields')), function(field) {
                    if (field === undefined) {
                        return;
                    }
                    return _.union(_.pluck(field.fields, 'name'), _.flatten(field.related_fields), [field.name]);
                })
            );

        fields.push(
            this.headerField,
            this.tileVisualIndicatorFields[this.module]
        );

        var fieldMetadata = app.metadata.getModule(this.module, 'fields');
        if (fieldMetadata) {
            // Filter out all fields that are not actual bean fields
            fields = _.reject(fields, function(name) {
                return _.isUndefined(fieldMetadata[name]);
            });
        }

        return this._fieldsToFetch = _.uniq(fields);
    },

    /**
     * Uses fields to get the requests for the data to be fetched
     */
    getRecords: function() {
        var fields = this.getFieldsForFetch();
        var requests = this.buildRequests(fields);
        this.fetchData(requests);
    },

    /**
     * Uses fields, filters and other properties to build requests for the data to be fetched
     * @param {Array} fields to be displayed on each tile
     * @return {Array} an array of request objects with dataType, method and url
     */
    buildRequests: function(fields) {
        var requests = {};
        requests.requests = [];

        _.each(this.recordsToDisplay, function(column) {
            var filter = this.getFilters(column);

            var getArgs = {
                filter: filter,
                fields: fields,
                'max_num': this.resultsPerPageColumn,
                'offset': this.offset,
                'order_by': {date_modified: 'DESC'}
            };

            var req = {
                'url': app.api.buildURL(this.module, null, null, getArgs).replace('rest/', ''),
                'method': 'GET',
                'dataType': 'json'
            };

            requests.requests.push(req);
        }, this);

        return requests;
    },

    /**
     * Makes the api call to get the data for the tiles
     * @param {Array} requests an array of request objects
     */
    fetchData: function(requests) {
        var self = this;
        this.moreData = false;
        app.api.call('create', app.api.buildURL(null, 'bulk'), requests, {
            success: function(dataColumns) {
                app.alert.dismiss('pipeline-records-loading');
                if (dataColumns.length !== self.recordsToDisplay.length) {
                    // the data being returned is not for this view
                    // user must've clicked several tabs before data finished loading
                    return;
                }
                self.dataFetched = true;
                self.totalRecords = 0;
                _.each(self.recordsToDisplay, function(column, index) {
                    var records = app.data.createBeanCollection(self.module);
                    if (!_.isEmpty(column.records.models)) {
                        records = column.records;
                    }
                    var contents = dataColumns[index].contents;
                    var augmentedContents = self.addTileVisualIndicator(contents.records);
                    records.add(augmentedContents);
                    column.records = records;
                    self.totalRecords = self.totalRecords + records.length;

                    if (contents.next_offset > -1 && !self.moreData) {
                        self.moreData = true;
                    }
                }, self);

                self._super('render');
                self.postRender();

                if (self.moreData) {
                    self.offset += self.resultsPerPageColumn;
                }
            }
        });
    },

    resizeContainer: function() {
        var $parent = this.$el.parents('.main-pane');
        var $searchFilter = $parent.find('.search-filter');
        var height = $parent.height() - $searchFilter.height();

        this.$el.height(height + 'px');
        this.$('.pipeline-column').height((height - 150) + 'px');
    },

    /**
     * Gives the ability for a tile to be dragged and moved to other columns on the page
     */
    buildDraggable: function() {
        if (!app.acl.hasAccessToModel('edit', this.model) ||
            !app.acl.hasAccessToModel('edit', this.model, this.headerField)) {
            return;
        }

        this.$('.column').sortable({
            connectWith: '.column',
            handle: '.pipeline-tile',
            cancel: '.portlet-toggle',
            placeholder: 'portlet-placeholder ui-corner-all',
            receive: _.bind(function(event, ui) {
                var modelId = this.$(ui.item).data('modelid');
                var oldCollection = _.findWhere(this.recordsToDisplay, {
                    headerKey: this.$(ui.sender).attr('data-column-name')
                });
                var newCollection = _.findWhere(this.recordsToDisplay, {
                    headerKey: this.$(ui.item).parent('ul').attr('data-column-name')
                });
                var model = oldCollection.records.get(modelId);
                if (!app.acl.hasAccessToModel('edit', model)) {
                    app.alert.show('not_authorized', {
                        level: 'error',
                        messages: 'Not allowed to perform action "save" on this record',
                        autoClose: true,
                    });

                    this.$(ui.sender).sortable('cancel');
                    return;
                }
                var success = _.bind(function() {
                    this.switchCollection(oldCollection, model, newCollection);
                    this.saveModel(model, {
                        ui: ui,
                        oldCollection: oldCollection,
                        newCollection: newCollection
                    });
                }, this);
                var error = _.bind(function() {
                    this.$(ui.sender).sortable('cancel');
                    this.$('.column').sortable('enable');
                }, this);
                var complete = function() {
                    app.alert.dismiss('model_loading');
                };

                // Run any functionality necessary before the change is processed
                this._preChange();

                model.fetch({
                    view: 'record',
                    fields: this.getFieldsForFetch(),
                    success: success,
                    error: error,
                    complete: complete
                });
            }, this)
        });

        this.$('.portlet')
            .addClass('ui-widget ui-widget-content ui-helper-clearfix ui-corner-all')
            .find('.span12')
            .addClass('ui-widget-header ui-corner-all');
    },

    /**
     * Gets called when a tile is dragged to another column
     * Removes the tile from the former column collection and adds it to the later one
     * @param {Object} oldCollection Collection object for the column to which the tile previously belonged
     * @param {Object} model model of the tile being moved
     * @param {Object} newCollection Collection object for the column to which the tile is moved
     */
    switchCollection: function(oldCollection, model, newCollection) {
        oldCollection.records.remove(model);
        newCollection.records.add(model, {at: 0});
    },

    /**
     * Gets called to save the model once it switches columns
     * @param {Object} model for the tile to be saved
     * @param {Object} pipelineData contains info about the pipeline ui and collections involved in the change
     */
    saveModel: function(model, pipelineData) {
        var self = this;

        // Set the changes on the model before validating and saving. If validation
        // fails, the updated model will be opened in a record view drawer which causes
        // the synced attributes to change, so we need to store a backup of the
        // previous values for changed fields on the model in case we need to revert
        this._setNewModelValues(model, pipelineData.ui);
        model.oldValues = _.pick(model.previousAttributes(), function(value, key) {
            return key in model.changed;
        });

        // Validate the model according to the record view validation rules. For
        // accurate validation which takes SugarLogic dependencies into account,
        // we need to actually open the record view. Here we load the view into
        // the side drawer (without opening it), then validate it. If validation
        // is successful, the model/collection change is saved. Otherwise, the
        // record view is opened in a regular drawer for the user to fix the
        // invalid fields
        var sideDrawer = this._getSideDrawer();
        var beanCollection = app.data.createBeanCollection(this.module, [model]);
        if (sideDrawer) {
            sideDrawer.showComponent({
                layout: 'tile-validation-drawer',
                context: {
                    skipRouting: true,
                    model: model,
                    collection: beanCollection,
                    module: self.module,
                    saveImmediately: true,
                    validationCallback: function(isValid) {
                        self._handleValidationResults(isValid, model, pipelineData);
                    },
                    saveCallback: function(saved) {
                        self._callWithTileModel(model, '_postChange', [!saved, pipelineData]);
                    }
                }
            });
        }
    },

    /**
     * Sets the changed values on the model before validation and saving. This is
     * useful to override in case custom action must be taken to handle field changes
     * (for example, converting "January 2020" to "01/31/2020" before setting the
     * value on the model)
     * @param {Object} model the model to set the values on
     * @param (Object} ui an object with the ui details of the tiles like originalPosition, offset, etc.
     * @private
     */
    _setNewModelValues: function(model, ui) {
        model.set(this.headerField, this.$(ui.item).parent('ul').attr('data-column-name'));
    },

    /**
     * Gets the side drawer component associated with the layout
     * @return {Object} The side drawer, or undefined if it does not exist
     * @private
     */
    _getSideDrawer: function() {
        if (!this.sideDrawer) {
            this.sideDrawer = this.layout.getComponent('side-drawer');
        }
        return this.sideDrawer;
    },

    /**
     * Opens a drawer to the record view to fix any invalid fields on the model
     * after switching the model to a new column
     * @param isValid boolean indicating whether the model passed validation
     * @param {Object} model the model that was validated
     * @param {Object} pipelineData contains info about the pipeline ui and collections involved in the change
     * @private
     */
    _handleValidationResults: function(isValid, model, pipelineData) {
        if (!isValid) {
            var self = this;
            var beanCollection = app.data.createBeanCollection(this.module, [model]);
            app.drawer.open({
                layout: 'tile-validation-drawer',
                context: {
                    skipRouting: true,
                    module: self.module,
                    model: model,
                    collection: beanCollection,
                    noEditFields: [self.headerField],
                    saveImmediately: true,
                    saveCallback: function(saved) {
                        app.drawer.close(saved);
                    },
                    cancelCallback: function() {
                        app.drawer.close(false);
                    },
                    editOnly: true
                }
            }, function(saved) {
                self._callWithTileModel(model, '_postChange', [!saved, pipelineData]);
            });
        }
    },

    /**
     * Utility function that runs before a column change is processed
     * @private
     */
    _preChange: function() {
        // Disable dragging while the change is being processed to prevent any
        // potential issues due to multiple simultaneous drag/drops
        this.$('.column').sortable('disable');

        // Display a loading message while the model data is being fetched
        app.alert.show('model_loading', {
            level: 'process',
        });
    },

    /**
     * Utility function. It fetches a model with only the fields required by the view.
     * @param {Object} model A model that is passed to the view from elsewhere.
     * @param {string} methodName The name of the method that should be called with the tile view compatible model.
     * This method should has to accept at least 1 parameter, the first being a model.
     * @param {Array} params Any other params that should be passed to the method called.
     * @private
     */
    _callWithTileModel: function(model, methodName, params) {
        this._preChange();
        var tileModel = app.data.createBean(this.module, {
            id: model.get('id')
        });
        tileModel.fetch({
            view: 'record',
            fields: this.getFieldsForFetch(),
            success: _.bind(function() {
                var newParams = _.union([tileModel], params || []);
                this[methodName].apply(this, newParams);
            }, this),
            error: _.bind(function() {
                this.$('.column').sortable('enable');
            }, this),
            complete: function() {
                app.alert.dismiss('model_loading');
            }
        });
    },

    /**
     * Utility function that runs after a column change is processed
     * @param {Object} model the model involved in the column change
     * @param {boolean} shouldRevert indicates whether the change needs to be reverted
     * @param {Object} pipelineData contains info about the pipeline ui and collections involved in the change
     * @private
     */
    _postChange: function(model, shouldRevert, pipelineData) {
        var validCollection = this.getColumnCollection(model);
        if (shouldRevert) {
            this._revertChanges(model, pipelineData);
        } else if (validCollection.headerKey !== pipelineData.newCollection.headerKey) {
            this.switchCollection(pipelineData.newCollection, model, validCollection);
        }

        // Since both this view and the record view make changes to the model,
        // sync its final attributes here to avoid "unsaved changes" warnings
        model.setSyncedAttributes(model.attributes);

        this._super('render');
        this.postRender();
        this.$('.column').sortable('enable');
    },

    /**
     * Reverts the changes to the model and collections made by a column move
     * @param {Object} model the model involved in the change
     * @param {Object} pipelineData contains info about the pipeline ui and collections involved in the change
     * @private
     */
    _revertChanges: function(model, pipelineData) {
        model.set(model.oldValues);
        this.switchCollection(pipelineData.newCollection, model, pipelineData.oldCollection);
        this.$(pipelineData.ui.sender).sortable('cancel');
    },

    /**
     * Action listener when the delete button is clicked on the tile
     * Asks for user confirmation and delete the tile record from the view
     * @param {Object} model model object of the tile to be deleted
     */
    deleteRecord: function(model) {
        var collection = model.collection;
        var self = this;

        app.alert.show('delete_confirmation', {
            level: 'confirmation',
            messages: self.getDeleteMessages(model).confirmation,
            onConfirm: function() {
                model.destroy({
                    showAlerts: {'process': true, 'success': {messages: self.getDeleteMessages(model).success}},
                    success: function(data) {
                        self.totalRecords = self.totalRecords - 1;
                        self._super('render');
                        self.postRender();
                    }
                });
            },
            onCancel: function() {
                return;
            }
        });
    },

    /**
     * Gets called when a tile record is successfully deleted
     * Displays the delete confirmation and success message
     * @param {Object} model model object of the deleted tile
     */
    getDeleteMessages: function(model) {
        var messages = {};
        var name = Handlebars.Utils.escapeExpression(app.utils.getRecordName(model)).trim();
        var context = app.lang.getModuleName(model.module).toLowerCase() + ' ' + name;
        messages.confirmation = app.utils.formatString(app.lang.get('NTC_DELETE_CONFIRMATION_FORMATTED'), [context]);
        messages.success = app.utils.formatString(app.lang.get('NTC_DELETE_SUCCESS'), [context]);
        return messages;
    },

    /**
     * Binds scroll to the recordlist pane
     */
    bindScroll: function() {
        this.$el.on('scroll', _.bind(this.listScrolled, this));
    },

    /**
     * Listens to the scroll event on the list
     * Checks and displays if more data is present on the page
     * @param event
     */
    listScrolled: function(event) {
        var elem = $(event.currentTarget);
        var isAtBottom = (elem[0].scrollHeight - elem.scrollTop()) <= elem.outerHeight();

        if (isAtBottom && this.moreData) {
            this.buildRecordsList();
        }
    },

    /**
     * Adds the visual indicator to all the tiles based on the status or date depending on the modules
     * @param {Array} modelsList a list of all the tile models
     * @return {Array} updated model list with all the indicator values
     */
    addTileVisualIndicator: function(modelsList) {
        var self = this;
        var updatedModel = {};
        var dueDate = app.date();
        var expectedCloseDate = app.date();

        return _.map(modelsList, function(model) {
            switch (model._module) {
                case 'Cases':
                    updatedModel = self.addIndicatorBasedOnStatus(model);
                    break;
                case 'Leads':
                    updatedModel = self.addIndicatorBasedOnStatus(model);
                    break;
                case 'Opportunities':
                    expectedCloseDate = app.date(model.date_closed, 'YYYY-MM-DD');
                    updatedModel = self.addIndicatorBasedOnDate(model, expectedCloseDate);
                    break;
                case 'Tasks':
                    dueDate = app.date.parseZone(model.date_due);
                    updatedModel = self.addIndicatorBasedOnDate(model, dueDate);
                    break;
                default:
                    model.tileVisualIndicator = self.tileVisualIndicator.default;
                    updatedModel = model;
            }

            return updatedModel;
        });
    },

    /**
     * Adds indicator based on the date_closed or date_due
     * @param {Object} model model object for the tile to which the indicator is being added
     * @param {string} date date string related to the model
     * @return {Object} updated model with visual indicator
     */
    addIndicatorBasedOnDate: function(model, date) {
        var now = app.date();
        var aMonthFromNow = app.date().add(1, 'month');

        if (date.isBefore(now)) {
            model.tileVisualIndicator = this.tileVisualIndicator.outOfDate;
        }
        if (date.isAfter(aMonthFromNow)) {
            model.tileVisualIndicator = this.tileVisualIndicator.inFuture;
        }
        if (date.isBetween(now, aMonthFromNow)) {
            model.tileVisualIndicator = this.tileVisualIndicator.nearFuture;
        }

        return model;
    },

    /**
     * Adds indicator based on the Opportunity status
     * @param {Object} model model object for the tile to which the indicator is being added
     * @return {Object} updated model with visual indicator
     */
    addIndicatorBasedOnStatus: function(model) {
        // Group statuses in 3 categories:
        var inFuture = ['New', 'Converted'];
        var outOfDate = ['Dead', 'Closed', 'Rejected', 'Duplicate', 'Recycled'];
        var nearFuture = ['Assigned', 'In Process', , 'Pending Input', ''];

        if (_.indexOf(outOfDate, model.status) !== -1) {
            model.tileVisualIndicator = this.tileVisualIndicator.outOfDate;
        }
        if (_.indexOf(inFuture, model.status) !== -1) {
            model.tileVisualIndicator = this.tileVisualIndicator.inFuture;
        }
        if (_.indexOf(nearFuture, model.status) !== -1) {
            model.tileVisualIndicator = this.tileVisualIndicator.nearFuture;
        }

        return model;
    },

    /**
     * Listens to the arrow-left button click
     * Updates the start date to 5 months prior
     * Sets offset to 0
     * Reloads the data in the recordlist view
     */
    navigateLeft: function() {
        this.startDate = app.date(this.startDate).subtract(5, 'month').format('YYYY-MM-DD');
        this.offset = 0;
        this.loadData();
    },

    /**
     * Listens to the arrow-right button click
     * Updates the start date to next 5 months
     * Sets offset to 0
     * Reloads the data in the recordlist view
     */
    navigateRight: function() {
        this.startDate = app.date(this.startDate).add(5, 'month').format('YYYY-MM-DD');
        this.offset = 0;
        this.loadData();
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        window.removeEventListener('resize', this.resizeContainerHandler);

        this.context.off('pipeline:recordlist:model:created', null, this);
        this.context.off('pipeline:recordlist:filter:changed', null, this);
        this.context.off('button:delete_button:click', null, this);
        this.context.off('pipeline:recordlist:resizeContent', null, this);

        this.$el.off('scroll');

        this._super('_dispose');
    }
})
