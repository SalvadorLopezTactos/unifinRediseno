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
var UITools = {
    index: 0,
    getIndex: function () {
        this.index = this.index + 1;
        return this.index;
    }
};
var getRelativePosition = function (targetElement, relativeElement) {
    var e = $(targetElement).offset(),
        re = ($(relativeElement).get(0) instanceof Document) ? {top: 0, left: 0} : $(relativeElement).offset();

    return {
        top: e.top - re.top,
        left: e.left - re.left
    };
};

function isHTMLElement (obj) {
    try {
        //Using W3 DOM2 (works for FF, Opera and Chrom)
        return obj instanceof HTMLElement;
    }
    catch(e){
        //Browsers not supporting W3 DOM2 don't have HTMLElement and
        //an exception is thrown and we end up here. Testing some
        //properties that all elements have. (works on IE7)
        return (typeof obj==="object") &&
            (obj.nodeType===1) && (typeof obj.style === "object") &&
            (typeof obj.ownerDocument ==="object");
    }
}

function isInDOM (element) {
    return jQuery(element).parents('body:last').get(0) === document.body;
}

function cloneObject (obj) {
    var newObj = {}, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) {
            newObj[key] = obj[key];
        }
    }
    return newObj;
}

