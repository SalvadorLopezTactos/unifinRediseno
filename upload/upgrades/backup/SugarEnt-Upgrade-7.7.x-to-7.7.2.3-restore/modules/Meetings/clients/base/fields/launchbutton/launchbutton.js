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
({extendsFrom:'RowactionField',initialize:function(options){this._super('initialize',[options]);this.type='rowaction';this.isHost=(this.def.host===true);},_render:function(){if(this.model.get('status')!=='Planned'||this.model.get('type')==='Sugar'||(this.isHost&&!this._hasPermissionToStartMeeting())){this.hide();}else{this._setLabel();this._super('_render');this.show();}},_hasPermissionToStartMeeting:function(){return(this.model.get('assigned_user_id')===app.user.id||app.acl.hasAccess('admin','Meetings'));},_setLabel:function(){this.label=(this.isHost)?this._getLabel('LBL_START_MEETING'):this._getLabel('LBL_JOIN_MEETING');},_getLabel:function(labelName){var meetingTypeStrings=app.lang.getAppListStrings('eapm_list'),meetingType=meetingTypeStrings[this.model.get('type')]||app.lang.get('LBL_MODULE_NAME_SINGULAR',this.module);return app.lang.get(labelName,this.module,{'meetingType':meetingType});},rowActionSelect:function(){var url=app.api.buildURL('Meetings','external',{id:this.model.id});app.api.call('read',url,null,{success:_.bind(this._launchMeeting,this),error:function(){app.alert.show('launch_meeting_error',{level:'error',messages:app.lang.get('LBL_ERROR_LAUNCH_MEETING_GENERAL',this.module)});}});},_launchMeeting:function(externalInfo){var launchUrl='';if(this.disposed){return;}
if(this.isHost&&externalInfo.is_host_option_allowed){launchUrl=externalInfo.host_url;}else if(!this.isHost&&externalInfo.is_join_option_allowed){launchUrl=externalInfo.join_url;}else{app.alert.show('launch_meeting_error',{level:'error',messages:app.lang.get(this.isHost?'LBL_EXTNOSTART_MAIN':'LBL_EXTNOT_MAIN',this.module)});return;}
if(!_.isEmpty(launchUrl)){window.open(launchUrl);}else{app.alert.show('launch_meeting_error',{level:'error',messages:this._getLabel('LBL_EXTERNAL_MEETING_NO_URL')});}},bindDataChange:function(){if(this.model){this.model.on('change',this.render,this);}}})