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
({extendsFrom:'DateField',initialize:function(options){this._super('initialize',[options]);this.type='date';this.model.addValidationTask('repeat_until_validator_'+this.cid,_.bind(this._doValidateRepeatUntil,this));},_doValidateRepeatUntil:function(fields,errors,callback){var isOnOrAfterStartDate,startDate=this.model.get('date_start'),repeatUntil=this.model.get(this.name),startDateField=this.view.getField('date_start');if(!_.isEmpty(repeatUntil)&&(this.action==='edit')&&startDateField){startDate=app.date(startDate).minutes(0).hours(0);isOnOrAfterStartDate=!app.date(repeatUntil).isBefore(startDate);if(!isOnOrAfterStartDate||!startDate.isValid()){errors[this.name]={'isAfter':startDateField.label};}}
callback(null,fields,errors);},_dispose:function(){this.model.removeValidationTask('repeat_until_validator_'+this.cid);this._super('_dispose');}})