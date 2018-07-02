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
(function(app){app.events.on('app:init',function(){app.utils=_.extend(app.utils,{'FilterOptions':Backbone.Model.extend({initialize:function(options){this._filterPopulateNames=[];this._filterRelate=null;},setFilterRelate:function(value){if(!_.isObject(value)||_.isEmpty(value)){return this;}
this._filterRelate=value;this.set('stickiness',false);return this;},setFilterPopulate:function(value){if(!_.isObject(value)||_.isEmpty(value)){return this;}
this.set('filter_populate',value);this.set('stickiness',false);return this;},setInitialFilter:function(id){this.set('initial_filter',id);return this;},setInitialFilterLabel:function(name){this.set('initial_filter_label',name);return this;},setLangModules:function(modules){if(!_.isArray(modules)){return;}
this.set('initial_filter_lang_modules',modules);},relateInitialFilterLabel:function(){this.set('initial_filter_label',this._filterPopulateNames.join(', '));return this;},config:function(options){options=options||{};this.setInitialFilter(options.initial_filter);this.setInitialFilterLabel(options.initial_filter_label);this.setFilterPopulate(options.filter_populate);this.setFilterRelate(options.filter_relate);return this;},populateRelate:function(relateModel){if(_.isEmpty(this._filterRelate)){return this;}
var filterPopulate=this.get('filter_populate')||{};_.each(this._filterRelate,function(toField,fromField){filterPopulate[toField]={$in:[relateModel.get(fromField)]};var relateNameField=_.find(relateModel.fields,function(field){return field.id_name===fromField;});if(relateNameField){this._filterPopulateNames.push(relateModel.get(relateNameField.name));}},this);this.set('filter_populate',filterPopulate);if(!this.get('initial_filter_label')){this.relateInitialFilterLabel();}
return this;},format:function(){if(!this.get('initial_filter')||!this.get('filter_populate')){return;}
return this.toJSON();}})});});})(SUGAR.App);