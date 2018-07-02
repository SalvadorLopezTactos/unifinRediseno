/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
(function(app) {
    var _doWhenStack = [],
        _doWhenLocked = false,
        _doWhenInterval = false,
        _doWhenretryCount = 0,

        _startDoWhenInterval = function () {
            if (!_doWhenInterval) {
                _doWhenInterval = window.setInterval(app.utils._doWhenCheck, 50);
            }
        };

    /**
     * Utils module provides several utility methods used throughout the app such as number formatting.
     *
     * @class Utils.Utils
     * @alias SUGAR.App.utils
     * @singleton
     */
    app.augment('utils', {

        /**
         * Capitalizes a string.
         * @param {String} s The string to capitalize.
         * @return {String} Capitalized string or an empty string if `s` is undefined or null.
         */
        capitalize: s => s ? (s.charAt(0).toUpperCase() + (s.length > 1 ? s.substr(1) : "")) : "",

        /**
         * Capitalizes a hyphenated string.
         *
         * `"my-string"` becomes `"MyString"`.
         * @param {String} s The string to capitalize.
         * @return {String} Capitalized string or an empty string if `s` is undefined or null.
         */
        capitalizeHyphenated: function(s) {
            return this._classify(s, '-');
        },

        /**
         * Capitalizes an underscored string.
         *
         * `"my_string"` becomes `"MyString"`.
         * @param {String} s The string to capitalize.
         * @return {String} Capitalized string or an empty string if `s` is undefined or null.
         */
        classify: function(s) {
            return this._classify(s, '_');
        },

        /**
         * Capitalizes a delimited string.
         *
         * `"my_string"` becomes `"MyString"`.
         * @param {String} s The string to capitalize.
         * @param {String} delimiter(optional) Delimiter string. Defaults to `'_'`.
         * @return {String} Capitalized string or an empty string if `s` is undefined or null.
         */
        _classify: function(s, delimiter) {
            var self = this, result = '';
            delimiter = delimiter || '_';

            if (!s || s.lastIndexOf(delimiter) === -1) {
                result = self.capitalize(s);
            } else {
                var words = s.split(delimiter);
                _.each(words, function(word) {
                    result += self.capitalize(word);
                });
            }
            return result;
        },

        /**
         * Extends a Class based on the given controller.
         *
         * If the controller has an `extendsFrom` property, it will be used to
         * define its parent class. It should be defined as a string in order
         * for the system to detect if there is any customization on that
         * parent (normally prefixed with `Custom` like `Custom<ClassName>`).
         *
         * If the parent class defined in the `extendsFrom` property doesn't
         * exist or the controller isn't specifying one, it will fallback to
         * the supplied `defaultBase` param which has it's own set of fallback
         * strategy defined by the components that call this method. See
         * {@link View.ViewManager} and {@link Data.DataManager}.
         *
         * @param {Object} cache Object cache to add controller to.
         * @param {Object} defaultBase Class to be extended from if no override
         *   (`extendsFrom`) is defined in the controller.
         * @param {string} className Class name to be used for new Class.
         * @param {Object|undefined} controller Properties for new Class.
         * @param {string} platformNamespace Platform name.
         * @return {Object} the new extended class.
         */
        extendClass: function(cache, defaultBase, className, controller, platformNamespace) {
            var klass;

            if (!_.isObject(controller)) {
                // nothing to extend from, use default
                klass = cache[className] = defaultBase;
                return klass;
            }

            if (_.isObject(controller.extendsFrom)) {
                //should be avoided due to chain breakage - aka custom fallback
                klass = cache[className] = controller.extendsFrom.extend(controller);
                return klass;
            }

            if (!controller.extendsFrom) {
                // follow the default fallback flow
                klass = cache[className] = defaultBase.extend(controller);
                return klass;
            }

            // try to find the base using the name and following the fallback flow
            var base = cache[platformNamespace + 'Custom' + controller.extendsFrom] ||
                cache[platformNamespace + controller.extendsFrom] ||
                cache['Custom' + controller.extendsFrom] ||
                cache[controller.extendsFrom];

            if (!base) {
                app.logger.warn('The "' + controller.extendsFrom + '" component was not found to be used as ' +
                    'the "' + className + '"\'s parent. Please update your code to point to an existing class.');
                base = defaultBase;
            }

            klass = cache[className] = base.extend(controller);
            return klass;
        },

        /**
         * Formats Numbers
         *
         * @param {Number} value number to be formatted eg 2.134
         * @param {Number} round number of digits to right of decimal to round at
         * @param {Number} precision number of digits to right of decimal to take precision at
         * @param {String} numberGroupSeparator character separator for number groups of 3 digits to the left of the decimal to add
         * @param {String} decimalSeparator character to replace decimal in arg number with
         * @return {String} formatted number string OR original value if it is not a number
         */
        formatNumber: function(value, round, precision, numberGroupSeparator, decimalSeparator) {
            round = round || precision;
            var original = value;
            if (_.isNaN(value) || !_.isFinite(value)) {
                return original;
            }
            if (_.isString(value)) {
                value = parseFloat(value, 10);
                if(_.isNaN(value)){
                    return original;
                }
            }
            // Return original value if it is not a number
            if(!_.isNumber(value)) {
                if(!_.isNull(value) && !_.isUndefined(value)) {
                    // invalid variable type
                    app.logger.warn('formatNumber: invalid variable type ('+typeof(original)+')');
                }
                return original;
            }

            // make sure that the precision variable is an integer and not a string
            // Big.js doesn't like it as a string
            if (_.isString(precision)) {
                precision = parseInt(precision);
            }
            
            value = Big(value).toFixed(precision);
            return (_.isString(numberGroupSeparator) && _.isString(decimalSeparator)) ?
                this.addNumberSeparators(value, numberGroupSeparator, decimalSeparator) : value;
        },

        /**
         * Format number to current user locale
         * @param {Number}  value
         * @return {String} formatted number
         */
        formatNumberLocale:function (value) {
            // use user locale, or decent defaults otherwise
            return this.formatNumber(
                value,
                app.user.getPreference('decimal_precision') || 2,
                app.user.getPreference('decimal_precision') || 2,
                app.user.getPreference('number_grouping_separator') || ',',
                app.user.getPreference('decimal_separator') || '.');
        },

        /**
         * Format full name with the provided locale format.
         * @param {Object} params Name property values.
         *        - first_name: first name.
         *        - last_name: last name.
         *        - salutation: salutation.
         * @param {String} format Locale format (i.e. [f l s], [s l, f]).
         * @return {String} formatted string.
         */
        formatName: function(params, format) {
            return format.replace(/(f)|(l)|(s)/g, function(str, firstName, lastName, salutation) {
                if (firstName) {
                    return params.first_name || '';
                }
                if (lastName) {
                    return params.last_name || '';
                }
                if (salutation && (params.last_name || params.first_name)) {
                    return params.salutation || '';
                }
                return '';
            })
                //Remove comma when last name is empty
                .replace(/^( )?,/g, '')
                //Remove comma when last name is provided but first name is empty
                .replace(/, $/g, '')
                //Remove extra spaces when middle part is missing
                .replace(/  /g, ' ')
                //trim spaces
                .trim();
        },

        /**
         * Format a record's name (ie. full name) according to the name format
         * passed in parameters or defined in the user preferences.
         *
         *     @example Format you can pass:
         *     'f l s' will output: `FirstName LastName Salutation`,
         *     's l, f' will output: `Salutation LastName FirstName`.
         *
         * The module defines a `nameFormat` object that maps a letter to a
         * field.
         *
         *     @example Name format mapping:
         *     {
         *         s: 'salutation',
         *         f: 'first_name',
         *         l: 'last_name'
         *     }
         *
         * There is a special case for enum type fields (e.g. `salutation`):
         * we need to pull the label from the app list strings.
         *
         * @param {String} module The module name the record belongs to.
         * @param {Object} data The record attributes.
         * @param {String} [format] The format definition.
         * @return {String} The formatted full name string.
         */
        formatNameModel: function(module, data, format) {
            format = format || app.user.getPreference('default_locale_name_format');
            data = data || {};

            var metadata = app.metadata.getModule(module) || {fields: {}};
            var formatMap = metadata.nameFormat || {};

            return _.reduce(format.split(''), function(formattedString, letter) {
                // only letters a-z may be significant in the format,
                // everything else is translated verbatim
                if (letter < 'a' || letter > 'z') {
                    return formattedString + letter;
                }
                if (!formatMap[letter]) {
                    return formattedString;
                }

                var enumLabel,
                    isEnum = metadata.fields[formatMap[letter]] &&
                        metadata.fields[formatMap[letter]].type === 'enum' &&
                        !_.isEmpty(metadata.fields[formatMap[letter]].options);

                if (isEnum) {
                    var list = app.lang.getAppListStrings(metadata.fields[formatMap[letter]].options);
                    enumLabel = list[data[formatMap[letter]]] || data[formatMap[letter]] || '';
                }

                return formattedString + (enumLabel || data[formatMap[letter]] || '');
            }, '')
                //Remove leading comma - i.e. ", John"
                .replace(/^( )?,/g, '')
                //Remove trailing comma - i.e., "John, ", "John,  ", etc.
                .replace(/, +$/g, '')
                //Remove extra spaces when middle part is missing
                .replace(/  /g, ' ')
                //trim spaces
                .trim();
        },

        /**
         * Format full name following user locale format.
         * @param {Object} params Name property values.
         *        - first_name: first name.
         *        - last_name: last name.
         *        - salutation: salutation.
         * @return {String} {String} formatted string.
         */
        formatNameLocale: function(params) {
            return this.formatName(params, app.user.getPreference('default_locale_name_format'));
        },

        /**
         * Adds number separators to a number string
         * @param {String} numberString string of number to be modified of the
         *   format nn.nnn
         * @param {String} numberGroupSeparator character separator for number
         *   groups of 3 digits to the left of the decimal to add
         * @param {String} decimalSeparator character to replace decimal in arg
         *   number with
         * @return {String}
         */
        addNumberSeparators: function(numberString, numberGroupSeparator, decimalSeparator) {
            var numberArray = numberString.split(".");
            var regex = /(\d+)(\d{3})/;
            while (numberGroupSeparator !== '' && regex.test(numberArray[0])) {
                numberArray[0] = numberArray[0].toString().replace(regex, '$1' + numberGroupSeparator + '$2');
            }
            return numberArray[0] + (numberArray.length > 1 &&
                numberArray[1] !== '' ? decimalSeparator + numberArray[1] : '');
        },

        /**
         * Unformats number strings
         * @param {String} numberString
         * @param {String} numberGroupSeparator
         * @param {String} decimalSeparator
         * @param {Boolean} toFloat
         * @return {String} formatted number string
         */
        unformatNumberString: function(numberString, numberGroupSeparator, decimalSeparator, toFloat) {
            toFloat = toFloat || false;
            if (typeof numberGroupSeparator === 'undefined' || typeof decimalSeparator === 'undefined') {
                return numberString;
            }

            // if number is not as string, make it a string
            if (!_.isString(numberString)) {
                if (_.isFinite(numberString)) {
                    // valid number, convert to string
                    numberString.toString();
                } else {
                    // invalid value: null, undefined, NaN, etc.
                    // set to empty string
                    numberString = '';
                }
            }

            // parse out number group separators
            if (numberGroupSeparator !== '') {
                var num_grp_sep_re = new RegExp('\\' + numberGroupSeparator, 'g');
                numberString = numberString.replace(num_grp_sep_re, '');
            }

            // parse out decimal separators
            numberString = numberString.replace(decimalSeparator, '.');

            // remove any invalid chars
            //numberString = numberString.replace(/[^0-9\.\+\-\%]/g, '');

            // convert to float
            if (numberString.length > 0 && toFloat) {
                var float = parseFloat(numberString);
                if (float == numberString) {
                    return float;
                }
            }

            return numberString;
        },

        /**
         * Unformat number string with user locale
         * @param {Number}  value
         * @param {Boolean} toFloat convert string to float value
         * @return {String} formatted value
         */
        unformatNumberStringLocale:function (value, toFloat) {
            return this.unformatNumberString(
                value,
                app.user.getPreference('number_grouping_separator') || ',',
                app.user.getPreference('decimal_separator') || '.',
                toFloat);
        },

        /**
         * This function will take a string that has tokens like {0}, {1} and will replace
         * those tokens with the args provided.
         * Based on format_string function from utils.php
         * @param {String} format String to format
         * @param {String} args Arguments to replace
         * @return {String} formatted string
         */
        formatString: function(format, args){
            for(var idx in args){
                format = format.replace('{'+idx+'}',args[idx]);
            }
            return format;
        },

        /**
         * This function will take a string and escape it for use in javascript regex.
         * @param {String} string the string to escape
         * @return {String} string escaped
         */
        regexEscape: function regexEscape(string) {
            if( typeof regexEscape.specialRegExp == 'undefined' ) {
                var specials = [
                    '/', '.', '*', '+', '?', '|',
                    '(', ')', '[', ']', '{', '}', '\\',
                    '-', ',', '^', '$', '#'
                ];
                regexEscape.specialRegExp = new RegExp(
                    '(\\' + specials.join('|\\') + ')', 'g'
                );
            }
            return string.replace(regexEscape.specialRegExp, '\\$1');
        },

        /**
         * Generates and returns a UUID
         * @return {string}
         */
        generateUUID: function() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                 /*jshint -W016 */ // "Unexpected use of '|'.",
                 /*jshint -W116 */ // "Expected '===' and instead saw '=='."
                 var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                 return v.toString(16);
            });
        },

        cookie: {
            /**
             * Sets a cookie
             * @param {String} cName cookie name
             * @param {String} value
             * @param {Number} exdays days until expiration
             * @param {String} path cookie path
             */
            setCookie: function(cName, value, exdays, path) {
                var exdate = new Date(), c_value;
                exdate.setDate(exdate.getDate() + exdays);
                c_value = encodeURIComponent(value);
                if (exdays) {
                    c_value += "; expires=" + exdate.toUTCString();
                }
                if (path) {
                    c_value += "; path=" + path;
                }
                document.cookie = cName + "=" + c_value;
            },

            /**
             * Gets a cookie
             * @param {String} cName
             * @return {String}
             */
            getCookie: function(cName) {
                var i, x, y, ARRcookies = document.cookie.split(";");
                for (i = 0; i < ARRcookies.length; i++) {
                    x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
                    y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
                    x = x.replace(/^\s+|\s+$/g, "");
                    if (x === cName) {
                        return decodeURIComponent(y);
                    }
                }
            }
        },

        /**
         * Checks if an email address is valid
         *
         * Only performs a very basic validation because the complexity of the
         * server-side regular expression is too great to mirror on the client,
         * both in terms of maintenance and difficulty in porting to a different
         * engine. Even if the light-weight validation passes, the server-side
         * validation may fail.
         * 
         * @param {String} address
         * @return {Boolean}
         */
        isValidEmailAddress: function(address) {
            return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@\S+$/.test(address);
        },

        /**
         *  Based on YUI onAvailible, but will use any boolean function instead of an ID.
         *  Once the given condition is met, the callback function will be executed.
         *
         * <pre><code>
         * // Execute a callback once an Object is defined
         * app.utils.doWhen("SUGAR.ObjectToWaitFor", function(){
         *     //Use the object here
         *     console.log(SUGAR.ObjectToWaitFor);
         * });
         *
         * // Use a function for condition and set paramters for the callback
         * var el = $("#myId");
         * var cond = function(){return el.hasClass("foo")};
         * var callback = function(params){this.log(params.msg); el.html(params.html);};
         * app.utils.doWhen(cond, callback, {msg:"Hello World", html:"&lt;h1&gt;Exists!&lt;/h1&gt;"}, console);
         * </code></pre>


         * @param {Function|string} condition function/evaluatable string which must return a boolean value.
         * @param {Function} callback function to execute when condition is met
         * @param {Object} [params] object to pass to the callback function
         * @param {Object} [scope] object to use as this when executing the callback
         */
        doWhen : function(condition, callback, params, scope){
            _doWhenStack.push({
                check:condition,
                fn:         callback,
                obj:        params,
                overrideContext:   scope
            });

            _doWhenretryCount = 50;
            _startDoWhenInterval();
        },
        /**
         *  The guts of doWhen. Runs through the stack checking all the conditions and fires the callbacks when the conditions are met.
         * @private
         */
        _doWhenCheck : function () {
            if (_doWhenStack.length === 0) {
                _doWhenretryCount = 0;
                if (_doWhenInterval) {
                     clearInterval(_doWhenInterval);
                    _doWhenInterval = null;
                }
                return;
            }

            if (_doWhenLocked) {
                return;
            }

            _doWhenLocked = true;

            // keep trying until after the page is loaded.  We need to
            // check the page load state prior to trying to bind the
            // elements so that we can be certain all elements have been
            // tested appropriately
            var tryAgain = $.isReady;
            if (!tryAgain) {
                tryAgain = (_doWhenretryCount > 0 && _doWhenStack.length > 0);
            }

            // onAvailable
            var notAvail = [];

            var executeItem = function (context, item) {
                if (item.overrideContext) {
                    if (item.overrideContext === true) {
                        context = item.obj;
                    } else {
                        context = item.overrideContext;
                    }
                }
                if (item.fn) {
                    item.fn.call(context, item.obj);
                }
            };

            var i, len, item, test;

            // onAvailable onContentReady
            for (i = 0, len = _doWhenStack.length; i < len; i = i + 1) {
                item = _doWhenStack[i];
                if (item) {
                    test = item.check;
                    if ((typeof(test) == 'string' &&
                         eval(test)) || // jshint ignore:line
                        (typeof(test) == 'function' && test())
                    ) {
                        executeItem(this, item);
                        _doWhenStack[i] = null;
                    }
                    else {
                        notAvail.push(item);
                    }
                }
            }

            _doWhenretryCount--;

            if (tryAgain) {
                for (i = _doWhenStack.length - 1; i > -1; i--) {
                    item = _doWhenStack[i];
                    if (!item || !item.check) {
                        _doWhenStack.splice(i, 1);
                    }
                }
                _startDoWhenInterval();
            } else {
                if (_doWhenInterval) {
                    clearInterval(_doWhenInterval);
                    _doWhenInterval = null;
                }
            }
            _doWhenLocked = false;
        },

        /**
         * Compares two version strings.
         *
         *     app.utils.versionCompare('8.2.5rc', '8.2.5a') === 1
         *     app.utils.versionCompare('8.2.50', '8.2.52', '<') === true
         *     app.utils.versionCompare('5.3.0-dev', '5.3.0') === -1
         *     app.utils.versionCompare('4.1.0.52','4.01.0.51') === 1
         *
         * @param {string} v1 First version.
         * @param {string} v2 Second version.
         * @param {string} [operator] Operator argument, if specified, test for
         *   a particular relationship. The possible operators are:
         *   `<`, `lt`, `<=`, `le`, `>`, `gt`, `>=`, `ge`, `==`, `=`, `eq`,
         *   `!=`, `<>`, and `ne`.
         *   This parameter is case-sensitive, values should be lowercase.
         *
         * @return {number|boolean} By default, returns -1 if the first version
         *   is lower than the second, 0 if they are equal, and 1 if the second
         *   is lower. When using the optional operator argument, the function
         *   will return `true` if the relationship is the one specified by the
         *   operator, `false` otherwise.
         */
        versionCompare: function(v1, v2, operator) {
            // Use php.js implementation
            // http://phpjs.org/functions/version_compare/
            return version_compare(v1, v2, operator);
        },

        extendFrom : function(subc, superc, overrides) {
            subc.prototype = new superc(); // set the superclass
            // overrides
            _.extend(subc.prototype, overrides);
        },

        /**
         * Creates a deep clone of an object.
         * @param {Mixed} obj
         * @return {Mixed} Returns a value of the same type as the input.
         */
        deepCopy: function(obj) {
            return _.isObject(obj) ? JSON.parse(JSON.stringify(obj)) : obj;
        },

        /**
         * Compare field values in the first bean with the second bean and return the field names
         * that have different values.
         * @param {Bean} beanA
         * @param {Bean} beanB
         * @return {Array}
         */
        compareBeans: function(beanA, beanB) {
            var changedFields;

            if (beanA.module !== beanB.module) {
                throw Error('Only beans of the same module can be compared.');
            }

            changedFields = _.reduce(beanA.attributes, function(memo, value, attribute) {
                // skip id field and all fields that start with an underscore
                if ((attribute !== 'id') && (attribute.indexOf('_') !== 0)) {
                    if (
                        !this.areBeanValuesEqual(value, beanB.get(attribute)) &&
                            this.hasDefaultValueChanged(attribute, beanA)
                        ) {
                        memo.push(attribute);
                    }
                }

                return memo;
            }, [], this);

            return changedFields;
        },

        /**
         * Checks to see if values in beans are equal to each other.
         * @param {Mixed} value1
         * @param {Mixed} value2
         * @return {boolean}
         */
        areBeanValuesEqual: function(value1, value2) {
            var getValueToCompare = function(value) {
                if (_.isObject(value) && _.isEmpty(value)) {
                    return '';
                } else if (!_.isObject(value) && (_.isUndefined(value) || _.isNull(value))) {
                    return '';
                } else {
                    return value;
                }
            };

            value1 = getValueToCompare(value1);
            value2 = getValueToCompare(value2);

            return ((_.isObject(value1) && _.isEqual(value1, value2)) || (!_.isObject(value1) && (value1 === value2)));
        },

        /**
         * Checks to see if the default value has changed.
         * @param {string} attribute
         * @param {Data.Bean} bean
         * @return {boolean}
         */
        hasDefaultValueChanged: function(attribute, bean) {
            var defaultValue = bean._defaults ? bean._defaults[attribute] : '';
            return !this.areBeanValuesEqual(defaultValue, bean.get(attribute));
        },

        /**
         * Checks if the AJAX error is a network connectivity error: timeout, DNS, etc.
         *
         * @param ajaxError AJAX error.
         * @returns {Boolean} true if the error is a network error.
         */
        isConnectivityError: function(ajaxError) {
            // There can be situations when the status is not zero but the actual request times out.
            return ((ajaxError.status === 0) ||
                    (ajaxError.textStatus === "timeout"));
        },

        /**
         * Returns ISO8601 timestamp in UTC time
         * @param {String|Number} [dateValue] Date string or raw msec number
         * @param {Object} [options]
         * @returns {String} Passed date or current date converted to UTC timezone
         */
        getTimestamp: function(dateValue, options) {
            options = options || {};
            var date = dateValue ? new Date(dateValue) : new Date(),
                dateString = date.toISOString();

            if (!options.msecPrecision) {
                dateString = dateString.replace(/\.\d{3}/, '');
            }

            //Z is replaced with +00:00 for unification with server
            return dateString.replace(/Z/, '+00:00');
        },

        /**
         * Builds a good url based on `siteUrl` from configuration.
         *
         * It is ready for the several use cases that `siteUrl` can have:
         *
         * - relative path (aka context);
         * - full path;
         * - empty path.
         *
         * @param {string} url the full url or a relative url without the prepended `/`.
         * @return {string}
         */
        buildUrl: function(url) {
            // Adjust relative URL: prepend it with site URL
            if (url.indexOf("http") !== 0 && !_.isEmpty(app.config.siteUrl)) {
                // Strip trailing forward slashes from site URL just in case
                url = app.config.siteUrl.replace(/\/+$/, "") + "/" + url;
            }
            return url;
        },

        /**

         * Get diff between `data1` and `data2`.
         * Note: this function is targeted to compare objects with the same properties.
         * @param {Object} data1 Changed object
         * @param {Object} data2 Original object
         * @param {Boolean} [strict=false] By default values are compared property by property via non-strict comparison.
         * @returns {Object} Hash of fields from `data1` which are different from `data2`
         */
        getChangedProps: function (data1, data2, strict) {

            function getType (value) {
                if (_.isObject(value)) {
                    if (_.isArray(value)) {
                        return 'array';
                    }
                    return 'object';
                }
                return 'other';
            }

            function isEqualProp (value1, value2) {

                if (strict) return _.isEqual(value1, value2);

                var value1Type = getType(value1),
                    value2Type = getType(value2);

                if (value1Type === value2Type && _.contains(['object', 'array'], value1Type)) {
                    if (value1Type === 'array' && value1.length !== value2.length) {
                        return false;
                    }
                    
                    var keys1 = _.keys(value1),
                        keys2 = _.keys(value2);

                    if (keys1.length !== keys2.length || !_.isEqual(keys1.sort(), keys2.sort())) {
                        return false;
                    }

                    return !_.any(value1, function (val, key) {
                        return !isEqualProp(value1[key], value2[key]);
                    });
                }
                else {
                    return strict ? (value1 === value2) : (value1 == value2);
                }
            }


            var diff = {};

            _.each(data1, function (value, key) {
                if (!isEqualProp(data1[key], data2[key])) {
                    diff[key] = value;
                }
            });

            return diff;
        },

        /**
         * Get the layout container for the given component.
         * @param {View.Component} component
         * @return {View.Layout}
         */
        getParentLayout: function(component) {
            var parent;

            if (component.view && component.view.layout) {
                parent = component.view.layout;
            } else {
                parent = component.layout;
            }

            return parent;
        },

        isSortable: function(module, fieldViewdef) {
            var fieldVardef = app.metadata.getModule(module).fields[fieldViewdef.name],
                isSortable = true;

            if (fieldVardef && !_.isUndefined(fieldVardef.sortable)) {
                isSortable = fieldVardef.sortable;
            }
            if (fieldViewdef && !_.isUndefined(fieldViewdef.sortable)) {
                isSortable = fieldViewdef.sortable;
            }
            return isSortable;
        },

        /**
         * Returns url without hypertext http(s):// prefix
         * @param {String} url - input url
         * @returns {String} - url without http(s):// prefix
         */
        stripHttpPrefix: function (url) {
            return url.replace(/^https?:\/\//, '');
        },        
    
        hardRefresh: function() {
            window.location.reload(true);
        },

        /**
         * Checks if the value should be rendered in RTL.
         *
         * @param {string} value The value to check.
         * @return {boolean} `true` if the string is in a RTL language.
         */
        isDirectionRTL: function(value) {
            var ltrChars = 'A-Za-z\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02B8\u0300-\u0590\u0800-\u1FFF' +
                    '\u2C00-\uFB1C\uFDFE-\uFE6F\uFEFD-\uFFFF',
                rtlChars = '\u0591-\u07FF\uFB1D-\uFDFD\uFE70-\uFEFC',
                isRTL = new RegExp('^[^' + ltrChars + ']*[' + rtlChars + ']');

            return isRTL.test(value);
        }

    });
})(SUGAR.App);
