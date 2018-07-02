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
({className:'selection-context',events:{'click [data-close-pill]':'handleClosePillEvent','click .reset_button':'removeAllPills'},plugins:['EllipsisInline'],initialize:function(options){this.pills=[];this.maxPillsDisplayed=50;this._super('initialize',[options]);},addPill:function(models){var modelName;var pillsAttrs=[];var pillsIds=_.pluck(this.pills,'id');models=_.isArray(models)?models:[models];_.each(models,function(model){modelName=model.name||model.full_name||model.document_name||model.get('name')||model.get('full_name')||model.get('document_name');if(modelName&&!_.contains(pillsIds,model.id)){pillsAttrs.push({id:model.id,name:modelName});}});this.pills.push.apply(this.pills,pillsAttrs);this._debounceRender();},removePill:function(models){models=_.isArray(models)?models:[models];var ids=_.pluck(models,'id');this.pills=_.reject(this.pills,function(pill){return _.contains(ids,pill.id);});this._debounceRender();},removeAllPills:function(event){if(event){if(this.$(event.target).hasClass('disabled')){return;}}
this.pills=[];this.render();this.context.trigger('mass_collection:clear');},resetPills:function(collection){if(!collection.length){this.pills=[];}
this.render();},handleClosePillEvent:function(event){var id=this.$(event.target).closest('.select2-search-choice').data('id').toString();this.closePill(id);},closePill:function(modelId){this.removePill({id:modelId});var model=this.massCollection.get(modelId);this.context.trigger('mass_collection:remove',model);},_debounceRender:_.debounce(function(){this.render();},50),_render:function(){this.massCollection=this.context.get('mass_collection');if(!this.massCollection){return;}
if(this.pills.length>this.maxPillsDisplayed){this.displayedPills=this.pills.slice(0,this.maxPillsDisplayed);this.tooManySelectedRecords=true;this.msgMaxPillsDisplayed=app.lang.get('TPL_MAX_PILLS_DISPLAYED',this.module,{maxPillsDisplayed:this.maxPillsDisplayed});}else{this.tooManySelectedRecords=false;this.displayedPills=this.pills;}
var recordsLeft=this.massCollection.length-this.displayedPills.length;if(recordsLeft){this.moreRecords=true;var label=this.displayedPills.length?'TPL_MORE_RECORDS':'TPL_RECORDS_SELECTED';this.msgMoreRecords=app.lang.get(label,this.module,{recordsLeft:recordsLeft});}else{this.moreRecords=false;}
this._super('_render');this.stopListening(this.massCollection);this.listenTo(this.massCollection,'add',this.addPill);this.listenTo(this.massCollection,'remove',this.removePill);this.listenTo(this.massCollection,'reset',this.resetPills);},bindDataChange:function(){this.collection.on('sync',function(collection,fetchedRecords){if(!_.isArray(fetchedRecords)){return;}
var recordsToAdd=_.filter(fetchedRecords,function(attrs){return this.massCollection.get(attrs.id);},this);if(!recordsToAdd.length){return;}
this.addPill(recordsToAdd);},this);},unbind:function(){this.stopListening(this.massCollection);this._super('unbind');}})