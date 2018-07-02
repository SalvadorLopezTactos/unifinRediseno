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

    /**
     * Holds report data from the server's endpoint once we fetch it
     */
    reportData: undefined,

    /**
     * Holds a reference to the Chart field
     */
    chartField: undefined,

    /**
     * Holds all report ID's and titles
     */
    reportOptions: undefined,

    /**
     * Holds acls for all reports
     */
    reportAcls: undefined,

    /**
     * ID for the autorefresh timer
     */
    timerId: undefined,

    events: {
        'click a[name=editReport]': 'editSavedReport'
    },

    /**
     * {@inheritDocs}
     */
    initDashlet: function (view) {
        // check if we're on the config screen
        if(this.meta.config) {
            this.meta.panels = this.dashletConfig.dashlet_config_panels;
            this.getAllSavedReports();
        } else {
            var autoRefresh = this.settings.get("auto_refresh");
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
    _scheduleReload: function (delay) {
        this.timerId = setTimeout(_.bind(function () {
            this.context.resetLoadFlag();
            this.loadData({
                success: function () {
                    this._scheduleReload(delay);
                }
            });
        }, this), delay);
    },

    /**
     * {@inheritDocs}
     */
    initialize: function(options) {
        this.reportData = new Backbone.Model();
        app.view.View.prototype.initialize.call(this, options);
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
     * {@inheritDocs}
     */
    bindDataChange: function() {
        if(this.meta.config) {
            this.settings.on('change:saved_report_id', function(model) {
                var reportTitle = this.reportOptions[model.get('saved_report_id')];

                this.settings.set({label: reportTitle});

                // set the title of the dashlet to the report title
                $('[name="label"]').val(reportTitle);
                
                // show or hide 'Edit Selected Report' link
                this.updateEditLink(model.get('saved_report_id'));
            }, this);
        }
    },

    /**
     * Check acls to show/hide 'Edit Selected Report' link
     */
    updateEditLink: function(reportId) {
        var acls = this.reportAcls[reportId || this.settings.get('saved_report_id')];
        if (acls && acls['edit'] === 'no') {
            $('[name="editReport"]').hide();
        }
        else {
            $('[name="editReport"]').show();
        }
    },

    /**
     * {@inheritDocs}
     */
    loadData: function(options) {
        options = options || {};
        this.getSavedReportById(this.settings.get('saved_report_id'), options);
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

        if(reportsField) {
            // set the initial saved_report_id to the first report in the list
            // if there are reports to show and we have not already saved this
            // dashlet yet with a report ID
            if(reports && !this.settings.has('saved_report_id')) {
                this.settings.set({
                    saved_report_id: _.first(reports).id
                });
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
        if(dt) {
            // manually set the icon class to spiny
            this.$("[data-action=loading]").removeClass(dt.cssIconDefault).addClass(dt.cssIconRefresh);
        }

        app.api.call('create', app.api.buildURL('Reports/chart/' + reportId), null, {
            success: _.bind(function(serverData) {
                // set reportData's rawChartData to the chartData from the server
                // this will trigger chart.js' change:rawChartData and the chart will update
                this.reportData.set({rawChartData: serverData.chartData});

                if (options && options.success) {
                    options.success.apply(this, arguments);
                }
            }, this),
            complete: options ? options.complete : null
        });
    },

    /**
     * {@inheritDocs}
     */
    _render: function() {
        // if we're in config, or if the chartField doesn't exist yet... render
        // otherwise do not render again as this destroys and re-draws the chart and looks awful
        if(this.meta.config || _.isUndefined(this.chartField)) {
            app.view.View.prototype._render.call(this);
        }
    },

    /**
     * {@inheritDocs}
     * When rendering fields, get a reference to the chart field if we don't have one yet
     */
    _renderField: function(field) {
        app.view.View.prototype._renderField.call(this, field);

        // hang on to a reference to the chart field
        if(_.isUndefined(this.chartField) && field.name == 'chart') {
            this.chartField = field;
        }
    }
})
