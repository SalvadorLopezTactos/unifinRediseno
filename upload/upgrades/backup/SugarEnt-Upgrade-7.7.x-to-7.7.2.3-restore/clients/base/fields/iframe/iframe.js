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
({direction:'ltr',_render:function(){this._super('_render');if(this.tplName==='disabled'){this.$(this.fieldTag).attr('disabled','disabled');}},unformat:function(value){value=(value!==''&&value!='http://')?value.trim():'';return value;},format:function(value){if(_.isEmpty(value)){value=_.isString(this.def['default'])?this.def['default']:undefined;}
if(this.def.gen=='1'){var regex=/{(.+?)}/,result=null;do{result=regex.exec(value);if(result){value=value.replace(result[0],this.model.get(result[1]));}}while(result);}
if(_.isString(value)&&!value.match(/^(http|https):\/\//)){value='http://'+value.trim();}
return value;}})