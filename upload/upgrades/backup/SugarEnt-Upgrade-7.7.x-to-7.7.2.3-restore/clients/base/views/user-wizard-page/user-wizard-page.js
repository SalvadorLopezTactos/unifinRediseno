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
({extendsFrom:"WizardPageView",showPage:true,initialize:function(options){options.template=app.template.getView('wizard-page');this._super('initialize',[options]);this.fieldsToValidate=this._fieldsToValidate(options.meta);this.action='edit';},isPageComplete:function(){return this.areAllRequiredFieldsNonEmpty;},bindDataChange:function(){this._super('bindDataChange');this.listenTo(this.model,'sync',this.render);},_render:function(){if(!this.model.dataFetched){return this;}
this._super('_render');},_prepareRequestPayload:function(){var payload={},self=this,fields=_.keys(this.fieldsToValidate);_.each(fields,function(key){payload[key]=self.model.get(key);});return payload;},beforeNext:function(callback){var self=this;this.getField("next_button").setDisabled(true);this.model.doValidate(this.fieldsToValidate,_.bind(function(isValid){var self=this;if(isValid){var payload=self._prepareRequestPayload();app.alert.show('wizardprofile',{level:'process',title:app.lang.get('LBL_LOADING'),autoClose:false});app.user.updateProfile(payload,function(err){app.alert.dismiss('wizardprofile');self.updateButtons();if(err){app.logger.debug("Wizard profile update failed: "+err);callback(false);}else{callback(true);}});}else{callback(false);}},self));}})