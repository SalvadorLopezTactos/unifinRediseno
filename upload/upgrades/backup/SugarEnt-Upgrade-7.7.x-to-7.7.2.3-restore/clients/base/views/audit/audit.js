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
({extendsFrom:'FilteredListView',fallbackFieldTemplate:'list-header',initialize:function(options){this.action='list';if(options.context.parent){this.baseModule=options.context.parent.get('module');this.baseRecord=options.context.parent.get('modelId');}
this._super('initialize',[options]);if(!this.collection){this._initCollection();}},_initCollection:function(){var AuditCollection=app.BeanCollection.extend({module:'audit',baseModule:this.baseModule,baseRecordId:this.baseRecord,buildURL:function(params){params=params||{};var parts=[],url;parts.push(app.api.serverUrl);parts.push(this.baseModule);parts.push(this.baseRecordId);parts.push(this.module);url=parts.join('/');params=$.param(params);if(params.length>0){url+='?'+params;}
return url;},sync:function(method,model,options){var url=this.buildURL(options.params),callbacks=app.data.getSyncCallbacks(method,model,options);app.api.call(method,url,options.attributes,callbacks);}});this.collection=new AuditCollection();},loadData:function(){if(this.collection.dataFetched){return;}
this.collection.fetch();},_renderData:function(){var parentModule=this.context.parent.get('module');var fields=app.metadata.getModule(parentModule).fields;_.each(this.collection.models,function(model){model.fields=app.utils.deepCopy(this.metaFields);var before=_.findWhere(model.fields,{name:'before'});_.extend(before,fields[model.get('field_name')],{name:'before'});var after=_.findWhere(model.fields,{name:'after'});_.extend(after,fields[model.get('field_name')],{name:'after'});if(_.contains(['multienum','enum'],before['type'])&&before['function']){before['type']='base';after['type']='base';}
model.fields=app.metadata._patchFields(this.module,app.metadata.getModule(this.module),model.fields);},this);this._super('_renderData');}})