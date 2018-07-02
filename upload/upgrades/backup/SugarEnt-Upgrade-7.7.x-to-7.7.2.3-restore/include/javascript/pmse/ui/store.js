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
var Store=function(options){this.records=[];this.model=null;this.proxy=null;Store.prototype.initObject.call(this,options);};Store.prototype.type='Store';Store.prototype.initObject=function(options){var defaults={};$.extend(true,defaults,options);};Store.prototype.addRecord=function(record){this.records.push(record);return this;};Store.prototype.getRecord=function(index){return this.records[index];};Store.prototype.getSize=function(){return this.records.length;};