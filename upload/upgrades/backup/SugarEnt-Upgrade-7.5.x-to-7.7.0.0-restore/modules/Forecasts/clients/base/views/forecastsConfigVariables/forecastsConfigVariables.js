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
 * @class View.Views.Base.Forecasts.ForecastsConfigVariablesView
 * @alias SUGAR.App.view.views.BaseForecastsForecastsConfigVariablesView
 * @extends View.View
 */
({
    /**
     * {@inheritdoc}
     */
    initialize: function(options) {
        app.view.View.prototype.initialize.call(this, options);
    },

    /**
     * {@inheritdocs}
     *
     * Sets up the multiselect fields to work properly
     *
     * @param {View.Field} field
     * @private
     */
    _renderField: function(field) {
        if (field.def.multi) {
            field = this._setUpMultiselectField(field);
        }
        app.view.View.prototype._renderField.call(this, field);

        // fix the width of the field's container
        field.$el.find('.chzn-container').css("width", "100%");
        field.$el.find('.chzn-drop').css("width", "100%");
    },

    /**
     * Sets up the save event and handler for the variables dropdown fields in the config settings.
     *
     * @param {View.Field} field the dropdown multi-select field
     * @return {*}
     * @private
     */
    _setUpMultiselectField: function (field) {
        // INVESTIGATE:  This is to get around what may be a bug in sidecar. The field.value gets overriden somewhere and it shouldn't.
        field.def.value = this.model.get(field.name);

        field.events = _.extend({"change select": "_updateSelections"}, field.events);

        field.bindDomChange = function() {};

        /**
         * updates the selection when a change event is triggered from a dropdown/multiselect
         * @param event the event that was triggered
         * @param input the (de)selection
         * @private
         */
        field._updateSelections = function(event, input) {
            var fieldValue = this.model.get(this.name);
            var id;

            if (_.has(input, "selected")) {
                id = input.selected;
                if (!_.contains(fieldValue, id)) {
                    fieldValue = _.union(fieldValue, id);
                }
            } else if(_.has(input, "deselected")) {
                id = input.deselected;
                if (_.contains(fieldValue, id)) {
                    fieldValue = _.without(fieldValue, id);
                }
            }
            this.def.value = fieldValue;
            this.model.set(this.name, fieldValue);
        };

        return field;
    }
})
