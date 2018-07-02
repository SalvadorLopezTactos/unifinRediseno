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
/**
 * @class Proxy
 * Handles the proxy connections
 * @extend Base
 *
 * @constructor
 * Creates a new instance of the class
 * @param {Object} options
 */
var Proxy = function (options) {
    Base.call(this, options);
    /**
     * Defines the URL to connect
     * @type {String}
     */
    this.url = null;
    this.callback = null;
    this.attributes = null;
    Proxy.prototype.initObject.call(this, options);
};
Proxy.prototype = new Base();

/**
 * Defines the object's type
 * @type {String}
 */
Proxy.prototype.type = 'Proxy';

/**
 * Defines the object's family
 * @type {String}
 */
Proxy.prototype.family = 'Proxy';

/**
 * Initializes the object with default values
 * @param {Object} options
 */
Proxy.prototype.initObject = function (options) {
    var defaults = {
        url: null,
        callback: null,
        attributes: null
    };
    $.extend(true, defaults, options);
    this.setUrl(defaults.url)
        .setCallback(defaults.callback)
        .setAttributes(defaults.attributes);
};

/**
 * Sets the URL property
 * @param {String} url
 * @return {*}
 */
Proxy.prototype.setUrl = function (url) {
    this.url = url;
    return this;
};

Proxy.prototype.setCallback = function (callback) {
    this.callback = callback;
    return this;
};

Proxy.prototype.setAttributes = function(attributes) {
    this.attributes = attributes;
    return this;
};

/**
 * Obtains the data
 */
Proxy.prototype.getData = function () {

};

/**
 * Sends the data
 * @param {Object} data
 * @param {Object} [callback]
 */
Proxy.prototype.sendData = function (data, callback) {

};
