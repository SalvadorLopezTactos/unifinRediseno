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
    extendsFrom: 'MassupdateView',
    
    /**
     * {@inheritdoc}
     */
    initialize: function(options) {
        this.plugins = _.clone(this.plugins) || [];
        this.plugins.push('DisableMassDelete', 'MassQuote');
        this._super("initialize", [options]);
    },

    /**
     * {@inheritdoc}
     */
    delegateListFireEvents: function() {
        this.layout.on("list:records:deleted", this.deleteCommitWarning, this);
        this._super("delegateListFireEvents");
    },
    
    /**
     * Shows a warning message if a RLI that is included in a forecast is deleted.
     * @return string message
     */
    deleteCommitWarning: function(lastSelectedModels) {
        var message = null;
        
        if (!_.isUndefined(_.find(lastSelectedModels, function(model) {
            if (model.get("commit_stage") == "include") {
                return true;
            }
            return false;
        }))) {
            var forecastModuleSingular = app.lang.get('LBL_MODULE_NAME_SINGULAR', 'Forecasts');
            message = app.lang.get("WARNING_DELETED_RECORD_LIST_RECOMMIT_1", "RevenueLineItems")
                + '<a href="#Forecasts">' + forecastModuleSingular + '</a>.  '
                + app.lang.get("WARNING_DELETED_RECORD_LIST_RECOMMIT_2", "RevenueLineItems")
                + '<a href="#Forecasts">' + forecastModuleSingular + '</a>.';
            app.alert.show("included_list_delete_warning", {
                level: "warning",
                messages: message,
                onLinkClick: function() {
                    app.alert.dismissAll();
                }
            });
        }
        
        return message;
    }
})
