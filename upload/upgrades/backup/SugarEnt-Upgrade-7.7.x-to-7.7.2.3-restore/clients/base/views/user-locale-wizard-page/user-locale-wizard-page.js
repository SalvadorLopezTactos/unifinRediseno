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
({extendsFrom:"UserWizardPageView",TIME_ZONE_KEY:'timezone',TIME_PREF_KEY:'timepref',DATE_PREF_KEY:'datepref',NAME_FORMAT_KEY:'default_locale_name_format',initialize:function(options){var self=this;options.template=app.template.getView('wizard-page');this._super('initialize',[options]);if(this.model){this.model.set(this.TIME_ZONE_KEY,(app.user.getPreference(this.TIME_ZONE_KEY)||''));this.model.set(this.TIME_PREF_KEY,(app.user.getPreference(this.TIME_PREF_KEY)||''));this.model.set(this.DATE_PREF_KEY,(app.user.getPreference(this.DATE_PREF_KEY)||''));this.model.set(this.NAME_FORMAT_KEY,(app.user.getPreference(this.NAME_FORMAT_KEY)||''));}
this.action='edit';},_render:function(){var self=this;this._prepareFields(function(){if(!self.disposed){self.fieldsToValidate=self._fieldsToValidate(self.meta);self._super("_render");}});},_prepareFields:function(callback){var self=this;app.user.loadLocale(function(localeOptions){_.each(self.meta.panels[0].fields,function(fieldDef){var opts=localeOptions[fieldDef.name];if(opts){fieldDef.options=opts;}});callback();});},beforeNext:function(callback){this.getField("next_button").setDisabled(true);this.model.doValidate(this.fieldsToValidate,_.bind(function(isValid){var self=this;if(isValid){var payload=this._prepareRequestPayload();app.alert.show('wizardlocale',{level:'process',title:app.lang.get('LBL_LOADING'),autoClose:false});payload['ut']=true;app.user.updatePreferences(payload,function(err){app.alert.dismiss('wizardlocale');self.updateButtons();if(err){app.logger.debug("Wizard locale update failed: "+err);callback(false);}else{callback(true);}});}else{callback(false);}},this));}})