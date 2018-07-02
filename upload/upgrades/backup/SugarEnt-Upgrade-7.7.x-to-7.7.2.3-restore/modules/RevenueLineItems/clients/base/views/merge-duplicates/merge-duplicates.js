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
({extendsFrom:'MergeDuplicatesView',_initSettings:function(){this._super('_initSettings');var config=app.metadata.getModule('Forecasts','config');if(!config||!config.is_setup){if(!_.contains(this.fieldNameBlacklist,'commit_stage')){this.fieldNameBlacklist.push('commit_stage');}}else if(_.contains(this.fieldNameBlacklist,'commit_stage')){this.fieldNameBlacklist.splice(_.indexOf(this.fieldNameBlacklist,'commit_stage'),1);}},bindDataChange:function(){this._super('bindDataChange');var config=app.metadata.getModule('Forecasts','config');if(config&&config.is_setup&&config.forecast_by==='RevenueLineItems'){this.collection.on('change:sales_stage change:commit_stage reset',function(model){var myModel=model;if(!_.isUndefined(model.models)){myModel=this.primaryRecord;}
var salesStage=myModel.get('sales_stage'),commit_stage=this.getField('commit_stage');if(salesStage){if(_.contains(config.sales_stage_won,salesStage)){if(config.commit_stages_included.length){myModel.set('commit_stage',_.first(config.commit_stages_included));}else{myModel.set('commit_stage','include');}
commit_stage.setDisabled(true);this.$('input[data-record-id="'+myModel.get('id')+'"][name="copy_commit_stage"]').prop("checked",true);}else if(_.contains(config.sales_stage_lost,salesStage)){myModel.set('commit_stage','exclude');commit_stage.setDisabled(true);this.$('input[data-record-id="'+myModel.get('id')+'"][name="copy_commit_stage"]').prop("checked",true);}else{commit_stage.setDisabled(false);}}},this);}}})