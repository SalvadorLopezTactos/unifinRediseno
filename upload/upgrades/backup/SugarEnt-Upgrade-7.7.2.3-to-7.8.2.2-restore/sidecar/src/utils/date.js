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
(function(app) {

    /**
     * This class extends from moment.js and tries to provide a compatibility
     * layer with old/previous code.
     *
     * @class Utils.Date
     * @alias SUGAR.App.date
     * @singleton
     */
    var date = moment;

    _.extend(date, {

        /**
         * Exception to be used when an invalid date/time is passed.
         *
         * @param {String} message The error message.
         * @param {String} date The date that is invalid.
         * @constructor
         */
        InvalidException: function(message, date) {
            this.name = 'InvalidException';
            this.message = message;
            this.date = date;
        },

        /**
         * Cached formats of converted date/time formats from server to client.
         *
         * This cache is populated by {@link #convertFormat}
         *
         * @type {Object}
         * @private
         */
        _cachedFormats: {},

        /**
         * Server date format according to momentjs.
         * This is exactly the same as the server is expecting `Y-m-d`.
         *
         * @type {String}
         * @private
         */
        _serverDateFormat: 'YYYY-MM-DD',

        /**
         * Convert PHP date/time format preference to JS.
         *
         * Momentjs uses a different formatting tokens:
         * {@link http://momentjs.com/docs/#/parsing/string-format/}
         *
         * Known possible values to convert (out of the box):
         *
         * ```
         * // dates
         * 'Y-m-d'
         * 'd-m-Y'
         * 'm-d-Y'
         * 'Y/m/d'
         * 'd/m/Y'
         * 'm/d/Y'
         * 'Y.m.d'
         * 'd.m.Y'
         * 'm.d.Y'
         *
         * // time
         * 'H:i'
         * 'h:ia'
         * 'h:iA'
         * 'H.i'
         * 'h.ia'
         * 'h.iA'
         * ```
         *
         * @param {String} server The server format preference to convert.
         * @return {String} The converted format that momentjs understands.
         * @private
         *
         */
        convertFormat: function(server) {

            if (date._cachedFormats[server]) {
                return date._cachedFormats[server];
            }

            var convertTable = {
                // date
                'd': 'DD',  // day of the month w\ leading zeros
                'm': 'MM',  // numeric month w\ leading zeros
                'Y': 'YYYY',  // full numeric year
                // time
                'H': 'HH', // 24-hour format w\ leading zeros
                'h': 'hh', // 12-hour format w\ leading zeros
                'i': 'mm' // minutes w\ leading zeros
            };

            var client = server;
            _.each(convertTable, function(to, from) {
                client = client.replace(from, to);
            });
            date._cachedFormats[server] = client;
            return client;
        },

        /**
         * Compares two dates and returns an integer that is great for sorting.
         *
         * @param {String} date1 The first date to compare.
         * @param {String} date2 The second date to compare.
         * @return {Number} Returns `-1`, `0` or `1` based on:
         * - `-1` if date1 < date2
         * - `0` if date1 = date2
         * - `1` if date1 > date2
         *
         * @throws {Error} if any of the given dates are invalid.
         */
        compare: function(date1, date2) {
            var mDate1 = moment(date1),
                mDate2 = moment(date2);

            if (!mDate1.isValid()) {
                throw new date.InvalidException('Invalid date passed for comparison.', date1);
            }
            if (!mDate2.isValid()) {
                throw new date.InvalidException('Invalid date passed for comparison.', date2);
            }

            if (mDate1.isBefore(mDate2)) {
                return -1;
            }
            if (mDate1.isAfter(mDate2)) {
                return 1;
            }
            return 0;
        },

        /**
         * Get the date format preference for the given user.
         * @param {Data.Bean/Object} user
         * @return {string}
         */
        getUserDateFormat: function(user) {
            user = user || app.user;
            return this.convertFormat(user.getPreference('datepref'));
        },

        /**
         * Get the time format preference for the given user.
         * @param {Data.Bean/Object} user
         * @return {string}
         */
        getUserTimeFormat: function(user) {
            user = user || app.user;
            return this.convertFormat(user.getPreference('timepref'));
        }

    });

    /**
     * @deprecated since 7.2.0. Convert your code to new date functionality.
     * @private
     */
    var _formatStringCache = {}; // hash table of the datetime formats that have already been parsed

    /**
     * Deprecated functionality will be kept in the old singleton prototype.
     * @deprecated since 7.2.0. Convert your code to new date functionality.
     */
    _.extend(date, {
        /**
         * Parses date strings into js Date()s
         * @param {String} date date string
         * @param {String} oldFormat date format string. If not specified parse will guess the date format
         * @return {Date} javascript date object
         */
        parse: function(date, oldFormat) {
            var jsDate     = new Date("Jan 1, 1970 00:00:00"),
                part       = "",
                dateRemain, j, c, i, v, timeformat;

            //if already a Date return it
            if (date instanceof Date) return date;

            // TODO add user prefs support

            if (!oldFormat) {
                oldFormat = this.guessFormat(date);
            }

            if (oldFormat === false) {
                //Check if date is a timestamp
                if (/^\d+$/.test(date)) {
                    return new Date(date);
                }

                //we cant figure out the format so return false
                return false;
            }

            dateRemain = $.trim(date);
            oldFormat = $.trim(oldFormat) + " "; // Trailing space to read as last separator.
            for (j = 0; j < oldFormat.length; j++) {
                c = oldFormat.charAt(j);
                if (c === ':' || c === '/' || c === '-' || c === '.' || c === " " || c === 'a' || c === "A") {
                    i = dateRemain.indexOf(c);
                    if (i === -1) i = dateRemain.length;
                    v = dateRemain.substring(0, i);
                    dateRemain = dateRemain.substring(i + 1);
                    switch (part) {
                        case 'm':
                            if (!(v > 0 && v < 13)) return false;
                            jsDate.setMonth(v - 1);
                            break;
                        case 'd':
                            if (!(v > 0 && v < 32)) return false;
                            jsDate.setDate(v);
                            break;
                        case 'Y':
                            if (v > 0 === false) return false;
                            jsDate.setYear(v);
                            break;
                        case 'h':
                            //Read time, assume minutes are at end of date string (we do not accept seconds)
                            timeformat = oldFormat.substring(oldFormat.length - 4);
                            v = parseInt(v, 10);
                            var timeFormatString = $.trim(timeformat.toLowerCase());
                            if (timeFormatString === "i a" || timeFormatString === c + "ia") {
                                var postfix = dateRemain.substring(dateRemain.length - 2).toLowerCase();
                                if (postfix === 'pm') {
                                    if (v < 12) {
                                        v += 12;
                                    }
                                }
                                // 12:00am => 00:00:00
                                else if (postfix === 'am' && v === 12) {
                                    v = 0;
                                }
                            }
                            jsDate.setHours(v);
                            break;
                        case 'H':
                            jsDate.setHours(v);
                            break;
                        case 'i':
                            v = v.substring(0, 2);
                            jsDate.setMinutes(v);
                            break;
                        case 's':
                            jsDate.setSeconds(v);
                            break;
                    }
                    part = "";
                } else {
                    part = c;
                }
            }
            return jsDate;
        },

        /**
         * Guesses format of a date string.
         * @param {String} date Date string
         * @return {String} Date format.
         */
        guessFormat: function(date) {
            if (typeof date !== "string")
                return false;
            //Is there a time
            var time = "", dateSep, dateParts, dateFormat, timeFormat, timeParts,
                timeSep, ampmCase, timeEnd;

            if (date.indexOf(" ") !== -1) {
                time = date.substring(date.indexOf(" ") + 1, date.length);
                date = date.substring(0, date.indexOf(" "));
            }

            //First detect if the date contains "-" or "/"
            dateSep = "/";
            if (date.indexOf("/") !== -1) {
            }
            else if (date.indexOf("-") !== -1) {
                dateSep = "-";
            }
            else if (date.indexOf(".") !== -1) {
                dateSep = ".";
            }
            else {
                return false;
            }

            dateParts = date.split(dateSep);
            dateFormat = "";

            if (dateParts[0].length === 4) {
                dateFormat = "Y" + dateSep + "m" + dateSep + "d";
            }
            else if (dateParts[2].length === 4) {
                dateFormat = "m" + dateSep + "d" + dateSep + "Y";
            }
            else {
                return false;
            }

            timeFormat = "";
            timeParts = [];

            // Check for time
            if (time !== "") {

                // start at the i, we always have minutes
                timeParts.push("i");

                timeSep = ":";

                if (time.indexOf(".") === 2) {
                    timeSep = ".";
                }

                // if its long we have seconds
                if (time.split(timeSep).length === 3) {
                    timeParts.push("s");
                }
                ampmCase = '';

                // check for am/pm
                timeEnd = time.substring(time.length - 2, time.length);
                if (timeEnd.toLowerCase() === "am" || timeEnd.toLowerCase() === "pm") {
                    timeParts.unshift("h");
                    if (timeEnd.toLowerCase() === timeEnd) {
                        ampmCase = 'lower';
                    } else {
                        ampmCase = 'upper';
                    }
                } else {
                    timeParts.unshift("H");
                }

                timeFormat = timeParts.join(timeSep);

                // check for space between am/pm and time
                if (time.indexOf(" ") !== -1) {
                    timeFormat += " ";
                }

                // deal with upper and lowercase am pm
                if (ampmCase && ampmCase === 'upper') {
                    timeFormat += "A";
                } else if (ampmCase && ampmCase === 'lower') {
                    timeFormat += "a";
                }

                dateFormat = dateFormat + " " + timeFormat;
            }

            return dateFormat;
        },

        /**
         * Parse a date format string into each of it's individual representations. Supports
         * only the options that are supported by the date.format function.
         *
         * @param {String} format   date format string such as "Y-m-d H:i:s"
         * @return {Object} object with properties representing each piece of a format
         */
        parseFormat: function(format) {
            // if this format has been seen before then don't bother parsing it again
            if (!(format in _formatStringCache)) {
                var parts = {},
                    i,
                    c;

                for (i = 0; i < format.length; i++) {
                    c = format.charAt(i);
                    switch (c) {
                        case 'm':
                        case 'n':
                            parts.month = c;
                            break;
                        case 'd':
                        case 'j':
                            parts.day = c;
                            break;
                        case 'Y':
                            parts.year = c;
                            break;
                        case 'H':
                        case 'h':
                        case 'g':
                            parts.hours = c;
                            break;
                        case 'i':
                            parts.minutes = c;
                            break;
                        case 's':
                            parts.seconds = c;
                            break;
                        case 'A':
                        case 'a':
                            parts.amPm = c;
                            break;
                        default:
                            break;
                    }
                }

                // cache the result so it doesn't have to be parsed again
                _formatStringCache[format] = parts;
            }

            return _formatStringCache[format];
        },

        /**
         * Formats javascript date objects into date strings
         * @param {Date} date
         * @param {String} format date format string such as "Y-m-d H:i:s"
         * @return {String} formatted date string
         */
        format: function(date, format) {
            if (!_.isDate(date)) return "";
            // TODO: add support for userPrefs
            var out = "", i, c, d, h, m, s;
            for (i = 0; i < format.length; i++) {
                c = format.charAt(i);
                switch (c) {
                    case '\\':
                        out += format.charAt(i+1);
                        // skip next character
                        i++;
                        break;
                    case 'm':
                    case 'n':
                        m = date.getMonth() + 1;
                        out += (m < 10 && c === "m") ? "0" + m : m;
                        break;
                    case 'd':
                    case 'j':
                        d = date.getDate();
                        out += (d < 10 && c === "d") ? "0" + d : d;
                        break;
                    case 'Y':
                        out += date.getFullYear();
                        break;
                    case 'H':
                    case 'h':
                    case 'g':
                        h = date.getHours();
                        if (c === "h" || c === "g") {
                            h = h > 12 ? h - 12 : h;
                            //Convert 0 to 12 for 12 hour formats
                            h = h === 0 ? 12 : h;
                        }
                        out += (h < 10 && c !== "g") ? "0" + h : h;
                        break;
                    case 'i':
                        m = date.getMinutes();
                        out += m < 10 ? "0" + m : m;
                        break;
                    case 's':
                        s = date.getSeconds();
                        out += s < 10 ? "0" + s : s;
                        break;
                    case 'a':
                    case 'A':
                        if (date.getHours() < 12)
                            out += (c === "a") ? "am" : "AM";
                        else
                            out += (c === "a") ? "pm" : "PM";
                        break;
                    default :
                        out += c;
                }
            }
            return out;
        },

        /**
         * Rounds a date to the nearest 15 minutes.
         * @param {Date} date A date to round.
         * @return {Date} Rounded date.
         */
        roundTime: function(date) {
            if (!date.getMinutes) return 0;
            var min = date.getMinutes();

            if (min < 1) {
                min = 0;
            }
            else if (min < 16) {
                min = 15;
            }
            else if (min < 31) {
                min = 30;
            }
            else if (min < 46) {
                min = 45;
            }
            else {
                min = 0;
                date.setHours(date.getHours() + 1);
            }

            date.setMinutes(min);

            return date;
        },

        /**
         * Converts a UTC date to a local time date
         * @param {Date} date a UTC date.
         * @return {Date} Date converted to local date.
         * @method
         */
        UTCtoLocalTime: function(date) {
            //if not a Date return it
            if (!(date instanceof Date)) return date;

            // Push the UTC tag to convert the date into local date
            return new Date(this.toUTC(date));
        },

        /**
         * Converts a UTC date to a date in the timezone represented by the offset.
         *
         * @param {Date} date  A UTC date.
         * @param {Number} offset  The timezone's UTC offset in hours.
         * @return {Date} Converted date.
         * @method
         */
        UTCtoTimezone: function(date, offset) {
            // if date is not a Date or there is no offset then return date
            if (!(date instanceof Date) || undefined === offset || null === offset) {
                return date;
            }

            // convert the offset to milliseconds
            // parseFloat is used to guarantee that offset is numerical before converting it
            offset = parseFloat(offset) * 60 * 60 * 1000;

            // the offset really needs to be the difference between the local time offset and the user's
            // preferred offset since javascript always represents dates in local time
            // javascript uses +7 hours while the api uses -7 hours to represent the same timezone offset,
            // so the javascript offset must be negated
            offset -= date.getTimezoneOffset() * 60 * 1000 * -1;

            return new Date(this.toUTC(date) + offset);
        },

        /**
         * Converts the date from local to UTC. Even though the date on the server is UTC,
         * JavaScript represents the date according to the local timezone. Use this function
         * to get the time value of the real UTC date, ignoring the timezone JavaScript
         * imposes on the date object.
         *
         * @param {Date} date a UTC date
         * @return {Number}  the number of milliseconds between universal time and date
         */
        toUTC: function(date) {
            //if not a Date return it
            if (!(date instanceof Date)) {
                return date;
            }

            var year = date.getFullYear(),
                month = date.getMonth(),
                day = date.getDate(),
                hours = date.getHours(),
                minutes = date.getMinutes(),
                seconds = date.getSeconds(),
                milliseconds = date.getMilliseconds();

            return Date.UTC(year, month, day, hours, minutes, seconds, milliseconds);
        },

        /**
         * Converts a date object into a relative time.
         * @param {Date} date
         * @return {Object} object containing relative time key string and value to push to the template
         */
        getRelativeTimeLabel: function(date) {
            var rightNow = new Date();
            var isFuture = rightNow.getTime() < date.getTime();
            //If incoming date is future we want to flip the calculation
            var diff = isFuture ? date - rightNow : rightNow - date;
            var second = 1000,
                minute = second * 60,
                hour = minute * 60,
                day = hour * 24,
                ctx = { str : "", value: undefined};

            if (isNaN(diff) || diff < 0) {
                return ctx; // return blank string if unknown
            }
            if (diff < second * 2) {
                // within 2 seconds
                ctx.str = 'LBL_TIME_AGO_NOW';
                return ctx;
            }

            if (diff < minute) {
                ctx.str = isFuture ? 'LBL_TIME_UNTIL_SECONDS' : 'LBL_TIME_AGO_SECONDS';
                ctx.value = Math.floor(diff / second);
                return ctx;
            }
            if (diff < minute * 2) {
                ctx.str = isFuture ? 'LBL_TIME_UNTIL_MINUTE' : 'LBL_TIME_AGO_MINUTE';
                return ctx;
            }
            if (diff < hour) {
                ctx.str = isFuture ? 'LBL_TIME_UNTIL_MINUTES' : 'LBL_TIME_AGO_MINUTES';
                ctx.value = Math.floor(diff / minute);
                return ctx;
            }
            if (diff < hour * 2) {
                ctx.str = isFuture ? 'LBL_TIME_UNTIL_HOUR' : 'LBL_TIME_AGO_HOUR';
                return ctx;
            }
            if (diff < day) {
                ctx.str = isFuture ? 'LBL_TIME_UNTIL_HOURS' : 'LBL_TIME_AGO_HOURS';
                ctx.value = Math.floor(diff / hour);
                return ctx;
            }
            if (diff > day && diff < day * 2) {
                ctx.str = isFuture ? 'LBL_TIME_UNTIL_DAY' : 'LBL_TIME_AGO_DAY';
                return ctx;
            }
            if (diff < day * 365) {
                ctx.str = isFuture ? 'LBL_TIME_UNTIL_DAYS' : 'LBL_TIME_AGO_DAYS';
                ctx.value = Math.floor(diff / day);
                return ctx;
            }
            else {
                ctx.str = isFuture ? 'LBL_TIME_UNTIL_YEAR' : 'LBL_TIME_AGO_YEAR';
                return ctx;
            }
        },

        /**
         * Parses display_default property which server returns for datetimecombo meta, etc. (for example,
         * if the user sets the default in Studio). The following are possibilities:
         * +1 day&06:00pm
         * -1 day&06:00pm
         * +1 week&06:00pm
         * +1 month&06:00pm
         * +1 year&06:00pm
         * now&06:00pm
         * next monday&06:00pm
         * next friday&06:00pm
         * first of next month@06:00pm
         *
         * @param {String} displayDefault
         * @param {Date} now An optional date to use as a point of reference (since we essentially convert
         * "+1 day", etc., to an adjusted date). This is mainly for testing odd dates like adding a month
         * specifically to January 31, etc. If not passed, current date will be used.
         * @return {String} String rep which can subsequently be used by later used for date.parse
         * e.g. "2012-08-09 00:30am"
         */
        parseDisplayDefault: function(displayDefault, now) {
            var dateMap, d, dt, humanDate, defaultTime, addMonths, next, setTimePart,
                dateObj = now ? now : new Date(), op, timeAway, parts, timeParts;

            if(!displayDefault) return displayDefault;

            // This adds months from 'd' date passed in. 'n' is the number of months to add.
            // Of course, you can use a negative sign to subtract months.
            addMonths = function(d, n) {
                var day = d.getDate();
                d.setMonth(d.getMonth()+n);
                if (d.getDate() < day) {
                    d.setDate(1);
                    d.setDate(d.getDate()-1);
                }
                return d;
            };

            // Helper to return the number of days from now to 'day' (see dateObj initialization above)
            next = function(day) {
                var days, todayDay, i, daysUntilNext;
                days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
                todayDay = dateObj.getDay();
                day = day.toLowerCase();

                for (var i = 7; i--;) {
                    if (day === days[i]) {
                        day = (i <= todayDay) ? (i + 7) : i;
                        break;
                    }
                }
                daysUntilNext = day - todayDay;
                return daysUntilNext;
            };

            // Maps keys with functions that converts human date as appropriate per key (e.g. +1 day, etc.)
            dateMap = {
                day: function(operator) {
                    return new Date(dateObj.setDate(dateObj.getDate() + operator));
                },
                week: function(operator) {
                    return new Date(dateObj.setDate(dateObj.getDate() + (operator*7) ))
                },
                month: function(operator) {
                    return addMonths(dateObj, operator);
                },
                year: function(operator) {
                    return addMonths(dateObj, (operator*12));
                },
                'now': function() { return dateObj; },
                'next monday': function() {
                    return new Date(dateObj.setDate(dateObj.getDate() + next("monday")));
                },
                'next friday': function() {
                    return new Date(dateObj.setDate(dateObj.getDate() + next("friday")));
                },
                'first of next month': function() {
                    // First set date to first day of "this month" so we don't have a potential
                    // date overrun (e.g. today's Oct 31 and we +1 month but no Nov 31 so Dec 1!)
                    dateObj.setDate(1);
                    // Now it's safe to add +1 months
                    var sinceEpoch = dateObj.setMonth(dateObj.getMonth() + 1);
                    return new Date(sinceEpoch);
                }
            };

            // Main entry point - parses displayDefault and calls correspondingly
            // mapped function to resolve to suitable date string for date.parse
            if(displayDefault && displayDefault.indexOf('&') >= 0) {
                dt = displayDefault.split("&"); //e.g. +1 day&06:00pm
                humanDate = dt[0];
                defaultTime = dt[1];
            } else {
                humanDate = displayDefault; // assume no time part e.g. for type date
            }

            if(humanDate.match(/\b(now|day|week|month|year)/g)) {
                if(humanDate.indexOf('now') === 0) {
                    timeAway = 'now';
                } else if(humanDate.indexOf("first day of next month") !== -1) {
                    timeAway = 'firstnextmonth';
                } else {
                    parts = humanDate.split(' ');
                    op = parts[0];
                    timeAway = parts[1];
                }
                if(timeAway.match('now')) {
                    d = dateMap.now();
                }
                else if(timeAway.match('firstnextmonth')) {
                    d = dateMap['first of next month']();
                }
                else if(timeAway.match('days?')) {
                    d = dateMap.day(parseInt(op, 10));
                }
                else if(timeAway.match('weeks?')) {
                    d = dateMap.week(parseInt(op, 10));
                }
                else if(timeAway.match('months?')) {
                    d = dateMap.month(parseInt(op, 10));
                }
                else if(timeAway.match('years?')) {
                    d = dateMap.year(parseInt(op, 10));
                }
                else {
                    if (!dateMap[humanDate]) {
                        return;
                    }
                    // TODO Better to log error???
                    d = dateMap[humanDate]();
                }
            } else {
                if (!dateMap[humanDate]) {
                    return;
                }
                d = dateMap[humanDate]();
            }

            setTimePart = (function(d) {
                var timeParts, hours, minutes;

                //Fixes bug SP-1280: Turns out hours in displayDefault can be either of single/double digits
                timeParts = /^(\d\d?).(\d{2}).?([ap]m)?$/.exec(defaultTime);
                if (timeParts && timeParts.length > 2) {
                    hours = timeParts[1];

                    if (hours) {

                        if (timeParts[3] === 'pm') {
                            if (hours < 12) {
                                hours = (parseInt(hours, 10) + 12);
                            }
                        } else {

                            // Set 12am to 00
                            if (hours === '12') {
                                hours = '0';
                            }
                        }

                        d.setHours(parseInt(hours, 10));
                    }

                    minutes = timeParts[2];
                    if (minutes) {
                        d.setMinutes(parseInt(minutes, 10));
                    }
                }
            }(d));

            return d;
        },

        /**
         * SugarCRM has date formats using Y, m, d format characters. However, given our stylgeguide is now using the bootstrap
         * datepicker, we need to remap those to it's format. For example: Y==yyyy, m==mm, and d==dd
         * @param {String} formatSpec The original SugarCRM (PHP) date format.
         * @return {String} Format spec passed in normalized to that expected by the bootstrap datepicker widget. If falsy,
         * returns empty string.
         */
        toDatepickerFormat: function(formatSpec) {
            if(_.isUndefined(formatSpec) || !formatSpec) return '';
            var normalizedFormatSpec,
                sugarToDatepickerMap = {
                    'y': 'yy',
                    'Y': 'yyyy',
                    'm': 'mm',
                    'd': 'dd'
                };
            normalizedFormatSpec = formatSpec.replace(/[yYmd]/g, function(s) {
                return sugarToDatepickerMap[s];
            });
            return normalizedFormatSpec;
        },
        /**
        * Strips out the 'T' and, either the 'Z' or +00:00 by, essentially, taking just the first 19 characters
        * @param  {String} value The value
        * @return {String} stripped value
        */
        stripIsoTimeDelimterAndTZ: function(value) {
            if(!_.isUndefined(value) && value) {
                // Since s.replace('T', ' ').replace('Z','') assumes we have Z it's better to do:
                // str.replace('T', ' ').substr(0, 19) ... which works for both of following formats:
                // '2012-11-07T04:28:52+00:00'.replace('T', ' ').substr(0, 19)
                // "2012-11-06 20:00:06.651Z".replace('T', ' ').substring(0, 19)
                return value.replace("T", " ").substr(0, 19);
            }
        },
        /**
        * Determines if date string is iso 8601'like ;)
        * @param  {String} val The date string value to check
        * @return {Boolean} True if is REST API / ISO 8601 compatible formatted date value.
        */
        isIso: function(val) {
            var yyyymmddExact,
                    yyyymmddLooseMatch;

            // First match most nominal case yyyy-mm-dd
            yyyymmddExact = val.match(/^([0-9]{4})-?(1[0-2]|0[1-9])-?(3[0-1]|0[1-9]|[1-2][0-9])$/);
            if (yyyymmddExact) {
                return true;
            }
            // If we have any of the iso 8601 chars and still starts with yyyy-mm-dd
            if (val.match(/[T\+Z ]/g)) {
                yyyymmddLooseMatch = val.match(/^([0-9]{4})-?(1[0-2]|0[1-9])-?(3[0-1]|0[1-9]|[1-2][0-9])/);
                if (yyyymmddLooseMatch) return true;
            }
            return false;
        },

        /**
         * Same behavior of {@link Utils.Date#compare}.
         *
         * @deprecated 7.2 and will be removed on 7.5. Use {@link Utils.Date#compare} instead.
         */
        compareDates: function(date1, date2) {
            app.logger.warn('date.compareDates() was called and is deprecated. ' +
                'Please update code to use date.compare()');

            return date.compare(date1, date2);
        },

        /**
         * @param {String} date1
         * @param {String} date2
         * @return {Boolean}
         *
         * @deprecated 7.2 and will be removed on 7.5. Use {@link date#isAfter} instead.
         */
        isDateAfter: function(date1, date2) {
            app.logger.warn('date.isDateAfter() was called and is deprecated. ' +
                'Please update code to use date(date1).isAfter(date2)');
            return date(date1).isAfter(date2);
        },

        /**
         * @param {String} date1
         * @param {String} date2
         * @return {Boolean}
         *
         * @deprecated 7.2 and will be removed on 7.5. Use {@link date#isBefore} instead.
         */
        isDateBefore: function(date1, date2) {
            app.logger.warn('date.isDateBefore() was called and is deprecated. ' +
                'Please update code to use date(date1).isBefore(date2)');
            return date(date1).isBefore(date2);
        },

        /**
         * @param {String} date1
         * @param {String} date2
         * @return {Boolean}
         *
         * @deprecated 7.2 and will be removed on 7.5. Use {@link date#isSame} instead.
         */
        isDateOn: function(date1, date2) {
            app.logger.warn('date.isDateOn() was called and is deprecated. ' +
                'Please update code to use date.isSame()');
            return date(date1).isSame(date2);
        },

        /**
         * @param {String} date1
         * @param {String} startDate
         * @param {String} endDate
         * @param {Boolean} [inclusive=false] include start and end dates in comparison
         * @return {Boolean}
         *
         * @deprecated 7.2 and will be removed on 7.5. Use {@link date#isBetween} instead.
         */
        isDateBetween: function(date1, startDate, endDate, inclusive) {
            app.logger.warn('date.isDateBetween() was called and is deprecated. ' +
                'Please update code to use date.isBetween()');

            return date(date1).isBetween(startDate, endDate, inclusive);
        }
    });

    _.extend(date.fn, {

        /**
         * Formats a date to a string based on user preferences.
         *
         * @param {Boolean} [dateOnly=false] Pass `true` to get date only.
         * @param {Data.Bean/Object} [user=App.user] The user bean or the
         *   current logged in user object. Defaults to current logged in
         *   user.
         * @return {String} The formatted date based on user's preference.
         */
        formatUser: function(dateOnly, user) {
            var format = date.getUserDateFormat(user);

            if (!dateOnly) {
                format += ' ' + date.getUserTimeFormat(user);
            }
            return this.format(format);
        },

        /**
         * Formats a date to a string according to server date format.
         *
         * @param {boolean} [dateOnly=false] Pass `true` to get date only.
         * @return {string} The formatted date according to server date format.
         */
        formatServer: function(dateOnly) {
            var format = dateOnly && date._serverDateFormat;

            return this.format(format);
        },

        /**
         * Returns `true` if the date is between the given `startDate` and
         * `endDate`.
         *
         * @param {String} startDate The start date of the period to test.
         * @param {String} endDate The end date of the period to test.
         * @param {Boolean} [inclusive=true] Include start and end dates in
         *   comparison.
         */
        isBetween: function(startDate, endDate, inclusive) {
            // inclusive should default to true unless explicitly sent false as the param
            inclusive = _.isUndefined(inclusive) ? true : inclusive;

            var isInRange = (this.isAfter(startDate) && this.isBefore(endDate));

            // if we're including start and end dates and date1 hasn't been found to be inside the range yet
            if (inclusive && !isInRange) {
                // check if date1 is on the start or end dates
                isInRange = (this.isSame(startDate) || this.isSame(endDate));
            }
            return isInRange;
        }

    });

    _.extend(date.duration.fn, {
        /**
         * Get the display string for the duration.
         * Note: It currently supports days, hours, and minutes, not months and years.
         * @return {string}
         */
        format: function() {
            var duration = [],
                minutes = this.minutes(),
                hours = this.hours(),
                days = Math.floor(this.asDays());

            if (days > 0) {
                duration.push(days);
                duration.push(app.lang.get(days === 1 ? 'LBL_DURATION_DAY' : 'LBL_DURATION_DAYS'));
            }

            if (hours > 0) {
                duration.push(hours);
                duration.push(app.lang.get(hours === 1 ? 'LBL_DURATION_HOUR' : 'LBL_DURATION_HOURS'));
            }

            if (minutes > 0) {
                duration.push(minutes);
                duration.push(app.lang.get(minutes === 1 ? 'LBL_DURATION_MINUTE' : 'LBL_DURATION_MINUTES'));
            }

            return duration.join(' ');
        }
    });

    app.augment('date', date);
})(SUGAR.App);
