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
({extendsFrom:'EnumField',initialize:function(options){this.plugins=_.clone(this.plugins)||[];this.plugins.push('ClickToEdit');this._super("initialize",[options]);},bindDataChange:function(){if(this.name==='sales_stage'){this.model.on('change:sales_stage',function(model,newValue){var salesStageWon=app.metadata.getModule('Forecasts','config').sales_stage_won;if(_.contains(salesStageWon,newValue)){this.context.trigger('forecasts:cteRemove:'+model.id)}},this);}
if(this.name==='commit_stage'){this.context.on('forecasts:cteRemove:'+this.model.id,function(){this.$el.removeClass('isEditable');var $divEl=this.$('div.clickToEdit');if($divEl.length){$divEl.removeClass('clickToEdit');}},this);}},_render:function(){this._super('_render');if(this.name==='commit_stage'&&this.$el.hasClass('disabled')){this.$el.addClass('list');}}})