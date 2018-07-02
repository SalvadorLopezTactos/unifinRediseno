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
({extendsFrom:'IntField',defaultCount:10,initialize:function(options){this._super('initialize',[options]);this.type=this.def.type='int';this.def['default']=this.def['default']||this.defaultCount;if(this.model.isNew()&&!this.model.isCopy()){this.model.setDefault(this.name,this.def['default']);}
this.model.addValidationTask('repeat_count_max_validator_'+this.cid,_.bind(this._doValidateRepeatCountMax,this));},format:function(value){value=this._super('format',[value]);return(value==='0'||value==null)?'':value;},unformat:function(value){if(!_.isString(value)){return value;}
value=this._super('unformat',[value]);if(_.isString(value)){if(value.trim()===''){value=0;}}else{value=Math.round(value);}
return value;},_doValidateRepeatCountMax:function(fields,errors,callback){var repeatCount=parseInt(this.model.get(this.name),10),maxRepeatCount=app.config.calendar.maxRepeatCount;if(repeatCount>maxRepeatCount){errors[this.name]={'maxValue':maxRepeatCount};}
callback(null,fields,errors);},_dispose:function(){this.model.removeValidationTask('repeat_count_max_validator_'+this.cid);this._super('_dispose');}})