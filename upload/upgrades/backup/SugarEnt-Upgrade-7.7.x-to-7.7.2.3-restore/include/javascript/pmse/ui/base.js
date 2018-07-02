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
var Base=function(options){var defaults={id:(options&&options.id)||'base-ui-'+UITools.getIndex()};$.extend(true,defaults,options);this.id=defaults.id;};Base.prototype.setId=function(value){this.id=value;return this;};Base.prototype.type="Core";Base.prototype.family="Core";Base.prototype.getType=function(){return this.type;};Base.prototype.getFamily=function(){return this.family;};Base.prototype.dispose=function(){var key;for(key in this){this[key]=null;}};if(typeof exports!=="undefined"){module.exports=Base;}