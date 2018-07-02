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
({className:'subpanel-header',attributes:{'data-sortable-subpanel':'true'},events:{'click':'togglePanel','click a[name=create_button]:not(".disabled")':'createRelatedClicked'},plugins:['LinkedModel','Tooltip'],initialize:function(options){options.meta=_.extend({},app.metadata.getView(null,'panel-top'),app.metadata.getView(options.module,'panel-top'),options.meta);this._super('initialize',[options]);this.parentModule=this.context.parent.get('module');this.on('linked-model:create',function(){this.context.set('skipFetch',false);this.context.reloadData();},this);},createRelatedClicked:function(event){this.createRelatedRecord(this.module);},togglePanel:function(evt){if(_.isNull(this.$el)){return;}
var $target=this.$(evt.target),isLink=$target.closest('a, button').length;if(isLink){return;}
this.context.set('collapsed',!this.context.get('collapsed'));}})