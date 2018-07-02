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
({extendsFrom:'EnumField',initialize:function(opts){this._super('initialize',[opts]);if(this.model.isNew()&&this.view.action==='detail'){this.def.readonly=false;}else{this.def.readonly=true;}},loadEnumOptions:function(fetch,callback){var module=this.def.module||this.module,optKey=this.def.key||this.name,config=app.metadata.getModule(module,'config')||{};this._setItems(config[optKey]);fetch=fetch||false;if(fetch||!this.items){var url=app.api.buildURL(module,'config',null,{});app.api.call('read',url,null,{success:_.bind(function(data){this._setItems(data[optKey]);callback.call(this);},this)});}},_loadTemplate:function(){this.type='enum';this._super('_loadTemplate');this.type=this.def.type;},_setItems:function(values){var result={},def=null;_.each(values,function(val){var tmp=_.omit(val,'primary');_.extend(result,tmp);if(val.primary){def=_.first(_.keys(tmp));}});this.items=result;if(def&&_.isUndefined(this.model.get(this.name))){this.defaultOnUndefined=false;this.model.set(this.name,def,{silent:true});if(_.isFunction(this.model.setDefault)){this.model.setDefault(this.name,def);}}},setMode:function(mode){if(mode=='edit'){if(this.model.has('id')){this.setDisabled(true);}else if(this.model.has('related_languages')){if(this.model.has('kbarticle_id')){this.setDisabled(true);}else{_.each(this.model.get('related_languages'),function(lang){delete this.items[lang];},this);this.model.set(this.name,_.first(_.keys(this.items)),{silent:true});}}}
this._super('setMode',[mode]);}})