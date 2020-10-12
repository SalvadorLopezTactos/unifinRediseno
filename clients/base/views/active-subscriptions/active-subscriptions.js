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
 * @class View.Views.Base.ActiveSubscriptionsView
 * @alias SUGAR.App.view.views.BaseActiveSubscriptionsView
 * @extends View.View
 */
({

    plugins: ['Dashlet'],

    /**
     * The module name to show active subscriptions for.
     *
     * @property {string}
     */
    baseModule: null,

    /**
     * The model to show active subscriptions for.
     *
     * @property {Object}
     */
    baseModel: null,

    overallSubscriptionStartDate: 0,

    overallSubscriptionEndDate: 0,

    overallDaysDifference: 0,

    endDate: '',

    expiryComingSoon: false,

    /**
     * Flag indicating if RLI is enabled.
     *
     * @property {bool}
     */
    opportunitiesWithRevenueLineItems: false,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.module = 'RevenueLineItems';
        this.moduleName = {'module_name': app.lang.getModuleName(this.module, {'plural': true})};
        this.baseModule = 'Accounts';
        this._getBaseModel();
        var oppConfig = app.metadata.getModule('Opportunities', 'config');
        if (oppConfig && oppConfig.opps_view_by === 'RevenueLineItems') {
            this.opportunitiesWithRevenueLineItems = true;
        }
    },

    /**
     * Set up collection when init dashlet.
     *
     * @param {string} viewName Current view
     */
    initDashlet: function(viewName) {
        this._mode = viewName;
        this._initCollection();
    },

    /**
     * Get base model from parent context.
     *
     * @private
     */
    _getBaseModel: function() {
        var baseModule = this.context.get('module');
        var currContext = this.context;

        if (baseModule !== this.baseModule) {
            return;
        }

        while (currContext) {
            var contextModel = currContext.get('rowModel') || currContext.get('model');

            if (contextModel && contextModel.get('_module') === baseModule) {
                this.baseModel = contextModel;
                break;
            }

            currContext = currContext.parent;
        }
    },

    /**
     * Initialize collection.
     *
     * @private
     */
    _initCollection: function() {
        if (!this.baseModel || !this.opportunitiesWithRevenueLineItems) {
            return;
        }
        var today = app.date().formatServer(true);
        var filter = [
            {
                'account_id': {
                    '$equals': this.baseModel.get('id')
                }
            },
            {
                'opportunities.sales_status': {
                    '$equals': 'Closed Won'
                }
            },
            {
                'sales_stage': {
                    '$equals': 'Closed Won'
                }
            },
            {
                'service_duration_value': {
                    '$gt': 0
                }
            },
            {
                'service_start_date': {
                    '$lte': today
                }
            },
            {
                'service_end_date': {
                    '$gte': today
                }
            }
        ];
        var options = {
            'fields': this.meta.fields || [],
            'filter': filter,
            'limit': app.config.maxRecordFetchSize || 1000,
            'params': {
                'order_by': 'service_start_date,service_end_date',
            },
            'success': _.bind(function() {
                if (this.disposed) {
                    return;
                }
                _.each(this.collection.models, function(model) {
                    // add 1 day to display remaining time correctly
                    var nextDate = app.date(model.get('service_end_date')).add('1', 'day');
                    model.set('service_remaining_time', nextDate.fromNow());
                });
                this._caseComparator();
                this._daysDifferenceCalculator();
                this.render();
            }, this)
        };
        this.collection = app.data.createBeanCollection(this.module, null, options);
        this.collection.fieldsMeta = {
            'total_amount': {
                'name': 'total_amount',
                'type': 'currency',
                'convertToBase': true,
                'currency_field': 'currency_id',
                'base_rate_field': 'base_rate'
            }
        };
    },

    /**
     * Load active subscriptions.
     *
     * @param {Object} options Call options
     */
    loadData: function(options) {
        if (this._mode === 'config' || !this.opportunitiesWithRevenueLineItems) {
            return;
        }
        this.collection.fetch(options);
    },

    /**
     * Calculates the upper and lower bounds for the timeline Graph calculating the earliest
     * Start Date and End Date for all the records.
     */
    _caseComparator: function() {
        if (this.collection) {
            var daysPast = moment('1970-01-01');
            var min = Number.MAX_VALUE;
            var max = 0;
            var start;
            var end;
            var modelArray = this.collection.models;
            modelArray.forEach(function(model) {
                start = model.get('service_start_date');
                start = this.moment(start);
                start = start.diff(daysPast, 'days');
                end = model.get('service_end_date');
                end = this.moment(end);
                end = end.diff(daysPast, 'days');
                if (max < end) {
                    max = end;
                }
                if (min > start) {
                    min = start;
                }
            });
            this.overallSubscriptionEndDate = max;
            this.overallSubscriptionStartDate = min;
        }
    },

    /**
     * Calculates the width for the graph by adjusting in to the 60% width
     * and sets width for the subscription time past and subscription time left
     * to fit into 60% width.
     */
    _daysDifferenceCalculator: function() {
        var daysPast = moment('1970-01-01');
        var today = moment();
        if (this.collection) {
            var overallSubscriptionStartDate = this.overallSubscriptionStartDate;
            var overallDaysDifference = this.overallSubscriptionEndDate - overallSubscriptionStartDate;
            var start = null;
            var end = null;
            var startDate = null;
            var endDate = null;
            var activeTimelineWidth = null;
            var activePastTimelineWidth = null;
            var timelineOffset = 40;
            today = today.diff(daysPast, 'days');

            _.each(this.collection.models, function(model) {
                start = model.get('service_start_date');
                start = this.moment(start);
                start = start.diff(daysPast, 'days');
                startDate = ((start - overallSubscriptionStartDate) / overallDaysDifference).toFixed(2) * 100;

                end = model.get('service_end_date');
                end = this.moment(end);
                this.endDate = end;
                end = end.diff(daysPast, 'days');
                endDate = ((end - overallSubscriptionStartDate) / overallDaysDifference).toFixed(2) * 100;

                activeTimelineWidth = ((end - start) / overallDaysDifference) * 60;
                timelineOffset = timelineOffset + startDate * 0.6;
                activeTimelineWidth = (activeTimelineWidth + timelineOffset) > 100 ? (100 - timelineOffset)
                    : activeTimelineWidth;
                activePastTimelineWidth = ((today - start) / (end - start)) * 100;
                activePastTimelineWidth = activePastTimelineWidth >= 100 ? activePastTimelineWidth - 1
                    : activePastTimelineWidth;
                this.expiryComingSoon = (activePastTimelineWidth) >= 90 ? true : false;
                timelineOffset = isNaN(timelineOffset) ? 40 : timelineOffset;
                activeTimelineWidth = isNaN(activeTimelineWidth) ? 60 : activeTimelineWidth;
                activePastTimelineWidth = isNaN(activePastTimelineWidth) ? 99 : activePastTimelineWidth;
                activeTimelineWidth = (activeTimelineWidth === 0) ? 100 - activePastTimelineWidth : activeTimelineWidth;
                model.set({
                    startDate: app.date(model.get('service_start_date')).formatUser().split(' ')[0],
                    endDate: app.date(model.get('service_end_date')).formatUser().split(' ')[0],
                    expiration: this.endDate.fromNow(),
                    timelineOffset: timelineOffset,
                    subscriptionValidityActive: activeTimelineWidth.toFixed(2),
                    subscriptionActiveWidth: activePastTimelineWidth.toFixed(2),
                    expiryComingSoon: this.expiryComingSoon
                });
                timelineOffset = 40;
            });
        }
    },
})
