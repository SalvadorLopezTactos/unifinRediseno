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
(function(app){app.events.on('app:init',function(){app.plugins.register('Editable',['view'],{onAttach:function(component,plugin){this.editableKeyDowned=_.bind(function(evt){this.editableHandleKeyDown.call(this,evt,evt.data.field);},this);this.editableMouseClicked=_.bind(function(evt){this.editableHandleMouseDown.call(this,evt,evt.data.field);},this);this.on('init',function(){app.routing.before('route',this.beforeRouteChange,this);$(window).on('beforeunload.'+this.cid,_.bind(this.warnUnsavedChangesOnRefresh,this));this.before('unsavedchange',this.beforeViewChange,this);if(_.isEmpty(app.additionalComponents['drawer'])){return;}
app.events.on('editable:beforehandlers:off',this.unbindBeforeHandler,this);this._currentUrl=Backbone.history.getFragment();});},beforeRouteChange:function(params){var onConfirm=_.bind(this.onConfirmRoute,this);return this.warnUnsavedChanges(onConfirm);},beforeViewChange:function(param){if(!(param&&_.isFunction(param.callback))){app.logger.error('Custom unsavedchange must contain callback function.');return true;}
var onConfirm=_.bind(function(){if(param.callback&&_.isFunction(param.callback)){param.callback.call(this);}},this);return this.warnUnsavedChanges(onConfirm,param.message);},warnUnsavedChanges:function(onConfirm,customMessage,onCancel){if(this.resavingAfterMetadataSync){return false;}
this.$(':focus').trigger('change');if(_.isFunction(this.hasUnsavedChanges)&&this.hasUnsavedChanges()){this._targetUrl=Backbone.history.getFragment();app.router.navigate(this._currentUrl,{trigger:false,replace:true});app.alert.show('leave_confirmation',{level:'confirmation',messages:app.lang.get(customMessage||'LBL_WARN_UNSAVED_CHANGES',this.module),onConfirm:onConfirm,onCancel:onCancel||$.noop});return false;}
return true;},warnUnsavedChangesOnRefresh:function(){if(this.resavingAfterMetadataSync){return false;}
if(_.isFunction(this.hasUnsavedChanges)&&this.hasUnsavedChanges()){return app.lang.get('LBL_WARN_UNSAVED_CHANGES',this.module);}
return;},onConfirmRoute:function(){app.events.trigger('editable:beforehandlers:off');if(this._currentUrl===this._targetUrl){app.router.refresh();}else{app.router.navigate(this._targetUrl,{trigger:true});}},toggleFields:function(fields,isEdit,callback){if(!_.isArray(fields)){return;}
var viewName=!!isEdit?'edit':this.action,numOfToggledFields=fields.length;_.each(fields,function(field){if(field.action===viewName){numOfToggledFields--;return;}
var meta=field.def;if(meta&&isEdit&&meta.readonly){numOfToggledFields--;return;}
_.defer(function(field){if(field.disposed!==true){field.setMode(viewName);field.$el.closest('.record-cell').toggleClass('edit',(viewName==='edit'));numOfToggledFields--;if((numOfToggledFields===0)&&_.isFunction(callback)){callback();}}},field);this.turnOffFieldEvents(field);},this);},turnOffFieldEvents:function(field){if(_.isFunction(field.unbindKeyDown)){field.unbindKeyDown(this.editableKeyDowned);}else{field.$(field.fieldTag).off('keydown.record',this.editableKeyDowned);}
$(document).off('mousedown.record'+field.name,this.editableMouseClicked);},turnOffEvents:function(fields){_.each(fields,function(field){this.turnOffFieldEvents(field);},this);},toggleField:function(field,isEdit){var viewName;if(_.isUndefined(isEdit)){viewName=(field.tplName===this.action)?'edit':this.action;}else{viewName=!!isEdit?'edit':this.action;}
if(!field.triggerBefore('toggleField',viewName)){return false;}
if(field.hasChanged()&&viewName==='detail'){return;}
field.setMode(viewName);if(viewName==='edit'){if(_.isFunction(field.focus)){field.focus();}else{var $el=field.$(field.fieldTag+':first');$el.focus().val($el.val());}
if(_.isFunction(field.bindKeyDown)){field.bindKeyDown(this.editableKeyDowned);}else{field.$(field.fieldTag).on('keydown.record',{field:field},this.editableKeyDowned);}
if(_.isFunction(field.bindDocumentMouseDown)){field.bindDocumentMouseDown(this.editableMouseClicked);}else{$(document).on('mousedown.record'+field.name,{field:field},this.editableMouseClicked);}
field.$el.closest('.record-cell').toggleClass('edit',true);}else{if(_.isFunction(field.unbindKeyDown)){field.unbindKeyDown();}else{field.$(field.fieldTag).off('keydown.record');}
$(document).off('mousedown.record'+field.name);field.$el.closest('.record-cell').toggleClass('edit',false);}},nextField:function(field,direction){if(!field){return;}
field.$(field.fieldTag).trigger('change');direction=_.contains(['nextField','prevField'],direction)?direction:'nextField';var nextField=field[direction];if(!nextField){return;}
if(_.isFunction(this.toggleMoreLess)&&nextField.$el.closest('.panel_hidden').hasClass('hide')){this.toggleMoreLess('more');}
this.toggleField(field,false);while(nextField.isDisabled()){if(nextField[direction]){nextField=nextField[direction];}else{break;}}
if(!nextField.isDisabled()){this.toggleField(nextField,true);}},editableHandleMouseDown:function(evt,field){if(field.tplName===this.action){return;}
var currFieldParent=field.$el,targetPlaceHolder=this.$(evt.target).parents("span[sfuuid='"+field.sfId+"']"),preventPlaceholder=this.$(evt.target).closest('.prevent-mousedown');var inPreventPlaceholder=(preventPlaceholder.length>0);var inTargetPlaceholder=(targetPlaceHolder.length>0);var isFocusInField=(currFieldParent.find(':focus').length>0);var drawerOpened=!_.isEmpty(app.drawer._components);if(inPreventPlaceholder||inTargetPlaceholder||isFocusInField||drawerOpened){return;}
this.toggleField(field,false);this.trigger('editable:mousedown',evt,field);},editableHandleKeyDown:function(evt,field){if(evt.which==27){this.toggleField(field,false);}
this.trigger('editable:keydown',evt,field);},unbindBeforeHandler:function(){app.routing.offBefore('route',this.beforeRouteChange,this);$(window).off('beforeunload.'+this.cid);if(_.isEmpty(app.additionalComponents['drawer'])){return;}
app.drawer.offBefore('reset',this.beforeRouteChange,this);this.offBefore('unsavedchange');},onDetach:function(){$(document).off('mousedown',this.editableMouseClicked);this.editableKeyDowned=null;this.editableMouseClicked=null;app.events.off('editable:beforehandlers:off',null,this);this.unbindBeforeHandler();}});});})(SUGAR.App);