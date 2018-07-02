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
(function(app) {
    app.events.on("app:init", function() {

        /**
         * This plugin disables the delete button for closed won/lost items (for use in Opps and Products)
         */
        app.plugins.register('DisableDelete', ["field"], {

            /**
             * Attach code for when the plugin is registered on a view
             *
             * @param component
             * @param plugin
             */
            onAttach: function(component, plugin) {
                this.on("render", this.removeDelete, this);
            },
            
            /**
             * Marks delete option as disabled and adds tooltip for listview items that are closed lost/won
             * 
             * @return string message that was set
             */
            removeDelete: function() {
                var sales_stage_won = null,
                    sales_stage_lost = null,
                    closed_RLI_count = 0,
                    message = null,
                    status = null,
                    button = null;

                if (_.contains(["list:deleterow:fire", "button:delete_button:click"], this.def.event)) {
                    sales_stage_won = app.metadata.getModule("Forecasts", "config").sales_stage_won;
                    sales_stage_lost = app.metadata.getModule("Forecasts", "config").sales_stage_lost;
                    //ENT allows sales_status, so we need to check to see if this module has it and use it
                    status = this.model.get("sales_status");

                    //grab the closed RLI count (when on opps)
                    closed_RLI_count = this.model.get("closed_revenue_line_items");
                    if (_.isNull(closed_RLI_count)) {
                        closed_RLI_count = 0;
                    }

                    if (_.isEmpty(status)) {
                        status = this.model.get("sales_stage");
                    }

                    //if we have closed RLIs, set the message here
                    if (closed_RLI_count > 0) {
                        message = app.lang.get("NOTICE_NO_DELETE_CLOSED_RLIS", "Opportunities");
                    }

                    //if this item has a closed status, this message wins, so set it accordingly
                    if (_.contains(sales_stage_won, status) || _.contains(sales_stage_lost, status)) {
                        message = app.lang.getAppString("NOTICE_NO_DELETE_CLOSED");
                    }

                    //if we have a message, disable the button.
                    if (!_.isEmpty(message)) {
                        button = this.getFieldElement();
                        button.addClass("disabled");
                        button.attr("data-event", "");
                        button.tooltip({title: message});
                    }
                }
                return message;
            }
        })
    })
})(SUGAR.App);
