/**
 * The file used to handle Handlebars helpers.
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */

/**
 * Handlebars helpers.
 *
 * These functions are to be used in handlebars templates.
 * @class Handlebars.helpers
 * @singleton
 */
(function (app) {
    app.events.on("app:init", function () {
        /**
         * convert a string to upper case
         */
        Handlebars.registerHelper('compare_value', function (lvalue, rvalue, options) {
            if (arguments.length < 3)
                throw new Error("Handlebars Helper compare_value needs 2 parameters");
            if (lvalue != rvalue) {
                return options.inverse(this);
            } else {
                return options.fn(this);
            }
        });


    });
})(SUGAR.App); 