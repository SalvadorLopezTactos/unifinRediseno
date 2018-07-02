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
({extendsFrom:'RowactionField',initialize:function(options){this._super('initialize',[options]);this.type='rowaction';},_render:function(){if(_.isEmpty(this.model.get('repeat_type'))){this.hide();}else{this._super('_render');}},bindDataChange:function(){if(this.model){this.model.on('change:repeat_type',this.render,this);}},rowActionSelect:function(){app.alert.show('delete_recurrence_confirmation',{title:app.lang.get('LBL_REMOVE_ALL_RECURRENCES',this.module),level:'confirmation',messages:this.getDeleteMessages().confirmation,onConfirm:_.bind(this.deleteRecurrences,this)});},deleteRecurrences:function(){this.model.destroy({params:{'all_recurrences':true},showAlerts:{'process':true,'success':{messages:this.getDeleteMessages().success}},success:_.bind(function(){var route='#'+this.module,currentRoute='#'+Backbone.history.getFragment();(currentRoute===route)?app.router.refresh():app.router.navigate(route,{trigger:true});},this)});},getDeleteMessages:function(){var messages={};var model=this.model;var name=app.utils.getRecordName(model);var context=app.lang.getModuleName(model.module).toLowerCase()+' '+name.trim();messages.confirmation=app.lang.get('LBL_CONFIRM_REMOVE_ALL_RECURRENCES',this.module);messages.success=app.utils.formatString(app.lang.get('NTC_DELETE_SUCCESS'),[context]);return messages;}})