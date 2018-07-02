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
 * @class Validator
 * Handles the validations of the fields
 * @extend Base
 *
 * @constructor
 * Create a new instance of the class
 * @param {Object} options
 * @param {Field} parent
 */
var Validator = function (options, parent) {
    Base.call(this, options);
    /**
     * Defines the Field parent
     * @type {Field}
     */
    this.parent = null;
    /**
     * Defines the criteria object
     * @type {Object}
     */
    this.criteria = null;
    /**
     * Defines if the object is validated
     * @type {Boolean}
     */
    this.validated = false;
    /**
     * Defines the validation state
     * @type {null/Boolean}
     */
    this.valid = null;
    /**
     * Defines the error message to show in case of the validation fails
     * @type {null/Boolean}
     */
    this.errorMessage = null;
    Validator.prototype.initObject.call(this, options, parent);
};
Validator.prototype = new Base();

/**
 * Defines the object's type
 * @type {String}
 */
Validator.prototype.type = 'Validator';

/**
 * Defines the object's family
 * @type {String}
 */
Validator.prototype.family = 'Validator';

/**
 * Initializes the object with default values
 * @param {Object} options
 * @param {Field} parent
 */
Validator.prototype.initObject = function (options, parent) {
    var defaults = {
        criteria: null,
        errorMessage: 'the validation has failed'
    };
    $.extend(true, defaults, options);
    this.setCriteria(defaults.criteria)
        .setParent(parent)
        .setErrorMessage(defaults.errorMessage);
};

/**
 * Sets the validation error message to show in case of the validation fails
 * @param {String} errorMessage
 * @return {*}
 */
Validator.prototype.setErrorMessage = function (errorMessage) {
    this.errorMessage = errorMessage;
    return this;
};

/**
 * GSets the validation error message to show in case of the validation fails
 * @param {String} errorMessage
 * @return {*}
 */
Validator.prototype.getErrorMessage = function () {
    return this.errorMessage;
};

/**
 * Sets the validation criteria
 * @param {Object} criteria
 * @return {*}
 */
Validator.prototype.setCriteria = function (criteria) {
    this.criteria = criteria;
    return this;
};

/**
 * Sets the parent field
 * @param {Field} parent
 * @return {*}
 */
Validator.prototype.setParent = function (parent) {
    this.parent = parent;
    return this;
};

/**
 * Evaluates the validator
 */
Validator.prototype.validate = function () {
    this.valid = true;
};

/**
 * Returns the validation response
 * @return {*}
 */
Validator.prototype.isValid = function () {
    this.validate();
    this.updateTooltip();
    return this.valid;
};

Validator.prototype.updateTooltip = function () {
    if (this.parent && this.parent.errorTooltip) {
        if (this.valid) {
            $(this.parent.errorTooltip.html)
                .removeClass('adam-tooltip-error-on')
                .addClass('adam-tooltip-error-off');
        } else {
            this.parent.errorTooltip.setMessage(this.errorMessage);
            $(this.parent.errorTooltip.html)
                .removeClass('adam-tooltip-error-off')
                .addClass('adam-tooltip-error-on');
        }
    }
};
