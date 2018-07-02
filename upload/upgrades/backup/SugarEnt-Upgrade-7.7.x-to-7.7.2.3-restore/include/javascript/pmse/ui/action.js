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
var Action=function(options){Base.call(this,options);this.text=null;this.disabled=null;this.hidden=null;this.handler=null;this.cssStyle=null;this.toolTip=null;this.selected=null;this.related=null;Action.prototype.initObject.call(this,options);};Action.prototype=new Base();Action.prototype.type="Action";Action.prototype.family="Action";Action.prototype.initObject=function(options){var defaults={text:null,cssStyle:null,disabled:false,hidden:false,selected:false,handler:function(){},related:null};$.extend(true,defaults,options);this.setText(defaults.text).setCssClass(defaults.cssStyle).setToolTip(defaults.toolTip).setSelected(defaults.selected).setDisabled(defaults.disabled).setHidden(defaults.hidden).setHandler(defaults.handler).setRelated(defaults.related);};Action.prototype.setText=function(text){this.text=text;return this;};Action.prototype.setHandler=function(fn){if(_.isFunction(fn)){this.handler=fn;}
return this;};Action.prototype.setCssClass=function(css){this.cssStyle=css;return this;};Action.prototype.setToolTip=function(tooltip){this.toolTip=tooltip;return this;}
Action.prototype.setSelected=function(selected){this.selected=selected;return this;}
Action.prototype.setDisabled=function(value){if(_.isBoolean(value)){this.disabled=value;if(this.related){if(_.isFunction(this.related.paint)){this.related.paint();}}}
return this;};Action.prototype.setHidden=function(value){if(_.isBoolean(value)){this.hidden=value;if(this.related){if(_.isFunction(this.related.paint)){this.related.paint();}}}
return this;};Action.prototype.setRelated=function(relation){this.related=relation;return this;};Action.prototype.enable=function(){this.setDisabled(false);};Action.prototype.disable=function(){this.setDisabled(true);};Action.prototype.hide=function(){this.setHidden(true);};Action.prototype.show=function(){this.setHidden(false);};Action.prototype.isEnabled=function(){return!this.disabled;};Action.prototype.isHidden=function(){return this.hidden;};Action.prototype.isAction=true;