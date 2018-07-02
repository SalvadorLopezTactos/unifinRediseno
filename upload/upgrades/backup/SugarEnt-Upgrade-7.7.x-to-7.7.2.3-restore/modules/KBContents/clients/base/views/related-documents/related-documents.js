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
({plugins:['Dashlet'],events:{'click [data-action=show-more]':'loadMoreData'},_defaultSettings:{limit:5},collection:null,initDashlet:function(){this._initSettings();this._initCollection();},_initSettings:function(){this.settings.set(_.extend({},this._defaultSettings,this.settings.attributes));return this;},_initCollection:function(){this.collection=app.data.createBeanCollection(this.module);this.collection.options={limit:this.settings.get('limit'),fields:['id','name','date_entered','created_by','created_by_name']};this.collection.sync=_.wrap(this.collection.sync,_.bind(function(sync,method,model,options){options=options||{};var viewModelId=this.model.get('id')||this.context.get('model').get('id')||this.context.parent.get('model').get('id');options.endpoint=function(method,model,options,callbacks){var url=app.api.buildURL(model.module,'related_documents',{id:viewModelId},options.params);return app.api.call('read',url,{},callbacks);};sync(method,model,options);},this));this.context.set('collection',this.collection);return this;},bindDataChange:function(){if(this.collection){this.collection.on('add remove reset',this.render,this);}},loadMoreData:function(){if(this.collection.next_offset>0){this.collection.paginate({add:true});}},loadData:function(options){options=options||{};if(this.collection.dataFetched){return;}
this.collection.fetch(options);}})