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
 * @class Element
 * Base class to handle HTML Divs
 * @extend Base
 *
 *
 * @constructor
 * Create a new instace of the class 'Element'
 * @param {Object} options
 */
var Element = function (options) {
    Base.call(this, options);
    /**
     * Absolute X position of the HTML Element
     * @type {Number}
     */
    this.x = null;
    /**
     * Absolute Y position of the HTML Element
     * @type {Number}
     */
    this.y = null;
    /**
     * Width dimension of the HTML Element
     * @type {Number}
     */
    this.width = null;
    /**
     * Height dimension of the HTML Element
     * @type {Number}
     */
    this.height = null;
    /**
     * Pointer to the HTMLElement object
     * @type {HTMLElement}
     */
    this.html = null;
    /**
     * Intance of the jCore.Style object to handle style tags
     * @type {Object}
     */
    this.style = null;
    /**
     * Defines if the HTML element is visible
     * @type {Boolean}
     */
    this.visible = null;
    /**
     * Defines the value of the zIndex for the HTML Element
     * @type {Number}
     */
    this.zOrder = null;

    Element.prototype.initObject.call(this, options);
};
Element.prototype = new Base();

/**
 * Defines the object type
 * @type {String}
 * @private
 */
Element.prototype.type = "Base";
/**
 * Defines the object family
 * @type {String}
 * @private
 */
Element.prototype.family = "Base";

/**
 * Initialize the object with the default values
 * @param {Object} options
 * @private
 */
Element.prototype.initObject = function (options) {
    var defaults = {
        //id : (options && options.id) || jCore.Utils.generateUniqueId(),
        style : {
            cssProperties: {},
            cssClasses: []
        },
        width : 0,
        height : 0,
        x : 0,
        y : 0,
        zOrder : 1,
        visible : true
    };
    $.extend(true, defaults, options);
    this//.setId(defaults.id)
        .setStyle(new Style({
            belongsTo: this,
            cssProperties: defaults.style.cssProperties,
            cssClasses: defaults.style.cssClasses
        }))
        .setDimension(defaults.width, defaults.height)
        .setPosition(defaults.x, defaults.y)
        .setZOrder(defaults.zOrder)
        .setVisible(defaults.visible);
};

/**
* Sets the id property
* @param {String} newID
* @return {*}
*/
Element.prototype.setId = function (newID) {
    this.id = newID;
    if (this.html) {
        this.html.id = this.id;
    }
    return this;
};
/**
 * Sets the X property
 * @param {Number} x
 * @return {*}
 */
Element.prototype.setX = function (x) {
    if (typeof x === 'number') {
        this.x = x;
        if (this.html) {
            this.style.addProperties({left: this.x});
        }
    } else {
        throw new Error('setX: x param is not a number');
    }
    return this;
};

/**
 * Sets the Y property
 * @param {Number} y
 * @return {*}
 */
Element.prototype.setY = function (y) {
    if (typeof y === 'number') {
        this.y = y;
        if (this.html) {
            this.style.addProperties({top: this.y});
        }
    } else {
        throw new Error('setY: y param is not a number');
    }
    return this;
};

/**
 * Sets the width property
 * @param {Number} w
 * @return {*}
 */
Element.prototype.setWidth = function (w) {
    if (typeof w === 'number') {
        this.width = w;
        if (this.html) {
            this.style.addProperties({width: this.width});
        }
    } else {
        throw new Error('setWidth: w is not a number');
    }
    return this;
};

/**
 * Sets the height property
 * @param {Number} h
 * @return {*}
 */
Element.prototype.setHeight = function (h) {
    if (typeof h === 'number') {
        this.height = h;
        if (this.html) {
            this.style.addProperties({height: this.height});
        }
    } else {
        throw new Error('setHeight: h is not a number');
    }
    return this;
};

/**
 * Sets the position of the HTML Element
 * @param {Number} x
 * @param {Number} y
 * @return {*}
 */
Element.prototype.setPosition = function (x, y) {
    this.setX(x);
    this.setY(y);
    return this;
};

/**
 * Sets the dimension of the HTML Element
 * @param {Number} w
 * @param {Number} h
 * @return {*}
 */
Element.prototype.setDimension = function (w, h) {
    this.setWidth(w);
    this.setHeight(h);
    return this;
};

/**
 * Sets the xOrder property
 * @param {Number} z
 * @return {*}
 */
Element.prototype.setZOrder = function (z) {
    if (typeof z === 'number' && z > 0) {
        this.zOrder = z;
        if (this.html) {
            this.style.addProperties({zIndex: this.zOrder});
        }
    }
    return this;
};

/**
 * Sets the visible property
 * @param {Boolean} value
 * @return {*}
 */
Element.prototype.setVisible = function (value) {
    if (_.isBoolean(value)) {
        this.visible = value;
        if (this.html) {
            if (value) {
                this.style.addProperties({display: "inline"});
            } else {
                this.style.addProperties({display: "none"});
            }
        }
    }
    return this;
};

/**
 * Sets the style object
 * @param {Object} style Instance of jCore.Style
 * @return {*}
 */
Element.prototype.setStyle = function (style) {
    if (style instanceof Style) {
        this.style = style;
    }
    return this;
};

/**
 * Creates a new HTML Element
 * @param {String} type
 * @return {HTMLElement}
 */
Element.prototype.createHTMLElement = function (type) {
    return document.createElement(type);
};

/**
 * Creates the hmtl object
 * @return {HTMLElement}
 */
Element.prototype.createHTML = function () {
    if (!this.html) {
        this.html = this.createHTMLElement('div');
        this.html.id = this.id;

        this.style.applyStyle();

        this.style.addProperties({
            position: "absolute",
            left: this.x,
            top: this.y,
            width: this.width,
            height: this.height,
            zIndex: this.zOrder
        });
    }
    return this.html;
};

/**
 * Defines the functionality to paint the HTML element
 * @abstract
 */
Element.prototype.paint = function () {
};

/**
 * Returns the html pointer
 * @return {HTMLElement}
 */
Element.prototype.getHTML = function () {
    if (!this.html) {
        this.createHTML();
    }
    return this.html;
};

/**
 * Calculates the text width
 * @param {String} text
 * @param {String} [font]
 * @return {*}
 */
Element.prototype.calculateWidth = function (text, font) {
    //TODO Improve the div creation (maybe we can use a singleton for this)
    var f = font || '12px arial',
        $o = $(this.createHTMLElement('div')), w;
        $o.text(text)
            .css({'position': 'absolute', 'float': 'left', 'white-space': 'nowrap', 'visibility': 'hidden', 'font': f})
            .appendTo($('body')),
        w = $o.width();

    $o.remove();

    return w;
};