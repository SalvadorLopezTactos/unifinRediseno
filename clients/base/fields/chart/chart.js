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
 * @class View.Fields.Base.ChartField
 * @alias SUGAR.App.view.fields.BaseChartField
 * @extends View.Fields.Base.BaseField
 */
({
    /**
     * Direction for the user's language - ltr or rtl
     */
    langDirection: 'ltr',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this._registerEvents();

        this.chart = null;
        this.chart_loaded = false;
        this.chartType = '';
        this.locale = SUGAR.charts.getSystemLocale();

        this.langDirection = app.lang.direction;
    },

    /**
     * Register events
     */
    _registerEvents: function() {
        this.listenTo(this.view, 'chart-container:size:changed', this.preserveAspectRatio, this);
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this.model.on('change:rawChartData', function(model, newChartData) {
            // make sure this.model.get('rawChartData') is not null by checking that
            // the newChartData (data set for the model's rawChartData) is not null
            if (newChartData && this.model.get('rawChartData').values.length > 0) {
                this.displayNoData(false);
                // if the chart already exists, remove it before we generate the new one
                if (this.chart_loaded) {
                    this.$('#d3_' + this.cid + ' svg').remove();
                }
                this.generateD3Chart();
            } else {
                this.displayNoData(true);
            }
        }, this);
    },

    /**
     * Update chart size according to container size and x/y axes
     */
    preserveAspectRatio: function() {
        const chartData = this.model.get('rawChartData');

        if (!chartData) {
            return;
        }

        const params = this.getChartParams(chartData);
        const config = this.getChartConfig(chartData, params);

        if (!config.maintainAspectRatio) {
            return;
        }

        const chartEl = this.$(`#chart_${this.cid}_wrapper`);
        const marginOffset = 0.1;
        const ratio = config.aspectRatio - marginOffset;

        chartEl.css({
            height: '',
            width: '',
            marginLeft: '',
        });

        const size = {
            width: chartEl.innerWidth(),
            height: chartEl.innerHeight()
        };

        if (size.height * ratio < size.width) {
            const width = size.height * ratio;

            chartEl.css({
                width: width,
                marginLeft: (size.width - width) / 2,
            });
        }
    },

    overflowHandler: function(distance) {
        var b = this.view.$el.parents().filter(function() {
            return $(this).css('overflow-y') === 'auto' || $(this).css('overflow-y') === 'scroll';
        }).first();

        b.scrollTop(b.scrollTop() - distance);
    },

    /**
     * Callback function on chart render complete.
     *
     * @param {Function} chart sucrose chart instance
     * @param {Object} params chart display parameters
     * @param {Object} data report data with properties and data array
     */
    chartComplete: function(chart, params, reportData, chartData) {
        app.logger.warn('chartComplete has been deprecated. Chart click event is now handled by onClickHander');
        this.chart = chart;
        this.chart_loaded = _.isFunction(chart.update);

        if (!this.chart_loaded) {
            return;
        }

        this.view.trigger('chart:complete', chart, params, reportData, chartData);
    },

    /**
     * Generate the D3 Chart Object
     */
    generateD3Chart: function() {
        var id = this.cid;
        var chartData = this.model.get('rawChartData');
        var params = this.getChartParams(chartData); //NOTE: This is where groupType comes from
        var config = this.getChartConfig(chartData, params);

        if (this.view.layout && this.view.layout.layout && this.view.layout.layout.name === 'drillthrough-pane') {
            params.isOnDrillthrough = true;
        }

        // make sure we destroy and unlisten to events before creating a new chart el
        if (this.chart) {
            this.chart.chart.unbindEvents();
            this.chart.destroyChart();
        }

        this.preserveAspectRatio();

        loadSugarChart(id, chartData, [], config, params, chart => {
            this.chart = chart;
            if (this.chart && this.chart.wrapperProperties) {
                this.updateChartWrapperCss(this.chart.wrapperProperties);
            }
        });

        // Resize chart on print.
        this.handlePrinting('on');
    },

    /**
     * Given a set of key/value CSS properties, applies them to the wrapper
     * element around the chart canvas
     *
     * @param {Object} properties the key/value CSS property pairs to set
     */
    updateChartWrapperCss: function(properties) {
        let chartWrapper = document.getElementById(`chart_${this.cid}_wrapper`);
        if (chartWrapper) {
            Object.assign(chartWrapper.style, properties);
        }
    },

    getChartParams: function(chartData) {
        var chartId = this.cid;
        var chartParams = this.model.get('rawChartParams') || {};
        // Get properties from rawChartData
        var properties = !_.isUndefined(chartData.properties) && Array.isArray(chartData.properties) ?
                chartData.properties[0] :
                {};
        // These params will be overriden the SugarCharts defaults
        var params = {
                chart_type: 'multibar',
                margin: {top: 0, right: 10, bottom: 10, left: 10},
                allowScroll: true,
                module: properties.base_module,
                overflowHandler: _.bind(this.overflowHandler, this),
                baseModule: properties.base_module
            };
        var state = this.context.get('chartState');

        if (!_.isEmpty(chartParams)) {
            params = _.extend(params, chartParams);
        }
        if (!_.isEmpty(state)) {
            params.state = state;
        }

        params.onClick = this.onClickHandler();
        delete params.chartElementId;

        return params;
    },

    /**
     * Tells parent view to handle chart click
     */
    onClickHandler: function() {
        let self = this;
        return function(event, activeElements, chart) {
            let reportData = self.model.get('rawReportData');
            // `this` is of type BaseChart
            self.view.trigger('chart:clicked', event, activeElements, chart, this, reportData);
        };
    },

    /**
     * Builds the chart config based on the type of chart
     * @return {Mixed}
     */
    getChartConfig: function(chartData, chartParams) {
        var data = chartData || this.model.get('rawChartData');
        var params = chartParams || this.model.get('rawChartParams');
        var chartConfig;
        var chartGroupType;

        // chartData artifact
        if (!_.isEmpty(chartData) && !_.isUndefined(chartData.properties)) {
            data.properties[0].type = params.chart_type;
        }

        switch (params.chart_type) {
            case 'pie chart':
                chartConfig = {
                    pieType: 'basic',
                    chartType: 'pieChart'
                };
                break;

            case 'donut chart':
                chartConfig = {
                    pieType: 'basic',
                    chartType: 'donutChart',
                };
                break;

            case 'treemap chart':
                chartConfig = {
                    treemapType: 'basic',
                    chartType: 'treemapChart',
                };
                break;

            case 'line chart':
                chartConfig = {
                    lineType: 'grouped',
                    chartType: 'lineChart'
                };
                break;

            case 'funnel chart':
            case 'funnel chart 3D':
                // funnel preserves its aspect ratio so it needs scroll
                this.$('[data-content="chart"]').css('overflow-y', 'auto');

                chartConfig = {
                    funnelType: 'basic',
                    chartType: 'funnelChart',
                    maintainAspectRatio: true,
                    aspectRatio: 1,
                };
                break;

            case 'gauge chart':
                chartConfig = {
                    gaugeType: 'basic',
                    chartType: 'gaugeChart'
                };
                break;

            case 'stacked group by chart':
                chartConfig = {
                    orientation: 'vertical',
                    barType: 'stacked',
                    chartType: 'barChart'
                };
                break;

            case 'group by chart':
                chartConfig = {
                    orientation: 'vertical',
                    barType: 'grouped',
                    chartType: 'barChart'
                };
                break;

            case 'bar chart':
                chartConfig = {
                    orientation: 'vertical',
                    barType: 'basic',
                    chartType: 'barChart'
                };
                break;

            case 'horizontal group by chart':
                chartConfig = {
                    orientation: 'horizontal',
                    barType: 'stacked',
                    chartType: 'barChart'
                };
                break;

            case 'horizontal grouped bar chart':
                chartConfig = {
                    orientation: 'horizontal',
                    barType: 'grouped',
                    chartType: 'barChart'
                };
                break;
            case 'vertical grouped bar chart':
                chartConfig = {
                    orientation: 'vertical',
                    barType: 'grouped',
                    chartType: 'barChart'
                };
                break;

            case 'horizontal bar chart':
            case 'horizontal':
                chartConfig = {
                    orientation: 'horizontal',
                    barType: 'basic',
                    chartType: 'barChart'
                };
                break;

            default:
                chartConfig = {
                    orientation: 'vertical',
                    barType: 'stacked',
                    chartType: 'barChart'
                };
                break;
        }

        // Not all the charts config has barType key, before we are checking agains barType value
        // we have to ensure that this key exists
        if (params.stacked && _.has(chartConfig, 'barType') && chartConfig.barType !== 'basic') {
            chartConfig.barType = 'stacked';
        }

        chartConfig.direction = app.lang.direction;

        // chartParams artifact
        chartGroupType = chartConfig.barType ||
            chartConfig.lineType ||
            chartConfig.pieType ||
            chartConfig.treemapType ||
            chartConfig.funnelType ||
            'basic';
        chartParams.dataType = chartGroupType === 'stacked' ? 'grouped' : chartGroupType;

        this.chartType = chartConfig.chartType;

        return chartConfig;
    },

    /**
     * Attach and detach a resize method to the print event
     * @param {string} The state of print handling.
     */
    handlePrinting: function(state) {
        var self = this,
            mediaQueryList = window.matchMedia && window.matchMedia('print'),
            pausecomp = function(millis) {
                // www.sean.co.uk
                var date = new Date(),
                    curDate = null;
                do {
                    curDate = new Date();
                } while (curDate - date < millis);
            },
            printResize = function(mql) {
                if (mql.matches) {
                    if (!_.isUndefined(self.chart.legend) && _.isFunction(self.chart.legend.showAll)) {
                        self.chart.legend.showAll(true);
                    }
                    self.chart.width(640).height(320).update();
                    pausecomp(200);
                } else {
                    browserResize();
                }
            },
            browserResize = function() {
                if (!_.isUndefined(self.chart.legend) && _.isFunction(self.chart.legend.showAll)) {
                    self.chart.legend.showAll(false);
                }
                self.chart.width(null).height(null).update();
            };

        if (state === 'on') {
            if (window.matchMedia) {
                mediaQueryList.addListener(printResize);
            } else if (window.attachEvent) {
                window.attachEvent('onbeforeprint', printResize);
                window.attachEvent('onafterprint', browserResize);
            } else {
                window.onbeforeprint = printResize;
                window.onafterprint = browserResize;
            }
        } else {
            if (window.matchMedia) {
                mediaQueryList.removeListener(printResize);
            } else if (window.detachEvent) {
                window.detachEvent('onbeforeprint', printResize);
                window.detachEvent('onafterprint', browserResize);
            } else {
                window.onbeforeprint = null;
                window.onafterprint = null;
            }
        }
    },

    /**
     * Toggle display of dashlet content and NoData message
     * @param {boolean} state The visibility state of the dashlet content.
     */
    displayNoData: function(state) {
        this.$('[data-content="chart"]').toggleClass('hide', state);
        this.$('[data-content="nodata"]').toggleClass('hide', !state);
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        this.handlePrinting('off');
        if (this.chart) {
            this.chart.destroyChart();
        }
        this._super('_dispose');
    },
})
