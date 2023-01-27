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

(function(app) {
    app.events.on('app:init', function() {
        /**
         * The Cascade plugin is used for Opportunity fields
         */
        app.plugins.register('Cascade', ['field'], {
            baseFieldName: null,
            baseFieldType: null,
            fieldNames: null,
            field: null,
            model: null,
            attachAction: null,
            readOnlyProp: null,

            /**
             * Set the appropriate field attribute for Opps+RLIs to handle
             * rendering the checkbox.
             *
             * Wrap "setMode" as it handles changing the field from detail to
             * edit modes. It now will also handle binding enable/disable
             * listeners to the checkbox.
             *
             * Listen to model.change events on this field, and set our model's
             * _cascade attribute.
             * @param component
             * @param plugin
             */
            onAttach: function(component, plugin) {
                this.baseFieldName = component.options.def.name;
                this.field = component;
                this.model = this.field.options.model;
                this.baseFieldType = this.field.options.def.type;
                this.attachAction = this.field.action;

                if (this.baseFieldType === 'fieldset-cascade') {
                    this.fieldNames = _.map(this.field.options.def.fields, function(field) {
                        return field.name;
                    });
                } else {
                    this.fieldNames = [this.field.baseFieldName];
                }

                var oppConfig = app.metadata.getModule('Opportunities', 'config');
                if (!oppConfig || oppConfig.opps_view_by !== 'RevenueLineItems') {
                    this.field.displayCheckbox = false;
                    return;
                } else if (this.field.options.view.action === 'create') {
                    this.field.displayCheckbox = false;
                    this.field.action = 'disabled';
                    return;
                }
                this.field.displayCheckbox = true;

                component.setMode = _.wrap(component.setMode, _.bind(function(setMode, args) {
                    setMode.call(component, args);
                    this.handleModeChange(args);
                }, this));

                if (this.field.options.view.action === 'edit') {
                    this.field.on('render', this.bindEditActions, this);
                }

                _.each(this.fieldNames, function(fieldName) {
                    this.model.on('change:' + fieldName, this.setCascadeValue, this);
                }, this);
                this.model.on('sync', this.clearCascadeValue, this);

                if (this.options && this.options.def && this.options.def.disable_field) {
                    let disableFieldName = this.options.def.disable_field;
                    // Adding listeners to all the fields that tend to calculate value to disable a field
                    // For example: we need to listen on total and closed RLI fields to calculate the open RLIs
                    // (open RLI = total - closed RLIs)
                    // and disable sales_stage and date_closed.
                    if (_.isArray(disableFieldName)) {
                        _.each(disableFieldName, function(fieldName) {
                            this.model.on('change:' + fieldName, this.handleReadOnly, this);
                        }, this);
                    } else {
                        this.model.on('change:' + disableFieldName, this.handleReadOnly, this);
                    }
                }

                this.field.on('render', function() {
                    if (this.view.el.classList.contains('flex-list-view')) {
                        this.view.el.classList.add('double-height-row');
                    }
                }, this);
            },

            /**
             * If we're in "edit" mode, bind our event listeners to the checkbox.
             *
             * Otherwise, make sure the field is enabled so clicking it or
             * entering edit mode will display the checkbox.
             * @param toTemplate
             */
            handleModeChange: function(toTemplate) {
                if (!this.field.$el) {
                    return;
                }
                var action = toTemplate || this.field.action || this.field.view.action || 'detail';
                if (action === 'edit') {
                    this.handleReadOnly(true);
                } else {
                    this.field.setDisabled(false, {trigger: true});
                }
            },

            /**
             * Bind a "click" listener to the checkbox. This is done using
             * jQuery because this checkbox exists only in our template and not
             * as a field on our model.
             */
            bindEditActions: function() {
                // If the plugin attached directly on edit mode (e.g. if the user refreshed
                // while on the edit view), the checkbox won't have been rendered yet. Make
                // sure it is available to attach the listener to.
                if (this.attachAction === 'edit') {
                    this.attachAction = null;
                    this.field.render();
                }

                var checkbox = this.field.$el.find('input[type=checkbox]');
                var self = this;
                checkbox.click(function() {
                    if (this.checked === false) {
                        self.field.setDisabled(true, {trigger: true});
                        self.resetModelValue();
                    } else {
                        self.field.setDisabled(false, {trigger: true});
                        $('.' + self.baseFieldName + '_should_cascade').prop('checked', true);
                        self.setCascadeValue();
                    }
                    // If the field has been enabled/disabled, it has also been
                    // re-rendered. This re-rendering removes the DOM element
                    // to which we bound our "click" listener, so we need to bind
                    // it to the element that exists now.
                    self.bindEditActions();
                });
            },

            handleReadOnly: function(editClick) {
                if (_.isUndefined(editClick)) {
                    editClick = false;
                }
                if (this.model && this.options && this.options.def && this.options.def.disable_field) {
                    let disableFieldName = this.options.def.disable_field;
                    let calculatedValue = null;
                    // When disableFieldName is an array, calculatedValue is fieldValue1 - fieldValue2
                    // For example: we need to calculate all open RLIs. fieldValue1 = total, fieldValue2 = closed RLI
                    // (open RLI = total - closed RLIs)
                    // and disable sales_stage and date_closed.
                    if (_.isArray(disableFieldName)) {
                        let fieldValue1 = this.model.get(disableFieldName[0]);
                        let fieldValue2 = this.model.get(disableFieldName[1]);
                        // if either fieldValue1 or fieldValue2 is undefined set calculatedValue to null
                        calculatedValue = (!_.isUndefined(fieldValue1) && !_.isUndefined(fieldValue2)) ?
                            (fieldValue1 - fieldValue2) : null;
                    } else if (typeof disableFieldName === 'string') {
                        var disableFieldValue = this.model.get(disableFieldName);
                        calculatedValue = !_.isUndefined(disableFieldValue) ? disableFieldValue : null;
                    }

                    if (calculatedValue !== null) {
                        if (!_.isUndefined(this.field.def) && _.isUndefined(this.field.def.readOnlyProp)) {
                            this.field.def.readOnlyProp = false;
                        }
                        this.readOnlyProp = calculatedValue <= 0 || this.field.def.readOnlyProp;
                        this.field.setDisabled(this.readOnlyProp, {trigger: true});
                    }
                }

                // Force to set the checkbox to false only on entering the edit mode and not during the other flow
                // Also check the state of the checkbox - if we loaded directly into edit mode, the previous check
                // wouldn't apply
                var checkbox = this.field.$el.find('input[type=checkbox]');
                if (app.utils.isTruthy(editClick) || (this.field.action === 'edit' && !checkbox.prop('checked'))) {
                    this.field.setDisabled(true, {trigger: true});
                }

                // If the field has errors, keep it enabled so the user can see the value they entered as well as
                // the error styling
                if (!_.isEmpty(this.field._errors)) {
                    this.field.hasErrors = true;
                    this.field.setDisabled(false);
                }

                this.bindEditActions();
            },

            /**
             * Util function to reset model to synced values and stop any cascades.
             * Used when un-checking the checkbox in edit mode.
             */
            resetModelValue: function() {
                _.each(this.fieldNames, function(fieldName) {
                    this.model.set(fieldName, this.model.getSynced(fieldName));
                    this.model.set(fieldName + '_cascade', '');
                }, this);
            },

            /**
             * Called on model.change events for our field. This sets the model
             * property needed to cause cascading changes.
             */
            setCascadeValue: function() {
                _.each(this.fieldNames, function(fieldName) {
                    this.model.set(fieldName + '_cascade', this.model.get(fieldName));
                }, this);
            },

            /**
             * Clear cascade field
             */
            clearCascadeValue: function() {
                if (this.context.attributes.layout  && this.context.attributes.layout === 'record') {
                    _.each(this.fieldNames, function(fieldName) {
                        this.model.set(fieldName + '_cascade', '');
                    }, this);
                }
            }
        });
    });
})(SUGAR.App);
