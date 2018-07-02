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
({initialize:function(options){app.view.Layout.prototype.initialize.call(this,options);this.collection.sync=this.sync;this.collection.allowed_modules=[app.lang.get('LBL_CAS_ID',options.module),app.lang.get('LBL_PROCESS_DEFINITION_NAME',options.module),app.lang.get('LBL_RECORD_NAME',options.module),app.lang.get('LBL_OWNER',options.module)];this.context.on('compose:addressbook:search',this.search,this);},sync:function(method,model,options){var callbacks,url;options=options||{};if(_.isEmpty(options.module_list)){options.module_list=['all'];}else{options.module_list=_.intersection(this.allowed_modules,options.module_list);}
app.config.maxQueryResult=app.config.maxQueryResult||20;options.limit=options.limit||app.config.maxQueryResult;options=app.data.parseOptionsForSync(method,model,options);callbacks=app.data.getSyncCallbacks(method,model,options);this.trigger('data:sync:start',method,model,options);url=app.api.buildURL('pmse_Inbox','unattendedCases',null,options.params);app.api.call('read',url,null,callbacks);},search:function(modules,term){this.collection.fetch({query:term,module_list:modules,offset:0,update:false});}})