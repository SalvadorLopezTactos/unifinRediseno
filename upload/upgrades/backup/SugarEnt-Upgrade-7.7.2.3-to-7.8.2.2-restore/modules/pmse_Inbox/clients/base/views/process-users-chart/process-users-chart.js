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
    plugins: ['Dashlet', 'Chart'],
    //className: 'process-users-chart',
    processCollection: null,
    currentValue: null,
    chartCollection: null,
    hasData: false,
    total: 0,
    showProcesses: null,

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
            .margin({top: 5, right: 20, bottom: 20, left: 20})
            .donut(true)
            .donutLabelsOutside(true)
            .donutRatio(0.447)
            .hole(this.total)
            .showTitle(false)
            .tooltips(true)
            .showLegend(true)
            .colorData('class')
            .tooltipContent(function(key, x, y, e, graph) {
                return '<p><b>' + key + '</b></p><p><b>' + parseInt(y, 10) + '</b></p>';
            })
            .strings({
                noData: app.lang.get('LBL_CHART_NO_DATA')
            });
    },

    initDashlet: function (view) {
        var self = this;
        // loading all Processes list
        this.showProcesses = !(this.settings.get('isRecord') === '1');

        if (this.showProcesses) {
            app.api.call('GET', app.api.buildURL('pmse_Project/filter?fields=id,name'), null, {
                success: _.bind(function (data) {
                    var options = {};

                    this.processCollection = data.records;
                    this.processCollection.unshift({
                        id: 'all',
                        name: app.lang.get('LBL_PMSE_ALL_PROCESSES_LABEL', 'pmse_Inbox')
                    });

                    //Filling options
                    _.each(this.processCollection, function (row) {
                        options[row.id] = row.name;
                    });
                    this.dashletConfig.processes_selector[0].options = options;
                    this.currentValue = 'all';

                    this.layout.render();
                    this.layout.loadData();
                }, this),
                complete: view.options ? view.options.complete : null
            });

            this.settings.on('change:processes_selector', function (context, value) {
                self.currentValue = value;
                self.loadData();
            });
        } else {
            this.currentValue = this.model.get('id');
            //this.loadData();
        }
    },

    hasChartData: function () {
       return this.hasData;
    },

    /**
     * Generic method to render chart with check for visibility and data.
     * Called by _renderHtml and loadData.
     */
    renderChart: function() {
        if (!this.isChartReady()) {
            return;
        }

        // Set value of label inside donut chart if is greater than zero
        if (this.total && this.total > 0) {
            this.chart.hole(this.total);
        }

        d3.select(this.el).select('svg#' + this.cid)
            .datum(this.chartCollection)
            .transition().duration(500)
            .call(this.chart);

        this.chart_loaded = _.isFunction(this.chart.update);
        this.displayNoData(!this.chart_loaded);
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
        if (!this.currentValue) {
            return;
        }
        url = app.api.buildURL('pmse_Inbox/processUsersChart/' + this.currentValue);
        this.hasData = false;
        app.api.call('GET', url, null, {
            success: function(data) {
                self.evaluateResponse(data);
                self.renderChart();
            },
            complete: options ? options.complete : null
        });
    },

    evaluateResponse: function(response) {
        this.total = response.properties.total;
        this.hasData = !!this.total;
        response.data.map(function(d) {
            d.value = parseInt(d.value, 10);
        });
        this.chartCollection = response;
    }
})
