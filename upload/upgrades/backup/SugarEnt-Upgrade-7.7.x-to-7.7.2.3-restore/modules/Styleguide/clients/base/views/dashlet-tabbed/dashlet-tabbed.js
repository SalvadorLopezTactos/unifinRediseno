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
({extendsFrom:'TabbedDashletView',_defaultSettings:{limit:10,visibility:'user'},initialize:function(options){options.meta=options.meta||{};options.meta.template='tabbed-dashlet';this._super('initialize',[options]);},_initTabs:function(){this._super("_initTabs");var today=new Date();today.setHours(23,59,59);today.toISOString();_.each(_.pluck(_.pluck(this.tabs,'filters'),'date_due'),function(filter){_.each(filter,function(value,operator){if(value==='today'){filter[operator]=today;}});});},_renderHtml:function(){if(this.meta.config){this._super('_renderHtml');return;}
var tab=this.tabs[this.settings.get('activeTab')];if(tab.overdue_badge){this.overdueBadge=tab.overdue_badge;}
var model1=app.data.createBean('Tasks');model1.set("assigned_user_id","seed_sally_id");model1.set("assigned_user_name","Sally Bronsen");model1.set("name","Programmatically added task");model1.set("date_due","2014-02-07T07:15:00-05:00");model1.set("date_due_flag",false);model1.set("date_start",null);model1.set("date_start_flag",false);model1.set("status","Not Started");this.collection.add(model1);_.each(this.collection.models,function(model){var pictureUrl=app.api.buildFileURL({module:'Users',id:model.get('assigned_user_id'),field:'picture'});model.set('picture_url',pictureUrl);},this);this._super('_renderHtml');}})