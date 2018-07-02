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
 * @class Layout
 * Handle the layout for panels
 * @extend Base
 *
 * @constructor
 * Creates a new instance of this class
 * @param {Object} options
 */
var Layout = function (options) {
    Base.call(this, options);

    Layout.prototype.initObject.call(this, options);
};

Layout.prototype = new Base();

/**
 * Defines the object's type
 * @type {String}
 */
Layout.prototype.type = 'Layout';

/**
 * Defines the object's family
 * @type {String}
 */
Layout.prototype.family = 'Layout';

/**
 * Initializes the object with default values
 * @param {Object} options
 */
Layout.prototype.initObject = function (options) {

};
