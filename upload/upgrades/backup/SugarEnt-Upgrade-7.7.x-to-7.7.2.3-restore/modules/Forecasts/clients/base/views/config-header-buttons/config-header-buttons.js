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
({extendsFrom:'ConfigHeaderButtonsView',_beforeSaveConfig:function(){var ctxModel=this.context.get('model');ctxModel.set({is_setup:true,show_forecasts_commit_warnings:true});if(ctxModel.get('forecast_ranges')=='show_custom_buckets'){var ranges=ctxModel.get('show_custom_buckets_ranges'),labels=ctxModel.get('show_custom_buckets_options'),commitStages=[],finalLabels=[];ctxModel.unset('commit_stages_included');_.each(ranges,function(range,key){if(range.in_included_total){commitStages.push(key)}
delete range.in_included_total;finalLabels.push([key,labels[key]]);},this);ctxModel.set({commit_stages_included:commitStages,show_custom_buckets_ranges:ranges,show_custom_buckets_options:finalLabels},{silent:true});}},cancelConfig:function(){if(app.metadata.getModule('Forecasts','config').is_setup){return this._super('cancelConfig');}
if(this.triggerBefore('cancel')){if(app.drawer.count()){app.drawer.close(this.context,this.context.get('model'));}
app.router.navigate('#Administration',{trigger:true});}},_saveConfig:function(){this.context.get('model').save({},{success:_.bind(function(model){if(app.drawer.count()){this.showSavedConfirmation();app.drawer.close(this.context,this.context.get('model'));Backbone.history.loadUrl(app.api.buildURL(this.module));}},this),error:_.bind(function(){this.getField('save_button').setDisabled(false);},this)});}})