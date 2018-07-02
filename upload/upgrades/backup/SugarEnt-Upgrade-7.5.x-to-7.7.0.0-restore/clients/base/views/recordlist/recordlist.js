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
 * @class View.Views.Base.RecordlistView
 * @alias SUGAR.App.view.views.BaseRecordlistView
 * @extends View.Views.Base.FlexListView
 */
({
    extendsFrom: 'FlexListView',
    plugins: [
        'SugarLogic',
        'ReorderableColumns',
        'ListColumnEllipsis',
        'ErrorDecoration',
        'Editable',
        'MergeDuplicates',
        'Pagination',
        'LinkedModel'
    ],

    /**
     * List of current inline edit models.
     *
     * @property
     */
    toggledModels: null,

    rowFields: {},

    /**
     * View name that corresponds to the list of fields API should retrieve
     */
    dataViewName: 'list',

    contextEvents: {
        "list:editall:fire": "toggleEdit",
        "list:editrow:fire": "editClicked",
        "list:deleterow:fire": "warnDelete"
    },

    /**
     * @override
     * @param {Object} options
     */
    initialize: function(options) {
        //Grab the record list of fields to display from the base metadata
        var recordListMeta = this._initializeMetadata(options.context);
        //Allows sub-views to override and use different view metadata if desired
        options.meta = this._filterMeta(_.extend({}, recordListMeta, options.meta || {}), options);
        this._super("initialize", [options]);

        //Extend the prototype's events object to setup additional events for this controller
        this.events = _.extend({}, this.events, {
            'click [name=inline-cancel]' : 'resize'
        });

        this.on('render', this._setRowFields, this);

        //Set the context to load the field list from the record metadata.
        this.context.set('dataView', this.dataViewName);

        //fire resize scroll-width on column add/remove
        this.on('list:toggle:column', this.resize, this);
        this.on('mergeduplicates:complete', this.refreshCollection, this);
        this.on('field:focus:location', this.setPanelPosition, this);
        if (this.layout) {
            this.layout.on('list:mergeduplicates:fire', this.mergeDuplicatesClicked, this);

            // We listen for if the search filters are opened or not. If so, when
            // user clicks show more button, we treat this as a search, otherwise,
            // normal show more for list view.
            this.layout.on('list:filter:toggled', this.filterToggled, this);
        }
        this.toggledModels = {};

        this.context._recordListFields = this.getFieldNames(null, true);

        this._currentUrl = Backbone.history.getFragment();

        //event register for preventing actions
        // when user escapes the page without confirming deleting
        app.routing.before("route", this.beforeRouteDelete, this, true);
        $(window).on("beforeunload.delete" + this.cid, _.bind(this.warnDeleteOnRefresh, this));
    },

    /**
     * Update the filter enable status.
     *
     * @param {Boolean} isOpened Value whether the filter is opened.
     */
    filterToggled: function(isOpened) {
        this.context.set('filterOpened', isOpened);
    },

    /**
     * Add the opened filter options to the paginate query.
     * Please see the {@link Pagination#getNextPagination} for detail.
     *
     * @return {Object} Pagination fetch options.
     */
    getPaginationOptions: function() {
        // If in "search mode" (the search filter is toggled open) set q:term param
        var options = this.context.get('filterOpened') ? this.getSearchOptions() : {};

        // Dashboard layout injects shared context with limit: 5.
        // Otherwise, we don't set so fetches will use max query in config.
        if (this.context.get('limit')) {
            options.limit = this.context.get('limit');
        }
        options = _.extend({}, this.context.get('collectionOptions'), options);
        return options;
    },

    /**
     * Add the previous typed search term.
     *
     * @return {Object} Pagination fetch options.
     */
    getSearchOptions: function() {
        var collection, options, previousTerms, term = '';
        collection = this.context.get('collection');

        // If we've made a previous search for this module grab from cache
        if (app.cache.has('previousTerms')) {
            previousTerms = app.cache.get('previousTerms');
            if (previousTerms) {
                term = previousTerms[this.module];
            }
        }
        // build search-specific options and return
        options = {
            params: {
                q: term
            },
            fields: collection.fields ? collection.fields : this.collection
        };
        return options;
    },

    /**
     * Retrieve the metadata of the recordlist view
     *
     * @returns {Object}
     * @private
     */
    _initializeMetadata: function() {
        return app.metadata.getView(null, 'recordlist') || {};
    },

    /**
     * Filters the given meta removing non-applicable portions
     * @param {Object} meta data to be filtered
     * @return {*}
     * @private
     */
    _filterMeta : function(meta, options){
        //Don't show the update calc field option if the module has no calculated fields or the user is not a dev for that module
        var context = options.context,
            isDeveloper = app.acl.hasAccess("developer", context.get("module")),
            hasCalcFields = context && context.get("model") && !!_.find(context.get("model").fields, function(def) {
                return def && def.calculated && def.calculated != "false";
            });
        if ((!isDeveloper || !hasCalcFields) && meta.selection && meta.selection.actions) {
            meta.selection.actions = _.reject(meta.selection.actions, function(action) {
                return action.name == "calc_field_button";
            });
        }

        return meta;
    },

    /**
     * Refresh the current collection set.
     */
    refreshCollection: function() {
        this.collection.fetch();
    },

    addActions:function () {
        if (this.actionsAdded) return;
        this._super("addActions");
        if(_.isUndefined(this.leftColumns[0])){
            //Add blank left column to contain favorite and inline-cancel buttons
            this.leftColumns.push({
                'type':'fieldset',
                'label': '',
                'sortable': false,
                'fields': []
            });
        }
        //Add Favorite to left
        this.addFavorite();

        //Add Save & Cancel
        var firstLeftColumn = this.leftColumns[0];
        if (firstLeftColumn && _.isArray(firstLeftColumn.fields)) {
            //Add Cancel button to left
            firstLeftColumn.fields.push({
                type:'editablelistbutton',
                label:'LBL_CANCEL_BUTTON_LABEL',
                name:'inline-cancel',
                css_class:'btn-link btn-invisible inline-cancel'
            });
            this.leftColumns[0] = firstLeftColumn;
        }
        var firstRightColumn = this.rightColumns[0];
        if (firstRightColumn && _.isArray(firstRightColumn.fields)) {
            //Add Save button to right
            firstRightColumn.css_class = 'overflow-visible';
            firstRightColumn.fields.push({
                type:'editablelistbutton',
                label:'LBL_SAVE_BUTTON_LABEL',
                name:'inline-save',
                css_class:'btn-primary'
            });
            this.rightColumns[0] = firstRightColumn;
        }
        this.actionsAdded = true;
    },

    /**
     * Add favorite column
     */
    addFavorite: function() {
        var favoritesEnabled = app.metadata.getModule(this.module, "favoritesEnabled");
        if (favoritesEnabled !== false
            && this.meta.favorite && this.leftColumns[0] && _.isArray(this.leftColumns[0].fields)) {
            this.leftColumns[0].fields.push({type:'favorite'});
        }
    },

    /**
     * Set, or reset, the collection of fields that contains each row.
     *
     * This function is invoked when the view renders. It will update the row
     * fields once the `Pagination` plugin successfully fetches new records.
     *
     * @private
     */
    _setRowFields: function() {
        this.rowFields = {};
        _.each(this.fields, function(field) {
            if (field.model.id && _.isUndefined(field.parent)) {
                this.rowFields[field.model.id] = this.rowFields[field.model.id] || [];
                this.rowFields[field.model.id].push(field);
            }
        }, this);
    },

    /**
     * Retrieve the location of the left edge of the list viewport.
     * @return {Number} Position of the left edge.
     * @private
     */
    _getLeftBorderPosition: function() {
        if (!this._leftBorderPosition) {
            var scrollPanel = this.$('.flex-list-view-content');
            this._leftBorderPosition = scrollPanel.find('thead tr:first th:first').outerWidth();
        }
        return this._leftBorderPosition;
    },

    /**
     * Retrieve the location of the right edge of the list viewport.
     * @return {Number} Position of the right edge.
     * @private
     */
    _getRightBorderPosition: function() {
        if (!this._rightBorderPosition) {
            var scrollPanel = this.$('.flex-list-view-content');
            this._rightBorderPosition = scrollPanel.find('thead tr:first th:last').position().left;
        }
        return this._rightBorderPosition;
    },

    /**
     * Set the position of the current list panel.
     *
     * If focus item located within the viewport area,
     * avoid adjusting panel location.
     *
     * @param {Object} location Location of the focused element.
     */
    setPanelPosition: function(location) {
        var leftBorderPosition = this._getLeftBorderPosition(),
            rightBorderPosition = this._getRightBorderPosition(),
            relativeLeft = location.left,
            relativeRight = location.right;
        if (relativeRight <= rightBorderPosition && relativeLeft >= leftBorderPosition) {
            return;
        }
        this.setScrollAtRightBorder(location.right);
    },

    /**
     * Set the position of scrollable panel
     * at the left border of the focused element.
     *
     * @param {Number} left Left position of the focused element.
     */
    setScrollAtLeftBorder: function(left) {
        var scrollPanel = this.$('.flex-list-view-content'),
            leftBorderPosition = this._getLeftBorderPosition(),
            scrollLeft = scrollPanel.scrollLeft();

        left += scrollLeft - leftBorderPosition;
        scrollPanel.scrollLeft(left);
    },

    /**
     * Set the position of scrollable panel
     * at the right border of the focused element.
     *
     * @param {Number} right Right position of the focused element.
     */
    setScrollAtRightBorder: function(right) {
        var scrollPanel = this.$('.flex-list-view-content'),
            rightBorderPosition = this._getRightBorderPosition(),
            scrollLeft = scrollPanel.scrollLeft();

        right += scrollLeft - rightBorderPosition;
        scrollPanel.scrollLeft(right);
    },

    /**
     * Delete the model once the user confirms the action
     */
    deleteModel: function() {
        var self = this,
            model = this._modelToDelete;

        model.destroy({
            //Show alerts for this request
            showAlerts: {
                'process': true,
                'success': {
                    messages: self.getDeleteMessages(self._modelToDelete).success
                }
            },
            success: function() {
                var redirect = self._targetUrl !== self._currentUrl;
                self._modelToDelete = null;
                self.collection.remove(model, { silent: redirect });
                if (redirect) {
                    self.unbindBeforeRouteDelete();
                    //Replace the url hash back to the current staying page
                    app.router.navigate(self._targetUrl, {trigger: true});
                    return;
                }
                app.events.trigger("preview:close");
                if (!self.disposed) {
                    self.render();
                }

                self.layout.trigger("list:record:deleted", model);
            }
        });
    },

    /**
     * Pre-event handler before current router is changed
     *
     * @return {Boolean} true to continue routing, false otherwise
     */
    beforeRouteDelete: function () {
        if (this._modelToDelete) {
            this.warnDelete(this._modelToDelete);
            return false;
        }
        return true;
    },

    /**
     * Formats the messages to display in the alerts when deleting a record.
     *
     * @param {Data.Bean} model The model concerned.
     * @return {Object} The list of messages.
     * @return {string} return.confirmation Confirmation message.
     * @return {string} return.success Success message.
     */
    getDeleteMessages: function(model) {
        var messages = {};
        var name = Handlebars.Utils.escapeExpression(app.utils.getRecordName(model)).trim();
        var context = app.lang.get('LBL_MODULE_NAME_SINGULAR', model.module).toLowerCase() + ' ' + name;

        messages.confirmation = app.utils.formatString(app.lang.get('NTC_DELETE_CONFIRMATION_FORMATTED'), [context]);
        messages.success = app.utils.formatString(app.lang.get('NTC_DELETE_SUCCESS'), [context]);
        return messages;
    },

    /**
     * Popup dialog message to confirm delete action
     *
     * @param {Backbone.Model} model the bean to delete
     */
    warnDelete: function(model) {
        var self = this;
        this._modelToDelete = model;

        self._targetUrl = Backbone.history.getFragment();
        //Replace the url hash back to the current staying page
        if (self._targetUrl !== self._currentUrl) {
            app.router.navigate(self._currentUrl, {trigger: false, replace: true});
        }

        app.alert.show('delete_confirmation', {
            level: 'confirmation',
            messages: self.getDeleteMessages(model).confirmation,
            onConfirm: _.bind(self.deleteModel, self),
            onCancel: function() {
                self._modelToDelete = null;
            }
        });
    },

    /**
     * Popup browser dialog message to confirm delete action
     *
     * @return {String} the message to be displayed in the browser dialog
     */
    warnDeleteOnRefresh: function() {
        if (this._modelToDelete) {
            return this.getDeleteMessages(this._modelToDelete).confirmation;
        }
    },

    /**
     * {@link app.plugins.view.editable}
     * Compare with last fetched data and return true if model contains changes.
     * if model contains changed attributes,
     * check whether those are among the editable fields or not.
     *
     * @return {Boolean} True if current inline edit model contains unsaved changes.
     */
    hasUnsavedChanges: function() {
        var firstKey = _.first(_.keys(this.rowFields)),
            formFields = [];

        _.each(this.rowFields[firstKey], function(field) {
            if (field.name) {
                formFields.push(field.name);
            }
            //Inspect fieldset children fields
            if (field.def.fields) {
                formFields = _.chain(field.def.fields)
                    .pluck('name')
                    .compact()
                    .union(formFields)
                    .value();
            }
        }, this);
        return _.some(_.values(this.toggledModels), function(model) {
            var changedAttributes = model.changedAttributes(model.getSyncedAttributes());

            if (_.isEmpty(changedAttributes)) {
                return false;
            }
            var unsavedFields = _.intersection(_.keys(changedAttributes), formFields);
            return !_.isEmpty(unsavedFields);
        }, this);
    },

    /**
     * Handles merge button.
     */
    mergeDuplicatesClicked: function() {
        this.mergeDuplicates(this.context.get('mass_collection'));
    },

    /**
     * Toggle the selected model's fields when edit is clicked.
     *
     * @param {Backbone.Model} model Selected row's model.
     */
    editClicked: function(model, field) {
        if (field.def.full_form) {
            this.createRelatedRecord(this.module, this.context.get('link'), model.id);
        } else {
            this.toggleRow(model.id, true);
            //check to see if horizontal scrolling needs to be enabled
            this.resize();
        }
    },

    /**
     * Toggle editable selected row's model fields.
     *
     * @param {String} modelId Model Id.
     * @param {Boolean} isEdit True for edit mode, otherwise toggle back to list mode.
     */
    toggleRow: function(modelId, isEdit) {
        if (isEdit) {
            this.toggledModels[modelId] = this.collection.get(modelId);
        } else {
            delete this.toggledModels[modelId];
        }
        this.$('tr[name=' + this.module + '_' + modelId + ']').toggleClass('tr-inline-edit', isEdit);
        this.toggleFields(this.rowFields[modelId], isEdit);
    },

    /**
     * Toggle editable entire row fields.
     *
     * @param {Boolean} isEdit True for edit mode, otherwise toggle back to list mode.
     */
    toggleEdit: function(isEdit) {
        var self = this;
        this.viewName = isEdit ? 'edit' : 'list';
        _.each(this.rowFields, function(editableFields, modelId) {
            //running the toggling jon in each thread to prevent blocking browser performance
            _.defer(function(modelId) {
                self.toggleRow(modelId, isEdit);
            }, modelId);
        }, this);
    },

    /**
     * Detach the event handlers for warning delete
     */
    unbindBeforeRouteDelete: function() {
        app.routing.offBefore("route", this.beforeRouteDelete, this);
        $(window).off("beforeunload.delete" + this.cid);
    },

    /**
     * @override
     * @private
     */
    _dispose: function(){
        this.unbindBeforeRouteDelete();
        this._super('_dispose');
        this.rowFields = null;
    },

    /**
     * Adds the favorite field to app.view.View.getFieldNames() if meta.favorites is true
     * so my_favorite is part of the field list and is fetched
     */
    getFieldNames: function(module, onlyDataFields) {
        //Start with an empty set of fields since the view name in the request will load all fields from the metadata.
        var fields = onlyDataFields ? [ ] : this._super('getFieldNames', arguments);
        if (this.meta.favorite) {
            fields = _.union(fields, ['my_favorite']);
        }
        if (this.meta.following) {
            fields = _.union(fields, ['following']);
        }
        return fields;
    },

    /**
     * Register keyboard shortcuts.
     */
    registerShortcuts: function() {
        this._super('registerShortcuts');

        app.shortcuts.register('List:Inline:Edit', 'e', function() {
            var self = this;
            if (this.$('.selected [name=inline-cancel]:visible').length === 0) {
                this.$('.selected [data-toggle=dropdown]:visible').click();
                this.$('.selected [name=edit_button]:visible').click();
                _.defer(function() {
                    self.$('.selected input:first').focus();
                });
            }
        }, this);

        app.shortcuts.register('List:Delete', 'd', function() {
            if (this.$('.selected [name=inline-cancel]:visible').length === 0) {
                this.$('.selected [data-toggle=dropdown]:visible').click().blur();
                this.$('.selected [name=delete_button]:visible').click();
            }
        }, this);

        app.shortcuts.register('List:Inline:Cancel', ['esc','ctrl+alt+l'], function() {
            var $cancelButton = this.$('.selected [name=inline-cancel]');
            if (($cancelButton.length > 0) && $cancelButton.is(':visible') && !$cancelButton.hasClass('disabled')) {
                $cancelButton.click();
            }
        }, this, true);

        app.shortcuts.register('List:Inline:Save', ['ctrl+s','ctrl+alt+a'], function() {
            var $saveButton = this.$('.selected [name=inline-save]');
            if (($saveButton.length > 0) && $saveButton.is(':visible') && !$saveButton.hasClass('disabled')) {
                $saveButton.click();
            }
        }, this, true);

        app.shortcuts.register('List:Favorite', 'f a', function() {
            this.$('.selected .icon-favorite:visible').click();
        }, this);

        app.shortcuts.register('List:Follow', 'f o', function() {
            this.$('.selected [data-toggle=dropdown]:visible').click().blur();
            this.$('.selected [name=follow_button]:visible').click();
        }, this);

        app.shortcuts.register('List:Preview', 'p', function() {
            var $preview = this.$('.selected [data-event="list:preview:fire"]:visible');
            if ($preview.is(':visible') && !$preview.hasClass('disabled')) {
                $preview.click();
            }
        }, this);

        app.shortcuts.register('List:Select', 'x', function() {
            var $checkbox = this.$('.selected input[type=checkbox]:first');
            if ($checkbox.is(':visible') && !$checkbox.hasClass('disabled')) {
                $checkbox.get(0).click();
            }
        }, this);
    }
})
