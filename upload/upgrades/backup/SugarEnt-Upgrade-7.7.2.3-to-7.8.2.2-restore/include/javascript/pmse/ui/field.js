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
 * @class Field
 * Handle form fields
 * @extend Element
 *
 * @constructor
 * Creates a new instace of the object
 * @param {Object} options
 * @param {Form} parent
 */
var Field = function (options, parent) {
    Element.call(this, options);
    /**
     * Defines the parent Form
     * @type {Form}
     */
    this.parent = null;
    /**
     * Defines the field's label
     * @type {String}
     */
    this.label = null;
    /**
     * Defines the Value
     * @type {*}
     */
    this.value = null;
    /**
     * Defines the validator object
     * @type {Validator}
     */
    this.validators = [];
    /**
     * Defines the field's name
     * @type {String}
     */
    this.name = null;
    /**
     * Defines the required state of the field
     * @type {Boolean}
     */
    this.required = null;
    /**
     * Defines the error message to show
     * @type {String}
     */
    this.messageError = null;
    /**
     * Defines the initial value of the field
     * @type {*}
     */
    this.initialValue = null;

    /**
     * Defines if the field is required but cannot be submited
     * @type {Boolean}
     */
    this.requiredFailed = false;

    this.fieldWidth = null;

    this.helpTooltip = null;

    this.errorTooltip = null;

    this.controlObject = null;

    this.labelObject = null;

    this.change = null;

    this.readOnly = null;

    this.submit = null;

    this.proxy = null;

    this.oldRequiredValue = null;

    this.disabled = null;

    Field.prototype.initObject.call(this, options, parent);
};
Field.prototype = new Element();

/**
 * Defines the object's type
 * @type {String}
 */
Field.prototype.type = 'Field';

/**
 * Defines the object's family
 * @type {String}
 */
Field.prototype.family = 'Field';

/**
 * Initializes the object with the default values
 * @param {Object} options
 * @param {Form} parent
 */
Field.prototype.initObject = function (options, parent) {
    var defaults = {
        required: false,
        label: '',
        validators: [],
        value: null,
        messageError: null,
        initialValue: null,
        fieldWidth: null,
        helpTooltip: null,
        change: function () {},
        readOnly: false,
        submit: true,
        proxy: null,
        disabled: false
    };
    $.extend(true, defaults, options);
    this.setParent(parent);
    this.setRequired(defaults.required)
        .setLabel(defaults.label)
        .setName(defaults.name || (this.type + '_' + this.id))
        .setValidators(defaults.validators)
        .setMessageError(defaults.messageError)
        .setInitialValue(defaults.initialValue)
        .setFieldWidth(defaults.fieldWidth)
        .setHelpTooltip(defaults.helpTooltip)
        .setErrorTooltip({})
        .setChangeHandler(defaults.change)
        .setReadOnly(defaults.readOnly)
        .setSubmit(defaults.submit)
        .setProxy(defaults.proxy)
        .setValue(defaults.value);

        if (defaults.disabled) {
            this.disable();
        } else {
            this.enable();
        }
};

/**
 * Sets the required property
 * @param {Boolean} value
 * @return {*}
 */
Field.prototype.setRequired = function (value) {
    var requiredMark;
    this.required = !!value;
    if (this.labelObject) {
        requiredMark = $(this.labelObject).find('i');
        if (value) {
            if (!requiredMark.get(0)) {
                requiredMark = this.createHTMLElement('i');
                requiredMark.appendChild(document.createTextNode('*'));
                this.labelObject.appendChild(requiredMark);
            } else {
                requiredMark.show();
            }
        } else {
            requiredMark.hide();
        }
    }
    return this;
};
/**
 * Takes the sent parameter and set it as the value in the control.
 * @param {String} value
 * @private
 */
Field.prototype._setValueToControl = function (value) {
    if (this.html && this.controlObject) {
        this.controlObject.value = this.value;
    }
    return this;
};
/**
 * Sets the field's value
 * @param {*} value
 * @param {Boolean} [change]
 * @return {*}
 */
