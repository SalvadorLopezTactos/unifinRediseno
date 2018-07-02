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
var Proxy=function(options){Base.call(this,options);this.url=null;this.callback=null;this.attributes=null;Proxy.prototype.initObject.call(this,options);};Proxy.prototype=new Base();Proxy.prototype.type='Proxy';Proxy.prototype.family='Proxy';Proxy.prototype.initObject=function(options){var defaults={url:null,callback:null,attributes:null};$.extend(true,defaults,options);this.setUrl(defaults.url).setCallback(defaults.callback).setAttributes(defaults.attributes);};Proxy.prototype.setUrl=function(url){this.url=url;return this;};Proxy.prototype.setCallback=function(callback){this.callback=callback;return this;};Proxy.prototype.setAttributes=function(attributes){this.attributes=attributes;return this;};Proxy.prototype.getData=function(){};Proxy.prototype.sendData=function(data,callback){};