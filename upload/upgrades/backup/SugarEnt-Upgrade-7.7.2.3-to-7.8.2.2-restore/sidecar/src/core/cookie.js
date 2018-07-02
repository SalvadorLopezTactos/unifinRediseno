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
 * Cookie storage for authentication data.
 *
 * @class Core.CookieManager
 * @singleton
 * @alias SUGAR.App.cookie
 */
(function(app, location, cookie) {

    var path = location.pathname.replace(/\/[^\/]*$/, "/cookie.html"),
        getCookie = function() {
            return {};
        };

    app.augment("cookie", {

        initAsync: function(callback) {
            var frame = document.createElement("iframe");
            frame.style.display = "none";
            frame.src = path;
            document.body.appendChild(frame);

            frame.contentWindow.onload = function() {
                getCookie = function() {
                    return frame.contentWindow.getCookie();
                };
                callback();
            };
        },

        /**
         * Checks if the item exists in storage.
         * @param {String} key Item key.
         * @return {Boolean} Whether the item exists in storage.
         */
        has: function(key) {
            return key in getCookie();
        },

        /**
         * Gets an item from the storage.
         * @param {String} key Item key.
         * @return {String} Item with the given key.
         */
        get: function(key) {
            return getCookie()[key];
        },

        /**
         * Puts an item into storage.
         * @param {String} key Item key.
         * @param {String} value Item to put.
         */
        set: function(key, value) {
            app.utils.cookie.setCookie(key, value, null, path);
        },

        /**
         * Deletes an item from storage.
         * @param {String} key Item key.
         */
        cut: function(key) {
            app.utils.cookie.setCookie(key, "", -1, path);
        }
    });

})(SUGAR.App, window.location);
