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
({plugins:['Dashlet'],events:{"click [data-action=show-more]":"loadMoreData"},collection:null,refresh:null,initialize:function(options){var self=this;options.module='KBContents';this._super('initialize',[options]);this.refresh=_.bind(this.loadData,this);if(_.isUndefined(this.meta.config)||this.meta.config===false){this.listenTo(this.context.parent.get('collection'),'sync',function(){if(self.collection){self.collection.dataFetched=false;self.layout.reloadDashlet(options);}});}
this._initCollection();this.listenTo(app.controller.context.get('model'),'change:useful',this.refresh);this.listenTo(app.controller.context.get('model'),'change:notuseful',this.refresh);},_initCollection:function(){this.collection=app.data.createBeanCollection(this.module);this.collection.setOption({params:{order_by:'useful:desc,notuseful:asc,viewcount:desc,date_entered:desc',mostUseful:true},limit:3,fields:['id','name','date_entered','created_by','created_by_name'],filter:{'active_rev':{'$equals':1},'useful':{'$gt':{'$field':'notuseful'}},'status':{'$equals':'published'}}});return this;},bindDataChange:function(){if(this.collection){this.collection.on('add remove reset',function(){if(this.disposed){return;}
this.render();},this);}},loadMoreData:function(){if(this.collection.next_offset>0){this.collection.paginate({add:true});}},loadData:function(options){this.collection.resetPagination();this.collection.fetch({success:function(){if(options&&options.complete){options.complete();}},error:_.bind(function(error){if(error.code==='not_authorized'){this.$el.find('.block-footer').html(app.lang.get('LBL_NO_DATA_AVAILABLE',this.module));}},this)});},dispose:function(){this.stopListening(app.controller.context.get('model'),'change:useful',this.refresh);this.stopListening(app.controller.context.get('model'),'change:notuseful',this.refresh);this._super('dispose');}})