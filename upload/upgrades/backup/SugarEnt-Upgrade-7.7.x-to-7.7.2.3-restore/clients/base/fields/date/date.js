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
({plugins:['EllipsisInline','Tooltip'],fieldTag:'input[data-type=date]',events:{'hide':'handleHideDatePicker'},direction:'ltr',initialize:function(options){this._initPlugins();this._super('initialize',[options]);this._initEvents();this._initDefaultValue();this._initPlaceholderAttribute();this.ellipsis=_.isUndefined(this.def.ellipsis)||this.def.ellipsis;this._hasDatePicker=false;},_initPlugins:function(){return this;},_initEvents:function(){return this;},_initDefaultValue:function(){if(!this.model.isNew()||this.model.get(this.name)||!this.def.display_default){return this;}
var value=app.date.parseDisplayDefault(this.def.display_default);if(!value){return this;}
value=this.unformat(app.date(value).format(app.date.convertFormat(this.getUserDateFormat())));this.model.setDefault(this.name,value);return this;},_initPlaceholderAttribute:function(){var placeholder=app.date.toDatepickerFormat(this.getUserDateFormat());this.fieldPlaceholder=this.def.placeholder&&app.lang.get(this.def.placeholder,this.module,{format:placeholder})||placeholder;return this;},getUserDateFormat:function(){return app.user.getPreference('datepref');},_setupDatePicker:function(){var $field=this.$(this.fieldTag),userDateFormat=this.getUserDateFormat(),options={format:app.date.toDatepickerFormat(userDateFormat),languageDictionary:this._patchPickerMeta(),weekStart:parseInt(app.user.getPreference('first_day_of_week'),10)};var appendToTarget=this._getAppendToTarget();if(appendToTarget){options['appendTo']=appendToTarget;}
$field.datepicker(options);this._hasDatePicker=true;},_getAppendToTarget:function(){var component=this.closestComponent('main-pane')||this.closestComponent('drawer')||this.closestComponent('preview-pane');if(component){return component.$el;}
return;},handleHideDatePicker:function(){var $field=this.$(this.fieldTag),value=this.unformat($field.val());if(!value){$field.val(value);}
this.model.set(this.name,value);},bindDomChange:function(){if(this._inDetailMode()){return;}
var $field=this.$(this.fieldTag);$field.on('focus',_.bind(this.handleFocus,this));$('.main-pane, .flex-list-view-content').on('scroll.'+this.cid,_.bind(function(){if(this._getAppendToTarget()){$field.datepicker('place');}},this));},_inDetailMode:function(){return this.action!=='edit'&&this.action!=='massupdate';},unbindDom:function(){this._super('unbindDom');if(this._inDetailMode()){return;}
$('.main-pane, .flex-list-view-content').off('scroll.'+this.cid);var $field=this.$(this.fieldTag),datePicker=$field.data('datepicker');if(datePicker&&!datePicker.hidden){$field.datepicker('hide');}},_patchPickerMeta:function(){var pickerMap=[],pickerMapKey,calMapIndex,mapLen,domCalKey,calProp,appListStrings,calendarPropsMap,i,filterIterator;appListStrings=app.metadata.getStrings('app_list_strings');filterIterator=function(v,k,l){return v[1]!=="";};calendarPropsMap=['dom_cal_day_long','dom_cal_day_short','dom_cal_month_long','dom_cal_month_short'];for(calMapIndex=0,mapLen=calendarPropsMap.length;calMapIndex<mapLen;calMapIndex++){domCalKey=calendarPropsMap[calMapIndex];calProp=appListStrings[domCalKey];if(!_.isUndefined(calProp)&&!_.isNull(calProp)){calProp=_.filter(calProp,filterIterator).map(function(prop){return prop[1];});calProp.push(calProp);}
switch(calMapIndex){case 0:pickerMapKey='day';break;case 1:pickerMapKey='daysShort';break;case 2:pickerMapKey='months';break;case 3:pickerMapKey='monthsShort';break;}
pickerMap[pickerMapKey]=calProp;}
return pickerMap;},format:function(value){if(!value){return value;}
value=app.date(value);if(!value.isValid()){return;}
return value.formatUser(true);},unformat:function(value){if(!value){return value;}
value=app.date(value,app.date.convertFormat(this.getUserDateFormat()),true);if(!value.isValid()){return;}
return value.formatServer(true);},_render:function(){this._super('_render');if(this.tplName!=='edit'&&this.tplName!=='massupdate'){this._hasDatePicker=false;return;}
this._setupDatePicker();},focus:function(){this.$(this.fieldTag).datepicker('focusShow');},_dispose:function(){if(this._hasDatePicker){$(window).off('resize',this.$(this.fieldTag).data('datepicker').place);}
this._super('_dispose');}})