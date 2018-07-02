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

    initialize: function(options) {
        this.inboxId = options.context.attributes.modelId;
        this.flowId = options.context.attributes.action;
        app.routing.before('route', this.beforeRouteChange, this);
    },

    loadData: function () {
        var self = this,
            sep = '/',
            pmseInboxUrl = app.api.buildURL(this.options.module + '/case/' + this.inboxId + sep + this.flowId ,'',{},{});

        app.api.call('READ', pmseInboxUrl, {},{
            success: function(data) {
                self.initCaseView(data)
            },
            error: function (error) {
                app.error.handleNotFoundError();
            }
        });
    },
    initCaseView: function(data){
        if(data.case.flow.cas_flow_status==='FORM'){
            this.params = {
                action: 'detail',
                layout: 'pmse-case',
                module: data.case.flow.cas_sugar_module,
                modelId: data.case.flow.cas_sugar_object_id,
                case: data.case
            };
            app.controller.loadView(this.params);
        } else if (data.case.flow.cas_flow_status === 'CLOSED') {
            app.alert.show('message-id', {
                level: 'warning',
                messages: app.lang.get('LBL_PA_PROCESS_CLOSED','pmse_Inbox'),
                autoClose: false
            });
            app.router.goBack();
        } else {
            app.alert.show('message-id', {
                level: 'warning',
                messages: app.lang.get('LBL_PA_PROCESS_UNAVAILABLE','pmse_Inbox'),
                autoClose: false
            });
        }
    },

    beforeRouteChange: function () {
        app.routing.offBefore('route', this.beforeRouteChange);
        $('.adam-modal').remove();
    }
})
