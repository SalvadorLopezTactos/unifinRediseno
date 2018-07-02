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
 * @class View.Views.Base.CreateView
 * @alias SUGAR.App.view.views.CreateView
 * @extends View.Views.Base.RecordView
 */
({
    extendsFrom: 'RecordView',
    editAllMode: false,

    SAVEACTIONS: {
        SAVE_AND_CREATE: 'saveAndCreate',
        SAVE_AND_VIEW: 'saveAndView'
    },

    enableDuplicateCheck: false,
    dupecheckList: null, //duplicate list layout

    saveButtonName: 'save_button',
    cancelButtonName: 'cancel_button',
    saveAndCreateButtonName: 'save_create_button',
    saveAndViewButtonName: 'save_view_button',
    restoreButtonName: 'restore_button',

    /**
     * Initialize the view and prepare the model with default button metadata
     * for the current layout.
     */
    initialize: function (options) {
        var createViewEvents = {};
        createViewEvents['click a[name=' + this.saveButtonName + ']:not(.disabled)'] = 'save';
        createViewEvents['click a[name=' + this.cancelButtonName + ']'] = 'cancel';
        createViewEvents['click a[name=' + this.saveAndCreateButtonName + ']:not(.disabled)'] = 'saveAndCreate';
        createViewEvents['click a[name=' + this.saveAndViewButtonName + ']:not(.disabled)'] = 'saveAndView';
        createViewEvents['click a[name=' + this.restoreButtonName + ']:not(.disabled)'] = 'restoreModel';
        this.events = _.extend({}, this.events, createViewEvents);
        this.plugins = _.union(this.plugins || [], [
            'FindDuplicates'
        ]);

        //add states for create view
        this.STATE = _.extend({}, this.STATE, {
            CREATE: 'create',
            SELECT: 'select',
            DUPLICATE: 'duplicate'
        });
        this._super("initialize", [options]);
        this.model.off("change", null, this);

        //keep track of what post-save action was chosen in case user chooses to ignore dupes
        this.context.lastSaveAction = null;

        //listen for the select and edit button
        this.context.on('list:dupecheck-list-select-edit:fire', this.editExisting, this);

        //extend the record view definition
        this.meta = _.extend({}, app.metadata.getView(this.module, 'record'), this.meta);

        //enable or disable duplicate check?
        var moduleMetadata = app.metadata.getModule(this.module);
        this.enableDuplicateCheck = (moduleMetadata && moduleMetadata.dupCheckEnabled) || false;

        // If user has no list acl it doesn't make sense to enable dupecheck
        if (!app.acl.hasAccess('list', this.module)) {
            this.enableDuplicateCheck = false;
        }

        var fields = (moduleMetadata && moduleMetadata.fields) ? moduleMetadata.fields : {};

        this.model.relatedAttributes = this.model.relatedAttributes || {};

        var assignedUserField = _.find(fields, function(field) {
            return field.type === 'relate' &&
                (field.name === 'assigned_user_id' || field.id_name === 'assigned_user_id');
        });
        if (assignedUserField) {
            // set the default assigned user as current user, unless we are copying another record
            var isDuplicate = this.model.has('assigned_user_id') && this.model.has('assigned_user_name');
            if (!isDuplicate) {
                this.model.set('assigned_user_id', app.user.id);
                this.model.set('assigned_user_name', app.user.get('full_name'));
                this.model.setDefaultAttribute('assigned_user_id', app.user.id);
                this.model.setDefaultAttribute('assigned_user_name', app.user.get('full_name'));
            }
            this.model.relatedAttributes.assigned_user_id = app.user.id;
            this.model.relatedAttributes.assigned_user_name = app.user.get('full_name');
        }

        this.model.on("error:validation", function(){
            this.alerts.showInvalidModel();
        }, this);

        // need to reset the default attributes because the plugin may have
        // calculated default values.
        this.on('sugarlogic:initialize', function() {
            this.model.setDefaultAttributes(this.model.attributes);
        }, this);
    },

    /**
     * @inheritDoc
     */
    /**
     * Check unsaved changes.
     * This method is called by {@link app.plugins.Editable}.
     *
     * @return {Boolean} `true` if current model contains unsaved changes,
     *  `false` otherwise.
     */
    hasUnsavedChanges: function() {
        if (this.resavingAfterMetadataSync) {
            return false;
        }
        var defaults = _.extend({}, this.model._defaults, this.model.getDefaultAttributes());
        return this.model.isNew() && !_.isEqual(defaults, this.model.attributes);
    },

    handleSync: function () {
        //override handleSync since there is no need to save the previous model state
    },

    delegateButtonEvents: function () {
        //override record view's button delegation
    },

    _render: function () {
        this._super("_render");

        this.setButtonStates(this.STATE.CREATE);

        // Don't need to add dupecheck layout if dupecheck disabled
        if (this.enableDuplicateCheck) {
            this.renderDupeCheckList();
        }

        //SP-1502: Broadcast model changes so quick-create field can keep track of unsaved changes
        app.events.trigger('create:model:changed', false);
        this.model.on('change', function() {
            app.events.trigger('create:model:changed', this.hasUnsavedChanges());
        }, this);
    },

    /**
     * Determine appropriate save action and execute it
     * Default to saveAndClose
     */
    save: function () {
        switch (this.context.lastSaveAction) {
            case this.SAVEACTIONS.SAVE_AND_CREATE:
                this.saveAndCreate();
                break;
            case this.SAVEACTIONS.SAVE_AND_VIEW:
                this.saveAndView();
                break;
            default:
                this.saveAndClose();
        }
    },

    /**
     * Save and close drawer
     */
    saveAndClose: function () {
        this.initiateSave(_.bind(function () {
            if(app.drawer){
                app.drawer.close(this.context, this.model);
            }
        }, this));
    },

    /**
     * Handle click on the cancel link
     */
    cancel: function () {
        //Clear unsaved changes on cancel.
        app.events.trigger('create:model:changed', false);
        this.$el.off();
        if(app.drawer){
            app.drawer.close(this.context);
        }
    },

    /**
     * Handle click on save and create another link
     */
    saveAndCreate: function() {
        this.context.lastSaveAction = this.SAVEACTIONS.SAVE_AND_CREATE;
        this.initiateSave(_.bind(
            function() {
                this.clear();
                // set the default attributes and the relatedAttributes back
                // on the model since it's been cleared out
                this.model.set(_.extend(this.model.getDefaultAttributes(), this.model.relatedAttributes));
                this.resetDuplicateState();
            },
            this
        ));
    },

    /**
     * Handle click on save and view link
     */
    saveAndView: function () {
        this.context.lastSaveAction = this.SAVEACTIONS.SAVE_AND_VIEW;
        this.initiateSave(_.bind(function () {
                app.navigate(this.context, this.model);
        }, this));
    },

    /**
     * Handle click on restore to original link
     */
    restoreModel: function () {
        this.model.clear();
        if (this._origAttributes) {
            this.model.set(this._origAttributes);
            this.model.isCopied = true;
        }
        this.createMode = true;
        if (!this.disposed) {
            this.render();
        }
        this.setButtonStates(this.STATE.CREATE);
    },

    /**
     * Check for possible duplicates before creating a new record
     * @param callback
     */
    initiateSave: function (callback) {
        this.disableButtons();
        async.waterfall([
            _.bind(this.validateModelWaterfall, this),
            _.bind(this.dupeCheckWaterfall, this),
            _.bind(this.createRecordWaterfall, this)
        ], _.bind(function (error) {
            this.enableButtons();
            if (error && error.status == 412 && !error.request.metadataRetry) {
                this.handleMetadataSyncError(error);
            } else if (!error && !this.disposed) {
                this.context.lastSaveAction = null;
                callback();
            }
        }, this));
    },
    /**
     * Check to see if all fields are valid
     * @param callback
     */
    validateModelWaterfall: function(callback) {
        this.model.doValidate(this.getFields(this.module), function(isValid) {
            callback(!isValid);
        });
    },

    /**
     * Check for possible duplicate records
     * @param callback
     */
    dupeCheckWaterfall: function (callback) {
        var success = _.bind(function (collection) {
                if (this.disposed) {
                    callback(true);
                }
                if (collection.models.length > 0) {
                    this.handleDuplicateFound(collection);
                    callback(true);
                } else {
                    this.resetDuplicateState();
                    callback(false);
                }
            }, this),
            error = _.bind(function (e) {
                if (e.status == 412 && !e.request.metadataRetry) {
                    this.handleMetadataSyncError(e);
                } else {
                    this.alerts.showServerError();
                    callback(true);
                }
            }, this);
        if (this.skipDupeCheck() || !this.enableDuplicateCheck) {
            callback(false);
        } else {
            this.checkForDuplicate(success, error);
        }
    },

    /**
     * Create new record
     * @param callback
     */
    createRecordWaterfall: function (callback) {
        var success = _.bind(function () {
                var acls = this.model.get('_acl');
                if (!_.isEmpty(acls) && acls.access === 'no' && acls.view === 'no') {
                    //This happens when the user creates a record he won't have access to.
                    //In this case the POST request returns a 200 code with empty response and acls set to no.
                    this.alerts.showSuccessButDeniedAccess();
                    callback(false);
                } else {
                    app.alert.show('create-success', {
                        level: 'success',
                        messages: this.buildSuccessMessage(this.model),
                        autoClose: true,
                        autoCloseDelay: 10000,
                        onLinkClick: function() {
                            app.alert.dismiss('create-success');
                        }
                    });
                    callback(false);
                }
            }, this),
            error = _.bind(function (e) {
                if (e.status == 412 && !e.request.metadataRetry) {
                    this.handleMetadataSyncError(e);
                } else {
                    this.alerts.showServerError();
                    callback(true);
                }
            }, this);

        this.saveModel(success, error);
    },

    /**
     * Check the server to see if there are possible duplicate records.
     * @param success
     * @param error
     */
    checkForDuplicate: function (success, error) {
        var options = {
            //Show alerts for this request
            showAlerts: true,
            success: success,
            error: error
        };

        this.context.trigger("dupecheck:fetch:fire", this.model, options);
    },

    /**
     * Duplicate found: display duplicates and change buttons
     */
    handleDuplicateFound: function () {
        this.setButtonStates(this.STATE.DUPLICATE);
        this.dupecheckList.show();
        this.skipDupeCheck(true);
    },

    /**
     * Clear out all things related to duplicate checks
     */
    resetDuplicateState: function () {
        this.setButtonStates(this.STATE.CREATE);
        this.hideDuplicates();
        this.skipDupeCheck(false);
    },

    /**
     * Called when current record is being saved to allow customization of options and params
     * during save
     *
     * Override to return set of custom options
     *
     * @param {Object} options The current set of options that is going to be used.  This is hand for extending
     */
    getCustomSaveOptions: function (options) {
        return {};
    },

    /**
     * Create a new record
     * @param success
     * @param error
     */
    saveModel: function (success, error) {
        var self = this,
            options;
        success = _.wrap(success, function (func, model) {
            app.file.checkFileFieldsAndProcessUpload(self, {
                    success: function () {
                        func();
                    }
                },
                {deleteIfFails: true}
            );
        });
        options = {
            success: success,
            error: error,
            viewed: true,
            relate: (self.model.link) ? true : null,
            //Show alerts for this request
            showAlerts: {
                'process': true,
                'success': false,
                'error': false //error callback implements its own error handler
            },
            lastSaveAction: this.context.lastSaveAction
        };
        this.applyAfterCreateOptions(options);

        options = _.extend({}, options, self.getCustomSaveOptions(options));
        self.model.save(null, options);
    },

    /**
     * Apply after_create parameters to the URL to specify operations to execute after creating a record.
     * @param options
     */
    applyAfterCreateOptions: function(options) {
        var copiedFromModelId = this.context.get('copiedFromModelId');

        if (copiedFromModelId && this.model.isCopy()) {
            options.params = options.params || {};
            options.params.after_create = {
                copy_rel_from: copiedFromModelId
            };
        }
    },

    /**
     * Using the model returned from the API call, build the success message
     * @param model
     * @returns {*}
     */
    buildSuccessMessage: function(model) {
        var modelAttributes,
            successLabel = 'LBL_RECORD_SAVED_SUCCESS',
            successMessageContext;

        //if we have model attributes, use them to build the message, otherwise use a generic message
        if (model && model.attributes) {
            modelAttributes = model.attributes;
        } else {
            modelAttributes = {};
            successLabel = 'LBL_RECORD_SAVED';
        }

        //use the model attributes combined with data from the view to build the success message context
        successMessageContext = _.extend({
            module: this.module,
            moduleSingularLower: this.moduleSingular.toLowerCase()
        }, modelAttributes);

        return app.lang.get(successLabel, this.module, successMessageContext);
    },

    /**
     * Check to see if we should skip duplicate check.
     * @param {Boolean} skip (optional) If specified, sets duplicate check to
     *  either true or false.
     * @return {*}
     */
    skipDupeCheck: function (skip) {
        var skipDupeCheck,
            saveButton = this.buttons[this.saveButtonName].getFieldElement();

        if (_.isUndefined(skip)) {
            skipDupeCheck = saveButton.data('skipDupeCheck');
            if (_.isUndefined(skipDupeCheck)) {
                skipDupeCheck = false;
            }
            return skipDupeCheck;
        } else {
            if (skip) {
                saveButton.data('skipDupeCheck', true);
            } else {
                saveButton.data('skipDupeCheck', false);
            }
        }
    },

    /**
     * Clears out field values
     */
    clear: function () {
        this.model.clear();
        if (!this.disposed) {
            this.render();
        }
    },

    /**
     * Make the specified record as the data to be edited, and merge the existing data.
     * @param model
     */
    editExisting: function (model) {
        var origAttributes = this.saveFormData(),
            skipDupeCheck = this.skipDupeCheck();

        this.model.clear();
        this.model.set(this.extendModel(model, origAttributes));

        this.createMode = false;
        if (!this.disposed) {
            this.render();
        }
        this.toggleEdit(true);

        this.hideDuplicates();
        this.skipDupeCheck(skipDupeCheck);
        this.setButtonStates(this.STATE.SELECT);
    },

    /**
     * Merge the selected record with the data entered in the form
     * @param newModel
     * @param origAttributes
     * @return {*}
     */
    extendModel: function (newModel, origAttributes) {
        var modelAttributes = _.clone(newModel.attributes);

        _.each(modelAttributes, function (value, key) {
            if (_.isUndefined(value) || _.isNull(value) ||
                ((_.isObject(value) || _.isArray(value) || _.isString(value)) && _.isEmpty(value))) {
                delete modelAttributes[key];
            }
        });

        return _.extend({}, origAttributes, modelAttributes);
    },

    /**
     * Save the data entered in the form
     * @return {*}
     */
    saveFormData: function () {
        this._origAttributes = _.clone(this.model.attributes);
        return this._origAttributes;
    },

    /**
     * Sets the dupecheck list type
     *
     * @param {String} type view to load
     */
    setDupeCheckType: function(type) {
        this.context.set('dupelisttype', type);
    },

    /**
     * Render duplicate check list table
     */
    renderDupeCheckList: function () {
        this.setDupeCheckType('dupecheck-list-edit');
        this.context.set('collection', this.createDuplicateCollection(this.model));

        if (_.isNull(this.dupecheckList)) {
            this.dupecheckList = app.view.createLayout({
                context: this.context,
                name: 'create-dupecheck',
                module: this.module
            });
            this.addToLayoutComponents(this.dupecheckList);
        }

        this.$('.headerpane').after(this.dupecheckList.$el);
        this.dupecheckList.hide();
        this.dupecheckList.render();
    },

    /**
     * Add component to layout's component list so it gets cleaned up properly on dispose
     *
     * @param component
     */
    addToLayoutComponents: function (component) {
        this.layout._components.push(component);
    },

    /**
     * If initialized (depends on this.enableDuplicateCheck flag) hides the
     * duplicate list.
     */
    hideDuplicates: function () {
        if (this.dupecheckList) {
            this.dupecheckList.hide();
        }
    },

    /**
     * Change the behavior of buttons depending on the state that they are in
     * @param state
     */
    setButtonStates: function (state) {
        this._super("setButtonStates", [state]);
        var $saveButtonEl = this.buttons[this.saveButtonName];
        if ($saveButtonEl) {
            switch (state) {
                case this.STATE.CREATE:
                case this.STATE.SELECT:
                    $saveButtonEl.getFieldElement().text(app.lang.get('LBL_SAVE_BUTTON_LABEL', this.module));
                    break;

                case this.STATE.DUPLICATE:
                    $saveButtonEl.getFieldElement().text(app.lang.get('LBL_IGNORE_DUPLICATE_AND_SAVE', this.module));
                    break;
            }
        }
    },

    /**
     * Disable buttons
     */
    disableButtons: function () {
        this.toggleButtons(false);
    },

    /**
     * Enable buttons
     */
    enableButtons: function () {
        this.toggleButtons(true);
    },

    /**
     * Enable or disable buttons
     * @param {boolean} enable
     */
    toggleButtons: function(enable) {
        _.each(this.buttons, function(button) {
            switch (button.type) {
                case 'button':
                case 'rowaction':
                    button.getFieldElement().toggleClass('disabled', !enable);
                    break;
                case 'actiondropdown':
                    button.$(button.actionDropDownTag).toggleClass('disabled', !enable);
                    break;
            }
        });
    },

    registerShortcuts: function() {
        this._super('registerShortcuts');

        app.shortcuts.register('Create:Save', ['ctrl+s','ctrl+alt+a'], function() {
            var $saveButton = this.$('a[name=' + this.saveButtonName + ']');
            if ($saveButton.is(':visible') && !$saveButton.hasClass('disabled')) {
                $saveButton.get(0).click();
            }
        }, this, true);

        app.shortcuts.register('Create:Cancel', ['esc','ctrl+alt+l'], function() {
            var $cancelButton = this.$('a[name=' + this.cancelButtonName + ']');
            if ($cancelButton.is(':visible') && !$cancelButton.hasClass('disabled')) {
                $cancelButton.get(0).click();
            }
        }, this, true);
    },

    alerts: {
        showInvalidModel: function () {
            app.alert.show('invalid-data', {
                level: 'error',
                messages: 'ERR_RESOLVE_ERRORS'
            });
        },
        showServerError: function () {
            app.alert.show('server-error', {
                level: 'error',
                messages: 'ERR_GENERIC_SERVER_ERROR'
            });
        },
        showSuccessButDeniedAccess: function() {
            app.alert.show('invalid-data', {
                level: 'warning',
                messages: 'LBL_RECORD_SAVED_ACCESS_DENIED',
                autoClose: true,
                autoCloseDelay: 9000
            });
        }
    }

})
