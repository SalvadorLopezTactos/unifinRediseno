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
    results: {},
    chart: {},
    plugins: ['Dashlet', 'Chart', 'Tooltip'],

    /**
     * Is the forecast Module setup??
     */
    forecastSetup: 0,

    /**
     * Holds the forecast isn't set up message if Forecasts hasn't been set up yet
     */
    forecastsNotSetUpMsg: undefined,

    /**
     * Track if current user is manager.
     */
    isManager: false,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this.isManager = app.user.get('is_manager');
        this._initPlugins();
        this._super('initialize', [options]);

        // check to make sure that forecast is configured
        this.forecastSetup = app.metadata.getModule('Forecasts', 'config').is_setup;
    },

    /**
     * @inheritdoc
     */
    initDashlet: function(view) {
        var userCurrency = app.metadata.getCurrency(app.user.getPreference('currency_id'));
        var userConversionRate = (userCurrency ? (1 / userCurrency.conversion_rate) : 1);
        var userCurrencyPreference = app.user.getPreference('currency_id');
        var salesStageLabels = app.lang.getAppListStrings('sales_stage_dom');

        function formatValue(d, precision) {
            return app.currency.formatAmountLocale(app.currency.convertWithRate(d, userConversionRate), userCurrencyPreference, precision);
        }

        if (!this.isManager && this.meta.config) {
            // FIXME: Dashlet's config page is rendered from meta.panels directly.
            // See the "dashletconfiguration-edit.hbs" file.
            this.meta.panels = _.chain(this.meta.panels).filter(function(panel) {
                panel.fields = _.without(panel.fields, _.findWhere(panel.fields, {name: 'visibility'}));
                return panel;
            }).value();
        }
        // get the current timeperiod
        if (this.forecastSetup) {
            app.api.call('GET', app.api.buildURL('TimePeriods/current'), null, {
                success: _.bind(function(currentTP) {
                    this.settings.set({'selectedTimePeriod': currentTP.id}, {silent: true});
                    this.layout.loadData();
                }, this),
                error: _.bind(function() {
                    // Needed to catch the 404 in case there isnt a current timeperiod
                }, this),
                complete: view.options ? view.options.complete : null
            });
        } else {
            this.settings.set({'selectedTimePeriod': 'current'}, {silent: true});
        }
        this.chart = nv.models.funnelChart()
            .showTitle(false)
            .tooltips(true)
            .margin({top: 0})
            .direction(app.lang.direction)
            .tooltipContent(function(key, x, y, e, graph) {
                return '<p>' + SUGAR.App.lang.get('LBL_SALES_STAGE', 'Forecasts') + ': <b>' + ((salesStageLabels && salesStageLabels[key]) ? salesStageLabels[key] : key) + '</b></p>' +
                    '<p>' + SUGAR.App.lang.get('LBL_AMOUNT', 'Forecasts') + ': <b>' + formatValue(y) + '</b></p>' +
                    '<p>' + SUGAR.App.lang.get('LBL_PERCENT', 'Forecasts') + ': <b>' + x + '%</b></p>';
            })
            .colorData('class', {step: 2})
            .fmtValueLabel(function(d) {
                var y = d.value || (isNaN(d) ? 0 : d);
                return formatValue(y, 0);
            })
            .strings({
                legend: {
                    close: app.lang.get('LBL_CHART_LEGEND_CLOSE'),
                    open: app.lang.get('LBL_CHART_LEGEND_OPEN')
                },
                noData: app.lang.get('LBL_CHART_NO_DATA')
            });
    },


    /**
     * Initialize plugins.
     * Only manager can toggle visibility.
     *
     * @return {View.Views.BaseForecastPipeline} Instance of this view.
     * @protected
     */
    _initPlugins: function() {
        if (this.isManager) {
            this.plugins = _.union(this.plugins, [
                'ToggleVisibility'
            ]);
        }
        return this;
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this.settings.on('change', function(model) {
            // reload the chart
            if (this.$el && this.$el.is(':visible')) {
                this.loadData({});
            }
        }, this);
    },

    /**
     * Generic method to render chart with check for visibility and data.
     * Called by _renderHtml and loadData.
     */
    renderChart: function() {
        if (!this.isChartReady()) {
            return;
        }
        // Clear out the current chart before a re-render
        this.$('svg#' + this.cid).children().remove();

        d3.select('svg#' + this.cid)
            .datum(this.results)
            .transition().duration(500)
            .call(this.chart);

        this.chart_loaded = _.isFunction(this.chart.update);
        this.displayNoData(!this.chart_loaded);
    },

    hasChartData: function() {
        return !_.isEmpty(this.results) && this.results.data && this.results.data.length > 0;
    },

    /**
     * @inheritdoc
     */
    loadData: function(options) {
        var timeperiod = this.settings.get('selectedTimePeriod');
        if (timeperiod) {
            var forecastBy = app.metadata.getModule('Forecasts', 'config').forecast_by || 'Opportunities',
                url_base = forecastBy + '/chart/pipeline/' + timeperiod + '/';

            if (this.isManager) {
                url_base += '/' + this.getVisibility();
            }
            var url = app.api.buildURL(url_base);
            app.api.call('GET', url, null, {
                success: _.bind(function(o) {
                    if (o && o.data) {
                        var salesStageLabels = app.lang.getAppListStrings('sales_stage_dom');

                        // update sales stage labels to translated strings
                        _.each(o.data, function(dataBlock) {
                            if (dataBlock && dataBlock.key && salesStageLabels && salesStageLabels[dataBlock.key]) {
                                dataBlock.key = salesStageLabels[dataBlock.key];
                            }

                        });
                    }
                    this.results = {};
                    this.results = o;
                    this.renderChart();
                }, this),
                error: _.bind(function(o) {
                    this.results = {};
                    this.renderChart();
                }, this),
                complete: options ? options.complete : null
            });
        }
    },

    /**
     * @inheritdoc
     */
    unbind: function() {
        this.settings.off('change');
        this._super('unbind');
    }
})
