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
({extendsFrom:'FlexListView',activityModules:[],allActivityModules:['Calls','Emails','Meetings','Notes','Tasks'],baseModule:'',baseRecord:'',initialize:function(options){this.plugins=_.union(this.plugins,['ReorderableColumns','ResizableColumns','ListColumnEllipsis']);if(options.context.parent){this.baseModule=options.context.parent.get('module');this.baseRecord=options.context.parent.get('modelId');}
this.setActivityModulesToFetch();var HistoryCollection=app.BeanCollection.extend({module:'history',activityModules:this.activityModules,buildURL:_.bind(function(params){params=params||{};var url=app.api.serverUrl+'/'
+this.baseModule+'/'
+this.baseRecord+'/'
+'link/history';params.module_list=this.activityModules.join(',');params=$.param(params);if(params.length>0){url+='?'+params;}
return url;},this),sync:function(method,model,options){options=app.data.parseOptionsForSync(method,model,options);if(options.params.fields){delete options.params.fields;}
var url=this.buildURL(options.params),callbacks=app.data.getSyncCallbacks(method,model,options);app.api.call(method,url,options.attributes,callbacks);}});options.collection=new HistoryCollection();this._super('initialize',[options]);this.template=app.template.getView(this.meta.template);this.context.set({collection:this.collection});$('html').addClass('print-drawer');},_initOrderBy:function(){var lastStateOrderBy=app.user.lastState.get(this.orderByLastStateKey)||{},lastOrderedFieldMeta=this.getFieldMeta(lastStateOrderBy.field);if(_.isEmpty(lastOrderedFieldMeta)||!lastOrderedFieldMeta.isSortable){lastStateOrderBy={};}
return _.extend({field:'',direction:'desc'},this.meta.orderBy,lastStateOrderBy);},setActivityModulesToFetch:function(){this.activityModules=this.allActivityModules;},loadData:function(options){if(this.collection.dataFetched){return;}
this.collection.fetch(options);},_renderField:function(field){var fieldName=field.name,fieldModule=field.model.get('_module'),fieldType=field.def.type||'default';if(fieldName==='name'){field.model.module=fieldModule;}else if(fieldName==='module'){field.model.set({module:field.model.get('moduleNameSingular')});}else if(fieldName==='related_contact'){var contact,contactId;field.model.module='Contacts';switch(fieldModule){case'Emails':contact='';contactId='';break;case'Notes':case'Calls':case'Meetings':case'Tasks':contact=field.model.get('contact_name');contactId=field.model.get('contact_id');break;}
field.model.set({related_contact:contact,related_contact_id:contactId});}else if(fieldName==='status'&&fieldModule==='Emails'){var fieldStatus=field.model.get('status'),emailStatusDom=app.lang.getAppListStrings('dom_email_status');if(!_.contains(emailStatusDom,fieldStatus)){fieldStatus=emailStatusDom[fieldStatus]}
field.model.set({status:fieldStatus});}
this._super('_renderField',[field]);},_render:function(){this._super('_render');this._sanitizeModels();},_sanitizeModels:function(){this.collection.map(function(model){model.module=model.get('_module');});},_setOrderBy:function(options){if(this.orderByLastStateKey){app.user.lastState.set(this.orderByLastStateKey,this.orderBy);}
options.orderBy=this.orderBy;this.collection.dataFetched=false;this.collection.skipFetch=false;this.loadData(options);},_dispose:function(){$('html').removeClass('print-drawer');this._super('_dispose');}})