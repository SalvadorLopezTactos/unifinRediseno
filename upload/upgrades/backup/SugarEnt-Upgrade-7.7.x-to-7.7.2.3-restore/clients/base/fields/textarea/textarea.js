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
({fieldTag:'textarea',_defaultSettings:{max_display_chars:450,collapsed:true},collapsed:undefined,_settings:{},plugins:['EllipsisInline'],events:{'click [data-action=toggle]':'toggleCollapsed'},initialize:function(options){this._super('initialize',[options]);this._initSettings();this.collapsed=this._settings.collapsed;},_initSettings:function(){this._settings=_.extend({},this._defaultSettings,this.def&&this.def.settings||{});return this;},setMode:function(name){var isList=(this.tplName==='list')&&_.contains(['edit','disabled'],name),mode=isList&&this.view.name!=='merge-duplicates'?this.tplName:name;this._super('setMode',[mode]);},format:function(value){if(this.tplName!=='edit'){var max=this._settings.max_display_chars;value={long:value};if(value.long&&value.long.length>max){value.short=value.long.substr(0,max).trim();}}
return value;},toggleCollapsed:function(){this.collapsed=!this.collapsed;this.render();},unformat:function(value){return value;}})