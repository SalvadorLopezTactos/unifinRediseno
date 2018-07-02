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
({'events':{'click button':'copyOnce'},_initialValues:null,_fields:null,_inSync:false,initialize:function(options){this._super('initialize',[options]);this._initialValues={};this._fields={};if(_.isUndefined(this.def.sync)){this.def.sync=true;}
this.before('render',function(){this.setDisabled(!this.hasAccess());return true;},this);},toggle:function(){this.sync(this.$fieldTag.is(':checked'));},sync:function(enable){enable=this.hasAccess()&&(_.isUndefined(enable)||enable);if(this._inSync===enable){return;}
this._inSync=enable;if(!enable){this.syncCopy(false);this.restore();return;}
_.each(this.def.mapping,function(target,source){this.copy(source,target);var field=this.getField(target);if(!_.isUndefined(field)){field.setDisabled(true);}},this);this.syncCopy(true);},copyOnce:function(evt){_.each(this.def.mapping,function(target,source){this.copy(source,target);},this);},copy:function(from,to){if(!this.model.has(from)){return;}
if(_.isUndefined(this._initialValues[to])){this._initialValues[to]=this.model.get(to);}
if(app.acl.hasAccessToModel('edit',this.model,to)){this.model.set(to,this.model.get(from));}},restore:function(){_.each(this._initialValues,function(value,field){this.model.set(field,value);},this);_.each(this.def.mapping,function(target,source){var field=this.getField(target);if(!_.isUndefined(field)){field.setDisabled(false);}},this);this._initialValues={};},syncCopy:function(enable){if(!this.def.sync){return;}
if(!enable){this.model.off(null,this.copyChanged);return;}
var events=_.map(_.keys(this.def.mapping),function(field){return'change:'+field;});this.model.on(events.join(' '),this.copyChanged,this);},copyChanged:function(model,value){_.each(model.changedAttributes(),function(newValue,field){model.set(this.def.mapping[field],model.get(field));},this);},getField:function(name){if(_.isUndefined(this._fields[name])){this._fields[name]=_.find(this.view.fields,function(field){return field.name==name;});}
return this._fields[name];},unformat:function(value){return null;},format:function(value){if(_.isNull(value)){return this._inSync;}
return value;},bindDomChange:function(){if(!(this.model instanceof Backbone.Model))return;var self=this;var el=this.$fieldTag=this.$el.find(this.fieldTag);el.on("change",function(){self.toggle();});},bindDataChange:function(){if(this.model&&this.def.sync){var active=!_.isUndefined(this.def['default'])?this.def['default']:true;if(!active&&this.model.isNew()){return;}
var inSync=this.model.isNew()||_.all(this.def.mapping,function(target,source){return this.model.has(source)&&this.model.get(source)===this.model.get(target);},this);this.sync(inSync);}},hasAccess:function(){return _.some(this.def.mapping||[],function(toField,fromField){return app.acl.hasAccessToModel('read',this.model,fromField)&&app.acl.hasAccessToModel('edit',this.model,toField);},this);}})