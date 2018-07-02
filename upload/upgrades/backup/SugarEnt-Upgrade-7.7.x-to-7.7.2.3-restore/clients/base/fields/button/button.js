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
({tagName:"span",fieldTag:"a",plugins:['Tooltip','MetadataEventDriven'],initialize:function(options){var self=this;this.events=_.extend({},{'click *':'preventClick'},this.events,options.def.events);this._super('initialize',[options]);this.before("render",function(){if(self.hasAccess()){this._show();return true;}
else{this.hide();return false;}});},_render:function(){this.fullRoute=_.isString(this.def.route)?this.def.route:null;app.view.Field.prototype._render.call(this);},getFieldElement:function(){return this.$(this.fieldTag);},setDisabled:function(disable){disable=_.isUndefined(disable)?true:disable;this.def.css_class=this.def.css_class||'';var css_class=this.def.css_class.split(' ');if(disable){css_class.push('disabled');}else{css_class=_.without(css_class,'disabled');}
this.def.css_class=_.unique(_.compact(css_class)).join(' ');app.view.Field.prototype.setDisabled.call(this,disable);},preventClick:function(evt){if(this.isDisabled()||this.$(this.fieldTag).hasClass('disabled')){evt.preventDefault();evt.stopImmediatePropagation();return false;}},_show:function(){if(this.isHidden!==false){if(!this.triggerBefore("show")){return false;}
this.getFieldElement().removeClass("hide").show();this.isHidden=false;this.trigger('show');}},show:function(){if(this.hasAccess()){this._show();}else{this.isHidden=true;}},hide:function(){if(this.isHidden!==true){if(!this.triggerBefore("hide")){return false;}
this.getFieldElement().addClass("hide").hide();this.isHidden=true;this.trigger('hide');}},isVisible:function(){return!this.isHidden;},bindDomChange:function(){},bindDataChange:function(){},hasAccess:function(){var acl_module=this.def.acl_module,acl_action=this.def.acl_action;if(_.isBoolean(this.def.allow_bwc)&&!this.def.allow_bwc){var isBwc=app.metadata.getModule(acl_module||this.module).isBwcEnabled;if(isBwc){return false;}}
if(!acl_module){return app.acl.hasAccessToModel(acl_action,this.model,this);}else{return app.acl.hasAccess(acl_action,acl_module);}}})