Field.prototype.setValue = function (value, change) {
    if (change) {
        this.value = value;
    } else {
        this.value = value || this.initialValue;
    }
    this._setValueToControl(this.value);
    if (this.proxy) {
        this.load();
    }
    return this;
};

/**
 * Sets the field's name
 * @param {String} name
 * @return {*}
 */
Field.prototype.setName = function (name) {
    this.name = name;
    return this;
};

/**
 * Sets the field's label
 * @param {String} label
 * @return {*}
 */
Field.prototype.setLabel = function (label) {
    this.label = label;
    return this;
};

/**
 * Sets the validator property
 * @param {Object/Validator} val
 * @return {*}
 */
Field.prototype.setValidators = function (val) {
    var i;

    for (i = 0; i < val.length; i += 1) {
        if (val[i] && val[i].family && val[i].family === 'Validator') {
            this.validators.push(val[i]);
        } else {
            this.validators.push(this.validatorFactory(val[i]));
        }
    }
    return this;
};

/**
 * Sets the fields validation error message
 * @param {String} msg
 * @return {*}
 */
Field.prototype.setMessageError = function (msg) {
    this.messageError = msg;
    return this;
};

/**
 * Sets the parent object
 * @param {Form} parent
 * @return {*}
 */
Field.prototype.setParent = function (parent) {
    this.parent = parent;
    return this;
};

/**
 * Sets the initial value property
 * @param {*} value
 * @return {*}
 */

Field.prototype.setInitialValue = function (value) {
    this.initialValue = value;
    return this;
};

Field.prototype.setFieldWidth = function (width) {
    this.fieldWidth = width;
    return this;
};

Field.prototype.setHelpTooltip = function (tooltip) {
    if (tooltip) {
        if (!tooltip.css) {
            tooltip.css = 'adam-tooltip-help';
        }
        this.helpTooltip = new Tooltip(tooltip, this);
    } else {
        this.helpTooltip = null;
    }
    return this;
};

Field.prototype.setErrorTooltip = function (tooltip) {
    if (tooltip) {
        if (!tooltip.css) {
            tooltip.css = 'adam-tooltip-error-off';
        }
        if (!tooltip.icon) {
            tooltip.icon = 'adam-tooltip-icon-error';
        }
        tooltip.visible = false;
        this.errorTooltip = new Tooltip(tooltip, this);
    } else {
        this.errorTooltip = null;
    }
    return this;
};

Field.prototype.setChangeHandler = function (fn) {
    this.change = fn;
    return this;
};

Field.prototype.setReadOnly = function (value) {
    this.readOnly = value;
    if (this.html) {
        this.controlObject.disabled = value;
    }
    return this;
};

Field.prototype.setSubmit = function (value) {
    this.submit = value;
    return this;
};

Field.prototype.setProxy = function (newProxy) {
    this.proxy = newProxy;
    return this;
};

/**
 * Returns a validator object
 * @param {Object} validator
 * @return {Validator}
 */
Field.prototype.validatorFactory = function (validator) {
    var out = null,
        regexp = {
            email: {
                pattern: /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                //message: this.parent.language.ERROR_INVALID_EMAIL
            },
            integer: {
                pattern: /^\s*(\+|-)?\d+\s*$/
                //message: this.parent.language.ERROR_INVALID_INTEGER
            },
            required: {
                pattern: /\S/
                //message: this.parent.language.ERROR_REQUIRED_FIELD
            }
        };
    if (validator && validator.jtype) {
        switch (validator.jtype) {
        case 'required':
            if (validator.criteria && !validator.criteria.trim) {
                /*validator.jtype = 'required_without_spaces';*/
                /*} else {*/
                out = new TextLengthValidator({
                    criteria: {
                        trim: false,
                        minLength: 1
                    },
                    errorMessage: validator.errorMessage || this.parent.language.ERROR_REQUIRED_FIELD
                }, this);
            }
            break;
        case 'email':
        case 'integer':
            validator.criteria = regexp[validator.jtype].pattern;
            out = new RegExpValidator($.extend({
                errorMessage: regexp[validator.jtype].message
            }, validator), this);
            break;
        case 'comparison':
            out = new ComparisonValidator($.extend({
                errorMessage: this.parent.language.ERROR_COMPARISON
            }, validator), this);
            break;
        case 'regexp':
            out = new RegExpValidator($.extend({
                errorMessage: this.parent.language.ERROR_REGEXP
            }, validator), this);
            break;
        case 'textLength':
            out = new TextLengthValidator($.extend({
                errorMessage: this.parent.language.ERROR_TEXT_LENGTH
            }, validator), this);
            break;
        case 'custom':
            out = new CustomValidator($.extend({
                errorMessage: ""
            }, validator), this);
            break;
        case 'number':
            out = new NumberValidator($.extend({
                errorMessage: ""
            }, validator), this);
            break;
        case 'range':
            out = new RangeValidator($.extend({
                errorMessage: ""
            }, validator), this);
            break;
        default:
            out = new Validator($.extend({
                errorMessage: ""
            }, validator), this);
        }
    } else {
        out = new Validator(null, this);
    }
    return out;
};

