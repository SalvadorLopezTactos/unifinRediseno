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
 * @class View.Views.Dashboards.DashboardHeaderpaneView
 * @alias SUGAR.App.view.views.DashboardsDashboardHeaderpaneView
 * @extends View.Views.Base.HeaderpaneView
 */
({
    extendsFrom: 'HeaderpaneView',

    buttons: null,

    editableFields: null,

    className: 'preview-headerbar',

    events: {
        'click [name=edit_button]': 'editClicked',
        'click [name=save_button]': 'saveClicked',
        'click [name=cancel_button]': 'cancelClicked',
        'click [name=create_cancel_button]': 'createCancelClicked',
        'click [name=edit_overview_tab_button]': 'editOverviewTabClicked',
    },

    initialize: function(options) {
        if (options.context.parent) {
            options.meta = app.metadata.getView(options.context.parent.get('module'), options.type, options.loadModule);
            options.template = app.template.getView(options.type);
        }
        this._super('initialize', [options]);
        if (this.model.isNew()) {
            this._setNewModelMeta();
        }
        this.context.set('dataView', '');
        this.model.on('change change:layout change:metadata', function() {
            if (this.inlineEditMode) {
                this.changed = true;
            }
        }, this);
        this.model.on('error:validation', this.handleValidationError, this);

        if (this.context.get('create')) {
            this.changed = true;
            this.action = 'edit';
            this.inlineEditMode = true;
        } else {
            this.action = 'detail';
        }
        this.buttons = {};

        this._bindEvents();
    },

    /**
     * Binds the events that are necessary for this view.
     *
     * @protected
     */
    _bindEvents: function() {
        this.context.on('record:set:state', this.setRecordState, this);
        this.context.on('tabbed-dashboard:switch-tab', this.switchTab, this);
    },

    /**
     * Handles the logic done when the state changes in the record.
     * This is the callback for the `record:set:state` event.
     *
     * @param {string} state The state that the record is set to.
     */
    setRecordState: function(state) {
        this.model.trigger('setMode', state);
        this.setButtonStates(state);
        this.inlineEditMode = state === 'edit';
        this.toggleEdit(this.inlineEditMode);
    },

    /**
     * Event handler for button 'Edit Overview Tab'.
     *
     * @param {Event} evt Triggered mouse event
     */
    editOverviewTabClicked: function(evt) {
        // switch to overview tab
        if (this.context.get('activeTab') !== 0) {
            this.context.trigger('tabbed-dashboard:switch-tab', 0);
        }
        this.editClicked(evt);
    },

    editClicked: function(evt) {
        this.previousModelState = app.utils.deepCopy(this.model.attributes);
        this.inlineEditMode = true;
        this.setButtonStates('edit');
        this.toggleEdit(true);
        this.model.trigger('setMode', 'edit');
    },

    /**
     * Get the dashboard name field and toggle states
     * @param {boolean} isEdit
     */
    toggleNameField: function(isEdit) {
        var field = this.getField('name');
        this.toggleField(field, !!isEdit);
    },

    /**
     * Run save function and switch to view mode
     */
    saveHandle: function() {
        var changes = this.model.changedAttributes(this.model.getSynced());
        if (changes && changes.name) {
            this.layout.handleSave();
        }

        this.setButtonStates('view');
        this.toggleEdit(false);
        this.model.trigger('setMode', 'view');
    },

    cancelClicked: function(evt) {
        this.changed = false;
        this.model.unset('updated');
        this.clearValidationErrors();
        this.setButtonStates('view');
        this.handleCancel();
        this.model.trigger('setMode', 'view');
        this.toggleNameField();
    },

    /**
     * Compare with last fetched data and return true if model contains changes
     *
     * See {@link app.plugins.view.editable}. Ignore the favorite icon for
     * checking for unsaved changes.
     *
     * @return {boolean} true if current model contains unsaved changes
     */
    hasUnsavedChanges: function() {
        if (this.model.get('updated')) {
            return true;
        }

        if (this.model.isNew()) {
            return this.model.hasChanged();
        }

        var changes = this.model.changedAttributes(this.model.getSynced());

        // If there are no changes, don't warn.
        if (_.isEmpty(changes)) {
            return false;
        }

        // If the only change is to my_favorite, don't warn.
        var nonFavoriteChange = _.find(changes, function(obj, key) {
            return key !== 'my_favorite';
        });

        return !_.isUndefined(nonFavoriteChange);
    },

    /**
     * @override
     *
     * The save function is handled by {@link View.Layouts.Dashboards.DashboardLayout#handleSave}.
     */
    saveClicked: function(evt) {
        this.toggleNameField();
    },

    createCancelClicked: function(evt) {
        if (this.context.parent) {
            this.layout.navigateLayout('list');
        } else {
            app.navigate(this.context);
        }
    },

    /**
     * Handle event: 'tabbed-dashboard:switch-tab'.
     *
     * @param {number} tabIndex New tab's index
     */
    switchTab: function(tabIndex) {
        this.context.set('activeTab', tabIndex);
        this._enableEditButton(this._isDashboard());
    },

    /**
     * Check if this is a tabbed dashboard and active tab is a dashboard.
     *
     * @return {bool} True if this is not a tabbed dashboard
     * or active tab is a dashboard, false otherwise
     * @private
     */
    _isDashboard: function() {
        var tabs = this.context.get('tabs');
        if (!tabs) {
            return true;
        }
        var tabIndex = this.context.get('activeTab') || 0;
        return tabs[tabIndex] &&
            ((tabs[tabIndex].components && tabs[tabIndex].components[0].rows) || tabs[tabIndex].dashlets || false);
    },

    /**
     * Show/hide edit button.
     *
     * @param {bool} state True to show, false to hide
     * @private
     */
    _enableEditButton: function(state) {
        var dropdown = _.find(this.buttons, function(button) {
            return button.type === 'actiondropdown';
        });
        if (dropdown) {
            var editButton = _.find(dropdown.fields, function(field) {
                return field.name === 'edit_button';
            });
            if (editButton) {
                editButton.setDisabled(!state);
                editButton.isHidden = !state;
                dropdown._orderButtons();
                dropdown.render();
            }
        }
    },

    /**
     * Defer rendering until after the data loads. See #_renderHeader for more info.
     *
     * We defer rendering until after data load because by default, the fields
     * will render once on initialization and then will re-render once the data
     * is loaded. This means that while the model is being fetched, it is still
     * possible to interact with the fields, even if the field is in the wrong
     * state (such as favorite/unfavorite). Additionally, this causes a
     * distracting and annoying flickering effect.
     *
     * To avoid both the flickering effect and prevent users from accidentally
     * setting field values during data fetch, we defer rendering until after
     * the data is loaded.
     *
     * @override
     * @private
     */
    _render: function() {
        // When creating a dashboard, there is no model to load, so there is
        // no need to defer rendering.
        if (this.context.get('create')) {
            this._renderHeader();
        } else {
            this.model.once('sync', this._renderHeader, this);
        }
        return this;
    },

    /**
     * Render the view manually.
     *
     * This function handles the responsibility typically handled in _render,
     * but unlike `_render`, it is not called automatically.
     *
     * See #_render for more information.
     */
    _renderHeader: function() {
        app.view.View.prototype._render.call(this);

        this._setButtons();
        this.setButtonStates(this.context.get('create') ? 'create' : 'view');
        this.setEditableFields();
        this._enableEditButton(false);
    },

    handleCancel: function() {
        this.inlineEditMode = false;
        if (!_.isEmpty(this.previousModelState)) {
            this.model.set(this.previousModelState);
        }
        this.toggleEdit(false);
    },

    bindDataChange: function() {
        //empty out because dashboard header does not need to switch the button sets while model is changed
    },

    toggleEdit: function(isEdit) {
        this.editableFields = this.editableFields.filter(function(item) {
            return item.name !== 'name';
        });

        this.toggleFields(this.editableFields, isEdit);
    },

    /**
     * Initialize metadata on new dashboard
     * @private
     */
    _setNewModelMeta: function() {
        var metadata = {
            dashlets: []
        };
        this.model.set('metadata', metadata, {silent: true});
        this.model.trigger('change:metadata');
        this.model.changed = {};
    },
})
