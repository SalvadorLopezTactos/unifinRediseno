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
({extendsFrom:'MultiSelectionListView',initialize:function(options){this._super('initialize',[options]);this.meta.selection=_.extend({},options.meta.selection,{isLinkAction:true});},initializeEvents:function(){this.context.on('selection-list:link:multi',this._selectMultipleAndClose,this);this.context.on('selection-list:select',this._refreshList,this);},_refreshList:function(){this.context.reloadData({recursive:false,error:function(error){app.alert.show('server-error',{level:'error',messages:'ERR_GENERIC_SERVER_ERROR'});}});},_selectMultipleAndClose:function(){var selections=this.context.get('mass_collection');if(selections&&selections.length>0){this.layout.once('list:masslink:complete',this._closeDrawer,this);this.layout.trigger('list:masslink:fire');}},_closeDrawer:function(model,data,response){app.drawer.close();var context=this.context.get('recContext');var view=this.context.get('recView');if(context.has('parentModel')){var parentModel=context.get('parentModel');var syncedAttributes=parentModel.getSynced();var updatedAttributes=_.reduce(data.record,function(memo,val,key){if(!_.isEqual(syncedAttributes[key],val)){memo[key]=val;}
return memo;},{});parentModel.set(updatedAttributes);parentModel.setSyncedAttributes(data.record);}
context.set('skipFetch',false);context.reloadData();}})