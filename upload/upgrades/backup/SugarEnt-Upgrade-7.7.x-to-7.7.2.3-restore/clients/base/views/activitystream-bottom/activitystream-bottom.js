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
({events:{'click [data-action=show-more]':'paginate'},_loadTemplate:function(options){this.tplName='list-bottom';this.template=app.template.getView(this.tplName);},_renderHtml:function(){if((this.collection.next_offset===-1)&&(this.collection.length>0)){this.$el.addClass('hide');}else{this.dataFetched=this.collection.dataFetched;this.showMoreLabel=app.lang.get('TPL_SHOW_MORE_MODULE',this.module);this.showLoadMsg=true;this._super('_renderHtml');this.$el.removeClass('hide');}},bindDataChange:function(){this.collection.on('reset add',this.render,this);},paginate:function(){this.context.trigger('activitystream:paginate',true);}})