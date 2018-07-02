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
({extendsFrom:'StickyRowactionField',events:{'click a[name=select_button]':'openSelectDrawer'},openSelectDrawer:function(){if(this.isDisabled()){return;}
app.drawer.open(this.getDrawerOptions(),_.bind(this.selectDrawerCallback,this));},getDrawerOptions:function(){var parentModel=this.context.get('parentModel');var linkModule=this.context.get('module');var link=this.context.get('link');var filterOptions=new app.utils.FilterOptions().config(this.def);filterOptions.setInitialFilter(this.def.initial_filter||'$relate');filterOptions.populateRelate(parentModel);return{layout:'multi-selection-list-link',context:{module:linkModule,recParentModel:parentModel,recLink:link,recContext:this.context,recView:this.view,independentMassCollection:true,filterOptions:filterOptions.format()}};},selectDrawerCallback:function(model){if(!model){return;}
var parentModel=this.context.get('parentModel');var link=this.context.get('link');var relatedModel=app.data.createRelatedBean(parentModel,model.id,link),options={showAlerts:true,relate:true,success:_.bind(function(model){this.context.get('collection').resetPagination();this.context.set('collapsed',false);},this),error:function(error){app.alert.show('server-error',{level:'error',messages:'ERR_GENERIC_SERVER_ERROR'});}};relatedModel.save(null,options);},isDisabled:function(){if(this._super('isDisabled')){return true;}
var link=this.context.get('link'),parentModule=this.context.get('parentModule'),required=app.utils.isRequiredLink(parentModule,link);return required;}})