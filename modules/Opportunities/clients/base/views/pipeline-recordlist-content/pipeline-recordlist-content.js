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
 * @class View.Views.Base.Opportunities.PipelineRecordlistContentView
 * @alias App.view.views.BaseOpportunitiesPipelineRecordlistContentView
 * @extends View.Views.Base.PipelineRecordlistContentView
 */
({
    extendsFrom: 'PipelineRecordlistContentView',


    /**
     * @inheritdoc
     */
    getFieldsForFetch: function() {
        var fields = this._super('getFieldsForFetch');
        var cfg = app.metadata.getModule('Opportunities', 'config');
        var newFields = ['closed_revenue_line_items'];

        if (cfg && cfg.opps_view_by) {
            newFields.push(cfg.opps_view_by === 'RevenueLineItems' ? 'sales_status' : 'sales_stage');
        }

        return _.union(fields, newFields, [this.headerField]);
    },

    /**
     * @inheritdoc
     */
    _setNewModelValues: function(model, ui) {
        var ctxModel = this.context.get('model');
        var $ulEl = this.$(ui.item).parent('ul');
        var headerFieldValue = $ulEl.attr('data-column-name');

        if (ctxModel && ctxModel.get('pipeline_type') === 'date_closed') {
            var dateClosed = app.date(headerFieldValue, 'MMMM YYYY')
                .endOf('month')
                .formatServer(true);

            model.set('date_closed', dateClosed);
        } else {
            model.set(this.headerField, headerFieldValue);

            if (this.headerField === 'sales_stage') {
                model.set({
                    probability: app.utils.getProbabilityBySalesStage(headerFieldValue),
                    commit_stage: app.utils.getCommitStageBySalesStage(headerFieldValue)
                });
            }
        }
    }
});
