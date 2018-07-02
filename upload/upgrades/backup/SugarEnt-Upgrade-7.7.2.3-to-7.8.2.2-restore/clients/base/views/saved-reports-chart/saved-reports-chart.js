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
 * @class View.Views.Base.SavedReportsChartView
 * @alias SUGAR.App.view.views.BaseSavedReportsChartView
 * @extends View.View
 */
({
    plugins: ['Dashlet'],

    events: {
        'click a[name=editReport]': 'editSavedReport'
    },

    /**
     * @inheritdoc
     */
    initDashlet: function(view) {
        // check if we're on the config screen
        if (this.meta.config) {
            this.meta.panels = this.dashletConfig.dashlet_config_panels;
            this.getAllSavedReports();
        } else {
            var autoRefresh = this.settings.get('auto_refresh');
            if (autoRefresh > 0) {
                if (this.timerId) {
                    clearTimeout(this.timerId);
                }

                this._scheduleReload(autoRefresh * 1000 * 60);
            }
        }
    },

    /**
     * Schedules chart data reload
     *
     * @param {Number} delay Number of milliseconds which the reload should be delayed for
     * @private
     */
    _scheduleReload: function(delay) {
        this.timerId = setTimeout(_.bind(function() {
            this.context.resetLoadFlag();
            this.loadData({
                success: function() {
                    this._scheduleReload(delay);
                }
            });
        }, this), delay);
    },

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        // Holds report data from the server's endpoint once we fetch it
        this.reportData = new Backbone.Model();
        this.reportOptions = [];
        this._super('initialize', [options]);
    },

    /**
     * Route to the bwc edit view of the currently selected Saved Report. If User clicks 'save' or 'cancel' or 'delete'
     * from there, return the user to the current page.
     */
    editSavedReport: function() {
        var currentTargetId = this.dashModel.get('saved_report_id'),
            params = {
                dashletEdit: 1
            },
            route = app.bwc.buildRoute('Reports', currentTargetId, 'ReportsWizard', params);

        //If this button was clicked too early, the saved_report_id may not be populated. Then we want to return
        //because moving on will result in a php error
        if (!currentTargetId) {
            return;
        }
        app.alert.show('navigate_confirmation', {
            level: 'confirmation',
            messages: 'LBL_NAVIGATE_TO_REPORTS',
            onConfirm: _.bind(function() {
                //Save current location to this so we can use it in the event listener
                this.currentLocation = Backbone.history.getFragment();

                //Add event listener for when the user finishes up the edit
                $(window).one('dashletEdit', _.bind(this.postEditListener, this));

                //Once we've successfully routed to the dashletEdit location,
                //any successive route should be checked. If the user moves away from the edit without
                //either cancelling or finishing the edit, we should forget that we have to come back to the current location
                var dashletEditVisited = false;
                app.router.on('route', function() {
                    var routeLocation = Backbone.history.getFragment();
                    if (routeLocation.indexOf('dashletEdit=1') >= 0) {
                        dashletEditVisited = true;
                    }
                    if (routeLocation.indexOf('dashletEdit=1') < 0 && dashletEditVisited) {
                        app.router.off('route');
                        $(window).off('dashletEdit');
                    }
                });

                //Go to edit page
                app.router.navigate(route, {trigger: true});
            }, this)
        });
    },

    /**
     * Call after the user is done editing the saved report. Return the user to the page that was stored when the
     * event was set
     *
     * @param {object} jquery event
     */
    postEditListener: function(event) {
        //Go back from whence we came
        if (this.currentLocation) {
            app.router.navigate(this.currentLocation, {trigger: true});
        }
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        if (this.meta.config) {
            this.settings.on('change:saved_report_id', function(model) {
                var reportId = model.get('saved_report_id');

                if (_.isEmpty(reportId)) {
                    return;
                }

                this.getSavedReportById(reportId, {
                    success: _.bind(function(data) {
                        this.setChartParams(data, true);
                    }, this)
                });

                // show or hide 'Edit Selected Report' link
                this.updateEditLink(reportId);
            }, this);

            this.settings.on('change:chart_type', function(model) {
                // toggle display of chart display option controls based on chart type
                this._toggleChartFields();
            }, this);
        }
    },

    /**
     * Check acls to show/hide 'Edit Selected Report' link
     */
    updateEditLink: function(reportId) {
        var acls = this.reportAcls[reportId || this.settings.get('saved_report_id')],
            showEditLink = !acls || acls['edit'] !== 'no';
        this.$('[name="editReport"]').toggle(showEditLink);
    },

    /**
     * @inheritdoc
     */
    loadData: function(options) {
        options = options || {};
        if (!_.isEmpty(this.settings.get('saved_report_id'))) {
            _.extend(options, {
                success: _.bind(function(data) {
                    this.setChartParams(data, false);
                }, this)
            });
            this.getSavedReportById(this.settings.get('saved_report_id'), options);
        }
    },

    getDefaultSettings: function() {
        // By default, settings only has: label, type, config, module
        // Module is normally null so we want to rehit that
        var settings = _.clone(this.settings.attributes),
            defaults = {
                module:          this.layout.module,
                auto_refresh:    0,
                show_title:      false,
                show_y_label:    false,
                y_axis_label:    '',
                show_x_label:    false,
                x_axis_label:    '',
                allowScroll:     true,
                showValues:      0,
                hideEmptyGroups: true,
                wrapTicks:       true,
                staggerTicks:    true,
                rotateTicks:     true
            };
        return _.defaults(settings, defaults);
    },

    /**
     * Process the chart data from the server
     *
     * @param {Object|String} serverData The Report Data from the server
     * @param {Boolean} [update] Is this an update to the report?
     */
    setChartParams: function(serverData, update) {
        // only called by bindDataChange when the report id is changed in config panel
        if (!serverData.reportData || !serverData.chartData) {
            if (!this.meta.config && this.chartField) {
                this.chartField.displayNoData(true);
            }
            return;
        }
        update = _.isUndefined(update) ? false : update;

        var data = serverData.reportData,
            properties = serverData.chartData.properties[0],
            config = this.getChartConfig(properties.type),
            params = this.getDefaultSettings(),
            defaults = {
                label: data.name,
                chart_type: config.chartType || properties.type,
                report_title: properties.title,
                show_legend: properties.legend === 'on' ? true : false,
                stacked: config.barType === 'stacked' || config.barType === 'basic' ? true : false,
                x_axis_label: this._getXaxisLabel(data),
                y_axis_label: this._getYaxisLabel(data)
            };

        // override settings when new report is selected
        if (update) {
            _.extend(params, defaults);
        } else {
            _.defaults(params, defaults);
        }

        // persist the chart settings for use by SugarCharts
        this.reportData.set({
            rawChartParams: params
        });

        // update the settings model for use by chart field
        this.settings.set(params);

        // toggle display of chart display option controls based on chart type
        this._toggleChartFields();

        // set the title of the dashlet to the report title
        this.$('[name="label"]').val(this.settings.get('label'));
    },

    /**
     * Builds the chart config based on the type of chart
     * @return {Mixed}
     */
    getChartConfig: function(chartType) {
        var chartConfig;

        switch (chartType) {
            case 'pie chart':
                chartConfig = {
                    chartType: 'pie chart'
                };
                break;

            case 'line chart':
                chartConfig = {
                    chartType: 'line chart'
                };
                break;

            case 'funnel chart 3D':
                chartConfig = {
                    chartType: 'funnel chart'
                };
                break;

            case 'gauge chart':
                chartConfig = {
                    chartType: 'gauge chart'
                };
                break;

            case 'stacked group by chart':
                chartConfig = {
                    orientation: 'vertical',
                    barType: 'stacked',
                    chartType: 'group by chart'
                };
                break;

            case 'group by chart':
                chartConfig = {
                    orientation: 'vertical',
                    barType: 'grouped',
                    chartType: 'group by chart'
                };
                break;

            case 'bar chart':
                chartConfig = {
                    orientation: 'vertical',
                    barType: 'basic',
                    chartType: 'bar chart'
                };
                break;

            case 'horizontal group by chart':
                chartConfig = {
                    orientation: 'horizontal',
                    barType: 'stacked',
                    chartType: 'horizontal group by chart'
                };
                break;

            case 'horizontal bar chart':
            case 'horizontal':
                chartConfig = {
                    orientation: 'horizontal',
                    barType: 'basic',
                    chartType: 'horizontal bar chart'
                };
                break;

            default:
                chartConfig = {
                    orientation: 'vertical',
                    barType: 'stacked',
                    chartType: 'bar chart'
                };
                break;
        }

        return chartConfig;
    },

    /**
     * Returns the x-axis label based on report data
     * @return {String}
     */
    _getXaxisLabel: function(data) {
        var label = '';
        if (data && data.group_defs) {
            label = _.first(data.group_defs).label;
        }
        return label;
    },

    /**
     * Returns the y-axis label based on report data
     * @return {String}
     */
    _getYaxisLabel: function(data) {
        var label = '';
        if (data && data.summary_columns) {
            _.each(data.summary_columns, function(column) {
                if (!_.isUndefined(column.group_function)) {
                    label = column.label;
                }
            });
        }
        return label;
    },

    /**
     * Makes a call to Reports/saved_reports to get any items stored in the saved_reports table
     */
    getAllSavedReports: function() {
        var params = {
                has_charts: true
            },
            url = app.api.buildURL('Reports/saved_reports', null, null, params);

        app.api.call('read', url, null, {
            success: _.bind(this.parseAllSavedReports, this)
        });
    },

    /**
     * Parses items passed back from Reports/saved_reports endpoint into enum options
     *
     * @param {Array} reports an array of saved reports returned from the endpoint
     */
    parseAllSavedReports: function(reports) {
        this.reportOptions = {};
        this.reportAcls = {};

        _.each(reports, function(report) {
            // build the reportOptions key/value pairs
            this.reportOptions[report.id] = report.name;
            this.reportAcls[report.id] = report._acl;
        }, this);

        // find the saved_report_id field
        var reportsField = _.find(this.fields, function(field) {
            return field.name == 'saved_report_id';
        });

        if (reportsField) {
            // set the initial saved_report_id to the first report in the list
            // if there are reports to show and we have not already saved this
            // dashlet yet with a report ID
            if (reports && (!this.settings.has('saved_report_id') || _.isEmpty(this.settings.get('saved_report_id')))) {
                this.settings.set('saved_report_id', _.first(reports).id);
            }

            // set field options and render
            reportsField.items = this.reportOptions;
            reportsField._render();

            // check acls to show or hide 'Edit Selected Report' link
            this.updateEditLink();
        }
    },

    /**
     * Makes a call to Reports/saved_reports/:id to fetch specific saved report data
     *
     * @param {String} reportId the ID for the report we're looking for
     */
    getSavedReportById: function(reportId, options) {
        var dt = this.layout.getComponent('dashlet-toolbar');
        if (dt) {
            // manually set the icon class to spiny
            this.$('[data-action=loading]').removeClass(dt.cssIconDefault).addClass(dt.cssIconRefresh);
        }

        app.api.call('create', app.api.buildURL('Reports/chart/' + reportId), {'ignore_datacheck': true}, {
            success: _.bind(function(serverData) {
                if (options && options.success) {
                    options.success.apply(this, arguments);
                }

                // set reportData's rawChartData to the chartData from the server
                // this will trigger chart.js' change:rawChartData and the chart will update
                this.reportData.set({
                    rawReportData: serverData.reportData,
                    rawChartData: serverData.chartData
                });
            }, this),
            complete: options ? options.complete : null
        });
    },

    /**
     * @inheritdoc
     */
    _render: function() {
        // if we're in config, or if the chartField doesn't exist yet... render
        // otherwise do not render again as this destroys and re-draws the chart and looks awful
        if (this.meta.config || _.isUndefined(this.chartField)) {
            this._super('_render');
        }
    },

    /**
     * Handle the display of the chart display option controls based on chart type
     *
     * @private
     */
    _toggleChartFields: function() {
        if (this.meta.config) {

            var xOptionsFieldset = this.getField('x_label_options'),
                tickDisplayMethods = this.getField('tickDisplayMethods'),
                yOptionsFieldset = this.getField('y_label_options'),
                showValuesField = this.getField('showValues'),
                groupDisplayOptions = this.getField('groupDisplayOptions'),
                stackedField = this.getField('stacked'),
                showDimensionOptions = false,
                showBarOptions = false,
                showTickOptions = false,
                showStacked = false,
                xOptionsLabel = app.lang.get('LBL_CHART_CONFIG_SHOW_XAXIS_LABEL'),
                yOptionsLabel = app.lang.get('LBL_CHART_CONFIG_SHOW_YAXIS_LABEL');

            switch (this.settings.get('chart_type')) {
                case 'pie chart':
                case 'gauge chart':
                case 'funnel chart 3D':
                    showDimensionOptions = false;
                    showBarOptions = false;
                    break;

                case 'line chart':
                    showDimensionOptions = true;
                    showBarOptions = false;
                    break;

                case 'stacked group by chart':
                case 'horizontal group by chart':
                case 'group by chart':
                    showDimensionOptions = true;
                    showBarOptions = true;
                    showStacked = true;
                    break;

                case 'vertical bar chart':
                case 'vertical':
                case 'bar chart':
                case 'horizontal bar chart':
                case 'horizontal':
                    showDimensionOptions = true;
                    showBarOptions = true;
                    showStacked = false;
                    break;

                default:
                    showDimensionOptions = false;
                    showBarOptions = false;
            }

            if (showDimensionOptions) {
                switch (this.settings.get('chart_type')) {
                    case 'horizontal group by chart':
                    case 'horizontal bar chart':
                    case 'horizontal':
                        showTickOptions = false;
                        xOptionsLabel = app.lang.get('LBL_CHART_CONFIG_SHOW_YAXIS_LABEL');
                        yOptionsLabel = app.lang.get('LBL_CHART_CONFIG_SHOW_XAXIS_LABEL');
                        break;
                    case 'line chart':
                        showTickOptions = false;
                        break;
                    default:
                        showTickOptions = true;
                        xOptionsLabel = app.lang.get('LBL_CHART_CONFIG_SHOW_XAXIS_LABEL');
                        yOptionsLabel = app.lang.get('LBL_CHART_CONFIG_SHOW_YAXIS_LABEL');
                }
            }

            if (xOptionsFieldset) {
                xOptionsFieldset.$el.closest('.record-cell').toggleClass('hide', !showDimensionOptions);
                xOptionsFieldset.$el.closest('.record-cell').find('.record-label').text(xOptionsLabel);
                yOptionsFieldset.$el.closest('.record-cell').find('.record-label').text(yOptionsLabel);
            }
            if (tickDisplayMethods) {
                tickDisplayMethods.$el.closest('.record-cell').toggleClass('hide', !showDimensionOptions || !showTickOptions);
                tickDisplayMethods.$el.find('.disabled').find('input').prop( 'checked', true ).prop('disabled', true);
            }

            if (yOptionsFieldset) {
                yOptionsFieldset.$el.closest('.record-cell').toggleClass('hide', !showDimensionOptions);
            }

            if (showValuesField) {
                showValuesField.$el.closest('.record-cell').toggleClass('hide', !showBarOptions);
            }
            if (groupDisplayOptions) {
                groupDisplayOptions.$el.closest('.record-cell').toggleClass('hide', !showBarOptions);
                if (stackedField) {
                    stackedField.$el.toggleClass('hide', !showStacked);
                }
            }

        }
    },

    /**
     * Handle the conditional display of settings input field based on checkbox toggle state
     *
     * @param {Object} toggle a checkbox control that determines display state of field
     * @param {Object} dependent the input field that holds the setting value
     * @private
     */
    _toggleDepedent: function(toggle, dependent) {
        var inputField = dependent.$el.find(dependent.fieldTag),
            enabled = this.settings.get(toggle.name),
            value = enabled ? this.settings.get(dependent.name) : '';
        inputField
            .prop('disabled', !enabled)
            .val(value);
    },

    /**
     * @inheritdoc
     * When rendering fields, get a reference to the chart field if we don't have one yet
     */
    _renderField: function(field) {
        this._super('_renderField', [field]);

        // Manage display state of fieldsets with toggle
        if (this.meta.config) {

            if (!_.isUndefined(field.def.toggle)) {
                var toggle = this.getField(field.def.toggle),
                    dependent = this.getField(field.def.dependent);

                this._toggleDepedent(toggle, dependent);

                this.settings.on('change:' + toggle.name, _.bind(function(event) {
                    this._toggleDepedent(toggle, dependent);
                }, this));
                this.settings.on('change:' + dependent.name, _.bind(function(event) {
                    this._toggleDepedent(toggle, dependent);
                }, this));
            }
        }

        // hang on to a reference to the chart field
        if (_.isUndefined(this.chartField) && field.name === 'chart') {
            this.chartField = field;
        }
    }
})
