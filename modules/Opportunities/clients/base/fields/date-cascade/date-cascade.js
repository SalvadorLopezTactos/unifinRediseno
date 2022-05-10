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
 * @class View.Fields.Base.Opportunities.DateCascadeField
 * @alias SUGAR.App.view.fields.BaseOpportunitiesDateCascadeField
 * @extends View.Fields.Base.DateField
 */
({
    extendsFrom: 'DateField',

    /**
     * Name of validation task for Service Start Date
     */
    validationName: null,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this.plugins = _.union(this.plugins || [], ['Cascade']);
        this._super('initialize', [options]);
        this.def.lblString = app.lang.get('LBL_UPDATE_OPPORTUNITIES_RLIS', 'Opportunities') +
            ' ' +
            app.lang.getModuleName('RevenueLineItems', {plural: true});

        var config = app.metadata.getModule('Opportunities', 'config');
        if (this.name === 'service_start_date' && config.opps_view_by === 'RevenueLineItems') {
            app.error.errorName2Keys.service_start_date_exceeds_end_date = 'LBL_SERVICE_START_DATE_INVALID';

            this.validationName = 'start_date_before_fixed_end_' + this.cid;
            this.model.addValidationTask(this.validationName, _.bind(this.validateServiceStartDate, this));
        }
    },

    /**
     * Validates that the service start date is not after the end date of any
     * add on RLIs.
     * @param fields
     * @param errors
     * @param callback
     */
    validateServiceStartDate: function(fields, errors, callback) {
        // We don't want to perform this check when creating an opportunity or if the service
        // start date is empty (no service RLIs, for example)
        var serviceStartDate = this.model.get('service_start_date');
        if (this.field.action !== 'edit' || _.isEmpty(serviceStartDate)) {
            callback(null, fields, errors);
            return;
        }

        // Show the Saving alert while validation runs. Otherwise the UI appears to be
        // unresponsive during this time.
        app.alert.show('service_start_date_validation', {
            level: 'process',
            title: app.lang.get('LBL_SAVING'),
            autoClose: false
        });

        var forecastConfig = app.metadata.getModule('Forecasts', 'config');
        var closedSalesStages = _.union(forecastConfig.sales_stage_won, forecastConfig.sales_stage_lost);

        var moduleName = app.data.getRelatedModule(this.model.module, 'revenuelineitems');
        var rliCollection = app.data.createBeanCollection(moduleName);

        rliCollection.filterDef = {
            'filter': [
                {'opportunity_id': {'$equals': this.model.get('id')}},
                {'add_on_to_id': {'$not_empty': ''}},
                {'sales_stage': {'$not_in': closedSalesStages}},
                {'service_end_date': {'$lt': serviceStartDate}}
            ]
        };

        rliCollection.fetch({
            showAlerts: false,
            fields: ['id'],
            relate: false,
            success: _.bind(function(data) {
                if (data.length > 0) {
                    _.extend(errors, {
                        'service_start_date': {
                            'service_start_date_exceeds_end_date': true
                        }
                    });
                    this._showValidationMessage();
                }
            }, this),
            complete: function() {
                app.alert.dismiss('service_start_date_validation');
                callback(null, fields, errors);
            }
        });
    },

    /**
     * Shows the invalid service start date error message
     * @private
     */
    _showValidationMessage: function() {
        app.alert.show('service_start_date_exceeds_end_date', {
            level: 'error',
            messages: app.lang.get('LBL_SERVICE_START_DATE_INVALID', 'Opportunities'),
        });
    },

    /**
     * @inheritdoc
     */
    _getAppendToTarget: function() {
        // Overriding this method to append the datepicker on the side-drawer for Renewals console
        // while parent method appends the datepicker on the main-pane || drawer || preview-pane only

        // Similar fix was used for datetimecombo.js for CS-153
        var $currentComponent = this.$el;

        // this algorithm does not work on list view
        if (this.view && (this.view.type === 'recordlist' || this.view.type === 'subpanel-list')) {
            return this._super('_getAppendToTarget');
        }

        // First, attempt to attach to a parent element with an appropriate data-type attribute.
        // bootstrap-datepicker requires that the append-to target be relatively positioned:
        // https://stackoverflow.com/questions/27966645/bootstrap-datepicker-appearing-at-incorrect-location-in-a-modal
        while ($currentComponent.length > 0) {
            var dataType = $currentComponent && $currentComponent.attr('data-type');
            if (dataType === this.type) {
                $currentComponent.css('position', 'relative');
                return $currentComponent;
            } else {
                $currentComponent = $currentComponent ? $currentComponent.parent() : {};
            }
        }

        // fall back to parent implementation if necessary
        return this._super('_getAppendToTarget');
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        if (this.validationName) {
            this.model.removeValidationTask(this.validationName);
        }
        this._super('_dispose');
    }
})
