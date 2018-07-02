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
 * @class View.Views.Base.OpportunityMetricsView
 * @alias SUGAR.App.view.views.BaseOpportunityMetricsView
 * @extends View.View
 */
({
    plugins: ['Dashlet', 'Chart'],
    className: 'opportunity-metrics-wrapper',

    metricsCollection: null,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        this.chart = nv.models.pieChart()
                .x(function(d) {
                    return d.key;
                })
                .y(function(d) {
                    return d.value;
                })
                .margin({top: 0, right: 0, bottom: 5, left: 0})
                .donut(true)
                .donutLabelsOutside(true)
                .donutRatio(0.447)
                .rotateDegrees(0)
                .arcDegrees(360)
                .maxRadius(110)
                .hole(this.total)
                .showTitle(false)
                .tooltips(true)
                .showLegend(false)
                .colorData('data')
                .direction(app.lang.direction)
                .tooltipContent(function(key, x, y, e, graph) {
                    return '<p><b>' + key + ' ' + parseInt(y, 10) + '</b></p>';
                })
                .strings({
                    noData: app.lang.get('LBL_CHART_NO_DATA')
                });
    },

    /**
     * Generic method to render chart with check for visibility and data.
     * Called by _renderHtml and loadData.
     */
    renderChart: function() {
        if (!this.isChartReady()) {
            return;
        }

        // Set value of label inside donut chart
        this.chart.hole(this.total);

        d3.select(this.el).select('svg#' + this.cid)
            .datum(this.chartCollection)
            .transition().duration(500)
            .call(this.chart);

        this.chart_loaded = _.isFunction(this.chart.update);
        this.displayNoData(!this.chart_loaded);
    },

    /* Process data loaded from REST endpoint so that d3 chart can consume
     * and set general chart properties
     */
    evaluateResult: function(data) {
        var total = 0,
            userConversionRate = 1 / app.metadata.getCurrency(app.user.getPreference('currency_id')).conversion_rate,
            userCurrencyPreference = app.user.getPreference('currency_id');
        _.each(data, function(value, key) {
            // parse currencies, format to user preference and attach the correct delimiters/symbols etc
            data[key].formattedAmount = app.currency.formatAmountLocale(app.currency.convertWithRate(value.amount_usdollar, userConversionRate), userCurrencyPreference, 0);
            data[key].icon = key === 'won' ? 'caret-up' : (key === 'lost' ? 'caret-down' : 'minus');
            data[key].cssClass = key === 'won' ? 'won' : (key === 'lost' ? 'lost' : 'active');
            data[key].dealLabel = key;
            data[key].stageLabel = app.lang.getAppListStrings('opportunity_metrics_dom')[key];
            total += value.count;
        });

        this.total = total;
        this.metricsCollection = data;

        this.chartCollection = {
            data: _.map(this.metricsCollection, function(value, key) {
                return {
                    'key': value.stageLabel,
                    'value': value.count,
                    'classes': key
                };
            }),
            properties: {
                title: app.lang.get('LBL_DASHLET_OPPORTUNITY_NAME'),
                value: 3,
                label: total
            }
        };
    },

    /**
     * @inheritdoc
     */
    loadData: function(options) {
        var self = this,
            url;
        if (this.meta.config) {
            return;
        }
        url = app.api.buildURL(this.model.module, 'opportunity_stats', {
            id: this.model.get('id')
        });
        app.api.call('read', url, null, {
            success: function(data) {
                self.evaluateResult(data);
                if (!self.disposed) {
                    // we have to rerender the entire dashlet, not just the chart,
                    // because the HBS file is dependant on metricsCollection
                    self.render();
                }
            },
            error: _.bind(function() {
                this.displayNoData(true);
            }, this),
            complete: options ? options.complete : null
        });
    }
})
