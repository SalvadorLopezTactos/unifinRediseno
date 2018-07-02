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
 * Persistent cache manager.
 *
 * By default, cache manager uses stash.js to manipulate items in `window.localStorage` object.
 * Use {@link Core.CacheManager#store} property to override the storage provider.
 * The value of the key which is passed as a parameter to `get/set/add` methods is prefixed with
 * `<env>:<appId>:` string to avoid clashes with other environments and applications running off the same domain name and port.
 * You can set environment and application ID in {@link Config} module.
 *
 * @class Core.CacheManager
 * @singleton
 * @alias SUGAR.App.cache
 */
(function(app) {

    var _keyPrefix = "";

    var _buildKey = function(key) {
        return _keyPrefix + key;
    };

    var _cache = {

        /**
         * Storage provider.
         *
         * Default: stash.js
         *
         * @cfg {Object}
         */
        // Not all stash.js's methods are available on cache module
        // We can add additional methods later if we need them (get, set, cut are the most used)
        store: stash,

        /**
         * Initializes cache manager.
         */
        init: function() {
            _keyPrefix = app.config.env + ":" + app.config.appId + ":";
            app.events.register("cache:clean", this);
        },

        /**
         * Checks if the item exists in cache.
         * @param {String} key Item key.
         */
        has: function(key) {
            // Only if we're in fact using the stash.js lib do we directly shim the has method. 
            // Otherwise, we delegate out to whatever this.store.has is.
            if(this.store === stash) {
                return window.localStorage.getItem(_buildKey(key)) !== null;
            } else {
                this.store.has(_buildKey(key));
            }
        },

        /**
         * Gets an item from the cache.
         * @param {String} key Item key.
         * @return {Function/Number/Boolean/String/Array/Object} Item with the given key.
         */
        get: function(key) {
            return this.store.get(_buildKey(key));
        },

        /**
         * Puts an item into cache.
         * @param {String} key Item key.
         * @param {Function/Number/Boolean/String/Array/Object} value Item to put.
         */
        set: function(key, value) {
            try {
                this.store.set(_buildKey(key), value);
            } catch(e) {
                if (e.name.toLowerCase().indexOf("quota") > -1) {
                    //Localstorage is full, the app needs to handle this.
                    this.clean();
                    this.store.set(_buildKey(key), value);
                }
            }
        },

        /**
         * Add an item to an existing item.
         * @param {String} key Item key.
         * @param {Function/Number/Boolean/String/Array/Object} value Item to add.
         */
        add: function(key, value) {
            try {
                this.store.add(_buildKey(key), value);
            } catch(e) {
                if (e.name.toLowerCase().indexOf("quota") > -1) {
                    //Localstorage is full, the app needs to handle this.
                    this.clean();
                    this.store.add(_buildKey(key), value);
                }
            }
        },

        /**
         * Remove non-critical values to free up space. Should be called whenever local storage quota is exceeded.
         * Listen for the clean event (passes callback as argument) in order to register keys to preserve after clean.
         *
         * Keys that are not vital should not be presvered during a cleanup.
         * Ex.
         * <pre><code>
         * ({
         *     initialize: function(options) {
         *         app.events.on("cache:clean", function(callback) {
         *             callback([
         *                 'my_important_cache_key',
         *                 'my_other_important_key',
         *             ])
         *         });
         *     },
         * });
         * </code></pre>
         */
        clean: function() {
            var preserveKeys = [],
                preservedValues = {};

            //First get a list of all keys to keep
            this.trigger("cache:clean", function(keys) {
                preserveKeys = _.union(keys, preserveKeys);
            });
            //Now get those values
            _.each(preserveKeys, function(key) {
                preservedValues[key] = this.get(key);
            }, this);
            //nuke all the keys we own
            this.cutAll();

            //restore any vital values
            _.each(preservedValues, function(value, key) {
                if (!_.isUndefined(value)){
                    this.set(key, value);
                }
            }, this);
        },

        /**
         * Deletes an item from cache.
         * @param {String} key Item key.
         */
        cut: function(key) {
            // Stash does delete ls[e] and IE9 complains if doesn't exist 
            if( this.store.has(_buildKey(key)) ) {
                this.store.cut(_buildKey(key));
            }
        },

        /**
         * Deletes all items from cache.
         *
         * By default, this method deletes all items for the current app and environment.
         * Pass `true` to this method to remove all items.
         * @param {Boolean} all(optional) Flag indicating if all items must be deleted from this cache.
         */
        cutAll: function(all) {
            if (all === true) return this.store.cutAll();
            // FIXME when we upgrade underscore in SC-5094
            var obj = this.store.getAll();
            var keys = _.keys(obj);
            for (var i = 0, length = keys.length; i < length; i++) {
                if (keys[i].indexOf(_keyPrefix) === 0) {
                    this.store.cut(keys[i]);
                }
            }
        }

    };

    //Use eventing for cache cleaning
    _.extend(_cache, Backbone.Events);

    app.augment("cache", _cache);


})(SUGAR.App);
