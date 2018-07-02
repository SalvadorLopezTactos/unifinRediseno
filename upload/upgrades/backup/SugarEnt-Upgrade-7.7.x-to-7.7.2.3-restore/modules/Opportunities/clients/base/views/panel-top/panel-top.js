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
({extendsFrom:"PanelTopView",initialize:function(options){this._super('initialize',[options]);this.on('linked-model:create',this._reloadRevenueLineItems,this);},_reloadRevenueLineItems:function(){if(app.metadata.getModule('Opportunities','config').opps_view_by=='RevenueLineItems'){var $rliSubpanel=$('div[data-subpanel-link="revenuelineitems"]');if(!$('li.subpanel',$rliSubpanel).hasClass('closed')){this.context.parent.trigger('subpanel:reload',{links:['revenuelineitems']});}else{var rliComponent=_.find(this.layout.layout._components,function(component){return component.module==='RevenueLineItems';});var cc_field=rliComponent.getComponent('panel-top').getField('collection-count');app.api.count('Accounts',{id:this.context.parent.get('modelId'),link:'revenuelineitems'},{success:function(data){cc_field.updateCount({length:data.record_count});}});}}}})