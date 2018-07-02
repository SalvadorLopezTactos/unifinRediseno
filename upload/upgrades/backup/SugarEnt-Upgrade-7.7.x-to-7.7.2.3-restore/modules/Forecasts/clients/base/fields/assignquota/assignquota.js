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
({extendsFrom:'RowactionField',disableButton:true,initialize:function(options){this._super('initialize',[options]);this.type='rowaction';},bindDataChange:function(){this.context.on('forecasts:worksheet:quota_changed',function(){this.disableButton=false;if(!this.disposed){this.render();}},this);this.context.on('forecasts:worksheet:committed',function(){this.disableButton=true;if(!this.disposed){this.render();}},this);this.context.on('forecasts:assign_quota',this.assignQuota,this);},_render:function(){this._super('_render');if(this.getFieldElement().length>0){this.setDisabled(this.disableButton);}},hasAccess:function(){var su=(this.context.get('selectedUser'))||app.user.toJSON(),isManager=su.is_manager||false,showOpps=su.showOpps||false;return(su.id===app.user.get('id')&&isManager&&showOpps===false);},assignQuota:function(worksheetType,selectedUser,selectedTimeperiod){app.api.call('create',app.api.buildURL('ForecastManagerWorksheets/assignQuota'),{'user_id':selectedUser.id,'timeperiod_id':selectedTimeperiod},{success:_.bind(function(o){app.alert.dismiss('saving_quota');app.alert.show('success',{level:'success',autoClose:true,autoCloseDelay:10000,title:app.lang.get("LBL_FORECASTS_WIZARD_SUCCESS_TITLE","Forecasts")+":",messages:[app.lang.get('LBL_QUOTA_ASSIGNED','Forecasts')]});this.disableButton=true;this.context.trigger('forecasts:quota_assigned');if(!this.disposed){this.render();}},this)});}})