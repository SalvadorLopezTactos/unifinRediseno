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
({events:{'click .actionLink[data-event="true"]':'_handleActionLink'},plugins:['LinkedModel'],initialize:function(options){this._super('initialize',[options]);app.events.on('create:model:changed',this.createModelChanged,this);this.on('linked-model:create',this._prepareCtxForReload,this);},_prepareCtxForReload:function(){this.context.resetLoadFlag();this.context.set('skipFetch',false);},createHasChanges:false,createModelChanged:function(hasChanged){this.createHasChanges=hasChanged;},_handleActionLink:function(evt){var $actionLink=$(evt.currentTarget),module=$actionLink.data('module'),moduleMeta=app.metadata.getModule(this.context.get('module'));this.actionLayout=$actionLink.data('layout');if(this.createHasChanges){app.alert.show('send_confirmation',{level:'confirmation',messages:'LBL_WARN_UNSAVED_CHANGES',onConfirm:_.bind(function(){app.drawer.reset(false);this.createRelatedRecord(module);},this)});}else{this.createRelatedRecord(module);}},routeToBwcCreate:function(module){var context=this.getRelatedContext(module);if(context){app.bwc.createRelatedRecord(module,this.context.get('model'),context.link);}else{var route=app.bwc.buildRoute(module,null,'EditView');app.router.navigate(route,{trigger:true});}},getRelatedContext:function(module){var meta=app.metadata.getModule(module),context;if(meta&&meta.menu.quickcreate.meta.related){var parentModel=this.context.get('model');if(parentModel.isNew()){return;}
context=_.find(meta.menu.quickcreate.meta.related,function(metadata){return metadata.module===parentModel.module;});}
return context;},openCreateDrawer:function(module){var relatedContext=this.getRelatedContext(module),model=null;if(relatedContext){model=this.createLinkModel(this.context.get('model'),relatedContext.link);}
app.drawer.open({layout:this.actionLayout||'create',context:{create:true,module:module,model:model}},_.bind(function(refresh,model){if(refresh){if(model&&!model.id){app.router.refresh();return;}
if(model&&relatedContext){this.context.trigger('panel-top:refresh',relatedContext.link);return;}
this._loadContext(app.controller.context,module);if(app.controller.context.children){_.each(app.controller.context.children,function(context){this._loadContext(context,module);},this);}}},this));},_loadContext:function(context,module){var collection=context.get('collection');if(collection&&collection.module===module){var options={showAlerts:false};context.resetLoadFlag(false);context.set('skipFetch',false);context.loadData(options);}}})