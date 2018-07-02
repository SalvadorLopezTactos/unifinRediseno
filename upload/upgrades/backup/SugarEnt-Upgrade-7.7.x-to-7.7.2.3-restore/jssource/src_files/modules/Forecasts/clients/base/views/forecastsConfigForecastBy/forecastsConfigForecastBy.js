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

({
    /**
     * Holds the changing date value for the title
     */
    titleSelectedValues: '',

    /**
     * Holds the view's title name
     */
    titleViewNameTitle: '',

    /**
     * Holds the options language strings for the forecast_by options
     */
    optionsLang: {},

    /**
     * Holds the collapsible toggle title template
     */
    toggleTitleTpl: {},

    /**
     * {@inheritdoc}
     */
    initialize: function(options) {
        app.view.View.prototype.initialize.call(this, options);

        this.titleViewNameTitle = app.lang.get('LBL_FORECASTS_CONFIG_TITLE_FORECAST_BY', 'Forecasts');
        this.optionsLang = app.lang.getAppListStrings('forecasts_config_worksheet_layout_forecast_by_options_dom');
        this.toggleTitleTpl = app.template.getView('forecastsConfigHelpers.toggleTitle', 'Forecasts');
    },

    /**
     * {@inheritdoc}
     */
    bindDataChange: function() {
        if(this.model) {
            this.model.on('change:forecast_by', function() {
                this.titleSelectedValues = this.optionsLang[this.model.get('forecast_by')];
                this.updateTitle();
            }, this);
        }
    },

    /**
     * Updates the accordion toggle title
     */
    updateTitle: function() {
        var tplVars = {
            title: this.titleViewNameTitle,
            selectedValues: this.titleSelectedValues,
            viewName: 'forecastsConfigForecastBy'
        };

        this.$el.find('#' + this.name + 'Title').html(this.toggleTitleTpl(tplVars));
    },

    /**
     * {@inheritdoc}
     */
    _render: function() {
        app.view.View.prototype._render.call(this);

        // add accordion-group class to wrapper $el div
        this.$el.addClass('accordion-group');
        this.updateTitle();
    }
})
