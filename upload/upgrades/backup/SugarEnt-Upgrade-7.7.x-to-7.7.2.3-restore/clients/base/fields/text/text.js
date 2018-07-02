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
({format:function(value){if(_.isString(value)){return value;}
if(_.isUndefined(value)||_.isNull(value)||(_.isObject(value)&&!_.isArray(value))){return'';}
if(_.isBoolean(value)){return value===true?'1':'0';}
return value.toString();},unformat:function(value){return value.trim();}})