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
({extendsFrom:'ConfigPanelView',scenarioOptions:[],selectedOptions:[],defaultSelect2:undefined,optionsSelect2:undefined,defaultForecastedAmountKey:'show_worksheet_likely',initialize:function(options){this._super('initialize',[options]);this.selectedOptions=[];this.scenarioOptions=[];_.each(this.meta.panels[0].fields,function(field){var obj={id:field.name,text:app.lang.get(field.label,'Forecasts')}
if(field.name==this.defaultForecastedAmountKey){obj['locked']=true;}
this.scenarioOptions.push(obj);if(this.model.get(field.name)==1){this.selectedOptions.push(obj);}},this);},_updateTitleValues:function(){},bindDataChange:function(){this.model.on('change:scenarios',function(model){var arr=[];if(model.get('show_worksheet_likely')){arr.push(app.lang.get('LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_LIKELY','Forecasts'));}
if(model.get('show_worksheet_best')){arr.push(app.lang.get('LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_BEST','Forecasts'));}
if(model.get('show_worksheet_worst')){arr.push(app.lang.get('LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_WORST','Forecasts'));}
this.titleSelectedValues=arr.join(', ');this.updateTitle();},this);this.model.trigger('change:scenarios',this.model);},_render:function(){this._super('_render');this.$('.select2-container-disabled').width('auto');this.$('.select2-search-field').css('display','none');var isRTL=app.lang.direction==='rtl';this.optionsSelect2=this.$('#scenariosSelect').select2({data:this.scenarioOptions,multiple:true,width:"100%",containerCssClass:"select2-choices-pills-close",escapeMarkup:function(m){return m;},initSelection:_.bind(function(element,callback){callback(this.selectedOptions);},this)});this.optionsSelect2.select2('val',this.selectedOptions);this.optionsSelect2.on('change',_.bind(this.handleScenarioModelChange,this));},handleScenarioModelChange:function(evt){var changedEnabled=[],changedDisabled=[],allOptions=[];_.each($(evt.target).val().split(','),function(option){changedEnabled.push(option);this.model.set(option,true,{silent:true});},this);_.each(this.scenarioOptions,function(option){allOptions.push(option.id);},this);changedDisabled=_.difference(allOptions,changedEnabled);_.each(changedDisabled,function(option){this.model.set(option,false,{silent:true});},this);this.model.trigger('change:scenarios',this.model);},formatCustomSelection:function(item){return'<a class="select2-choice-filter" rel="'+item.id+'" href="javascript:void(0)">'+item.text+'</a>';},_dispose:function(){if(this.defaultSelect2){this.defaultSelect2.off();this.defaultSelect2.select2('destroy');this.defaultSelect2=null;}
if(this.optionsSelect2){this.optionsSelect2.off();this.optionsSelect2.select2('destroy');this.optionsSelect2=null;}
this._super('_dispose');}})