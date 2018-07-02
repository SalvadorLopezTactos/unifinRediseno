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
({events:{'click a[name="cancel_button"]':'cancelConfig','click a[name="save_button"]:not(.disabled)':'saveConfig'},moduleLangObj:undefined,initialize:function(options){this._super('initialize',[options]);Object.defineProperty(this,'currentModule',{get:function(){app.logger.warn('ConfigHeaderButtonsView\'s `currentModule` property is deprecated since 7.7.0 and will be removed in 7.8.0. '+'Please use `module` instead.');return this.module;}});this.moduleLangObj={module:app.lang.getModuleName(this.module,{plural:true})};var model=this.context.get('model');model.url=app.api.buildURL(this.module,'config');model.sync=function(method,model,options){this.trigger('data:sync:start',method,model,options);var url=_.isFunction(model.url)?model.url():model.url;return app.api.call(method,url,model,options);};model.fetch=function(options){options=options?_.clone(options):{};if(options.parse===void 0)options.parse=true;var model=this,success=options.success;options.success=function(resp){if(!model.set(model.parse(resp,options),options)){return false;}
if(success){success(model,resp,options);}
model.trigger('sync',model,resp,options);};var error=options.error;options.error=function(resp){if(error){error(model,resp,options);}
model.trigger('error',model,resp,options);};return this.sync('read',this,options);};model.save=function(key,val,options){var attrs,method,xhr,attributes=this.attributes;if(key==null||typeof key==='object'){attrs=key;options=val;}else{(attrs={})[key]=val;}
if(attrs&&(!options||!options.wait)&&!this.set(attrs,options)){return false;}
options=_.extend({validate:true},options);if(!this._validate(attrs,options)){return false;}
if(attrs&&options.wait){this.attributes=_.extend({},attributes,attrs);}
if(options.parse===void 0)options.parse=true;var model=this,success=options.success;options.success=function(resp){model.attributes=attributes;var serverAttrs=model.parse(resp,options);if(options.wait){serverAttrs=_.extend(attrs||{},serverAttrs);}
if(_.isObject(serverAttrs)&&!model.set(serverAttrs,options)){return false;}
if(success){success(model,resp,options);}
model.trigger('sync',model,resp,options);};method=this.isNew()?'create':(options.patch?'patch':'update');if(method==='patch'){options.attrs=attrs;}
xhr=this.sync(method,this,options);if(attrs&&options.wait){this.attributes=attributes;}
return xhr;};this.context.set({model:model});this.before('save',this._beforeSaveConfig,this);this.before('cancel',this._beforeCancelConfig,this);},saveConfig:function(){if(this.triggerBefore('save')){this.getField('save_button').setDisabled(true);this._saveConfig();}},_saveConfig:function(){this.context.get('model').save({},{success:_.bind(function(model){if(app.drawer.count()){this.showSavedConfirmation();app.drawer.close(this.context,this.context.get('model'));}},this),error:_.bind(function(){this.getField('save_button').setDisabled(false);},this)});},_beforeSaveConfig:function(){return true;},showSavedConfirmation:function(onClose){onClose=onClose||function(){};var alert=app.alert.show('module_config_success',{level:'success',title:app.lang.get('LBL_CONFIG_TITLE_MODULE_SETTINGS',this.module,this.moduleLangObj)+':',messages:app.lang.get('LBL_CONFIG_MODULE_SETTINGS_SAVED',this.module,this.moduleLangObj),autoClose:true,autoCloseDelay:10000,onAutoClose:_.bind(function(){alert.getCloseSelector().off();onClose();})});var $close=alert.getCloseSelector();$close.on('click',onClose);app.accessibility.run($close,'click');},cancelConfig:function(){if(this.triggerBefore('cancel')){if(app.drawer.count()){app.drawer.close(this.context,this.context.get('model'));}else{app.router.navigate(this.module,{trigger:true});}}},_beforeCancelConfig:function(){return true;}})