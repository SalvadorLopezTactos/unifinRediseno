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
({events:{'click [data-action="show-more"]':'showMoreRecords'},initialize:function(options){this._super('initialize',[options]);this.action='list';this._showMoreLabel=this.meta&&this.meta.label||'TPL_SHOW_MORE_MODULE';this._initPagination();},_initPagination:function(){this.paginationComponent=_.find(this.layout._components,function(component){return _.contains(component.plugins,'Pagination');},this);},showMoreRecords:function(){if(!this.paginationComponent){return;}
var options={};options.success=_.bind(function(){this.layout.trigger('list:paginate:success');this.context.trigger('paginate');this.render();},this);this.paginationComponent.getNextPagination(options);this.render();},setShowMoreLabel:function(){var model=this.collection.at(0);var module=model?model.module:this.context.get('module');var context={count:this.collection.length,offset:this.collection.next_offset>=0};if(module){context.module=new Handlebars.SafeString(app.lang.getModuleName(module,{plural:true}).toLowerCase());}
this.showMoreLabel=app.lang.get(this._showMoreLabel,module,context);},onCollectionChange:function(){var prevCollection=this.context.previous('collection');if(prevCollection){prevCollection.off(null,null,this);}
this.collection=this.context.get('collection');this.collection.on('add remove reset',this.render,this);this.render();},_renderHtml:function(){this.setShowMoreLabel();this._super('_renderHtml');},bindDataChange:function(){this.context.on('change:collection',this.onCollectionChange,this);this.collection.on('add remove reset',this.render,this);},show:function(){this._super('show');if(!this.paginationComponent){return;}
this.paginationComponent.layout.$el.addClass('pagination');},hide:function(){this._super('hide');if(!this.paginationComponent){return;}
this.paginationComponent.layout.$el.removeClass('pagination');}})