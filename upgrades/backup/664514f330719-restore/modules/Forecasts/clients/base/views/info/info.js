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
 * @class View.Views.Base.Forecasts.InfoView
 * @alias SUGAR.App.view.views.BaseForecastsInfoView
 * @extends View.View
 */
({
    /**
     * Timeperiod model
     */
    tpModel: undefined,

    /**
     * @inheritdoc
     *
     */
    initialize: function(options) {
        if (app.lang.direction === 'rtl') {
            options.template = app.template.getView('info.info-rtl', 'Forecasts');

            // reverse the datapoints
            options.meta.datapoints.reverse();
        }

        this.tpModel = new Backbone.Model();
        this._super("initialize", [options]);
        this.resetSelection(this.context.get("selectedTimePeriod"));

        // Use the next commit model as this view's model
        this.model = this.context.get('nextCommitModel');
    },

    /**
     * @inheritdoc
     *
     */
    bindDataChange: function(){
        this.tpModel.on("change", function(model){
            this.context.trigger(
                'forecasts:timeperiod:changed',
                model,
                this.getField('selectedTimePeriod').tpTooltipMap[model.get('selectedTimePeriod')]);
        }, this);

        this.context.on("forecasts:timeperiod:canceled", function(){
            this.resetSelection(this.tpModel.previous("selectedTimePeriod"));
        }, this);

        this.listenTo(this.context, 'forecasts:worksheet:totals:initialized', this._handleWorksheetTotalsInitialized);
        this.listenTo(this.context, 'forecasts:commit-models:loaded', this._handleCommitModelsLoaded);
        this.listenTo(this.context, 'button:cancel_button:click', this._handleCancelClicked);
    },

    /**
     * Handles when the layout's commit models have been loaded
     *
     * @private
     */
    _handleCommitModelsLoaded: function() {
        this._syncDatapointValues();
    },

    /**
     * Handles when the totals of the worksheet records are initially
     * loaded and calculated
     *
     * @param {Object} totals
     * @private
     */
    _handleWorksheetTotalsInitialized: function(totals) {
        this.syncedTotals = totals;
        this._syncDatapointValues();
    },

    /**
     * Takes the last committed model (if applicable) and the initial
     * totals from the worksheet, and determines which values should
     * be used at the synced/baseline values for the datapoint fields
     *
     * @private
     */
    _syncDatapointValues: function() {
        // Get the commit models
        let lastCommitModel = this.context.get('lastCommitModel');
        let nextCommitModel = this.context.get('nextCommitModel');

        // Sync any last committed datapoint values if necessary
        let valuesToSync = {};
        if (lastCommitModel instanceof Backbone.Model) {
            _.each(this.meta.datapoints, function(datapoint) {
                valuesToSync[datapoint.name] = lastCommitModel.get(datapoint.name);
            }, this);
        } else if (this.syncedTotals) {
            _.each(this.meta.datapoints, function(datapoint) {
                if (!_.isUndefined(this.syncedTotals[datapoint.name])) {
                    valuesToSync[datapoint.name] = this.syncedTotals[datapoint.name];
                }
            }, this);
        }

        nextCommitModel.setSyncedAttributes(valuesToSync);
        nextCommitModel.set(valuesToSync);
    },

    /**
     * Handles when the edit cancel button is clicked in the Forecasts view
     * @private
     */
    _handleCancelClicked: function() {
        // Revert the next commit model's attributes
        let nextCommitModel = this.context.get('nextCommitModel');
        if (nextCommitModel instanceof Backbone.Model) {
            nextCommitModel.revertAttributes();
        }
    },

    /**
     * Sets the timeperiod to the selected timeperiod, used primarily for resetting
     * the dropdown on nav cancel
     */
    resetSelection: function(timeperiod_id){
        this.tpModel.set({selectedTimePeriod:timeperiod_id}, {silent:true});
        _.find(this.fields, function(field){
            if(_.isEqual(field.name, "selectedTimePeriod")){
                field.render();
                return true;
            }
        });
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        this.stopListening();
        this._super('_dispose');
    }
})
