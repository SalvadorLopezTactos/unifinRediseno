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
({extendsFrom:'TabbedDashletView',_defaultSettings:{limit:10,visibility:'user'},initialize:function(options){options.meta=options.meta||{};options.meta.template='tabbed-dashlet';this.plugins=_.union(this.plugins,['LinkedModel']);this.tbodyTag='ul[data-action="pagination-body"]';this._super('initialize',[options]);},_initEvents:function(){this._super('_initEvents');this.on('linked-model:create',this.loadData,this);return this;},createRecord:function(event,params){if(this.module!=='Home'){this.createRelatedRecord(params.module,params.link);}else{var self=this;app.drawer.open({layout:'create',context:{create:true,module:params.module}},function(context,model){if(!model){return;}
self.context.resetLoadFlag();self.context.set('skipFetch',false);if(_.isFunction(self.loadData)){self.loadData();}else{self.context.loadData();}});}},bindCollectionAdd:function(model){var pictureUrl=app.api.buildFileURL({module:'Users',id:model.get('assigned_user_id'),field:'picture'});model.set('picture_url',pictureUrl);this._super('bindCollectionAdd',[model]);}})