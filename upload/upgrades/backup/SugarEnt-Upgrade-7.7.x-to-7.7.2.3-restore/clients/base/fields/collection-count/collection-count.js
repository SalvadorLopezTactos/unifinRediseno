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
({plugins:['Tooltip'],events:{'click [data-action="count"]':'fetchCount'},fetchCount:function(){if(_.isNull(this.collection.total)){app.alert.show('fetch_count',{level:'process',title:app.lang.get('LBL_LOADING'),autoClose:false});}
this.collection.fetchTotal({success:_.bind(function(){if(!this.disposed){this.updateCount();}},this),complete:function(){app.alert.dismiss('fetch_count');}});},updateCount:function(options){this._setCountLabel(options);this.render();},_setCountLabel:function(options){options=options||{};var length=this.collection.length;var fullyFetched=this.collection.next_offset<=0;length=!_.isUndefined(options.length)?options.length:length;fullyFetched=!_.isUndefined(options.hasMore)?!options.hasMore:fullyFetched;if(!length&&!this.collection.dataFetched){return this.countLabel='';}
var tplKey='TPL_LIST_HEADER_COUNT_TOTAL';var context={num:length};if(fullyFetched){tplKey='TPL_LIST_HEADER_COUNT';}else if(!_.isNull(this.collection.total)){context.total=this.collection.total;}else{var tooltipLabel=app.lang.get('TPL_LIST_HEADER_COUNT_TOOLTIP',this.module);context.total=new Handlebars.SafeString('<a data-action="count" rel="tooltip" data-placement="right" title="'+tooltipLabel+'">'+
Handlebars.Utils.escapeExpression(app.lang.get('TPL_LIST_HEADER_COUNT_PARTIAL',this.module,{num:context.num+1}))+'</a>');}
return this.countLabel=new Handlebars.SafeString(app.lang.get(tplKey,this.module,context));},bindDataChange:function(){if(!this.collection){return;}
this.listenTo(this.collection,'remove reset',function(){if(!this.disposed){this.updateCount();}});this.listenTo(this.context,'paginate',function(){if(!this.disposed){this.fetchCount();}});this.listenTo(this.context,'refresh:count',function(hasAmount,properties){if(!this.disposed){this.updateCount(properties);}});}})