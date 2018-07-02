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
({plugins:['ErrorDecoration'],events:{'click [name=cancel_button]':'cancel','click [name=forgotPassword_button]':'forgotPassword','change select[name=country]':'render'},_declareModel:function(meta){meta=meta||{};var fields={};_.each(_.flatten(_.pluck(meta.panels,"fields")),function(field){fields[field.name]=field;});app.data.declareModel('Forgotpassword',{fields:fields});},initialize:function(options){this._declareModel(options.meta);options.context.prepare(true);app.view.View.prototype.initialize.call(this,options);this._showResult=false;},_render:function(){if(!(app.config&&app.config.forgotpasswordON===true)){return;}
this.logoUrl=app.metadata.getLogoUrl();app.view.View.prototype._render.call(this);return this;},cancel:function(){app.router.goBack();},forgotPassword:function(){var self=this;self.model.doValidate(null,function(isValid){if(isValid){if(app.config.honeypot_on&&app.config.honeypot_on===true&&(self.$('input[name="first_name"]').val()||self.model.get('first_name')))return;app.$contentEl.hide();app.alert.show('forgotPassword',{level:'process',title:app.lang.get('LBL_LOADING'),autoClose:false});var emails=self.model.get('email');var params={username:self.model.get('username')};if(emails&&emails[0]&&emails[0].email_address){params.email=emails[0].email_address;}
var url=app.api.buildURL('password/request','',{},params);app.api.call('READ',url,{},{success:function(response){self._showSuccess=true;self._showResult=true;self.resultLabel="LBL_PASSWORD_REQUEST_SENT";self.model.clear();if(!self.disposed){self.render();}},error:function(err){self._showSuccess=false;self._showResult=true;self.resultLabel=err.message||'LBL_PASSWORD_REQUEST_ERROR';if(!self.disposed){self.render();}},complete:function(){app.alert.dismiss('forgotPassword');app.$contentEl.show();}})}},self);},_backButton:[{name:'cancel_button',type:'button',label:'LBL_BACK',value:'forgotPassword',primary:false}]})