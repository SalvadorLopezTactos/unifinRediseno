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
({extendsFrom:'ActivitystreamLayout',_previewOpened:false,initialize:function(options){this._super("initialize",[options]);app.events.on("preview:render",this.fetchActivities,this);app.events.on('preview:open',function(){this._previewOpened=true;},this);app.events.on('preview:close',function(){this._previewOpened=false;this.disposeAllActivities();},this);},fetchActivities:function(model,collection,fetch,previewId,showActivities){if(app.metadata.getModule(model.module).isBwcEnabled){return;}
this.disposeAllActivities();this.collection.dataFetched=false;this.$el.hide();showActivities=_.isUndefined(showActivities)?true:showActivities;if(showActivities){this.collection.reset();this.collection.resetPagination();this.collection.setOption('endpoint',function(method,collection,options,callbacks){var url=app.api.buildURL(model.module,null,{id:model.get('id'),link:'activities'},options.params);return app.api.call('read',url,null,callbacks);});this.collection.fetch({success:_.bind(this.renderActivities,this)});}},renderActivities:function(collection){var self=this;if(this.disposed){return;}
if(this._previewOpened){if(collection.length===0){this.$el.hide();}else{this.$el.show();collection.each(function(activity){self.renderPost(activity,true);});}}else{_.delay(function(){self.renderActivities(collection);},500);}},setCollectionOptions:function(){},exposeDataTransfer:function(){},loadData:function(){},bindDataChange:function(){this.collection.on('add',function(activity){if(!this.disposed){this.renderPost(activity,true);}},this);}})