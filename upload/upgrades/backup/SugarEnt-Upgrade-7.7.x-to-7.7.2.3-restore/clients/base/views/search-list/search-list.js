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
({plugins:['Pagination'],initialize:function(options){this._super('initialize',[options]);this._fieldsMeta={};this.addPreviewEvents();},bindDataChange:function(){this.collection.on('sync',function(collection){if(this.disposed){return;}
var isCollection=(collection instanceof App.BeanCollection);if(!isCollection){return;}
this.parseModels(this.collection.models);if(this._previewed){app.events.trigger('preview:close');}
this.render();},this);},parseModels:function(models){var gsUtils=app.utils.GlobalSearch;_.each(models,function(model){var moduleMeta=this._fieldsMeta[model.module]||gsUtils.getFieldsMeta(model.module);this._fieldsMeta[model.module]=moduleMeta;model.primaryFields=gsUtils.highlightFields(model,moduleMeta.primaryFields);model.secondaryFields=gsUtils.highlightFields(model,moduleMeta.secondaryFields,true);this._rejectEmptyFields(model,model.primaryFields);this._rejectEmptyFields(model,model.secondaryFields);model.primaryFields=this._sortHighlights(model.primaryFields);model.secondaryFields=this._sortHighlights(model.secondaryFields);model.rowactions=moduleMeta.rowactions;},this);},_sortHighlights:function(fieldsObject){var fieldsArray=_.values(fieldsObject);fieldsArray=_.sortBy(fieldsArray,function(field){if(field.type==='avatar'){return 0;}
return field.highlighted?1:2;});return fieldsArray;},_rejectEmptyFields:function(model,viewDefs){_.each(viewDefs,function(field){if(field.type==='avatar'||field.highlighted){return;}
var fieldValue=model.get(field.name);if(_.isEmpty(fieldValue)&&!_.isNumber(fieldValue)){delete viewDefs[field.name];}});},addPreviewEvents:function(){this.context.on('list:preview:fire',function(model){app.events.trigger('preview:render',model,this.collection,true);},this);app.events.on('list:preview:decorate',this.decorateRow,this);if(this.layout){this.layout.on('list:paginate:success',function(){app.events.trigger('preview:collection:change',this.collection);if(this._previewed){this.decorateRow(this._previewed);}},this);}},decorateRow:function(model){this._previewed=model;this.$('li.highlighted').removeClass('highlighted current');if(model){var curr=this.$('[data-id="'+model.id+'"]');curr.addClass('current highlighted');}},getPaginationOptions:function(){var selectedFacets=this.context.get('selectedFacets');var tagFilters=_.pluck(this.context.get('tags'),'id');var options=null;if(selectedFacets||tagFilters){options={apiOptions:{data:{},fetchWithPost:true,useNewApi:true}};}
if(selectedFacets){options.apiOptions.data.agg_filters=selectedFacets;}
if(tagFilters){options.apiOptions.data.tag_filters=tagFilters;}
return options;}})