/**
 * Returns the object representation of the field
 * @return {Object}
 */
Field.prototype.getObjectValue = function () {
    var result = {};
    if (this.submit) {
        result[this.name] = this.value;
    }
    return result;
};

/**
 * Returns the evaluation if the fields is required
 * @return {Boolean}
 */
Field.prototype.evalRequired = function () {
    var response = true, value;
    if (this.required) {
        response = (this.value !== null && this.value !== '' && this.value.trim());
        if (!response) {
            $(this.controlObject).addClass('required');
        } else {
            $(this.controlObject).removeClass('required');
        }
    }
    return response;
};

/**
 * Resets the field
 */
Field.prototype.reset = function () {
    this.setValue(this.initialValue || null, true);
    if (this.errorTooltip) {
        $(this.errorTooltip.html).removeClass('adam-tooltip-error-on');
        $(this.errorTooltip.html).addClass('adam-tooltip-error-off');
    }
    if (this.required && this.controlObject) {
        $(this.controlObject).removeClass('required');
    }
};

Field.prototype.attachListeners = function () {

};

Field.prototype.createHTML = function () {
    Element.prototype.createHTML.call(this);
    this.style.removeProperties(['position', 'width', 'height', 'top', 'left', 'z-index']);
    this.style.addClasses(['adam-field']);
    return this.html;
};

Field.prototype.isValid = function () {
    var i, res = true;

    for (i = 0; i < this.validators.length; i += 1) {
        res = res && this.validators[i].isValid();

        if (!res) {
            this.errorTooltip.setMessage(this.validators[i].getErrorMessage());
            $(this.errorTooltip.html).removeClass('adam-tooltip-error-off');
            $(this.errorTooltip.html).addClass('adam-tooltip-error-on');
            return res;
        }
    }

    if (res) {
        $(this.errorTooltip.html).removeClass('adam-tooltip-error-on');
        $(this.errorTooltip.html).addClass('adam-tooltip-error-off');
    }

    return res;
};

Field.prototype.onChange = function (newValue, oldValue) {
    if (this.required) {
        this.evalRequired();
    }

    this.isValid();

    if (this.change) {
        this.change(this, newValue, oldValue);
    }
    this.parent.setDirty(true);
    return this;
};


Field.prototype.doLoad = function () {
    if (this.proxy) {
        this.load();
    }
};

/**
 * @abstract
 * Loads the field through the proxy defined
 */
Field.prototype.load = function () {

};

Field.prototype.enable = function () {
    if (this.controlObject) {
        this.labelObject.className = 'adam-form-label';
        this.controlObject.disabled = false;
    }
    if (this.oldRequiredValue) {
        this.setRequired(this.oldRequiredValue);
    }
    this.disabled = false;
    return this;
};

Field.prototype.disable = function () {
    if (!this.oldRequiredValue) {
        this.oldRequiredValue = this.required;
    }
    this.setRequired(false);
    if (this.controlObject) {
        this.labelObject.className = 'adam-form-label-disabled';
        this.controlObject.disabled = true;
        $(this.controlObject).removeClass('required');
    }
    this.disabled = true;
    return this;
};
