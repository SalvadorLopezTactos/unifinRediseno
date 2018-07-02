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
({extendsFrom:'EnumField',defaultOnUndefined:false,initialize:function(options){this._super('initialize',[options]);this.type='enum';this.def['default']=this.getDefaultDayOfWeek();this.model.addValidationTask('repeat_dow_validator_'+this.cid,_.bind(this._doValidateRepeatDow,this));},getDefaultDayOfWeek:function(){var isoDayOfWeek=app.date().isoWeekday(),sugarDayOfWeek=(isoDayOfWeek===7)?0:isoDayOfWeek;return sugarDayOfWeek.toString();},format:function(value){return(_.isString(value))?value.split('').sort():value;},unformat:function(value){return(_.isArray(value))?value.sort().join(''):value;},_doValidateRepeatDow:function(fields,errors,callback){var repeatType=this.model.get('repeat_type'),repeatDow=this.model.get(this.name);if(repeatType==='Weekly'&&(!_.isString(repeatDow)||repeatDow.length<1)){errors[this.name]={'required':true};}
callback(null,fields,errors);},_dispose:function(){this.model.removeValidationTask('repeat_dow_validator_'+this.cid);this._super('_dispose');}})