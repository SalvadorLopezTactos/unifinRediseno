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
 * @class View.Fields.Base.EditablelistbuttonField
 * @alias SUGAR.App.view.fields.BaseEditablelistbuttonField
 * @extends View.Fields.Base.ButtonField
 */
({
    events: {
        'click [name=inline-save]' : 'saveClicked',
        'click [name=inline-cancel]' : 'cancelClicked'
    },
    extendsFrom: 'ButtonField',
    initialize: function(options) {
        this._super("initialize", [options]);
        if(this.name === 'inline-save') {
            this.model.off("change", null, this);
            this.model.on("change", function() {
                this.changed = true;
            }, this);
        }
    },
    _loadTemplate: function() {
        app.view.Field.prototype._loadTemplate.call(this);
        if(this.view.action === 'list' && _.indexOf(['edit', 'disabled'], this.action) >= 0 ) {
            this.template = app.template.getField('button', 'edit', this.module, 'edit');
        } else {
            this.template = app.template.empty;
        }
    },
    /**
     * Called whenever validation completes on the model being edited
     * @param {boolean} isValid TRUE if model is valid
     * @private
     */
    _validationComplete : function(isValid){
        if (!isValid) {
            this.setDisabled(false);
            return;
        }
        if (!this.changed) {
            this.cancelEdit();
            return;
        }

        this._save();
    },

    _save: function() {
        var self = this,
            successCallback = function(model) {
                self.changed = false;
                self.view.toggleRow(model.id, false);
            },
            options = {
                success: successCallback,
                error: function(error) {
                    if (error.status === 409) {
                        app.utils.resolve409Conflict(error, self.model, function(model, isDatabaseData) {
                            if (model) {
                                if (isDatabaseData) {
                                    successCallback(model);
                                } else {
                                    self._save();
                                }
                            }
                        });
                    }
                },
                complete: function() {
                    // remove this model from the list if it has been unlinked
                    if (self.model.get('_unlinked')) {
                        self.collection.remove(self.model, { silent: true });
                        self.collection.trigger('reset');
                        self.view.render();
                    } else {
                        self.setDisabled(false);
                    }
                },
                lastModified: self.model.get('date_modified'),
                //Show alerts for this request
                showAlerts: {
                    'process': true,
                    'success': {
                        messages: app.lang.get('LBL_RECORD_SAVED', self.module)
                    }
                },
                relate: this.model.link ? true : false
            };

        options = _.extend({}, options, this.getCustomSaveOptions(options));

        this.model.save({}, options);
    },

    getCustomSaveOptions: function(options) {
        return {};
    },

    saveModel: function() {
        this.setDisabled(true);
        var fieldsToValidate = this.view.getFields(this.module, this.model);
        this.model.doValidate(fieldsToValidate, _.bind(this._validationComplete, this));
    },
    cancelEdit: function() {
        if (this.isDisabled()) {
            this.setDisabled(false);
        }
        this.changed = false;
        this.model.revertAttributes();
        this.view.clearValidationErrors();
        this.view.toggleRow(this.model.id, false);

        // trigger a cancel event across the parent context so listening components
        // know the changes made in this row are being reverted
        if(this.context.parent) {
            this.context.parent.trigger('editablelist:cancel', this.model);
        }
    },
    saveClicked: function(evt) {
        if (!$(evt.currentTarget).hasClass('disabled')) {
            this.saveModel();
        }
    },
    cancelClicked: function(evt) {
        this.cancelEdit();
    }
})
